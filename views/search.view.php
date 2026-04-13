<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search & Browse | COSS AUTOMOTIVE</title>
    <meta name="description" content="Browse and search New Zealand's premium automotive collection. Filter by brand, model, year, price and more.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        select { appearance: none; -webkit-appearance: none; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-[#d8e2ff]">

<?php include 'includes/navbar.php'; ?>

<main class="pt-24 pb-20">

    <!-- Sticky Filter Bar -->
    <div class="sticky top-[80px] z-40 bg-white border-b border-[#c2c6d5]/30 px-8 md:px-12 py-5">
        <form method="GET" action="search.php">
            <div class="max-w-[1400px] mx-auto grid grid-cols-2 md:grid-cols-7 gap-4 items-end">
                <div class="flex flex-col space-y-2">
                    <label class="text-[10px] tracking-[0.15em] uppercase font-bold text-[#424753]">Brand</label>
                    <input class="bg-transparent border-b border-[#c2c6d5] focus:border-[#0051ae] outline-none py-2 text-sm font-light"
                           name="brand" placeholder="BMW, Porsche..." type="text" value="<?= htmlspecialchars($brand) ?>"/>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="text-[10px] tracking-[0.15em] uppercase font-bold text-[#424753]">Model</label>
                    <input class="bg-transparent border-b border-[#c2c6d5] focus:border-[#0051ae] outline-none py-2 text-sm font-light"
                           name="model" placeholder="e.g. M3" type="text" value="<?= htmlspecialchars($model) ?>"/>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="text-[10px] tracking-[0.15em] uppercase font-bold text-[#424753]">Year</label>
                    <input class="bg-transparent border-b border-[#c2c6d5] focus:border-[#0051ae] outline-none py-2 text-sm font-light"
                           name="year" placeholder="2024" type="text" value="<?= htmlspecialchars($year) ?>"/>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="text-[10px] tracking-[0.15em] uppercase font-bold text-[#424753]">Max Price</label>
                    <input class="bg-transparent border-b border-[#c2c6d5] focus:border-[#0051ae] outline-none py-2 text-sm font-light"
                           name="price" placeholder="$150,000" type="text" value="<?= htmlspecialchars($price) ?>"/>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="text-[10px] tracking-[0.15em] uppercase font-bold text-[#424753]">Transmission</label>
                    <select class="bg-transparent border-b border-[#c2c6d5] focus:border-[#0051ae] outline-none py-2 text-sm font-light" name="transmission">
                        <option value="">All</option>
                        <option value="Automatic" <?= $transmission === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                        <option value="Manual"    <?= $transmission === 'Manual'    ? 'selected' : '' ?>>Manual</option>
                    </select>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="text-[10px] tracking-[0.15em] uppercase font-bold text-[#424753]">Fuel Type</label>
                    <select class="bg-transparent border-b border-[#c2c6d5] focus:border-[#0051ae] outline-none py-2 text-sm font-light" name="fuel_type">
                        <option value="">All</option>
                        <option value="Petrol"   <?= $fuel_type === 'Petrol'   ? 'selected' : '' ?>>Petrol</option>
                        <option value="Diesel"   <?= $fuel_type === 'Diesel'   ? 'selected' : '' ?>>Diesel</option>
                        <option value="Hybrid"   <?= $fuel_type === 'Hybrid'   ? 'selected' : '' ?>>Hybrid</option>
                        <option value="Electric" <?= $fuel_type === 'Electric' ? 'selected' : '' ?>>Electric</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <button class="bg-[#0051ae] text-white py-3 font-bold text-xs tracking-widest uppercase hover:bg-[#1c69d4] transition-all active:scale-95" type="submit">
                        SEARCH
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <section class="px-8 md:px-12 py-12 md:py-16 max-w-[1400px] mx-auto">

        <!-- Results Header -->
        <div class="flex justify-between items-baseline mb-10 md:mb-12 border-b border-[#c2c6d5]/10 pb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-thin tracking-tighter text-on-surface mb-2">Available Collection</h1>
                <p class="text-xs uppercase tracking-[0.2em] text-[#424753] font-medium"><?= $total ?> VEHICLE<?= $total !== 1 ? 'S' : '' ?> <?= ($brand || $model || $year || $price || $transmission || $fuel_type) ? 'MATCHING YOUR CRITERIA' : 'IN COLLECTION' ?></p>
            </div>
            <form method="GET" action="search.php" class="flex items-center space-x-3">
                <!-- Preserve filters on sort -->
                <?php foreach ($_GET as $k => $v): ?>
                    <?php if ($k !== 'sort'): ?>
                    <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <span class="text-[10px] uppercase tracking-widest text-[#424753]">Sort by:</span>
                <select name="sort" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold tracking-widest uppercase outline-none focus:ring-0 cursor-pointer">
                    <option value="newest"    <?= $sort === 'newest'    ? 'selected' : '' ?>>Newest First</option>
                    <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price (High-Low)</option>
                    <option value="price_asc"  <?= $sort === 'price_asc'  ? 'selected' : '' ?>>Price (Low-High)</option>
                </select>
            </form>
        </div>

        <?php if (empty($cars)): ?>
        <!-- No Results -->
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <span class="material-symbols-outlined text-6xl text-[#c2c6d5] mb-8" style="font-variation-settings:'FILL' 0,'wght' 100,'GRAD' 0,'opsz' 48;">directions_car</span>
            <h2 class="text-2xl font-extralight tracking-tight uppercase text-on-surface mb-4">No Vehicles Found</h2>
            <p class="text-[#424753] font-light text-xs tracking-[0.15em] uppercase mb-8">Try adjusting your search criteria</p>
            <a href="search.php" class="text-[10px] font-bold tracking-[0.2em] uppercase text-[#0051ae] flex items-center gap-2 hover:text-[#1c69d4] transition-colors">
                <span class="material-symbols-outlined text-sm">refresh</span> CLEAR ALL FILTERS
            </a>
        </div>

        <?php else: ?>
        <!-- Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16 md:gap-y-20">
            <?php foreach ($cars as $car):
                $img_src = !empty($car['image_url']) ? $car['image_url'] :
                           (!empty($car['image_path']) && file_exists(dirname(__DIR__) . '/'.$car['image_path']) ? $car['image_path'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBG9RNwfNEOsIQy5IkhkNJ9ZYR0VPOiuwI5HeztB-zGiVivol9KN1QdLMGuWqYA2aRY9khPVihZCRjyrtKOPwbQralx9wUak1u0hS4Mag_5LfCzAe40V9ynKee7yJ6ZzhRFwphHCQFi3NBhp_SqepqEvDFEy6xkAtCkyKx5tgw4q9ADsaQFSpREh8Ouz_W0fkGWETRqX5Z2Gg7MCD3rwrDRy3IXNHBAuqvAPvr8n6EODxlMoQ_KOXVwvNdzo_q5MPydzha0KZXjeQY');
                $car_name = htmlspecialchars(trim($car['company_name'] . ' ' . $car['car_model']));
                $car_year_field = $car['car_year'] ?? $car['year'] ?? '';
            ?>
            <div class="group cursor-pointer" onclick="window.location='car-details.php?id=<?= (int)$car['car_id'] ?>'">
                <div class="aspect-[16/10] overflow-hidden bg-[#efeded] mb-6 relative">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         alt="<?= $car_name ?>"
                         src="<?= htmlspecialchars($img_src) ?>"/>
                    <?php if (!empty($car['status']) && $car['status'] === 'sold'): ?>
                    <div class="absolute top-4 left-4 bg-[#424753] text-white px-3 py-1 text-[10px] font-bold tracking-widest uppercase">SOLD</div>
                    <?php else: ?>
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 text-[10px] font-bold tracking-widest uppercase">AVAILABLE</div>
                    <?php endif; ?>
                </div>
                <div class="space-y-3 transition-all duration-300 group-hover:border-b-2 group-hover:border-[#1c69d4] pb-4">
                    <h3 class="text-2xl font-light tracking-tight"><?= $car_name ?></h3>
                    <p class="text-[11px] font-medium tracking-[0.15em] text-[#424753] uppercase">
                        <?= htmlspecialchars($car_year_field) ?>
                        <?php if (!empty($car['mileage'])): ?><span class="mx-1 opacity-30">·</span><?= number_format($car['mileage']) ?> KM<?php endif; ?>
                        <?php if (!empty($car['transmission'])): ?><span class="mx-1 opacity-30">·</span><?= htmlspecialchars($car['transmission']) ?><?php endif; ?>
                        <?php if (!empty($car['fuel_type'])): ?><span class="mx-1 opacity-30">·</span><?= htmlspecialchars($car['fuel_type']) ?><?php endif; ?>
                    </p>
                    <div class="flex justify-between items-center pt-2">
                        <?php if (!empty($car['price'])): ?>
                        <span class="text-3xl font-bold tracking-tighter">$<?= number_format($car['price']) ?></span>
                        <?php else: ?>
                        <span class="text-lg font-light text-[#424753]">Price on Request</span>
                        <?php endif; ?>
                        <a class="text-[10px] font-black tracking-widest uppercase text-[#0051ae] hover:text-[#1c69d4] flex items-center"
                           href="car-details.php?id=<?= (int)$car['car_id'] ?>">
                            View Details <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Back to top -->
        <div class="mt-16 md:mt-24 flex justify-center">
            <a href="search.php" class="text-[10px] font-medium tracking-[0.2em] uppercase text-[#424753] hover:text-[#0051ae] transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">refresh</span>
                RESET FILTERS
            </a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
