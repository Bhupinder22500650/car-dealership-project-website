<?php
// --------------------------------------------------------------------------
// Start session and redirect logged-in sellers
// --------------------------------------------------------------------------
session_start();

// --------------------------------------------------------------------------
// Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/db/db_connect.php';
require_once __DIR__ . '/db/create_tables.php';

// --------------------------------------------------------------------------
// Redirect logged-in sellers to cars page
// --------------------------------------------------------------------------
if (isset($_SESSION['seller_id'])) {
    header('Location: cars.php');
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
        "SELECT seller_id, password 
         FROM seller 
         WHERE username = ?"
    );
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    // Verify user exists and check password
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($seller_id, $hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            // Successful login: set session and redirect
            session_regenerate_id(true);
            $_SESSION['seller_id'] = $seller_id;
            $_SESSION['username']  = $username;
            header('Location: cars.php');
            exit;
        }
    }
    $error = 'Invalid username or password.';

    // On failure, set error message
    $stmt->close();
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ------------------------------------------------------------------------
       Page Metadata & Resources
       ------------------------------------------------------------------------ -->
  <meta charset="UTF-8">
  <title>Seller Login – COSS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link external CSS and JS -->
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>

  <!-- ------------------------------------------------------------------------
       Inline Styles for Login Form
       ------------------------------------------------------------------------ -->
  <style>
    /* Container styling */
    .login {
      max-width: 400px;
      margin: 4rem auto;
      padding: 2rem;
      background-color: #1e1e1e;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,255,174,0.2);
    }
    /* Title styling */
    .login__title {
      text-align: center;
      color: #00ffae;
      margin-bottom: 1.5rem;
      font-size: 1.5rem;
    }
    /* Input field styling */
    .login__form input {
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
    .login__form input:focus {
      background-color: yellow;
      color: #121212;
      outline: none;
    }
    /* Button styling */
    .login__btn {
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
    .login__btn:hover {
      background-color: #00c68e;
      transform: scale(1.02);
    }
    /* Footer link styling */
    .login__footer {
      text-align: center;
      margin-top: 1rem;
      color: #aaa;
    }
    .login__footer a {
      color: #00ffae;
      text-decoration: none;
    }
    .login__footer a:hover {
      text-decoration: underline;
    }
    /* Error message styling */
    .feedback {
      text-align: center;
      color: #ff4d4d;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="login">
        <h2 class="login__title">Seller Login</h2>

        <!-- Display error message if login fails -->
        <?php if ($error): ?>
            <div class="feedback"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Login form -->
        <form id="loginForm" class="login__form" action="login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($username) ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="login__btn">Login</button>
        </form>

        <!-- Link to registration page -->
        <p class="login__footer">
            Don't have an account? <a href="registration.php">Register here</a>
        </p>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
