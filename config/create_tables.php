<?php
// Include database connection
require_once __DIR__ . '/database.php';

// Function to check if a table exists
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

function columnExists($conn, $tableName, $columnName) {
    $safeTable = $conn->real_escape_string($tableName);
    $safeColumn = $conn->real_escape_string($columnName);
    $result = $conn->query("SHOW COLUMNS FROM `{$safeTable}` LIKE '{$safeColumn}'");
    return $result && $result->num_rows > 0;
}

// Create tables if they don't exist
function createTables($conn) {
    // -----------------------------------------------------
    // 1) Users Table (Replacing old 'seller' table)
    // -----------------------------------------------------
    // We add 'user_type' ENUM to distinguish Buyers, Sellers, and Admins.
    if (!tableExists($conn, 'users')) {
        $sql = "CREATE TABLE users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            First_name VARCHAR(50) NOT NULL,
            Last_name VARCHAR(50) NOT NULL,
            Address VARCHAR(255) NOT NULL,
            Phone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            user_type ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
            profile_photo VARCHAR(255) DEFAULT 'assets/img/default-avatar.png',
            bio TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if (!$conn->query($sql)) {
            die("Error creating users table: " . $conn->error);
        }
    }

    // -----------------------------------------------------
    // 2) Cars Table (Expanded specifications)
    // -----------------------------------------------------
    if (!tableExists($conn, 'cars')) {
        $sql = "CREATE TABLE cars (
            car_id INT AUTO_INCREMENT PRIMARY KEY,
            seller_id INT NOT NULL,
            company_name VARCHAR(50) NOT NULL,
            car_model VARCHAR(100) NOT NULL,
            car_year INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            mileage INT NOT NULL DEFAULT 0,
            transmission VARCHAR(30) NOT NULL DEFAULT 'Automatic',
            fuel_type VARCHAR(30) NOT NULL DEFAULT 'Petrol',
            location VARCHAR(100) NOT NULL,
            body_type VARCHAR(50) NOT NULL,
            description TEXT,
            image_url VARCHAR(255) DEFAULT 'assets/img/default-car.jpg',
            status ENUM('available', 'sold') NOT NULL DEFAULT 'available',
            bought_by INT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (seller_id) REFERENCES users(user_id) ON DELETE CASCADE,
            FOREIGN KEY (bought_by) REFERENCES users(user_id) ON DELETE SET NULL
        )";
        if (!$conn->query($sql)) {
            die("Error creating cars table: " . $conn->error);
        }
    }

    // -----------------------------------------------------
    // 3) Messages Table
    // -----------------------------------------------------
    if (!tableExists($conn, 'messages')) {
        $sql = "CREATE TABLE messages (
            message_id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,     /* The Buyer */
            receiver_id INT NOT NULL,   /* The Seller */
            car_id INT NOT NULL,        /* The Subject Car */
            message TEXT NOT NULL,
            message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            is_read TINYINT(1) DEFAULT 0,
            FOREIGN KEY (sender_id) REFERENCES users(user_id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES users(user_id) ON DELETE CASCADE,
            FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
        )";
        if (!$conn->query($sql)) {
            die("Error creating messages table: " . $conn->error);
        }
    }

    // -----------------------------------------------------
    // 4) Feedback Table
    // -----------------------------------------------------
    if (!tableExists($conn, 'feedback')) {
        $sql = "CREATE TABLE feedback (
            feedback_id INT AUTO_INCREMENT PRIMARY KEY,
            car_id INT NOT NULL,
            user_id INT NOT NULL,
            email VARCHAR(100) NOT NULL,
            comment TEXT NOT NULL,
            rating INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
        )";
        if (!$conn->query($sql)) {
            die("Error creating feedback table: " . $conn->error);
        }
    }

    // -----------------------------------------------------
    // 5) Login Logs Table (For tracking user activity)
    // -----------------------------------------------------
    if (!tableExists($conn, 'login_logs')) {
        $sql = "CREATE TABLE login_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            login_time DATETIME NOT NULL,
            logout_time DATETIME NULL,
            ip_address VARCHAR(45) NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
        )";
        if (!$conn->query($sql)) {
            die("Error creating login_logs table: " . $conn->error);
        }
    }

    // -----------------------------------------------------
    // 6) Backfill missing columns on existing deployments
    // -----------------------------------------------------
    if (tableExists($conn, 'users')) {
        if (!columnExists($conn, 'users', 'profile_photo')) {
            $conn->query("ALTER TABLE users ADD COLUMN profile_photo VARCHAR(255) DEFAULT 'assets/img/default-avatar.png'");
        }
        if (!columnExists($conn, 'users', 'bio')) {
            $conn->query("ALTER TABLE users ADD COLUMN bio TEXT");
        }
    }

    if (tableExists($conn, 'feedback') && !columnExists($conn, 'feedback', 'rating')) {
        $conn->query("ALTER TABLE feedback ADD COLUMN rating INT DEFAULT 0");
    }

    if (tableExists($conn, 'cars')) {
        if (!columnExists($conn, 'cars', 'status')) {
            $conn->query("ALTER TABLE cars ADD COLUMN status ENUM('available', 'sold') NOT NULL DEFAULT 'available'");
        }
        if (!columnExists($conn, 'cars', 'bought_by')) {
            $conn->query("ALTER TABLE cars ADD COLUMN bought_by INT NULL");
            $conn->query("ALTER TABLE cars ADD CONSTRAINT fk_cars_bought_by FOREIGN KEY (bought_by) REFERENCES users(user_id) ON DELETE SET NULL");
        }
    }
}

// --------------------------------------------------------------------------
// Execute table creation (Migration Logic)
// --------------------------------------------------------------------------

// Re-create new schema iteratively
createTables($conn);

// Close connection (Uncommented to ensure cleanup during direct script calls)
// $conn->close();
?> 
