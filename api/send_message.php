<?php
session_start();
require_once dirname(__DIR__) . '/config/database.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to send a message']);
    exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request token']);
    exit;
}

// Validate input
if (!isset($_POST['car_id']) || !isset($_POST['receiver_id']) || !isset($_POST['message'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$car_id = (int)$_POST['car_id'];
$receiver_id = (int)$_POST['receiver_id'];
$message = trim($_POST['message']);
$sender_id = $_SESSION['user_id'];

// Validate message length
if (strlen($message) < 5 || strlen($message) > 1000) {
    echo json_encode(['success' => false, 'message' => 'Message must be between 5 and 1000 characters']);
    exit;
}

try {
    // Ensure target car exists and receiver owns it
    $car_stmt = $conn->prepare("SELECT seller_id FROM cars WHERE car_id = ?");
    $car_stmt->bind_param('i', $car_id);
    $car_stmt->execute();
    $car_result = $car_stmt->get_result();
    $car_stmt->close();
    if ($car_result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid car selected']);
        exit;
    }
    $car_row = $car_result->fetch_assoc();
    $expected_receiver_id = (int)$car_row['seller_id'];
    if ($receiver_id !== $expected_receiver_id) {
        echo json_encode(['success' => false, 'message' => 'Receiver does not match selected car owner']);
        exit;
    }
    if ($sender_id === $receiver_id) {
        echo json_encode(['success' => false, 'message' => 'Cannot send a message to yourself']);
        exit;
    }

    // Insert new message
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, car_id, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiis', $sender_id, $receiver_id, $car_id, $message);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error sending message']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error while sending message']);
}

$conn->close();
?> 
