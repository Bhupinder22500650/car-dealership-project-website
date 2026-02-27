<?php
// --------------------------------------------------------------------------
// 1. Start session
// --------------------------------------------------------------------------
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --------------------------------------------------------------------------
// 2. Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/db/db_connect.php';
require_once __DIR__ . '/db/create_tables.php';

// --------------------------------------------------------------------------
// 3. Get car ID from URL parameter
// --------------------------------------------------------------------------
$car_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($car_id <= 0) {
    header('Location: index.php');
    exit;
}

// --------------------------------------------------------------------------
// 4. Fetch car details
// --------------------------------------------------------------------------
$stmt = $conn->prepare("
    SELECT c.*, s.username as seller_name 
    FROM cars c 
    LEFT JOIN seller s ON c.seller_id = s.seller_id 
    WHERE c.car_id = ?
");
$stmt->bind_param('i', $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    header('Location: index.php');
    exit;
}

$stmt->close();
$conn->close();
?>

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
            flex: 1;
            max-width: 600px;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .car-detail__image {
            width: 100%;
            height: auto;
            border-radius: 15px;
            border: 2px solid #00ffae;
            transition: transform 0.5s ease;
        }

        .car-detail__image:hover {
            transform: scale(1.05);
        }

        .car-detail__info {
            flex: 1;
            padding: 1rem;
        }

        .car-detail__title {
            font-size: 2.5rem;
            color: #00ffae;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(0,255,174,0.3);
        }

        .car-detail__price {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 2rem;
            font-weight: 600;
            background: linear-gradient(45deg, #00ffae, #00ccff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
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
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .car-detail__spec-item:hover {
            background-color: #363636;
            border-color: #00ffae;
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
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .car-detail__button--primary {
            background: linear-gradient(45deg, #00ffae, #00ccff);
            color: #121212;
            box-shadow: 0 4px 15px rgba(0,255,174,0.3);
        }

        .car-detail__button--secondary {
            background-color: transparent;
            color: #00ffae;
            border: 2px solid #00ffae;
            box-shadow: 0 4px 15px rgba(0,255,174,0.1);
        }

        .car-detail__button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,255,174,0.4);
        }

        .car-detail__button--secondary:hover {
            background-color: rgba(0,255,174,0.1);
        }

        .car-detail__seller {
            margin-top: 3rem;
            padding: 2rem;
            background-color: #2c2c2c;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .car-detail__seller:hover {
            border-color: #00ffae;
            transform: translateY(-3px);
        }

        .car-detail__seller-title {
            color: #00ffae;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .car-detail__seller-name {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 500;
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
            background-color: #1e1e1e;
            margin: 10% auto;
            padding: 2rem;
            border: 1px solid #00ffae;
            border-radius: 15px;
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
            color: #00ffae;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #fff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #00ffae;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group select,
        .form-group textarea,
        .form-group input[type="email"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #00ffae;
            border-radius: 8px;
            background-color: #2c2c2c;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group select:focus,
        .form-group textarea:focus,
        .form-group input[type="email"]:focus {
            outline: none;
            border-color: #00ccff;
            box-shadow: 0 0 10px rgba(0,255,174,0.3);
        }

        .form-group input[type="email"]::placeholder {
            color: #666;
        }

        .form-group input[type="email"]:hover {
            border-color: #00ccff;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

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
                        <div class="car-detail__spec-label">Body Type</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['body_type']) ?></div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Location</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['location']) ?></div>
                    </div>
                    <div class="car-detail__spec-item">
                        <div class="car-detail__spec-label">Listed By</div>
                        <div class="car-detail__spec-value"><?= htmlspecialchars($car['seller_name']) ?></div>
                    </div>
                </div>

                <div class="car-detail__actions">
                    <button class="car-detail__button car-detail__button--primary" onclick="openFeedbackModal()">
                        Give Feedback
                    </button>
                </div>
            </div>
        </div>

        <div class="car-detail__seller">
            <h3 class="car-detail__seller-title">About the Seller</h3>
            <p class="car-detail__seller-name"><?= htmlspecialchars($car['seller_name']) ?></p>
        </div>
    </main>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Give Feedback</h2>
            <form id="feedbackForm" action="submit_feedback.php" method="POST">
                <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <div class="form-group">
                    <label for="email">Your Email:</label>
                    <input type="email" name="email" id="email" required placeholder="Enter your email address">
                </div>
                <div class="form-group">
                    <label for="comment">Your Feedback:</label>
                    <textarea name="comment" id="comment" rows="4" required placeholder="Share your experience with this car..."></textarea>
                </div>
                <button type="submit" class="car-detail__button car-detail__button--primary">Submit Feedback</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Modal functionality
        const modal = document.getElementById('feedbackModal');
        const closeBtn = document.getElementsByClassName('close')[0];

        function openFeedbackModal() {
            <?php if (!isset($_SESSION['seller_id'])): ?>
                alert('Please login to submit feedback');
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
        document.getElementById('feedbackForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('submit_feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thank you for your feedback!');
                    modal.style.display = 'none';
                    this.reset();
                } else {
                    alert(data.message || 'Error submitting feedback. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting feedback. Please try again.');
            });
        };
    </script>
</body>
</html> 
