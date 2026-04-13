<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback - COSS</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="assets/js/script.js" defer></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="feedback" style="max-width: 600px; margin: 3rem auto; padding: 2rem; background:#1e1e1e; border-radius: 10px;">
        <h2 class="feedback__title">Leave Feedback</h2>
        <p style="margin-bottom:1rem; color:#ccc;">Car: <?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?></p>

        <?php if ($error): ?>
            <p style="color:#ff4d4d;"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($success): ?>
            <p style="color:#ffffff; font-weight:700; border-left:4px solid #e11a22; padding-left:10px; margin-bottom: 2rem; letter-spacing: 1px; text-transform: uppercase;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form class="feedback__form" action="feedback.php" method="POST">
            <input type="hidden" name="car_id" value="<?= (int)$car_id ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="email" class="feedback__input" name="email" placeholder="Your Email" required value="<?= htmlspecialchars($email) ?>">
            <textarea class="feedback__textarea" name="comment" placeholder="Write your feedback here..." required><?= htmlspecialchars($comment) ?></textarea>
            <button type="submit" class="feedback__button">Submit</button>
        </form>

        <p class="feedback__back" style="margin-top:1rem;">
            <a class="feedback__back-link" href="car-details.php?id=<?= (int)$car_id ?>">Back to Car Details</a>
        </p>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
