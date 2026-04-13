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
    /* Container styling: Precision Matte */
    .registration {
      max-width: 650px;
      margin: 4rem auto;
      padding: 3rem 2.5rem;
      background: #111111;
      border: 1px solid #333333;
      position: relative;
    }

    /* Subtle glowing top accent becomes sharp red line */
    .registration::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; height: 4px;
      background: #e11a22; /* Acura Red */
    }

    /* Title styling */
    .registration__title {
      text-align: center;
      color: #ffffff;
      margin-bottom: 3rem;
      font-size: 2rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .registration__title span {
      color: #e11a22;
    }

    /* Form Layout */
    .form-row {
      display: flex;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }
    
    .form-group {
      flex: 1;
      position: relative;
    }
    
    .form-group--full {
      width: 100%;
      margin-bottom: 1.5rem;
    }

    /* Input field styling */
    .registration__form input {
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

    .registration__form input::placeholder {
      color: #666666;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 1px;
    }

    /* Input focus effect */
    .registration__form input:focus {
      background-color: #000000;
      border-color: #ffffff;
      outline: none;
    }

    /* Button styling */
    .registration__btn {
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
      margin-top: 1.5rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .registration__btn:hover {
      background-color: #000000;
      color: #ffffff;
      border-color: #e11a22;
    }

    .registration__btn:active {
      transform: translateY(1px);
    }

    /* Footer link styling */
    .registration__footer {
      text-align: center;
      margin-top: 2rem;
      color: #666666;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .registration__footer a {
      color: #ffffff;
      text-decoration: none;
      font-weight: 700;
      border-bottom: 1px solid #e11a22;
      padding-bottom: 2px;
      transition: border-color 0.2s linear;
    }
    .registration__footer a:hover {
      border-color: #ffffff;
    }

    /* Feedback messages */
    .feedback {
      padding: 12px;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-align: center;
      color: #ffffff;
    }
    .feedback.error {
      background: #e11a22;
      border: none;
      text-align: left;
    }
    .feedback.error p {
      margin: 0.3rem 0;
    }
    .feedback.success {
      background: #333333;
      border: 1px solid #555555;
    }
    
    @media (max-width: 600px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
      .form-group {
        margin-bottom: 1.5rem;
      }
    }
  </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="registration reveal-3d">
        <h2 class="registration__title">Create an <span>Account</span></h2>

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
            
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="firstName" placeholder="First Name" required value="<?= htmlspecialchars($firstName ?? '') ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="lastName" placeholder="Last Name" required value="<?= htmlspecialchars($lastName ?? '') ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required value="<?= htmlspecialchars($email ?? '') ?>">
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Phone Number" required value="<?= htmlspecialchars($phone ?? '') ?>">
                </div>
            </div>

            <div class="form-group form-group--full">
                <input type="text" name="address" placeholder="Full Address" required value="<?= htmlspecialchars($address ?? '') ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
            <input type="text"
                   name="username"
                   id="username"
                   placeholder="Username"
                   value="<?= htmlspecialchars($username ?? '') ?>"
                   required>
          </div>
          <div class="form-group">
            <select name="userType" id="userType" style="width: 100%; padding: 1rem; border: none; border-bottom: 2px solid #333333; background: transparent; color: #ffffff; font-size: 1rem; margin-top: 10px;" required>
              <option value="buyer" style="color: #000;">Register as Buyer</option>
              <option value="seller" style="color: #000;">Register as Seller</option>
            </select>
          </div>
          <div class="form-group">
            <input type="password"
                   name="password"
                   id="password"
                   placeholder="Password"
                   required>
          </div>
            </div>
            
            <button type="submit" class="registration__btn">Register Now</button>
        </form>

        <!-- Back to home link -->
        <p class="registration__footer">
            Already have an account? <a href="login.php">Sign In</a><br><br>
            <a href="index.php">&larr; Back to Home</a>
        </p>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
