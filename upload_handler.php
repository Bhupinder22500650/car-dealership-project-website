<?php
// --------------------------------------------------------------------------
// upload_handler.php
// --------------------------------------------------------------------------

// 1. Initialize session and include database connection
// --------------------------------------------------------------------------
session_start();
require_once __DIR__ . '/db/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['seller_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Please login to upload images.'
    ]);
    exit;
}

// 2. Function to handle file upload
// --------------------------------------------------------------------------
function handleImageUpload($file, $car_id) {
    global $conn;
    
    // Validate file
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check for upload errors
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

    // Check file size (5MB max)
    if ($file['size'] > 5000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // Check MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    $allowed_types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];

    if (!array_key_exists($mime_type, $allowed_types)) {
        throw new RuntimeException('Invalid file format. Allowed formats: JPG, PNG, GIF');
    }

    // Generate unique filename
    $extension = $allowed_types[$mime_type];
    $filename = sprintf(
        '%s.%s',
        sha1_file($file['tmp_name']),
        $extension
    );

    // Create upload directory if it doesn't exist
    $upload_dir = __DIR__ . '/assets/img/cars/';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            throw new RuntimeException('Failed to create upload directory. Please check permissions.');
        }
    }

    // Check if directory is writable
    if (!is_writable($upload_dir)) {
        throw new RuntimeException('Upload directory is not writable. Please check permissions.');
    }

    // Move uploaded file
    $filepath = $upload_dir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        $error = error_get_last();
        throw new RuntimeException('Failed to move uploaded file. Error: ' . ($error ? $error['message'] : 'Unknown error'));
    }

    // Ensure current user owns this car before writing image path
    $seller_id = (int)$_SESSION['seller_id'];
    $owner_stmt = $conn->prepare("SELECT car_id FROM cars WHERE car_id = ? AND seller_id = ?");
    $owner_stmt->bind_param('ii', $car_id, $seller_id);
    $owner_stmt->execute();
    $owner_result = $owner_stmt->get_result();
    $owner_stmt->close();
    if ($owner_result->num_rows === 0) {
        unlink($filepath);
        throw new RuntimeException('Car not found or not owned by current user.');
    }

    // Update database with image path
    $image_url = 'assets/img/cars/' . $filename;
    $stmt = $conn->prepare("UPDATE cars SET image_url = ? WHERE car_id = ? AND seller_id = ?");
    $stmt->bind_param('sii', $image_url, $car_id, $seller_id);
    
    if (!$stmt->execute()) {
        // If database update fails, delete the uploaded file
        unlink($filepath);
        throw new RuntimeException('Failed to update database: ' . $stmt->error);
    }

    $stmt->close();
    return $image_url;
}

// 3. Handle POST request
// --------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            throw new RuntimeException('Invalid request token.');
        }

        if (!isset($_POST['car_id'])) {
            throw new RuntimeException('Car ID is required.');
        }

        if (!isset($_FILES['car_image'])) {
            throw new RuntimeException('No file uploaded.');
        }

        $car_id = (int)$_POST['car_id'];
        $image_url = handleImageUpload($_FILES['car_image'], $car_id);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'image_url' => $image_url
        ]);

    } catch (RuntimeException $e) {
        // Return error response
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
}

// 4. Close database connection
// --------------------------------------------------------------------------
$conn->close(); 
