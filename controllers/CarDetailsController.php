<?php
// --------------------------------------------------------------------------
// 1. Start session
// --------------------------------------------------------------------------
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --------------------------------------------------------------------------
// 2. Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/create_tables.php';

// --------------------------------------------------------------------------
// 3. Get car ID from URL parameter
// --------------------------------------------------------------------------
$car_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($car_id <= 0) {
    header('Location: index.php');
    exit;
}

// --------------------------------------------------------------------------
// 4. Fetch car details
// --------------------------------------------------------------------------
$stmt = $conn->prepare("
    SELECT c.*, u.username as seller_name 
    FROM cars c
    WHERE c.car_id = ?
");
$stmt->bind_param('i', $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    header('Location: index.php');
    exit;
}

$stmt->close();
// $conn->close();

require_once __DIR__ . '/../views/car-details.view.php';
?>
