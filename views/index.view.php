<?php
// Fetch recent listings for the featured section.
$featured_cars = [];
if (isset($conn)) {
    $hasCarYear = false;
    $hasYear = false;
    $hasImageUrl = false;
    $hasImagePath = false;
    $hasStatus = false;

    $colCarYear = $conn->query("SHOW COLUMNS FROM cars LIKE 'car_year'");
    if ($colCarYear && $colCarYear->num_rows > 0) $hasCarYear = true;
    $colYear = $conn->query("SHOW COLUMNS FROM cars LIKE 'year'");
    if ($colYear && $colYear->num_rows > 0) $hasYear = true;
    $colImageUrl = $conn->query("SHOW COLUMNS FROM cars LIKE 'image_url'");
    if ($colImageUrl && $colImageUrl->num_rows > 0) $hasImageUrl = true;
    $colImagePath = $conn->query("SHOW COLUMNS FROM cars LIKE 'image_path'");
    if ($colImagePath && $colImagePath->num_rows > 0) $hasImagePath = true;
    $colStatus = $conn->query("SHOW COLUMNS FROM cars LIKE 'status'");
    if ($colStatus && $colStatus->num_rows > 0) $hasStatus = true;

    $yearExpr = $hasCarYear ? 'car_year' : ($hasYear ? 'year' : 'NULL');
    $imageExpr = $hasImageUrl ? 'image_url' : ($hasImagePath ? 'image_path AS image_url' : 'NULL AS image_url');
    $featured_sql = "SELECT car_id, company_name, car_model, {$yearExpr} AS car_year, price, fuel_type, {$imageExpr} FROM cars ORDER BY car_id DESC LIMIT 8";
    $featured_result = $conn->query($featured_sql);
    if ($featured_result instanceof mysqli_result) {
        while ($row = $featured_result->fetch_assoc()) {
            if (!empty($row['car_id'])) {
                $featured_cars[] = $row;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>COSS – New Zealand's Premium Car Marketplace</title>
    <meta name="description" content="Buy, sell, and discover premium vehicles. New Zealand's most curated automotive marketplace. COSS connects buyers and sellers of exceptional cars.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">

<?php include 'includes/navbar.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="relative h-screen w-full bg-black flex items-end overflow-hidden">
        <div class="absolute inset-0 z-0">
            <?php
            $banner = file_exists(dirname(__DIR__) . '/assets/img/banner.jpg') ? 'assets/img/banner.jpg' : 'https://lh3.googleusercontent.com/aida-public/AB6AXuC5BbWcn8oPxjxCcx4a5VMGkVxnHoS2P5x6swSM81Jmdi5K0SZBl2GGPltE_-8BBQUhy4oNjIghis22-kezoeyu9bfC44-JeeEhwVcTFeRPaMpmTzRLH0vET0mWsmZCKAkZ--tzfcah2fZgwIn3PhTDQTYEJUO05i_PlauO1__CycUPzN1UwWNSVVkOfBG534VldFVvBfSy94Fwc04aNLXbfR-sUTY3bxSXinuZsXdmSUxnRtROysbesM_Scg1hZMX3SYZ5dPGnjhE';
            ?>
            <img alt="Cinematic luxury car" class="w-full h-full object-cover opacity-60" src="<?= $banner ?>"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
        </div>
        <div class="relative z-10 px-8 md:px-12 pb-20 md:pb-32 w-full max-w-7xl">
            <div class="flex flex-col space-y-2">
                <h1 class="text-white text-7xl md:text-[10rem] font-black leading-[0.85] tracking-tighter">
                    BUY.<br/>SELL.<br/>DRIVE.
                </h1>
                <p class="text-white/60 font-light tracking-[0.2em] uppercase text-sm mt-8 max-w-sm">
                    New Zealand's premium car marketplace
                </p>
                <div class="flex flex-wrap gap-4 mt-10">
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'seller'): ?>
                    <a href="cars.php" class="bg-white text-black px-10 py-5 font-medium tracking-[0.1em] uppercase text-xs transition-all duration-300 hover:bg-[#0051ae] hover:text-white active:scale-95">
                        LIST YOUR CAR
                    </a>
                    <?php else: ?>
                    <a href="registration.php" class="bg-white text-black px-10 py-5 font-medium tracking-[0.1em] uppercase text-xs transition-all duration-300 hover:bg-[#0051ae] hover:text-white active:scale-95">
                        GET STARTED
                    </a>
                    <?php endif; ?>
                    <a href="search.php" class="bg-transparent border border-white text-white px-10 py-5 font-medium tracking-[0.1em] uppercase text-xs transition-all duration-300 hover:bg-white hover:text-black active:scale-95">
                        BROWSE CARS
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why COSS Strip -->
    <section class="bg-white py-20 md:py-24 border-b border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-4 px-8 md:px-12 gap-0">
            <div class="flex flex-col p-8 md:p-12 border-l border-gray-200">
                <span class="text-5xl font-thin text-black/10 mb-6">01</span>
                <hr class="w-12 border-black mb-8"/>
                <h3 class="font-bold tracking-widest text-xs uppercase mb-4">Easy Listings</h3>
                <p class="text-[#424753] font-light text-xs leading-relaxed max-w-[200px]">Streamlined process for high-value asset turnover.</p>
            </div>
            <div class="flex flex-col p-8 md:p-12 border-l border-gray-200">
                <span class="text-5xl font-thin text-black/10 mb-6">02</span>
                <hr class="w-12 border-black mb-8"/>
                <h3 class="font-bold tracking-widest text-xs uppercase mb-4">Verified Network</h3>
                <p class="text-[#424753] font-light text-xs leading-relaxed max-w-[200px]">Exclusively curated community of premium automotive sellers.</p>
            </div>
            <div class="flex flex-col p-8 md:p-12 border-l border-gray-200">
                <span class="text-5xl font-thin text-black/10 mb-6">03</span>
                <hr class="w-12 border-black mb-8"/>
                <h3 class="font-bold tracking-widest text-xs uppercase mb-4">Global Reach</h3>
                <p class="text-[#424753] font-light text-xs leading-relaxed max-w-[200px]">Connecting unique specifications with international collectors.</p>
            </div>
            <div class="flex flex-col p-8 md:p-12 border-l border-r border-gray-200">
                <span class="text-5xl font-thin text-black/10 mb-6">04</span>
                <hr class="w-12 border-black mb-8"/>
                <h3 class="font-bold tracking-widest text-xs uppercase mb-4">Direct Concierge</h3>
                <p class="text-[#424753] font-light text-xs leading-relaxed max-w-[200px]">White-glove support for every transaction stage.</p>
            </div>
        </div>
    </section>

    <!-- Featured Models -->
    <section class="bg-[#faf9f9] py-24 md:py-32 overflow-hidden">
        <div class="px-8 md:px-12 mb-16">
            <span class="text-[#0051ae] font-light tracking-[0.3em] uppercase text-[10px] block mb-4">CURATED COLLECTION</span>
            <h2 class="text-4xl md:text-5xl font-extralight tracking-tight text-[#1b1c1c] uppercase">Featured Cars</h2>
        </div>
        <?php if (!empty($featured_cars)): ?>
        <div class="flex overflow-x-auto gap-8 md:gap-10 px-8 md:px-12 pb-12 snap-x snap-mandatory no-scrollbar">
            <?php foreach ($featured_cars as $car): 
                $car_img = !empty($car['image_url']) && file_exists(dirname(__DIR__) . '/' . $car['image_url']) ? $car['image_url'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBI1eRAFBqSNU4dAs1OLZ3TPIE8-NtbZg7cvmLpa2P5VrIsGXKXSDGQx2kPcxqUODTpuU6UijKYCRnU93MutrkPy1B7mAfKb12FaloUcd9ewBc3zPb_zNvjaWu7bZFuACsCtov2S7yXqNZ_k5M3jR43dDKV_Y6mCYRFua0Cah5bmNMS2FtWOo8MD-7GkyeQ1wd8Fem99phi1x-D-QXYEXTequWTOkLUsVp2HysGh_-sMUTADI4GsB8nFohLi-Ikw7DPHWzppBtAaZg';
            ?>
            <div class="flex-none w-[320px] md:w-[420px] snap-start group cursor-pointer">
                <div class="relative aspect-[4/5] bg-[#efeded] overflow-hidden">
                    <img alt="<?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         src="<?= htmlspecialchars($car_img) ?>"/>
                    <div class="absolute top-6 left-6 bg-white px-4 py-2 text-[10px] font-bold tracking-[0.2em] uppercase">AVAILABLE</div>
                </div>
                <div class="py-8 transition-all duration-300 border-b border-transparent group-hover:border-[#1c69d4]">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-xl font-bold tracking-tight uppercase"><?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?></h4>
                            <p class="text-[#424753] font-light tracking-widest uppercase text-xs mt-1">
                                <?= htmlspecialchars($car['car_year'] ?? '') ?> · <?= htmlspecialchars($car['fuel_type'] ?? 'Petrol') ?>
                            </p>
                        </div>
                        <?php if ($car['price']): ?>
                        <span class="text-lg font-medium">$<?= number_format($car['price']) ?></span>
                        <?php endif; ?>
                    </div>
                    <a class="inline-flex items-center space-x-2 text-[10px] font-bold tracking-[0.2em] uppercase text-[#0051ae] group-hover:text-[#1c69d4] transition-colors" href="car-details.php?id=<?= $car['car_id'] ?>">
                        <span>VIEW DETAILS</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="px-8 md:px-12">
            <div class="border border-dashed border-[#c2c6d5]/40 p-10 text-center bg-white/60">
                <p class="text-xs tracking-[0.2em] uppercase text-[#424753]">No live car listings found yet.</p>
            </div>
        </div>
        <?php endif; ?>
    </section>

    <!-- CTA Section -->
    <section class="bg-[#efeded] py-24 md:py-32 px-8 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-20 items-center max-w-7xl mx-auto">
            <div>
                <h2 class="text-5xl md:text-6xl font-black tracking-tighter leading-none uppercase mb-8">Ready to move<br/>your asset?</h2>
                <p class="text-[#424753] text-sm tracking-wide leading-loose max-w-md mb-12">
                    Whether you're looking to acquire a rare masterpiece or divest from your collection, COSS provides the professional infrastructure required for high-stakes automotive transactions.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="search.php" class="bg-[#1b1c1c] text-white px-10 py-5 font-medium tracking-[0.1em] uppercase text-xs transition-all duration-300 hover:bg-[#0051ae] active:scale-95">
                        EXPLORE COLLECTION
                    </a>
                    <a href="registration.php" class="border border-[#1b1c1c] text-[#1b1c1c] px-10 py-5 font-medium tracking-[0.1em] uppercase text-xs transition-all duration-300 hover:bg-[#1b1c1c] hover:text-white active:scale-95">
                        CREATE ACCOUNT
                    </a>
                </div>
            </div>
            <div class="relative aspect-video bg-black overflow-hidden shadow-2xl">
                <img alt="Luxury car dashboard" class="w-full h-full object-cover opacity-90"
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuDk1qVn1VetnooyzfUN7VQAXTFijZzC0qYQRjUvKuxX5cPcyt4yYwZNwU-iz68oxfoGhaLT6z0rYFDJuQA8TJMq_NzizOMyccz48pOXMqBnXC6eeLqr5sQ2EwOWNimxB-2D6r0Sl8B4VD8IoIZ7ZPrmrdRd5y8DND52jKM4I18Bu0VG911j683T2ZSn7LEGPhBFPGQXX2fl0BVf3VpV6m5JkP5gbnKaN-QyL0V-aX0Q4epZclXq_SP8fCCiKNwWa1V38IlC2yCmqas"/>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
