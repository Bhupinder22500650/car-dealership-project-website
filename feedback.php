<?php
session_start();

require_once __DIR__ . '/db/db_connect.php';
require_once __DIR__ . '/db/create_tables.php';

if (!isset($_SESSION['seller_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';
$email = '';
$comment = '';
$car_id = isset($_GET['car_id']) ? (int)$_GET['car_id'] : (int)($_POST['car_id'] ?? 0);

if ($car_id <= 0) {
    header('Location: search.php');
    exit;
}

// Load user email and selected car for display.
$user_stmt = $conn->prepare('SELECT email FROM seller WHERE seller_id = ?');
$user_stmt->bind_param('i', $_SESSION['seller_id']);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
if ($user_row = $user_result->fetch_assoc()) {
    $email = $user_row['email'];
}
$user_stmt->close();

$car_stmt = $conn->prepare('SELECT car_id, company_name, car_model FROM cars WHERE car_id = ?');
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
        $error = 'Invalid request token. Please refresh and try again.';
    } else {
        $email_input = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $comment = trim($_POST['comment'] ?? '');

        if (!$email_input) {
            $error = 'Invalid email address.';
        } elseif (strlen($comment) < 10 || strlen($comment) > 500) {
            $error = 'Feedback must be between 10 and 500 characters.';
        } else {
            $user_id = (int)$_SESSION['seller_id'];

            $check_stmt = $conn->prepare('SELECT feedback_id FROM feedback WHERE car_id = ? AND user_id = ?');
            $check_stmt->bind_param('ii', $car_id, $user_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $save_stmt = $conn->prepare('UPDATE feedback SET email = ?, comment = ?, updated_at = NOW() WHERE car_id = ? AND user_id = ?');
                $save_stmt->bind_param('ssii', $email_input, $comment, $car_id, $user_id);
            } else {
                $save_stmt = $conn->prepare('INSERT INTO feedback (car_id, user_id, email, comment, created_at) VALUES (?, ?, ?, ?, NOW())');
                $save_stmt->bind_param('iiss', $car_id, $user_id, $email_input, $comment);
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

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback - COSS</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="feedback" style="max-width: 600px; margin: 3rem auto; padding: 2rem; background:#1e1e1e; border-radius: 10px;">
        <h2 class="feedback__title">Leave Feedback</h2>
        <p style="margin-bottom:1rem; color:#ccc;">Car: <?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?></p>

        <?php if ($error): ?>
            <p style="color:#ff4d4d;"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($success): ?>
            <p style="color:#00ffae;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form class="feedback__form" action="feedback.php" method="POST">
            <input type="hidden" name="car_id" value="<?= (int)$car_id ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="email" class="feedback__input" name="email" placeholder="Your Email" required value="<?= htmlspecialchars($email) ?>">
            <textarea class="feedback__textarea" name="comment" placeholder="Write your feedback here..." required><?= htmlspecialchars($comment) ?></textarea>
            <button type="submit" class="feedback__button">Submit</button>
        </form>

        <p class="feedback__back" style="margin-top:1rem;">
            <a class="feedback__back-link" href="car-details.php?id=<?= (int)$car_id ?>">Back to Car Details</a>
        </p>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
