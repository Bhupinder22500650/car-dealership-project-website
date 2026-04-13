<?php
// --------------------------------------------------------------------------
// Start session and redirect logged-in sellers
// --------------------------------------------------------------------------
session_start();

// --------------------------------------------------------------------------
// Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/create_tables.php';

// --------------------------------------------------------------------------
// Redirect logged-in users
// --------------------------------------------------------------------------
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: cars.php'); // Default fallback for now
    }
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --------------------------------------------------------------------------
// Initialize variables for form handling
// --------------------------------------------------------------------------
$error    = '';   // Holds error message on login failure
$username = '';   // Retains submitted username on failure

// --------------------------------------------------------------------------
// Handle form submission and user authentication
// --------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request token. Please try again.';
    } else {
        // Retrieve and trim form inputs
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Prepare statement to fetch user by username
        $stmt = $conn->prepare(
            "SELECT user_id, password, user_type 
             FROM users 
             WHERE username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $hashedPassword, $userType);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                // Avoid session fixation
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $userType;

                // Track Login
                $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
                $logStmt = $conn->prepare("INSERT INTO login_logs (user_id, login_time, ip_address) VALUES (?, NOW(), ?)");
                if ($logStmt) {
                    $logStmt->bind_param("is", $userId, $ip);
                    $logStmt->execute();
                    $logStmt->close();
                }

                // Redirect based on role
                if ($userType === 'admin') {
                    header('Location: admin_dashboard.php');
                } else if ($userType === 'seller') {
                    header('Location: cars.php');
                } else {
                    header('Location: search.php'); // Buyers go to search
                }
                exit;
            }
        }
        $error = 'Invalid username or password.';
        $stmt->close();
    }
}

// Render the View
require_once __DIR__ . '/../views/login.view.php';
?>
