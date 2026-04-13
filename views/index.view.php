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
       Inline Hero Section Styles (Acura-style Precision)
       ------------------------------------------------------------------------ -->
  <style>
    /* ------------------------------------------
       Hero Section Styling
    ------------------------------------------- */
    .hero {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
      min-height: 70vh;
      text-align: center;
      background: #000000;
      color: #fff;
      perspective: 1000px;
      position: relative;
    }
    
    .hero__content {
      position: absolute;
      bottom: 20%;
      left: 10%;
      text-align: left;
      z-index: 10;
      transform-style: preserve-3d;
      max-width: 600px;
    }
    
    .hero__title {
      font-size: 5rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 2px;
      line-height: 1.1;
      margin-bottom: 0.5rem;
      color: #ffffff;
      transform: translateZ(50px);
    }
    
    .hero__text {
      font-size: 1.25rem;
      font-weight: 400;
      margin-bottom: 2rem;
      color: #aaaaaa;
      text-transform: uppercase;
      letter-spacing: 1px;
      transform: translateZ(30px);
    }
    
    .hero__btn {
      padding: 1rem 3rem;
      font-size: 0.9rem;
      font-weight: 700;
      background-color: transparent;
      color: #ffffff;
      text-decoration: none;
      border: 2px solid #ffffff;
      text-transform: uppercase;
      letter-spacing: 2px;
      display: inline-block;
      transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
      transform: translateZ(40px);
    }
    
    .hero__btn:hover {
      background-color: #e11a22;           /* Precision Red */
      border-color: #e11a22;
      color: #ffffff;
      transform: scale(1.02) translateZ(50px);
    }

    /* ------------------------------------------
       Features Section Styling
    ------------------------------------------- */
    .features {
      padding: 5rem 2rem;
      text-align: center;
      background-color: #0a0a0a;
    }
    
    .features__title {
      font-size: 2rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 3rem;
      color: #ffffff;
    }
    
    .features__grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1px; /* Sharp grid borders */
      background-color: #222222;
      margin: 0 auto;
      max-width: 1200px;
    }
    
    .features__item {
      background-color: #111111;
      padding: 4rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #cccccc;
      transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
      transform-style: preserve-3d;
      perspective: 1000px;
      /* No border radius */
    }
    
    .features__item:hover {
      background-color: #e11a22;
      color: #ffffff;
      transform: scale(1.02);
      z-index: 2;
      box-shadow: 0 20px 40px rgba(0,0,0,0.8);
    }
  </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section with Integrated Banner -->
    <section class="hero reveal-3d">
        <img
            src="assets/img/banner.jpg"
            alt="Award-Winning BMW Cars"
            style="
                position: absolute;
                top: 0; left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 1;
                filter: brightness(0.6);
            "
        />
        <div class="hero__content">
            <h2 class="hero__title">Buy.<br>Sell.<br>Drive.</h2>
            <p class="hero__text">Precision performance in your hands.</p>

            <!-- Conditional Call-to-Action Button -->
            <?php if (isset($_SESSION['seller_id'])): ?>
                <a href="cars.php" class="hero__btn">List Inventory</a>
            <?php else: ?>
                <a href="registration.php" class="hero__btn">Explore Now</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features reveal-3d">
        <h3 class="features__title">Why Choose Us?</h3>
        <div class="features__grid">
            <div class="features__item reveal-3d">Easy Listings</div>
            <div class="features__item reveal-3d">Smart Search</div>
            <div class="features__item reveal-3d">Verified Feedback</div>
            <div class="features__item reveal-3d">Responsive Design</div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
