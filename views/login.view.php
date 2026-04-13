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
    /* Container styling: Precision Matte */
    .login {
      max-width: 420px;
      margin: 6rem auto;
      padding: 3rem 2.5rem;
      background: #111111;
      border: 1px solid #333333;
      position: relative;
    }
    
    /* Subtle glowing top accent becomes sharp red line */
    .login::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; height: 4px;
      background: #e11a22; /* Acura Red */
    }

    /* Title styling */
    .login__title {
      text-align: center;
      color: #ffffff;
      margin-bottom: 2.5rem;
      font-size: 2rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .login__title span {
      color: #e11a22;
    }

    /* Input field container */
    .form-group {
      position: relative;
      margin-bottom: 1.5rem;
    }

    /* Input field styling */
    .login__form input {
      width: 100%;
      padding: 15px;
      font-size: 1rem;
      background-color: #0a0a0a;
      border: 1px solid #444444;
      color: #ffffff;
      border-radius: 0; /* Sharp edges */
      transition: all 0.2s linear;
      box-sizing: border-box;
    }
    
    .login__form input::placeholder {
      color: #666666;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 1px;
    }

    /* Input focus effect */
    .login__form input:focus {
      background-color: #000000;
      border-color: #ffffff;
      outline: none;
    }

    /* Button styling */
    .login__btn {
      width: 100%;
      padding: 16px;
      font-size: 1.1rem;
      font-weight: 700;
      background-color: #e11a22; /* Solid Red */
      color: #ffffff;
      border: 2px solid #e11a22;
      border-radius: 0; /* Sharp edges */
      cursor: pointer;
      transition: all 0.2s linear;
      margin-top: 1rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    
    .login__btn:hover {
      background-color: #000000;
      color: #ffffff;
      border-color: #e11a22;
    }
    
    .login__btn:active {
      transform: translateY(1px);
    }

    /* Footer link styling */
    .login__footer {
      text-align: center;
      margin-top: 2rem;
      color: #666666;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .login__footer a {
      color: #ffffff;
      text-decoration: none;
      font-weight: 700;
      border-bottom: 1px solid #e11a22;
      padding-bottom: 2px;
      transition: border-color 0.2s linear;
    }
    .login__footer a:hover {
      border-color: #ffffff;
    }

    /* Error message styling */
    .feedback {
      text-align: center;
      color: #ffffff;
      background: #e11a22;
      padding: 12px;
      border: none;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
  </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="login reveal-3d">
        <h2 class="login__title">Welcome <span>Back</span></h2>

        <!-- Display error message if login fails -->
        <?php if ($error): ?>
            <div class="feedback"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Login form -->
        <form id="loginForm" class="login__form" action="login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($username) ?>">
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="login__btn">Sign In</button>
        </form>

        <!-- Link to registration page -->
        <p class="login__footer">
            Don't have an account? <a href="registration.php">Register here</a>
        </p>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
