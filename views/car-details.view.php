<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?> | COSS</title>
    <meta name="description" content="View detailed information about this <?= htmlspecialchars(($car_year_field ?? '') . ' ' . ($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?> on COSS Automotive Marketplace.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        .spec-divider { width: 1px; height: 1.5rem; background: #c2c6d5; }
    </style>
</head>
<body class="bg-surface text-on-surface">

<?php include 'includes/navbar.php'; ?>

<main class="pt-0">
    <!-- Hero: Full-width cinematic image -->
    <section class="w-full h-[70vh] md:h-[85vh] relative overflow-hidden bg-black">
        <img alt="<?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>"
             class="w-full h-full object-cover opacity-90"
             src="<?= htmlspecialchars($img_src) ?>"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        <!-- Breadcrumb -->
        <a href="search.php" class="absolute top-28 left-8 md:left-12 text-white/70 hover:text-white transition-colors flex items-center gap-2 text-xs uppercase tracking-widest">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Collection
        </a>
    </section>

    <!-- Product Details -->
    <div class="max-w-[1440px] mx-auto px-8 md:px-12 py-16 md:py-20 flex flex-col lg:flex-row gap-12 lg:gap-16">

        <!-- Left Column: Details -->
        <div class="w-full lg:w-[60%] space-y-12">
            <!-- Identity -->
            <header class="space-y-6">
                <span class="text-xs text-[#0051ae] tracking-[0.3em] uppercase font-medium"><!-- Status label -->
                    <?= !empty($car['status']) && $car['status'] === 'sold' ? 'SOLD' : 'AVAILABLE NOW' ?>
                </span>
                <h1 class="text-5xl md:text-6xl font-extralight tracking-tight leading-none uppercase">
                    <?= htmlspecialchars($car_year_field ? "$car_year_field " : '') ?><?= htmlspecialchars($car['company_name'] ?? '') ?><br/><?= htmlspecialchars($car['car_model'] ?? '') ?>
                </h1>
                <!-- Quick Specs -->
                <div class="flex flex-wrap items-center gap-6 md:gap-8 py-8 border-y border-[#c2c6d5]/20">
                    <?php $specs = [
                        'Year' => $car_year_field,
                        'Mileage' => !empty($car['mileage']) ? number_format($car['mileage']) . ' km' : null,
                        'Transmission' => $car['transmission'] ?? null,
                        'Fuel' => $car['fuel_type'] ?? null,
                        'Colour' => $car['color'] ?? null,
                        'Body' => $car['body_type'] ?? null,
                    ]; $first = true;
                    foreach ($specs as $label => $value): if (empty($value)) continue; ?>
                    <?php if (!$first): ?><div class="spec-divider hidden sm:block"></div><?php endif; ?>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-medium tracking-[0.2em] uppercase text-[#727784]"><?= $label ?></span>
                        <span class="font-light text-base mt-1"><?= htmlspecialchars($value) ?></span>
                    </div>
                    <?php $first = false; endforeach; ?>
                </div>
            </header>

            <!-- Description -->
            <?php if (!empty($car['description'])): ?>
            <article class="space-y-4">
                <h2 class="text-[10px] font-medium tracking-[0.2em] uppercase text-[#424753]">The Narrative</h2>
                <p class="leading-loose font-light text-[#424753]"><?= nl2br(htmlspecialchars($car['description'])) ?></p>
            </article>
            <?php endif; ?>

            <!-- Location -->
            <?php if (!empty($car['location'])): ?>
            <div class="flex items-center gap-4 text-[#424753]">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <span class="text-xs tracking-widest uppercase"><?= htmlspecialchars($car['location']) ?></span>
            </div>
            <?php endif; ?>

            <!-- Seller Info -->
            <?php if (!empty($car['seller_name'])): ?>
            <a href="profile.php?id=<?= (int)$car['seller_id'] ?>" class="flex items-center justify-between py-6 border-y border-[#c2c6d5]/20 hover:opacity-80 transition-opacity group">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 bg-[#e3e2e2] flex items-center justify-center overflow-hidden">
                        <?php if (!empty($car['seller_photo']) && $car['seller_photo'] !== 'assets/img/default-avatar.png'): ?>
                            <img src="<?= htmlspecialchars($car['seller_photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-[#424753]">account_circle</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest group-hover:text-[#0051ae] transition-colors"><?= htmlspecialchars($car['seller_name']) ?></p>
                        <p class="text-[10px] text-[#727784] uppercase tracking-widest mt-1">View Seller Profile</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-[#1c69d4]" style="font-variation-settings: 'FILL' 1;">open_in_new</span>
            </a>
            <?php endif; ?>

            <!-- Reviews -->
            <?php if (!empty($reviews)): ?>
            <section class="space-y-8 pt-4">
                <h2 class="text-[10px] font-medium tracking-[0.2em] uppercase text-[#424753]">Buyer Reviews</h2>
                <?php foreach ($reviews as $review): ?>
                <div class="border-l-2 border-[#0051ae] pl-6 space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-widest"><?= htmlspecialchars(trim($review['First_name'] . ' ' . $review['Last_name'])) ?></p>
                    <p class="font-light text-[#424753] leading-relaxed italic text-sm">"<?= htmlspecialchars($review['comment']) ?>"</p>
                    <p class="text-[10px] text-[#727784] uppercase tracking-widest"><?= date('M j, Y', strtotime($review['created_at'])) ?></p>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
        </div>

        <!-- Right Column: Sticky Sidebar -->
        <div class="w-full lg:w-[40%]">
            <div class="sticky top-28 bg-white shadow-xl p-8 md:p-10 space-y-8">
                <!-- Price -->
                <div class="space-y-1">
                    <span class="text-[10px] font-medium tracking-[0.2em] uppercase text-[#727784]">Current Valuation</span>
                    <?php if (!empty($car['price'])): ?>
                    <h3 class="text-5xl font-light tracking-tighter">$<?= number_format($car['price']) ?></h3>
                    <?php else: ?>
                    <h3 class="text-2xl font-light text-[#424753]">Price on Request</h3>
                    <?php endif; ?>
                    <p class="text-xs text-[#1c69d4] font-medium tracking-wide uppercase">
                        <?= !empty($car['status']) && $car['status'] === 'sold' ? 'THIS VEHICLE HAS BEEN SOLD' : 'AVAILABLE FOR IMMEDIATE PURCHASE' ?>
                    </p>
                </div>

                <!-- Actions -->
                <?php if (empty($car['status']) || $car['status'] !== 'sold'): ?>
                <div class="space-y-3 pt-4 border-t border-[#c2c6d5]/10">
                    <button onclick="openContactModal()"
                            class="w-full bg-[#1b1c1c] text-white py-5 text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-colors duration-300">
                        SEND MESSAGE
                    </button>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="feedback.php?car_id=<?= $car['car_id'] ?>"
                       class="block w-full border border-[#1b1c1c] text-[#1b1c1c] py-5 text-[10px] font-bold tracking-[0.2em] uppercase text-center hover:bg-[#1b1c1c] hover:text-white transition-colors duration-300">
                        LEAVE FEEDBACK
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Key details list -->
                <div class="space-y-4 pt-4 border-t border-[#c2c6d5]/10">
                    <?php if (!empty($car['location'])): ?>
                    <div class="flex items-center gap-3 text-[#424753]">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <span class="text-[10px] uppercase tracking-widest"><?= htmlspecialchars($car['location']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-center gap-3 text-[#424753]">
                        <span class="material-symbols-outlined text-sm">shield</span>
                        <span class="text-[10px] uppercase tracking-widest">Verified COSS Listing</span>
                    </div>
                </div>

                <!-- Back link -->
                <a href="search.php" class="flex items-center gap-2 text-[10px] font-medium tracking-widest uppercase text-[#727784] hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Collection
                </a>
            </div>
        </div>
    </div>
</main>

<!-- Contact Seller Modal -->
<div id="contactModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center">
    <div class="bg-white w-full max-w-lg mx-4 p-10 relative">
        <button onclick="document.getElementById('contactModal').classList.add('hidden')"
                class="absolute top-5 right-6 text-[#424753] hover:text-on-surface transition-colors text-xl font-thin">&times;</button>
        <h2 class="text-xl font-extralight tracking-widest uppercase mb-2">DIRECT MESSAGE</h2>
        <p class="text-[10px] tracking-widest uppercase text-[#727784] mb-8">
            <?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>
        </p>
        <form id="contactForm" action="api/send_message.php" method="POST">
            <input type="hidden" name="car_id"     value="<?= (int)$car['car_id'] ?>">
            <input type="hidden" name="receiver_id" value="<?= (int)($car['seller_id'] ?? 0) ?>">
            <input type="hidden" name="csrf_token"  value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div class="space-y-2 mb-8">
                <label class="text-[10px] font-medium tracking-[0.15em] uppercase text-[#424753] block">Your Message</label>
                <textarea class="w-full bg-[#f4f3f3] border-0 border-b border-[#c2c6d5] p-4 focus:border-[#0051ae] focus:outline-none resize-none font-light text-sm"
                          name="message" rows="4"
                          placeholder="Hi, I'm interested in this <?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>..." required></textarea>
            </div>
            <button type="submit" class="w-full bg-[#1b1c1c] text-white py-5 text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-all">
                SEND MESSAGE
            </button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
function openContactModal() {
    <?php if (!isset($_SESSION['user_id'])): ?>
    if (confirm('Please log in to send a message. Go to login page?')) {
        window.location.href = 'login.php';
    }
    return;
    <?php endif; ?>
    document.getElementById('contactModal').classList.remove('hidden');
}

// Close modal on outside click
document.getElementById('contactModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.add('hidden');
});

// AJAX form submit
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    btn.textContent = 'SENDING...';
    btn.disabled = true;

    fetch('api/send_message.php', { method: 'POST', body: new FormData(this) })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.textContent = 'MESSAGE SENT ✓';
                setTimeout(() => {
                    document.getElementById('contactModal').classList.add('hidden');
                    btn.textContent = 'SEND MESSAGE';
                    btn.disabled = false;
                    this.reset();
                }, 1500);
            } else {
                alert(data.message || 'Error sending message.');
                btn.textContent = 'SEND MESSAGE';
                btn.disabled = false;
            }
        })
        .catch(() => {
            alert('Error sending message. Please try again.');
            btn.textContent = 'SEND MESSAGE';
            btn.disabled = false;
        });
});
</script>
</body>
</html>
