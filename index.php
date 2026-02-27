<?php
// --------------------------------------------------------------------------
// Initialize session for tracking logged‐in users across pages
// --------------------------------------------------------------------------
session_start();

// --------------------------------------------------------------------------
// Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/db/db_connect.php';
require_once __DIR__ . '/db/create_tables.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ------------------------------------------------------------------------
       Document Metadata
       ------------------------------------------------------------------------ -->
  <meta charset="UTF-8">
  <title>Car Online Sale System (COSS)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ------------------------------------------------------------------------
       Stylesheets & Scripts
       ------------------------------------------------------------------------ -->
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>

  <!-- ------------------------------------------------------------------------
       Inline Hero Section Styles
       ------------------------------------------------------------------------ -->
  <style>
    /* ------------------------------------------
       Hero Section Styling
    ------------------------------------------- */
    .hero {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 4rem 2rem;
      text-align: center;
      background: linear-gradient(135deg, #2c2c2c, #1f1f1f);
      color: #fff;
    }
    .hero__content {
      max-width: 600px;
    }
    .hero__title {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
    .hero__text {
      font-size: 1.2rem;
      margin-bottom: 2rem;
    }
    .hero__btn {
      padding: 0.75rem 2rem;
      font-size: 1rem;
      background-color: #00ffae;
      color: #121212;
      text-decoration: none;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
    .hero__btn:hover {
      background-color: #00c68e;
      transform: scale(1.05);
    }

    /* ------------------------------------------
       Features Section Styling
    ------------------------------------------- */
    .features {
      padding: 2rem;
      text-align: center;
    }
    .features__title {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    .features__grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
      margin-top: 1rem;
    }
    .features__item {
      background-color: #1e1e1e;
      padding: 1rem;
      border-radius: 8px;
      font-size: 1rem;
    }

    /* ------------------------------------------
       Footer Section Styling
    ------------------------------------------- */
    .footer {
      background-color: #1c1c1c;
      padding: 2rem;
      text-align: center;
      color: #e0e0e0;
      margin-top: 3rem;
    }
    .footer__text {
      margin: 0.3rem 0;
    }
    .footer__link {
      color: #00ffae;
      text-decoration: none;
    }
    .footer__link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Banner Image -->
    <section style="width:100%; overflow:hidden; margin-bottom:2rem;">
        <img
            src="assets/img/banner.jpg"
            alt="Award-Winning BMW Cars"
            style="
                width: 100%;
                height: auto;
                display: block;
                border-bottom: 3px solid #00ffae;
                box-shadow: 0 2px 10px rgba(0,0,0,0.4);
            "
        />
    </section>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero__content">
            <h2 class="hero__title">Buy. Sell. Drive.</h2>
            <p class="hero__text">New Zealand's trusted online car marketplace.</p>

            <!-- Conditional Call-to-Action Button -->
            <?php if (isset($_SESSION['seller_id'])): ?>
                <a href="cars.php" class="hero__btn">List a Car</a>
            <?php else: ?>
                <a href="registration.php" class="hero__btn">Get Started</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h3 class="features__title">Why Choose Us?</h3>
        <div class="features__grid">
            <div class="features__item">🚗 Easy Listings</div>
            <div class="features__item">🔍 Smart Search</div>
            <div class="features__item">⭐ Real Feedback</div>
            <div class="features__item">📱 Mobile Friendly</div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
