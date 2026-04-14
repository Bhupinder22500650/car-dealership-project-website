<?php
session_start();

require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$hasRatingColumn = false;
$ratingCol = $conn->query("SHOW COLUMNS FROM feedback LIKE 'rating'");
if ($ratingCol && $ratingCol->num_rows > 0) {
    $hasRatingColumn = true;
}

$error = '';
$success = '';
$email = '';
$comment = '';
$rating = 0;
$car_id = isset($_GET['car_id']) ? (int) $_GET['car_id'] : (int) ($_POST['car_id'] ?? 0);

if ($car_id <= 0) {
    header('Location: search.php');
    exit;
}

$user_stmt = $conn->prepare('SELECT email FROM users WHERE user_id = ?');
$user_stmt->bind_param('i', $_SESSION['user_id']);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
if ($user_row = $user_result->fetch_assoc()) {
    $email = $user_row['email'];
}
$user_stmt->close();

$car_stmt = $conn->prepare('SELECT car_id, company_name, car_model, car_year FROM cars WHERE car_id = ?');
$car_stmt->bind_param('i', $car_id);
$car_stmt->execute();
$car_result = $car_stmt->get_result();
$car = $car_result->fetch_assoc();
$car_stmt->close();

if (!$car) {
    header('Location: search.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request token.';
    } else {
        $email_input = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $comment = trim($_POST['comment'] ?? '');
        $rating = max(0, min(5, (int) ($_POST['rating'] ?? 0)));

        if (!$email_input) {
            $error = 'Invalid email address.';
        } elseif (strlen($comment) < 10 || strlen($comment) > 500) {
            $error = 'Feedback must be between 10 and 500 characters.';
        } else {
            $user_id = (int) $_SESSION['user_id'];

            $check_stmt = $conn->prepare('SELECT feedback_id FROM feedback WHERE car_id = ? AND user_id = ?');
            $check_stmt->bind_param('ii', $car_id, $user_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                if ($hasRatingColumn) {
                    $save_stmt = $conn->prepare(
                        'UPDATE feedback SET email = ?, comment = ?, rating = ?, updated_at = NOW() WHERE car_id = ? AND user_id = ?'
                    );
                    $save_stmt->bind_param('ssiii', $email_input, $comment, $rating, $car_id, $user_id);
                } else {
                    $save_stmt = $conn->prepare(
                        'UPDATE feedback SET email = ?, comment = ?, updated_at = NOW() WHERE car_id = ? AND user_id = ?'
                    );
                    $save_stmt->bind_param('ssii', $email_input, $comment, $car_id, $user_id);
                }
            } else {
                if ($hasRatingColumn) {
                    $save_stmt = $conn->prepare(
                        'INSERT INTO feedback (car_id, user_id, email, comment, rating, created_at) VALUES (?, ?, ?, ?, ?, NOW())'
                    );
                    $save_stmt->bind_param('iissi', $car_id, $user_id, $email_input, $comment, $rating);
                } else {
                    $save_stmt = $conn->prepare(
                        'INSERT INTO feedback (car_id, user_id, email, comment, created_at) VALUES (?, ?, ?, ?, NOW())'
                    );
                    $save_stmt->bind_param('iiss', $car_id, $user_id, $email_input, $comment);
                }
            }
            $check_stmt->close();

            if ($save_stmt->execute()) {
                $success = 'Thank you for your feedback!';
                $comment = '';
            } else {
                $error = 'Unable to submit feedback right now.';
            }
            $save_stmt->close();
            $email = $email_input ?: $email;
        }
    }
}

require_once __DIR__ . '/../views/feedback.view.php';
