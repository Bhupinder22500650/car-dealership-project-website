<?php
// --------------------------------------------------------------------------
// 1. Initialize session and include database
// --------------------------------------------------------------------------
session_start();
require_once __DIR__ . '/../config/database.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'] ?? 'buyer';

// --------------------------------------------------------------------------
// 2. Fetch Messages
// --------------------------------------------------------------------------
// If seller, show messages received. If buyer, show messages sent.
// To make it comprehensive, we can show both "Sent" and "Received", or just all related messages.

$sql = "
    SELECT 
        m.message_id, 
        m.message, 
        m.message_date, 
        m.is_read,
        m.sender_id,
        m.receiver_id,
        c.company_name, 
        c.car_model,
        sender.First_name AS sender_first,
        sender.Last_name AS sender_last,
        receiver.First_name AS receiver_first,
        receiver.Last_name AS receiver_last
    FROM messages m
    JOIN cars c ON m.car_id = c.car_id
    JOIN users sender ON m.sender_id = sender.user_id
    JOIN users receiver ON m.receiver_id = receiver.user_id
    WHERE m.sender_id = ? OR m.receiver_id = ?
    ORDER BY m.message_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Mark messages as read if the user is the receiver
$update_sql = "UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND is_read = 0";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $user_id);
$update_stmt->execute();
$update_stmt->close();

// $conn->close();

require_once __DIR__ . '/../views/messages.view.php';
?>
