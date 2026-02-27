<?php
// Include database connection
require_once __DIR__ . '/db_connect.php';

// Function to check if a table exists
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

// Create tables if they don't exist
function createTables($conn) {
    // Create seller table if not exists
    if (!tableExists($conn, 'seller')) {
        $sql = "CREATE TABLE seller (
            seller_id INT AUTO_INCREMENT PRIMARY KEY,
            First_name VARCHAR(50) NOT NULL,
            Last_name VARCHAR(50) NOT NULL,
            Address VARCHAR(255) NOT NULL,
            Phone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";
        if (!$conn->query($sql)) {
            die("Error creating seller table: " . $conn->error);
        }
    }

    // Create cars table if not exists
    if (!tableExists($conn, 'cars')) {
        $sql = "CREATE TABLE cars (
            car_id INT AUTO_INCREMENT PRIMARY KEY,
            seller_id INT NOT NULL,
            company_name VARCHAR(50) NOT NULL,
            car_model VARCHAR(100) NOT NULL,
            car_year INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            location VARCHAR(100) NOT NULL,
            body_type VARCHAR(50) NOT NULL,
            image_url VARCHAR(255) DEFAULT 'assets/img/default-car.jpg',
            FOREIGN KEY (seller_id) REFERENCES seller(seller_id)
        )";
        if (!$conn->query($sql)) {
            die("Error creating cars table: " . $conn->error);
        }
    }

    // Create feedback table if not exists
    if (!tableExists($conn, 'feedback')) {
        $sql = "CREATE TABLE feedback (
            feedback_id INT AUTO_INCREMENT PRIMARY KEY,
            car_id INT NOT NULL,
            user_id INT NOT NULL,
            email VARCHAR(100) NOT NULL,
            comment TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (car_id) REFERENCES cars(car_id),
            FOREIGN KEY (user_id) REFERENCES seller(seller_id)
        )";
        if (!$conn->query($sql)) {
            die("Error creating feedback table: " . $conn->error);
        }
    }
}

// Execute table creation
createTables($conn);

// Close connection
// $conn->close();
?> 