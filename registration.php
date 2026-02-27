<?php
// --------------------------------------------------------------------------
// registration.php
// --------------------------------------------------------------------------

// 1) Do not expose PHP errors in production pages
ini_set('display_errors', 0);

// 2) Start session
session_start();

// 3) Include shared DB connection
require_once __DIR__ . '/db/db_connect.php';
require_once __DIR__ . '/db/create_tables.php';

// 4) If already logged in, redirect away
if (isset($_SESSION['seller_id'])) {
    header('Location: cars.php');
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

    // — Check duplicates
    if (empty($errors)) {
        $chk = $conn->prepare(
            "SELECT seller_id
               FROM seller
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
            "INSERT INTO seller
             (First_name, Last_name, Address, Phone, email, username, password)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "sssssss",
            $firstName,
            $lastName,
            $address,
            $phone,
            $email,
            $username,
            $passwordHash
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ------------------------------------------------------------------------
       Page Metadata & Resources
       ------------------------------------------------------------------------ -->
  <meta charset="UTF-8">
  <title>Seller Registration – COSS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>

  <!-- ------------------------------------------------------------------------
       Inline Styles for Registration Form
       ------------------------------------------------------------------------ -->
  <style>
    /* Container styling */
    .registration {
      max-width: 500px;
      margin: 3rem auto;
      padding: 2rem;
      background-color: #1e1e1e;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,255,174,0.2);
    }
    /* Title styling */
    .registration__title {
      text-align: center;
      color: #00ffae;
      margin-bottom: 1.5rem;
    }
    /* Input field styling */
    .registration__form input {
      width: 100%;
      margin-bottom: 1rem;
      padding: 12px;
      font-size: 1rem;
      background-color: #2c2c2c;
      border: 1px solid #444;
      color: #e0e0e0;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    /* Input focus effect */
    .registration__form input:focus {
      background-color: yellow;
      color: #121212;
    }
    /* Button styling */
    .registration__btn {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      background-color: #00ffae;
      color: #121212;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .registration__btn:hover {
      background-color: #00c68e;
      transform: scale(1.02);
    }
    /* Feedback messages */
    .feedback { margin-bottom: 1rem; }
    .feedback.error { color: #f66; }
    .feedback.success { color: #0f0; }
  </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="registration">
        <h2 class="registration__title">Seller Registration</h2>

        <?php if ($errors): ?>
            <div class="feedback error">
                <?php foreach ($errors as $e): ?>
                    <p>• <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="feedback success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Registration form -->
        <form class="registration__form" action="registration.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="text" name="firstName" placeholder="First Name" required value="<?= htmlspecialchars($firstName ?? '') ?>">
            <input type="text" name="lastName" placeholder="Last Name" required value="<?= htmlspecialchars($lastName ?? '') ?>">
            <input type="text" name="address" placeholder="Address" required value="<?= htmlspecialchars($address ?? '') ?>">
            <input type="tel" name="phone" placeholder="Phone" required value="<?= htmlspecialchars($phone ?? '') ?>">
            <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>">
            <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($username ?? '') ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="registration__btn">Register</button>
        </form>

        <!-- Back to home link -->
        <p><a href="index.php">&larr; Back to Home</a></p>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
