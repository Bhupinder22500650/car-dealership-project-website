<?php
// --------------------------------------------------------------------------
// registration.php
// --------------------------------------------------------------------------

// 1) Do not expose PHP errors in production pages
ini_set('display_errors', 0);

// 2) Start session
session_start();

// 3) Include shared DB connection
require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header('Location: search.php');
    } else {
        header('Location: cars.php'); // Default fallback
    }
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 5) Prepare feedback storage
$errors  = [];
$success = '';

// 6) Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid request token. Please try again.';
    }

    if (empty($errors)) {
    // — Collect & trim
    $firstName = trim($_POST['firstName']  ?? '');
    $lastName  = trim($_POST['lastName']   ?? '');
    $address   = trim($_POST['address']    ?? '');
    $phone     = trim($_POST['phone']      ?? '');
    $email     = trim($_POST['email']      ?? '');
    $username  = trim($_POST['username']   ?? '');
    $password  = $_POST['password']        ?? '';
    $userType  = $_POST['userType']        ?? 'buyer'; // default to buyer

    // — Validate
    if (strlen($username) < 6) {
        $errors[] = 'Username must be at least 6 characters.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }
    if (!preg_match('/^[\d+\-\s]+$/', $phone)) {
        $errors[] = 'Phone contains invalid characters.';
    }
    if (!in_array($userType, ['buyer', 'seller'], true)) {
        $errors[] = 'Invalid account type selected.';
    }

    // — Check duplicates
    if (empty($errors)) {
        $chk = $conn->prepare(
            "SELECT user_id
               FROM users
               WHERE username = ? OR email = ?"
        );
        $chk->bind_param('ss', $username, $email);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            $errors[] = 'Username or email already taken.';
        }
        $chk->close();
    }

    // — Insert if OK
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users
             (First_name, Last_name, Address, Phone, email, username, password, user_type)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssssssss",
            $firstName,
            $lastName,
            $address,
            $phone,
            $email,
            $username,
            $passwordHash,
            $userType
        );

        if ($stmt->execute()) {
            $success = '✅ Registration successful! <a href="login.php">Log in here</a>.';
            // clear fields
            $firstName = $lastName = $address = $phone = $email = $username = '';
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
        $stmt->close();
    }
    }
}

// 7) Close DB
// $conn->close();

require_once __DIR__ . '/../views/registration.view.php';
?>
