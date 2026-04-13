<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Feedback | COSS AUTOMOTIVE</title>
    <meta name="description" content="Share your feedback on your COSS automotive experience.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        .star-btn { cursor: pointer; transition: color 0.15s; }
        .star-btn.active .material-symbols-outlined { color: #0051ae; font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-[#d8e2ff] selection:text-[#001a41]">

<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<main class="min-h-screen flex flex-col items-center justify-center pt-32 pb-24 px-6 bg-surface">
    <div class="w-full max-w-[560px]">
        <!-- Form Header -->
        <header class="mb-12 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-on-surface mb-3 uppercase">LEAVE FEEDBACK</h1>
            <p class="text-[#5f5e5e] font-light tracking-widest uppercase text-xs">
                <?= htmlspecialchars(($car['car_year'] ?? '') . ' ' . ($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>
            </p>
        </header>

        <!-- Alerts -->
        <?php if ($error): ?>
        <div class="coss-alert-error mb-8"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
        <div class="coss-alert-success mb-8"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Feedback Form -->
        <form class="space-y-10" action="feedback.php" method="POST">
            <input type="hidden" name="car_id" value="<?= (int)$car_id ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="rating" id="rating_input" value="<?= $rating ?>">

            <!-- Email Field -->
            <div class="space-y-2">
                <label class="block text-[10px] font-medium tracking-[0.15em] text-[#727784] uppercase">Your Email</label>
                <input class="w-full bg-transparent border-0 border-b border-[#c2c6d5] py-3 px-0 focus:ring-0 focus:border-[#0051ae] focus:outline-none transition-colors text-on-surface font-light"
                       name="email" type="email" value="<?= htmlspecialchars($email) ?>" required/>
            </div>

            <!-- Star Rating -->
            <div class="space-y-4">
                <label class="block text-[10px] font-medium tracking-[0.15em] text-[#727784] uppercase">Overall Experience</label>
                <div class="flex space-x-3" id="star-container">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                    <button class="star-btn focus:outline-none <?= $s <= $rating ? 'active' : '' ?>" type="button" data-star="<?= $s ?>">
                        <span class="material-symbols-outlined text-3xl text-[#1b1c1c] hover:text-[#0051ae] transition-colors <?= $s <= $rating ? 'text-[#0051ae]' : '' ?>"
                              style="font-variation-settings: 'FILL' <?= $s <= $rating ? '1' : '0' ?>, 'wght' 300, 'GRAD' 0, 'opsz' 24;">star</span>
                    </button>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Comments -->
            <div class="space-y-2">
                <label class="block text-[10px] font-medium tracking-[0.15em] text-[#727784] uppercase">Detailed Comments</label>
                <textarea class="w-full bg-[#f4f3f3] border-0 border-b border-[#c2c6d5] p-4 focus:ring-0 focus:border-[#0051ae] focus:outline-none transition-all text-on-surface font-light resize-none placeholder:text-[#727784]/50"
                          name="comment" placeholder="Describe your experience with this vehicle..." rows="6"><?= htmlspecialchars($comment) ?></textarea>
            </div>

            <!-- Submit -->
            <button class="w-full bg-[#1b1c1c] text-white py-5 text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-all duration-300 active:scale-[0.98]" type="submit">
                SUBMIT FEEDBACK
            </button>
        </form>

        <!-- Back Link -->
        <footer class="mt-10 text-center md:text-left">
            <a class="inline-flex items-center text-[10px] font-medium tracking-[0.1em] text-[#727784] uppercase hover:text-on-surface transition-colors group" href="car-details.php?id=<?= (int)$car_id ?>">
                <span class="material-symbols-outlined text-sm mr-2 transition-transform group-hover:-translate-x-1">arrow_back</span>
                Back to <?= htmlspecialchars($car['company_name'] . ' ' . $car['car_model']) ?>
            </a>
        </footer>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
// Star rating interaction
var stars = document.querySelectorAll('.star-btn');
var ratingInput = document.getElementById('rating_input');
stars.forEach(function(btn) {
    btn.addEventListener('click', function() {
        var val = parseInt(this.dataset.star);
        ratingInput.value = val;
        stars.forEach(function(s, i) {
            var icon = s.querySelector('.material-symbols-outlined');
            if (i < val) {
                s.classList.add('active');
                icon.style.fontVariationSettings = "'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24";
                icon.style.color = '#0051ae';
            } else {
                s.classList.remove('active');
                icon.style.fontVariationSettings = "'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24";
                icon.style.color = '#1b1c1c';
            }
        });
    });
    btn.addEventListener('mouseenter', function() {
        var val = parseInt(this.dataset.star);
        stars.forEach(function(s, i) {
            var icon = s.querySelector('.material-symbols-outlined');
            icon.style.color = i < val ? '#0051ae' : '#1b1c1c';
        });
    });
    btn.addEventListener('mouseleave', function() {
        var current = parseInt(ratingInput.value);
        stars.forEach(function(s, i) {
            var icon = s.querySelector('.material-symbols-outlined');
            icon.style.color = i < current ? '#0051ae' : '#1b1c1c';
        });
    });
});
</script>
</body>
</html>
