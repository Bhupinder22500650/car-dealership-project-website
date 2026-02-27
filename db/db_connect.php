<?php
// db_connect.php

// 1) Database credentials
$host   = 'localhost';    // your MySQL host
$user   = 'root';         // your MySQL user
$pass   = '';             // your MySQL password
$dbname = 'coss';         // your database name

// 2) Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// 3) Check for connection errors
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// 4) (Optional) set charset
$conn->set_charset('utf8mb4');
