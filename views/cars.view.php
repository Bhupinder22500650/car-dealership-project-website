<!DOCTYPE html>
<html lang="en">
<head>
  <?php // ---------------------------------------------------------------------- ?>
  <?php // Page metadata & resources                                      ?>
  <?php // ---------------------------------------------------------------------- ?>
  <meta charset="UTF-8">
  <title>Manage Cars – COSS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>

  <?php // ---------------------------------------------------------------------- ?>
  <?php // Inline styles for car listing form                              ?>
  <?php // ---------------------------------------------------------------------- ?>
  <style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        margin: 0;
        background-color: #121212;
        color: #e0e0e0;
    }
    main {
        flex: 1;
        padding: 2rem;
    }
    .car-form {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      background-color: #1e1e1e;
      border-radius: 15px;
      box-shadow: 0 0 30px rgba(0,255,174,0.15);
      transition: transform 0.3s ease;
    }

    .car-form:hover {
      transform: translateY(-5px);
    }

    .car-form__title {
      font-size: 2.5rem;
      color: #ffffff;
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .car-form__grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .car-form__input {
      width: 100%;
      padding: 1rem;
      font-size: 1rem;
      background-color: #2c2c2c;
      border: 1px solid #444;
      color: #e0e0e0;
      border-radius: 8px;
      transition: all 0.3s ease;
      margin-bottom: 1rem;
      box-sizing: border-box;
    }

    .car-form__input:focus {
      background-color: #333;
      outline: none;
      border-color: #ffffff;
    }

    .car-form__input::placeholder {
      color: #888;
    }

    .car-form__button {
      width: 100%;
      padding: 1.2rem;
      font-size: 1.1rem;
      background: #e11a22;
      color: #ffffff;
      border: 2px solid #e11a22;
      border-radius: 0; /* Sharp edges */
      cursor: pointer;
      transition: all 0.2s linear;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-top: 1rem;
      box-sizing: border-box;
    }

    .car-form__button:hover {
      background: #000000;
      color: #ffffff;
      border-color: #e11a22;
    }

    .cars-list {
      margin-top: 3rem;
    }

    .cars-list__title {
      font-size: 2rem;
      color: #ffffff;
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .car-item {
      background-color: #111111;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      border-radius: 0;
      display: flex;
      align-items: center;
      gap: 2rem;
      transition: all 0.2s linear;
      border: 1px solid #222222;
    }

    .car-item:hover {
      transform: translateY(-3px);
      border-color: #e11a22; /* Red accent */
    }

    .car-info {
      flex-grow: 1;
    }

    .car-info__title {
      font-size: 1.4rem;
      color: #fff;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .car-info__details {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      margin-top: 1rem;
    }

    .car-info__detail {
      background-color: #363636;
      padding: 0.8rem;
      border-radius: 8px;
      font-size: 0.9rem;
    }

    .car-info__label {
      color: #888;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 0.3rem;
    }

    .car-info__value {
      color: #fff;
      font-weight: 500;
    }

    .car-actions {
      display: flex;
      gap: 1rem;
      flex-direction: column;
    }

    .car-actions button {
      padding: 0.8rem 1.5rem;
      border: 2px solid transparent;
      border-radius: 0; /* Sharp edges */
      cursor: pointer;
      transition: all 0.2s linear;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 0.9rem;
    }

    .edit-btn {
      background-color: #e11a22;
      color: #ffffff;
    }

    .upload-btn {
      background-color: transparent;
      color: #ffffff;
      border: 2px solid #555555 !important;
    }
    
    .upload-btn:hover {
      border: 2px solid #ffffff !important;
    }

    .delete-btn {
      background-color: transparent;
      color: #ff4d4d;
      border: 2px solid #ff4d4d !important;
    }

    .car-actions button:hover {
      background-color: #000000;
      color: #ffffff;
    }

    .car-image {
      width: 200px;
      height: 150px;
      object-fit: cover;
      border-radius: 0;
      border: 2px solid #333333;
      transition: transform 0.3s ease;
    }

    .car-image:hover {
      transform: scale(1.05);
    }

    .car-image-placeholder {
      width: 200px;
      height: 150px;
      background-color: #111111;
      border: 2px solid #333333;
      border-radius: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #666;
      font-size: 0.9rem;
      text-align: center;
      transition: all 0.2s linear;
    }

    .car-image-placeholder:hover {
      border-color: #ffffff;
      color: #888;
    }

    .feedback {
      padding: 1.2rem;
      margin-bottom: 2rem;
      border-radius: 8px;
      text-align: center;
      font-weight: 500;
      animation: fadeIn 0.3s ease;
    }

    .feedback.error {
      background-color: rgba(255, 77, 77, 0.1);
      color: #ff4d4d;
      border: 1px solid rgba(255, 77, 77, 0.3);
    }

    .feedback.success {
      background-color: transparent;
      color: #ffffff;
      border: 1px solid #333333;
      border-left: 4px solid #e11a22; /* Red accent on success */
    }

    .edit-form {
      display: none;
      margin-top: 1.5rem;
      padding: 1.5rem;
      background-color: #111111;
      border-radius: 0;
      border: 1px solid #333333;
      animation: slideDown 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideDown {
      from { 
        opacity: 0;
        transform: translateY(-10px);
      }
      to { 
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .car-form__grid {
        grid-template-columns: 1fr;
      }

      .car-item {
        flex-direction: column;
        text-align: center;
      }

      .car-info__details {
        grid-template-columns: 1fr;
      }

      .car-actions {
        flex-direction: row;
        justify-content: center;
      }

      .car-image, .car-image-placeholder {
        width: 100%;
        height: 200px;
      }
    }
  </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="car-form">
        <h2 class="car-form__title">Manage Your Cars</h2>

        <!-- Display feedback messages -->
        <?php if ($error): ?>
            <div class="feedback error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="feedback success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Add Car Form -->
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="addCarForm" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div class="car-form__grid">
                <input type="text" name="company" class="car-form__input" placeholder="Company Name" required value="<?= htmlspecialchars($company) ?>">
                <input type="text" name="model" class="car-form__input" placeholder="Car Model" required value="<?= htmlspecialchars($model) ?>">
                <input type="number" name="year" class="car-form__input" placeholder="Year" min="1900" max="<?= date('Y') ?>" required value="<?= htmlspecialchars($year) ?>">
                <input type="number" name="price" class="car-form__input" placeholder="Price" step="0.01" required value="<?= htmlspecialchars($price) ?>">
                <input type="number" name="mileage" class="car-form__input" placeholder="Mileage (km)" required value="<?= htmlspecialchars($mileage) ?>">
                <select name="transmission" class="car-form__input" required>
                    <option value="">Select Transmission</option>
                    <option value="Automatic" <?= $transmission === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                    <option value="Manual" <?= $transmission === 'Manual' ? 'selected' : '' ?>>Manual</option>
                </select>
                <select name="fuelType" class="car-form__input" required>
                    <option value="">Select Fuel Type</option>
                    <option value="Petrol" <?= $fuelType === 'Petrol' ? 'selected' : '' ?>>Petrol</option>
                    <option value="Diesel" <?= $fuelType === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                    <option value="Hybrid" <?= $fuelType === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                    <option value="Electric" <?= $fuelType === 'Electric' ? 'selected' : '' ?>>Electric</option>
                </select>
                <input type="text" name="location" class="car-form__input" placeholder="Location" required value="<?= htmlspecialchars($location) ?>">
                <select name="bodyType" class="car-form__input" required>
                    <option value="">Select Body Type</option>
                    <option value="Sedan" <?= $bodyType === 'Sedan' ? 'selected' : '' ?>>Sedan</option>
                    <option value="SUV" <?= $bodyType === 'SUV' ? 'selected' : '' ?>>SUV</option>
                    <option value="Hatchback" <?= $bodyType === 'Hatchback' ? 'selected' : '' ?>>Hatchback</option>
                    <option value="Coupe" <?= $bodyType === 'Coupe' ? 'selected' : '' ?>>Coupe</option>
                    <option value="Convertible" <?= $bodyType === 'Convertible' ? 'selected' : '' ?>>Convertible</option>
                    <option value="Wagon" <?= $bodyType === 'Wagon' ? 'selected' : '' ?>>Wagon</option>
                    <option value="Van" <?= $bodyType === 'Van' ? 'selected' : '' ?>>Van</option>
                    <option value="Truck" <?= $bodyType === 'Truck' ? 'selected' : '' ?>>Truck</option>
                </select>
            </div>
            <textarea name="description" class="car-form__input" placeholder="Vehicle Description" rows="4" style="resize:none;" required><?= htmlspecialchars($description) ?></textarea>
            <input type="file" name="car_image" class="car-form__input" accept="image/*" id="carImage">
            <button type="submit" class="car-form__button">Add Car</button>
        </form>

        <!-- Cars List -->
        <div class="cars-list">
            <h3 class="cars-list__title">Your Listed Cars</h3>
            <?php foreach ($cars as $car): ?>
                <div class="car-item" id="car-<?= $car['car_id'] ?>">
                    <?php if ($car['image_url'] && file_exists($car['image_url'])): ?>
                        <img src="<?= htmlspecialchars($car['image_url']) ?>" alt="<?= htmlspecialchars($car['car_model']) ?>" class="car-image">
                    <?php else: ?>
                        <div class="car-image-placeholder">
                            No Image<br>Available
                        </div>
                    <?php endif; ?>
                    <div class="car-info">
                        <h4 class="car-info__title"><?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?></h4>
                        <div class="car-info__details">
                            <div class="car-info__detail">
                                <div class="car-info__label">Year</div>
                                <div class="car-info__value"><?= htmlspecialchars($car['car_year']) ?></div>
                            </div>
                            <div class="car-info__detail">
                                <div class="car-info__label">Price</div>
                                <div class="car-info__value">$<?= number_format($car['price'], 2) ?></div>
                            </div>
                            <div class="car-info__detail">
                                <div class="car-info__label">Location</div>
                                <div class="car-info__value"><?= htmlspecialchars($car['location']) ?></div>
                            </div>
                            <div class="car-info__detail">
                                <div class="car-info__label">Body Type</div>
                                <div class="car-info__value"><?= htmlspecialchars($car['body_type']) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="car-actions">
                        <button class="edit-btn" onclick="showEditForm(<?= $car['car_id'] ?>)">Edit</button>
                        <button class="upload-btn" onclick="uploadCarImage(<?= $car['car_id'] ?>)" data-car-id="<?= $car['car_id'] ?>">Upload Image</button>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="display: inline;">
                            <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <button type="submit" name="delete_car" class="delete-btn" onclick="return confirm('Are you sure you want to delete this car?')">Delete</button>
                        </form>
                    </div>
                </div>
                <!-- Edit Form (Hidden by default) -->
                <div class="edit-form" id="edit-form-<?= $car['car_id'] ?>">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="editCarForm-<?= $car['car_id'] ?>">
                        <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <div class="car-form__grid">
                            <input type="text" name="company" class="car-form__input" value="<?= htmlspecialchars($car['company_name']) ?>" required>
                            <input type="text" name="model" class="car-form__input" value="<?= htmlspecialchars($car['car_model']) ?>" required>
                            <input type="number" name="year" class="car-form__input" value="<?= htmlspecialchars($car['car_year']) ?>" required>
                            <input type="number" name="price" class="car-form__input" value="<?= htmlspecialchars($car['price']) ?>" step="0.01" required>
                            <input type="number" name="mileage" class="car-form__input" value="<?= htmlspecialchars($car['mileage']) ?>" required>
                            <select name="transmission" class="car-form__input" required>
                                <option value="Automatic" <?= $car['transmission'] === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                                <option value="Manual" <?= $car['transmission'] === 'Manual' ? 'selected' : '' ?>>Manual</option>
                            </select>
                            <select name="fuelType" class="car-form__input" required>
                                <option value="Petrol" <?= $car['fuel_type'] === 'Petrol' ? 'selected' : '' ?>>Petrol</option>
                                <option value="Diesel" <?= $car['fuel_type'] === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                                <option value="Hybrid" <?= $car['fuel_type'] === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                                <option value="Electric" <?= $car['fuel_type'] === 'Electric' ? 'selected' : '' ?>>Electric</option>
                            </select>
                            <input type="text" name="location" class="car-form__input" value="<?= htmlspecialchars($car['location']) ?>" required>
                            <select name="bodyType" class="car-form__input" required>
                                <option value="Sedan" <?= $car['body_type'] === 'Sedan' ? 'selected' : '' ?>>Sedan</option>
                                <option value="SUV" <?= $car['body_type'] === 'SUV' ? 'selected' : '' ?>>SUV</option>
                                <option value="Hatchback" <?= $car['body_type'] === 'Hatchback' ? 'selected' : '' ?>>Hatchback</option>
                                <option value="Coupe" <?= $car['body_type'] === 'Coupe' ? 'selected' : '' ?>>Coupe</option>
                                <option value="Convertible" <?= $car['body_type'] === 'Convertible' ? 'selected' : '' ?>>Convertible</option>
                                <option value="Wagon" <?= $car['body_type'] === 'Wagon' ? 'selected' : '' ?>>Wagon</option>
                                <option value="Van" <?= $car['body_type'] === 'Van' ? 'selected' : '' ?>>Van</option>
                                <option value="Truck" <?= $car['body_type'] === 'Truck' ? 'selected' : '' ?>>Truck</option>
                            </select>
                        </div>
                        <textarea name="description" class="car-form__input" rows="4" style="resize:none;" required><?= htmlspecialchars($car['description']) ?></textarea>
                        <button type="submit" name="edit_car" class="car-form__button">Update Car</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script>
        const csrfToken = '<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) ?>';

        function showEditForm(carId) {
            const editForm = document.getElementById(`edit-form-${carId}`);
            if (editForm.style.display === 'block') {
                editForm.style.display = 'none';
            } else {
                // Hide all other edit forms first
                document.querySelectorAll('.edit-form').forEach(form => {
                    form.style.display = 'none';
                });
                editForm.style.display = 'block';
            }
        }

        // Add image upload functionality
        function uploadCarImage(carId) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('car_image', file);
                formData.append('car_id', carId);
                formData.append('csrf_token', csrfToken);

                // Show loading state
                const uploadBtn = document.querySelector(`[data-car-id="${carId}"]`);
                const originalText = uploadBtn.textContent;
                uploadBtn.textContent = 'Uploading...';
                uploadBtn.disabled = true;

                fetch('api/upload_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update image on the page
                        const carItem = uploadBtn.closest('.car-item');
                        const imgContainer = carItem.querySelector('.car-image, .car-image-placeholder');
                        if (imgContainer) {
                            if (imgContainer.classList.contains('car-image-placeholder')) {
                                const newImg = document.createElement('img');
                                newImg.src = data.image_url;
                                newImg.alt = carItem.querySelector('h4').textContent;
                                newImg.className = 'car-image';
                                imgContainer.parentNode.replaceChild(newImg, imgContainer);
                            } else {
                                imgContainer.src = data.image_url;
                            }
                        }
                        
                        // Show success message
                        alert('Image uploaded successfully!');
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    alert('Error uploading image: ' + error.message);
                })
                .finally(() => {
                    // Reset button state
                    uploadBtn.textContent = originalText;
                    uploadBtn.disabled = false;
                });
            };

            input.click();
        }
    </script>
</body>
</html>
