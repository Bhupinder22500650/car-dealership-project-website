<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Cars – COSS</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
 /* ------------------ Form Block ------------------ */
/* Container for forms with centered layout, padding, and dark theme */
.form__container {
  max-width: 500px;           /* Limits form width for readability */
  margin: 3rem auto;          /* Centers form vertically with top/bottom margin */
  padding: 2rem;              /* Inner spacing around form elements */
  background-color: #1e1e1e;  /* Dark background for contrast */
  border-radius: 10px;        /* Rounded corners for modern look */
  box-shadow: 0 0 10px rgba(0, 255, 174, 0.2); /* Soft teal glow */
  text-align: center;         /* Center-aligns headings and buttons */
}

/* Title inside form for section heading */
.form__title {
  font-size: 1.8rem;         /* Larger text for prominence */
  color: #ffffff;            /* White accent color */
  margin-bottom: 1.5rem;     /* Spacing below the title */
}

/* Input fields styling */
.form__input {
  width: 100%;               /* Full width of container */
  margin-bottom: 1rem;       /* Spacing between inputs */
  padding: 12px;             /* Comfortable click area */
  font-size: 1rem;           /* Readable font size */
  background-color: #2c2c2c; /* Slightly lighter dark background */
  border: 1px solid #444;    /* Subtle border for definition */
  color: #e0e0e0;            /* Light text color */
  border-radius: 5px;        /* Slight rounding to match container */
  transition: background-color 0.3s ease; /* Smooth focus change */
}

/* Focus state for inputs to indicate active field */
.form__input:focus {
  background-color: yellow;  /* Highlight background on focus */
  color: #121212;            /* Dark text for readability */
}

/* Button inside form */
.form__btn {
  width: 100%;               /* Full width button */
  padding: 12px;             /* Comfortable click area */
  font-size: 1rem;           /* Matches input text size */
  background-color: #e11a22; /* Red accent button */
  color: #ffffff;            /* White text on red button */
  border: none;              /* No border for flat design */
  border-radius: 5px;        /* Matches form and inputs */
  cursor: pointer;           /* Pointer on hover to show clickability */
  transition: background-color 0.3s ease, transform 0.2s ease; /* Hover effects */
  margin-top: 1rem;          /* Spacing above button */
}

/* Hover state for form button */
.form__btn:hover {
  background-color: #000000; /* Dark on hover */
  transform: scale(1.02);    /* Slight grow effect */
}

/* Link below form for secondary actions */
.form__link {
  display: inline-block;     /* Allows margin and padding */
  margin-top: 1.5rem;        /* Space above link */
  color: #e11a22;            /* Red color for link */
  text-decoration: none;     /* Removes underline */
}

/* Hover state for link to show interactivity */
.form__link:hover {
  text-decoration: underline; /* Underline on hover */
}

/* ------------------ Car Listings Block ------------------ */
/* Wrapper for listings section with padding and background */
.car-listings {
  padding: 2rem;             /* Inner spacing */
  background-color: #181818; /* Slightly different dark tone */
  text-align: center;        /* Centered heading and cards */
}

/* Title for car listings section */
.car-listings__title {
  color: #ffffff;            /* White accent color */
  margin-bottom: 2rem;       /* Spacing below title */
}

/* Flex container for cards, responsive wrapping */
.car-listings__list {
  display: flex;             /* Flex layout for cards */
  flex-wrap: wrap;           /* Wrap cards on small screens */
  justify-content: center;   /* Center cards horizontally */
  gap: 2rem;                 /* Space between cards */
}

/* ------------------ Car Card Block ------------------ */
/* Individual card styling */
.car-card {
  background-color: #111111;
  border-radius: 0;
  width: 320px;
  color: #eeeeee;
  box-shadow: none; /* Removed floating shadow for grounded look */
  border: 1px solid #222222;
  transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  overflow: hidden;
  transform-style: preserve-3d;
  perspective: 1000px;
}

.car-card:hover {
  transform: translateY(-8px) rotateX(1deg) rotateY(-1deg);
  border-color: #e11a22; /* Red accent on hover */
}

.car-card__image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-bottom: 2px solid #e11a22;
}

.car-card__info {
  padding: 1.5rem;
}

.car-card__info-title {
  font-size: 1.4rem;
  color: #ffffff;
  margin: 0 0 0.5rem 0;
  font-weight: 600;
}

.car-card__price {
  font-size: 1.6rem;
  color: #e11a22;
  font-weight: 700;
  margin-bottom: 1rem;
}

.car-card__specs {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}

.car-card__spec {
  background-color: #2c2c2c;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  color: #ffffff;
}

.car-card__actions {
  display: flex;
  gap: 0.8rem;
}

.car-card__btn {
  flex: 1;
  padding: 0.8rem;
  font-size: 0.95rem;
  background-color: #e11a22;
  border: none;
  color: #ffffff;
  border-radius: 0;
  cursor: pointer;
  transition: all 0.2s linear;
  font-weight: 700;
  text-transform: uppercase;
}

.car-card__btn:hover {
  background-color: #000000;
  color: #ffffff;
}

.car-card__view-btn {
  display: block;
  text-align: center;
  background-color: #e11a22; /* Acura Red */
  color: #ffffff;
  padding: 1rem;
  text-decoration: none;
  font-weight: 700;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  border-top: 1px solid #333333;
  transition: background-color 0.2s linear;
}

.car-card__view-btn:hover {
  background-color: #000000;
  color: #ffffff;
}

/* ------------------ Car Popup Block ------------------ */
/* Fullscreen overlay for popup */
.car-popup {
  position: fixed;           /* Sticks to viewport */
  top: 0;                    /* Top of screen */
  left: 0;                   /* Left side */
  width: 100%;               /* Full width */
  height: 100%;              /* Full height */
  background: rgba(18, 18, 18, 0.9); /* Semi-transparent backdrop */
  display: flex;             /* Center popup content */
  justify-content: center;   /* Horizontal centering */
  align-items: center;       /* Vertical centering */
  z-index: 9999;             /* On top of all elements */
}

/* Content wrapper inside popup */
.car-popup__content {
  background-color: #111111; /* Dark background */
  padding: 2rem;             /* Inner spacing */
  max-width: 90%;            /* Responsive width */
  width: 600px;              /* Max fixed width */
  border-radius: 0;       /* Rounded corners */
  border: 1px solid #333333;
  color: #ffffff;               /* White text */
  position: relative;        /* For close button positioning */
  text-align: center;        /* Center text */
}

/* Close button styling */
.car-popup__close-btn {
  position: absolute;        /* Positioned relative to content */
  top: 0.5rem;               /* Offset from top */
  right: 1rem;               /* Offset from right */
  font-size: 2rem;           /* Large click target */
  color: #fff;               /* White color */
  cursor: pointer;           /* Pointer on hover */
}

/* Ensures nested card in popup retains spacing */
.car-popup__content .car-card {
  margin-top: 1rem;          /* Space above card */
}

/* Search Section Styles */
.search {
    background: linear-gradient(to bottom, #1a1a1a, #121212);
    padding: 4rem 1rem;
}

.search__container {
    max-width: 900px;
    margin: 0 auto;
    padding: 4rem 3rem;
    background: #000000;
    border-radius: 0;
    border-top: 4px solid #e11a22; /* Sharp red accent */
    border-bottom: 4px solid #e11a22;
}

.search__title {
    font-size: 2.5rem;
    color: #ffffff;
    margin-bottom: 0.5rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-align: center;
}

.search__subtitle {
    color: #aaaaaa;
    text-align: center;
    margin-bottom: 3rem;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.search__form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.search__input-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.search__input-wrapper {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.search__label {
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.search__input {
    width: 100%;
    padding: 1.2rem;
    background-color: #111111;
    border: 1px solid #333333;
    border-radius: 0; /* Sharp */
    color: #ffffff;
    font-size: 1rem;
    transition: all 0.2s linear;
    box-sizing: border-box;
}

.search__input:focus {
    outline: none;
    border-color: #ffffff;
    background-color: #0a0a0a;
}

.search__input::placeholder {
    color: #666;
}

.search__price-input {
    position: relative;
    display: flex;
    align-items: center;
}

.search__currency {
    position: absolute;
    left: 1rem;
    color: #ffffff;
    font-weight: 600;
}

.search__price-input .search__input {
    padding-left: 2rem;
}

.search__btn {
    width: 100%;
    padding: 1.2rem;
    background: #e11a22;
    color: #ffffff;
    border: 2px solid #e11a22;
    border-radius: 0;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.8rem;
    transition: all 0.2s linear;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.search__btn:hover {
    background: #000000;
    color: #ffffff;
    border-color: #e11a22;
}

.search__btn-icon {
    width: 20px;
    height: 20px;
}

.search__back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #888888;
    text-decoration: none;
    margin-top: 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.85rem;
    transition: color 0.2s linear;
}

.search__back-link:hover {
    color: #e11a22;
}

.search__back-icon {
    width: 20px;
    height: 20px;
}

@media (max-width: 768px) {
    .search__container {
        padding: 1.5rem;
    }

    .search__title {
        font-size: 2rem;
    }

    .search__input-group {
        grid-template-columns: 1fr;
    }
}

</style>

</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Search Form -->
    <main class="search reveal-3d">
        <div class="search__container">
            <h2 class="search__title">Find Your Perfect Car</h2>
            <p class="search__subtitle">Search through our extensive premium collection of vehicles</p>
            <form id="carSearchForm" class="search__form" method="GET" action="search.php">
                <div class="search__input-group">
                    <div class="search__input-wrapper">
                        <label for="searchBrand" class="search__label">Brand</label>
                        <input class="search__input" type="text" id="searchBrand" name="brand" 
                               placeholder="e.g. Acura" value="<?php echo htmlspecialchars($brand); ?>">
                    </div>
                    <div class="search__input-wrapper">
                        <label for="searchModel" class="search__label">Model</label>
                        <input class="search__input" type="text" id="searchModel" name="model" 
                               placeholder="e.g. NSX" value="<?php echo htmlspecialchars($model); ?>">
                    </div>
                    <div class="search__input-wrapper">
                        <label for="searchYear" class="search__label">Year</label>
                        <input class="search__input" type="text" id="searchYear" name="year" 
                               placeholder="e.g. 2024" value="<?php echo htmlspecialchars($year); ?>">
                    </div>
                    <div class="search__input-wrapper">
                        <label for="searchPrice" class="search__label">Max Price</label>
                        <div class="search__price-input">
                            <span class="search__currency">$</span>
                            <input class="search__input" type="text" id="searchPrice" name="price" 
                                   placeholder="e.g. 50000" value="<?php echo htmlspecialchars($price); ?>">
                        </div>
                    </div>
                    <div class="search__input-wrapper">
                        <label for="searchMileage" class="search__label">Max Mileage (km)</label>
                        <input class="search__input" type="text" id="searchMileage" name="mileage" 
                               placeholder="e.g. 100000" value="<?php echo htmlspecialchars($mileage); ?>">
                    </div>
                    <div class="search__input-wrapper">
                        <label for="searchTransmission" class="search__label">Transmission</label>
                        <select class="search__input" id="searchTransmission" name="transmission">
                            <option value="">Any</option>
                            <option value="Automatic" <?php echo $transmission === 'Automatic' ? 'selected' : ''; ?>>Automatic</option>
                            <option value="Manual" <?php echo $transmission === 'Manual' ? 'selected' : ''; ?>>Manual</option>
                        </select>
                    </div>
                    <div class="search__input-wrapper">
                        <label for="searchFuel" class="search__label">Fuel Type</label>
                        <select class="search__input" id="searchFuel" name="fuel_type">
                            <option value="">Any</option>
                            <option value="Petrol" <?php echo $fuel_type === 'Petrol' ? 'selected' : ''; ?>>Petrol</option>
                            <option value="Diesel" <?php echo $fuel_type === 'Diesel' ? 'selected' : ''; ?>>Diesel</option>
                            <option value="Hybrid" <?php echo $fuel_type === 'Hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                            <option value="Electric" <?php echo $fuel_type === 'Electric' ? 'selected' : ''; ?>>Electric</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="search__btn">
                    <span class="search__btn-text">Search Cars</span>
                    <svg class="search__btn-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" 
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
            <a class="search__back-link" href="index.php">
                <svg class="search__back-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Home
            </a>
        </div>
    </main>

    <!-- AVAILABLE CARS SECTION -->
    <section class="car-listings reveal-3d">
      <h2 class="car-listings__title">Available Cars</h2>
      <div class="car-listings__list">
        <?php
        if ($result->num_rows > 0) {
            while ($car = $result->fetch_assoc()) {
                ?>
                <div class="car-card reveal-3d">
                    <img class="car-card__image" src="<?php echo htmlspecialchars($car['image_url'] ?? 'assets/img/default-car.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($car['car_model']); ?>">
                    <div class="car-card__info">
                        <h3 class="car-card__info-title"><?php echo htmlspecialchars($car['company_name'] . ' ' . $car['car_model']); ?></h3>
                        <div class="car-card__price">$<?php echo number_format($car['price']); ?></div>
                        <div class="car-card__specs">
                            <span class="car-card__spec"><?php echo htmlspecialchars($car['car_year']); ?></span>
                            <span class="car-card__spec"><?php echo htmlspecialchars($car['transmission']); ?></span>
                            <span class="car-card__spec"><?php echo htmlspecialchars($car['fuel_type']); ?></span>
                            <span class="car-card__spec"><?php echo number_format($car['mileage']); ?> km</span>
                            <span class="car-card__spec"><?php echo htmlspecialchars($car['location']); ?></span>
                        </div>
                        <div class="car-card__actions">
                            <button class="car-card__btn" onclick="viewDetails(<?php echo $car['car_id']; ?>)">View Details</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="no-results">
                <h3>No cars found matching your criteria</h3>
                <p>Please try adjusting your search filters or <a href="search.php">clear all filters</a></p>
            </div>
            <?php
        }
        ?>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script>
    function viewDetails(carId) {
        window.location.href = `car-details.php?id=${carId}`;
    }
    </script>
</body>
</html>
