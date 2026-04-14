<?php
// --------------------------------------------------------------------------
// 1. Start session and enforce login
// --------------------------------------------------------------------------
session_start();

// --------------------------------------------------------------------------
// 2. Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/../config/database.php';

// --------------------------------------------------------------------------
// 3. Function to handle file upload
// --------------------------------------------------------------------------
function handleImageUpload($file, $car_id = null) {
    global $conn;

    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_PARTIAL:
            throw new RuntimeException('File was only partially uploaded.');
        case UPLOAD_ERR_NO_TMP_DIR:
            throw new RuntimeException('Missing a temporary folder.');
        case UPLOAD_ERR_CANT_WRITE:
            throw new RuntimeException('Failed to write file to disk.');
        case UPLOAD_ERR_EXTENSION:
            throw new RuntimeException('A PHP extension stopped the file upload.');
        default:
            throw new RuntimeException('Unknown upload error.');
    }

    // 20MB max
    if ($file['size'] > 20971520) {
        throw new RuntimeException('File too large. Maximum 20MB allowed.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    $allowed_types = [
        'image/jpeg'          => 'jpg',
        'image/jpg'           => 'jpg',
        'image/png'           => 'png',
        'image/gif'           => 'gif',
        'image/webp'          => 'webp',
        'image/avif'          => 'avif',
    ];

    if (!array_key_exists($mime_type, $allowed_types)) {
        throw new RuntimeException('Unsupported format. Allowed: JPG, PNG, GIF, WebP, AVIF');
    }
    $extension = $allowed_types[$mime_type];

    $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $extension);
    $upload_dir = dirname(__DIR__) . '/assets/img/cars/';
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
        throw new RuntimeException('Failed to create upload directory.');
    }
    if (!is_writable($upload_dir)) {
        throw new RuntimeException('Upload directory is not writable.');
    }

    $filepath = $upload_dir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    if ($car_id !== null) {
        $image_url = 'assets/img/cars/' . $filename;
        $stmt = $conn->prepare('UPDATE cars SET image_url = ? WHERE car_id = ?');
        $stmt->bind_param('si', $image_url, $car_id);
        if (!$stmt->execute()) {
            unlink($filepath);
            throw new RuntimeException('DB update failed: ' . $stmt->error);
        }
        $stmt->close();
    }

    return 'assets/img/cars/' . $filename;
}

// --------------------------------------------------------------------------
// 4. Require seller to be logged in; otherwise redirect to login page
// --------------------------------------------------------------------------
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'seller') {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$hasCarStatusColumn = false;
$statusColumn = $conn->query("SHOW COLUMNS FROM cars LIKE 'status'");
if ($statusColumn && $statusColumn->num_rows > 0) {
    $hasCarStatusColumn = true;
}

// --------------------------------------------------------------------------
// 5. Initialize feedback & sticky input variables
// --------------------------------------------------------------------------
$error = '';
$success = '';
$company = '';
$model = '';
$year = '';
$price = '';
$location = '';
$bodyType = '';
$mileage  = '';
$transmission = '';
$fuelType = '';
$description = '';

// --------------------------------------------------------------------------
// 6. Handle form submission and data operations
// --------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request token. Please refresh the page and try again.';
    } else {
    $seller_id = $_SESSION['user_id'];
    
    // Handle Delete Operation
    if (isset($_POST['delete_car'])) {
        $car_id = (int)$_POST['car_id'];
        $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ? AND seller_id = ?");
        $stmt->bind_param('ii', $car_id, $seller_id);
        if ($stmt->execute()) {
            $success = 'Car deleted successfully!';
        } else {
            $error = 'Error deleting car: ' . $stmt->error;
        }
        $stmt->close();
    }
    else if (isset($_POST['mark_sold'])) {
        $car_id = (int) $_POST['car_id'];
        if (!$hasCarStatusColumn) {
            $error = 'Cannot mark sold yet because car status column is missing in database.';
        } else {
            $stmt = $conn->prepare("UPDATE cars SET status = 'sold' WHERE car_id = ? AND seller_id = ?");
            if ($stmt) {
                $stmt->bind_param('ii', $car_id, $seller_id);
                if ($stmt->execute()) {
                    $success = 'Listing marked as sold.';
                } else {
                    $error = 'Error updating status: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = 'Unable to prepare sold-status update.';
            }
        }
    }
    // Handle Edit Operation
    else if (isset($_POST['edit_car'])) {
        $car_id = (int)$_POST['car_id'];
        $company = trim($_POST['company'] ?? '');
        $model = trim($_POST['model'] ?? '');
        $year = (int)trim($_POST['year'] ?? 0);
        $price = (float)trim($_POST['price'] ?? 0);
        $location = trim($_POST['location'] ?? '');
        $bodyType = trim($_POST['bodyType'] ?? '');
        $mileage  = (int)trim($_POST['mileage'] ?? 0);
        $transmission = trim($_POST['transmission'] ?? 'Automatic');
        $fuelType = trim($_POST['fuelType'] ?? 'Petrol');
        $description = trim($_POST['description'] ?? '');
        
        $stmt = $conn->prepare(
            "UPDATE cars SET 
            company_name = ?, 
            car_model = ?, 
            car_year = ?, 
            price = ?, 
            mileage = ?,
            transmission = ?,
            fuel_type = ?,
            location = ?, 
            body_type = ?,
            description = ?
            WHERE car_id = ? AND seller_id = ?"
        );
        
        $stmt->bind_param('ssidssssssii', $company, $model, $year, $price, $mileage, $transmission, $fuelType, $location, $bodyType, $description, $car_id, $seller_id);
        
        if ($stmt->execute()) {
            $success = 'Car updated successfully!';
        } else {
            $error = 'Error updating car: ' . $stmt->error;
        }
        $stmt->close();
    }
    // Handle Add Operation
    else {
        $company = trim($_POST['company'] ?? '');
        $model = trim($_POST['model'] ?? '');
        $year = (int)trim($_POST['year'] ?? 0);
        $price = (float)trim($_POST['price'] ?? 0);
        $location = trim($_POST['location'] ?? '');
        $bodyType = trim($_POST['bodyType'] ?? '');
        $mileage  = (int)trim($_POST['mileage'] ?? 0);
        $transmission = trim($_POST['transmission'] ?? 'Automatic');
        $fuelType = trim($_POST['fuelType'] ?? 'Petrol');
        $description = trim($_POST['description'] ?? '');
        
        // Set default image URL
        $image_url = 'assets/img/default-car.jpg';
        
        // Handle image upload if present
        if (isset($_FILES['car_image']) && $_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
            try {
                $image_url = handleImageUpload($_FILES['car_image'], null);
            } catch (RuntimeException $e) {
                $error = 'Error uploading image: ' . $e->getMessage();
            }
        }
        
        $stmt = $conn->prepare(
            "INSERT INTO cars 
            (seller_id, company_name, car_model, car_year, price, mileage, transmission, fuel_type, location, body_type, description, image_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('issidsssssss', $seller_id, $company, $model, $year, $price, $mileage, $transmission, $fuelType, $location, $bodyType, $description, $image_url);
        
        if ($stmt->execute()) {
            $success = 'Car added successfully!';
            // Reset form fields
            $company = $model = $year = $price = $mileage = $transmission = $fuelType = $location = $bodyType = $description = '';
        } else {
            $error = 'Error adding car: ' . $stmt->error;
        }
        $stmt->close();
    }
    }
}

// Fetch all cars for the current seller
$stmt = $conn->prepare("SELECT * FROM cars WHERE seller_id = ? ORDER BY car_id DESC");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Close database connection
// $conn->close();

require_once __DIR__ . '/../views/cars.view.php';
?>
