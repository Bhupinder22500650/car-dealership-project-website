<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?> - COSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <style>
        .car-detail {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #1e1e1e;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0,255,174,0.15);
            transition: transform 0.3s ease;
        }

        .car-detail:hover {
            transform: translateY(-5px);
        }

        .car-detail__header {
            display: flex;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .car-detail__image-container {
            width: 100%;
            max-width: 600px;
            position: relative;
            overflow: hidden;
            border-radius: 0;
            border: 1px solid #333333;
        }

        .car-detail__image {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 0;
            border: none;
            transition: transform 0.2s linear;
        }

        .car-detail__image:hover {
            transform: scale(1.02);
        }

        .car-detail__info {
            flex: 1;
            padding: 1rem;
        }

        .car-detail__title {
            font-size: 2.5rem;
            color: #ffffff;
            margin-bottom: 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .car-detail__price {
            font-size: 2rem;
            color: #e11a22; /* Acura Red */
            font-weight: 700;
            margin-bottom: 2rem;
            letter-spacing: 1px;
        }

        /* Buttons */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            margin: 2rem 0;
            padding: 0.8rem 1.5rem;
            border: 2px solid #555555;
            border-radius: 0;
            transition: all 0.2s linear;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .back-link:hover {
            background-color: #ffffff;
            color: #000000;
            transform: translateX(-5px);
        }

        .btn-action {
            display: block;
            width: 100%;
            text-align: center;
            padding: 1.2rem;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            border-radius: 0; /* Sharp edges */
            cursor: pointer;
            transition: all 0.2s linear;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid transparent;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #e11a22;
            color: #ffffff;
            border-color: #e11a22;
        }

        .btn-primary:hover {
            background-color: #000000;
            color: #ffffff;
        }

        .car-detail__specs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .car-detail__spec-item {
            background-color: #2c2c2c;
            padding: 1.5rem;
            border-radius: 0; /* Sharp edges */
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .car-detail__spec-item:hover {
            background-color: #363636;
            border-color: #e11a22; /* Red accent on hover */
            transform: translateY(-3px);
        }

        .car-detail__spec-label {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .car-detail__spec-value {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .car-detail__actions {
            display: flex;
            gap: 1.5rem;
            margin-top: 2.5rem;
        }

        .car-detail__button {
            padding: 1.2rem 2.5rem;
            font-size: 1.1rem;
            border: none;
            border-radius: 0; /* Sharp edges */
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .car-detail__button--primary {
            background-color: #e11a22; /* Pure red */
            color: #ffffff;
            box-shadow: none; /* Removed */
        }

        .car-detail__button--secondary {
            background-color: transparent;
            color: #e11a22; /* Pure red */
            border: 2px solid #e11a22; /* Pure red */
            box-shadow: none; /* Removed */
        }

        .car-detail__button:hover {
            transform: translateY(-3px);
            box-shadow: none; /* Removed */
        }

        .car-detail__button--secondary:hover {
            background-color: rgba(225,26,34,0.1); /* Red accent on hover */
        }

        /* Full Details Section */
        .car-detail__full-info {
            background: #111111;
            padding: 3rem;
            border: 1px solid #222222;
            margin-bottom: 2rem;
        }

        .car-detail__section-title {
            font-size: 1.5rem;
            color: #ffffff;
            margin-bottom: 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #333333;
            padding-bottom: 0.5rem;
        }

        .car-detail__description {
            line-height: 1.8;
            color: #cccccc;
            font-size: 1.05rem;
            white-space: pre-wrap; /* Preserves newlines from textarea */
        }

        /* Seller Info */
        .car-detail__seller {
            padding: 2rem 3rem;
            background: #0a0a0a;
            border: 1px solid #222222;
            border-left: 4px solid #e11a22; /* Sharp red accent */
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 4rem;
        }

        .car-detail__seller-title {
            font-size: 1.2rem;
            color: #ffffff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .car-detail__seller-name {
            color: #cccccc;
            font-size: 1.1rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .car-detail {
                margin: 1rem;
                padding: 1.5rem;
            }

            .car-detail__header {
                flex-direction: column;
                gap: 2rem;
            }

            .car-detail__image-container {
                max-width: 100%;
            }

            .car-detail__specs {
                grid-template-columns: 1fr;
            }

            .car-detail__actions {
                flex-direction: column;
            }

            .car-detail__button {
                width: 100%;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
        }

        .modal-content {
            background-color: #111111;
            margin: 10% auto;
            padding: 2rem;
            border: 1px solid #333333;
            border-top: 4px solid #e11a22; /* Red top border */
            border-radius: 0;
            width: 80%;
            max-width: 600px;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            position: absolute;
            right: 1.5rem;
            top: 1rem;
            color: #888888;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s linear;
        }

        .close:hover {
            color: #fff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
        }

        .form-group select,
        .form-group textarea,
        .form-group input[type="email"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #333333;
            border-radius: 0; /* Sharp edges */
            background-color: #111111;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.2s linear;
        }

        .form-group select:focus,
        .form-group textarea:focus,
        .form-group input[type="email"]:focus {
            outline: none;
            border-color: #ffffff;
            background-color: #0a0a0a;
        }

        .form-group input[type="email"]::placeholder {
            color: #666;
        }

        .form-group input[type="email"]:hover {
            border-color: #ffffff;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="car-detail">
        <div class="car-detail__header">
            <div class="car-detail__image-container">
                <?php if ($car['image_url'] && file_exists($car['image_url'])): ?>
                    <img src="<?= htmlspecialchars($car['image_url']) ?>" 
                         alt="<?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?>" 
                         class="car-detail__image">
                <?php else: ?>
                    <img src="assets/img/default-car.jpg" 
                         alt="Default Car Image" 
                         class="car-detail__image">
                <?php endif; ?>
            </div>
            
            <div class="car-detail__info">
                <h1 class="car-detail__title">
                    <?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?>
                </h1>
                <div class="car-detail__price">
                    $<?= number_format($car['price'], 2) ?>
                </div>
                
                <div class="car-detail__specs">
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Year</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['car_year']) ?></div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Transmission</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['transmission'] ?? 'N/A') ?></div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Fuel Type</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Mileage</div>
                        <div class="car-detail__spec-value"><?= number_format($car['mileage'] ?? 0) ?> km</div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Body Type</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['body_type']) ?></div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Location</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['location']) ?></div>
                    </div>
                </div>
                
                <div class="car-detail__full-info">
                    <h2 class="car-detail__section-title">Vehicle Overview</h2>
                    <div class="car-detail__description">
                        <?= !empty($car['description']) ? htmlspecialchars($car['description']) : 'No description provided for this vehicle.' ?>
                    </div>
                </div>

                <div class="car-detail__actions">
                    <button class="car-detail__button car-detail__button--primary" onclick="openContactModal()">
                        Contact Seller
                    </button>
                    <a href="search.php" class="car-detail__button car-detail__button--secondary" style="text-decoration: none; text-align: center;">
                        Back to Search
                    </a>
                </div>
            </div>
        </div>

        <div class="car-detail__seller">
            <h3 class="car-detail__seller-title">About the Seller</h3>
            <p class="car-detail__seller-name"><?= htmlspecialchars($car['seller_name']) ?></p>
        </div>
    </main>

    <!-- Contact Seller Modal -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Direct Message Seller</h2>
            <form id="contactForm" action="api/send_message.php" method="POST">
                <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                <input type="hidden" name="receiver_id" value="<?= $car['seller_id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <div class="form-group">
                    <label for="message">Your Message:</label>
                    <textarea name="message" id="message" rows="4" required placeholder="Hi, I am interested in this <?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?>..."></textarea>
                </div>
                <button type="submit" class="car-detail__button car-detail__button--primary">Send Message</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Modal functionality
        const modal = document.getElementById('contactModal');
        const closeBtn = document.getElementsByClassName('close')[0];

        function openContactModal() {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert('Please login as a registered Buyer or Seller to send messages.');
                window.location.href = 'login.php';
                return;
            <?php endif; ?>
            modal.style.display = 'block';
        }

        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Form submission
        document.getElementById('contactForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('api/send_message.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Message sent successfully! The seller will be notified.');
                    modal.style.display = 'none';
                    this.reset();
                } else {
                    alert(data.message || 'Error sending message. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error sending message. Please try again.');
            });
        };
    </script>
</body>
</html> 
