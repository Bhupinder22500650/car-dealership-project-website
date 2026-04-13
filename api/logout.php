<?php
// Start the session
session_start();
// Track logout time
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../config/database.php';
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("UPDATE login_logs SET logout_time = NOW() WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
}

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: ../login.php');
exit;
?> 