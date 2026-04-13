<?php
// db_connect.php

// --------------------------------------------------------------------------
// Global Error Handling (Production Ready)
// --------------------------------------------------------------------------
// Hide raw PHP errors from users
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Log errors to a file instead
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error_log.txt');

// --------------------------------------------------------------------------
// Database Connection (Environment Variables)
// --------------------------------------------------------------------------
// Use environment variables for DB credentials, fallback to InfinityFree settings
$host   = getenv('DB_HOST') ?: 'sql112.infinityfree.com';
$user   = getenv('DB_USER') ?: 'if0_41538800';
$pass   = getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'eijblXG0bJg';
$dbname = getenv('DB_NAME') ?: 'if0_41538800_coss';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    // Log the actual error, but show a generic message to the user
    error_log('Database connection failed: ' . $conn->connect_error);
    die('A database error occurred. Please try again later.');
}

// (Optional) set charset
$conn->set_charset('utf8mb4');
?>
