<?php
session_start();
require_once __DIR__ . '/db/db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['seller_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to submit feedback']);
    exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request token']);
    exit;
}

// Validate input
if (!isset($_POST['car_id']) || !isset($_POST['email']) || !isset($_POST['comment'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$car_id = (int)$_POST['car_id'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$comment = trim($_POST['comment']);
$user_id = $_SESSION['seller_id'];

// Validate email
if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Validate comment length
if (strlen($comment) < 10 || strlen($comment) > 500) {
    echo json_encode(['success' => false, 'message' => 'Comment must be between 10 and 500 characters']);
    exit;
}

try {
    // Ensure target car exists
    $car_stmt = $conn->prepare("SELECT car_id FROM cars WHERE car_id = ?");
    $car_stmt->bind_param('i', $car_id);
    $car_stmt->execute();
    $car_result = $car_stmt->get_result();
    $car_stmt->close();
    if ($car_result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid car selected']);
        exit;
    }

    // Check if user has already submitted feedback for this car
    $check_stmt = $conn->prepare("SELECT feedback_id FROM feedback WHERE car_id = ? AND user_id = ?");
    $check_stmt->bind_param('ii', $car_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing feedback
        $stmt = $conn->prepare("UPDATE feedback SET email = ?, comment = ?, updated_at = NOW() WHERE car_id = ? AND user_id = ?");
        $stmt->bind_param('ssii', $email, $comment, $car_id, $user_id);
    } else {
        // Insert new feedback
        $stmt = $conn->prepare("INSERT INTO feedback (car_id, user_id, email, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param('iiss', $car_id, $user_id, $email, $comment);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error submitting feedback']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error while submitting feedback']);
}

$conn->close();
?> 
