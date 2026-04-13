<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Listings | COSS AUTOMOTIVE</title>
    <meta name="description" content="Manage your COSS automotive listings. Add, edit, and remove vehicle listings.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        details[open] summary .summary-icon { transform: rotate(45deg); }
        .summary-icon { transition: transform 0.3s; }
        select { appearance: none; -webkit-appearance: none; }
    </style>
</head>
<body class="bg-surface text-on-surface">

<?php include 'includes/navbar.php'; ?>

<main class="pt-32 pb-40 px-6 md:px-24 max-w-7xl mx-auto">

    <!-- Header -->
    <header class="mb-20">
        <h1 class="text-5xl md:text-7xl font-extralight tracking-[-0.02em] uppercase text-on-surface mb-4">MY LISTINGS</h1>
        <p class="text-sm font-light tracking-[0.1em] text-on-surface-variant uppercase"><?= htmlspecialchars($_SESSION['username'] ?? '') ?>'s Automotive Collection</p>
    </header>

    <!-- Feedback Messages -->
    <?php if ($error): ?>
    <div class="coss-alert-error mb-10"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
    <div class="coss-alert-success mb-10"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Add New Listing Panel -->
    <section class="mb-24">
        <details class="group bg-surface-container-low overflow-hidden" id="addListingPanel">
            <summary class="flex items-center justify-between p-8 cursor-pointer list-none hover:bg-surface-container-high transition-colors">
                <span class="text-lg font-light tracking-[0.1em] uppercase">Add New Listing</span>
                <div class="w-12 h-12 flex items-center justify-center bg-on-background text-white summary-icon transition-transform duration-300">
                    <span class="material-symbols-outlined">add</span>
                </div>
            </summary>
            <div class="p-8 md:p-12 border-t border-outline-variant/10 bg-surface-container-lowest">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                        <!-- Brand -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Vehicle Brand</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none placeholder:text-outline-variant transition-all font-light text-sm uppercase tracking-wider"
                                   name="company" placeholder="e.g. BMW" type="text" value="<?= htmlspecialchars($company) ?>" required/>
                        </div>
                        <!-- Model -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Car Model</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none placeholder:text-outline-variant transition-all font-light text-sm uppercase tracking-wider"
                                   name="model" placeholder="e.g. M4 Competition" type="text" value="<?= htmlspecialchars($model) ?>" required/>
                        </div>
                        <!-- Year -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Production Year</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none placeholder:text-outline-variant transition-all font-light text-sm uppercase tracking-wider"
                                   name="year" placeholder="<?= date('Y') ?>" type="number" min="1900" max="<?= date('Y') ?>" value="<?= htmlspecialchars($year) ?>" required/>
                        </div>
                        <!-- Price -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Asking Price (NZD)</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none placeholder:text-outline-variant transition-all font-light text-sm uppercase tracking-wider"
                                   name="price" placeholder="85,000" type="number" step="0.01" value="<?= htmlspecialchars($price) ?>" required/>
                        </div>
                        <!-- Mileage -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Mileage (km)</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none placeholder:text-outline-variant transition-all font-light text-sm uppercase tracking-wider"
                                   name="mileage" placeholder="e.g. 15000" type="number" value="<?= htmlspecialchars($mileage) ?>" required/>
                        </div>
                        <!-- Transmission -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Transmission</label>
                            <select class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none transition-all font-light text-sm uppercase tracking-wider" name="transmission" required>
                                <option value="">SELECT</option>
                                <option value="Automatic" <?= $transmission === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                                <option value="Manual"    <?= $transmission === 'Manual'    ? 'selected' : '' ?>>Manual</option>
                            </select>
                        </div>
                        <!-- Fuel Type -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Fuel Type</label>
                            <select class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none transition-all font-light text-sm uppercase tracking-wider" name="fuelType" required>
                                <option value="">SELECT</option>
                                <option value="Petrol"   <?= $fuelType === 'Petrol'   ? 'selected' : '' ?>>Petrol</option>
                                <option value="Diesel"   <?= $fuelType === 'Diesel'   ? 'selected' : '' ?>>Diesel</option>
                                <option value="Hybrid"   <?= $fuelType === 'Hybrid'   ? 'selected' : '' ?>>Hybrid</option>
                                <option value="Electric" <?= $fuelType === 'Electric' ? 'selected' : '' ?>>Electric</option>
                            </select>
                        </div>
                        <!-- Body Type -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Body Type</label>
                            <select class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none transition-all font-light text-sm uppercase tracking-wider" name="bodyType" required>
                                <option value="">SELECT</option>
                                <?php foreach (['Sedan','SUV','Hatchback','Coupe','Convertible','Wagon','Van','Truck'] as $bt): ?>
                                <option value="<?= $bt ?>" <?= $bodyType === $bt ? 'selected' : '' ?>><?= $bt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Location -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Location</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none placeholder:text-outline-variant transition-all font-light text-sm uppercase tracking-wider"
                                   name="location" placeholder="e.g. Auckland" type="text" value="<?= htmlspecialchars($location) ?>" required/>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-10 space-y-2">
                        <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Vehicle Description</label>
                        <textarea class="w-full bg-[#f4f3f3] border-0 border-b border-outline-variant p-4 focus:ring-0 focus:border-primary focus:outline-none transition-all font-light text-sm resize-none placeholder:text-outline-variant"
                                  name="description" rows="4" placeholder="Describe this vehicle..."><?= htmlspecialchars($description) ?></textarea>
                    </div>

                    <!-- Image Upload: Drag & Drop Zone -->
                    <div class="mb-10 space-y-3">
                        <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Vehicle Photo</label>

                        <!-- Hidden real file input — accepts from ANY location on device -->
                        <input id="carImageInput" name="car_image" type="file"
                               class="sr-only"
                               accept="image/jpeg,image/png,image/gif,image/webp,image/heic,image/heif,image/avif,image/bmp,image/tiff,image/svg+xml,.jpg,.jpeg,.png,.gif,.webp,.heic,.heif,.avif,.bmp,.tiff,.tif,.svg"/>

                        <!-- Drop zone -->
                        <div id="dropZone"
                             class="relative border-2 border-dashed border-[#c2c6d5] bg-[#f9f8f8] rounded-none p-10 flex flex-col items-center justify-center text-center cursor-pointer hover:border-[#0051ae] hover:bg-[#f0f4ff] transition-all duration-200 group min-h-[180px]"
                             onclick="document.getElementById('carImageInput').click()">

                            <!-- Upload icon -->
                            <span id="dzIcon" class="material-symbols-outlined text-5xl text-[#c2c6d5] group-hover:text-[#0051ae] transition-colors mb-4"
                                  style="font-variation-settings:'FILL' 0,'wght' 100,'GRAD' 0,'opsz' 48;">add_photo_alternate</span>

                            <!-- Preview image (hidden until file chosen) -->
                            <img id="dzPreview" src="" alt="Preview"
                                 class="hidden absolute inset-0 w-full h-full object-contain p-4"/>

                            <p id="dzText" class="text-xs font-light tracking-[0.1em] uppercase text-[#727784]">
                                Click to browse &mdash; or drag &amp; drop a photo here
                            </p>
                            <p id="dzHint" class="text-[10px] mt-2 text-[#c2c6d5] tracking-widest uppercase">
                                From Desktop · Downloads · Photos · iCloud · USB · Anywhere
                            </p>
                            <p id="dzFileName" class="hidden text-[11px] mt-3 font-semibold tracking-wider text-[#0051ae] uppercase"></p>
                        </div>

                        <!-- Clear button -->
                        <button id="dzClear" type="button" onclick="clearDropzone(event)"
                                class="hidden text-[10px] text-[#727784] hover:text-error uppercase tracking-widest flex items-center gap-1 transition-colors">
                            <span class="material-symbols-outlined text-sm">close</span> Remove Photo
                        </button>

                        <p class="text-[10px] text-[#c2c6d5] tracking-widest uppercase">
                            JPG · PNG · GIF · WebP · HEIC · HEIF · AVIF · BMP · TIFF · SVG &mdash; Max 20&nbsp;MB
                        </p>
                    </div>

                    <button class="w-full md:w-auto px-16 py-4 bg-on-background text-white text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-primary transition-colors active:scale-95" type="submit">
                        CREATE LISTING
                    </button>
                </form>
            </div>
        </details>
    </section>

    <!-- Listed Cars -->
    <section class="space-y-0">
        <?php if (empty($cars)): ?>
        <div class="py-20 text-center border border-dashed border-outline-variant/20">
            <span class="material-symbols-outlined text-4xl text-outline/40 mb-4 block" style="font-variation-settings:'FILL' 0,'wght' 100,'GRAD' 0,'opsz' 48;">sell</span>
            <p class="text-[#424753] font-light tracking-widest uppercase text-xs">No listings yet. Add your first vehicle above.</p>
        </div>
        <?php endif; ?>

        <?php foreach ($cars as $car):
            $img_src = !empty($car['image_url']) && file_exists(dirname(__DIR__) . '/' . $car['image_url']) ? $car['image_url'] :
                       'https://lh3.googleusercontent.com/aida-public/AB6AXuCFKsVjd_SZvoy6Je3F4uzU5bx_o-EyelEKVVyWcHJRX3F4ySbfD1dWJW-epXLmWDS6-8jPm24qjOLutWTnWPly8ZIQ7Tv6868GMv0_zB1oUKx--zv_2SPXIpTowXuQieR6ITz51n8IUYGPMeHMppTi_kG2upwHx6BYTvyBdnmi7XnepX7c6qFfzHEtQGPbqQroQh3N5Q3gS34QJda_wVx3c2cBuTUrEg3n78RYpCu1xOixvesICDmgtG5E1PO2uPT3zvzm8eQCVWM';
            $car_year_field = $car['car_year'] ?? '';
        ?>
        <article class="group border-b border-outline-variant/10 transition-all hover:bg-white">
            <div class="flex flex-col md:flex-row items-start gap-8 md:gap-12 py-12">
                <!-- Thumbnail -->
                <div class="w-full md:w-64 lg:w-80 h-48 flex-shrink-0 overflow-hidden bg-surface-container">
                    <img alt="<?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>"
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700"
                         src="<?= htmlspecialchars($img_src) ?>"/>
                </div>

                <!-- Info + Actions -->
                <div class="flex-grow flex flex-col justify-between">
                    <div class="flex flex-col md:flex-row md:items-start justify-between mb-6 md:mb-8 gap-4">
                        <div>
                            <div class="flex items-center gap-4 mb-2 flex-wrap">
                                <h2 class="text-2xl md:text-3xl font-light tracking-tight uppercase">
                                    <?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?>
                                </h2>
                                <span class="px-3 py-1 border border-primary text-primary text-[9px] font-bold tracking-[0.15em] uppercase">LISTED</span>
                            </div>
                            <p class="text-xs font-light tracking-widest text-on-surface-variant uppercase">
                                <?= htmlspecialchars($car_year_field) ?>
                                <?php if (!empty($car['transmission'])): ?> · <?= htmlspecialchars($car['transmission']) ?><?php endif; ?>
                                <?php if (!empty($car['fuel_type'])): ?> · <?= htmlspecialchars($car['fuel_type']) ?><?php endif; ?>
                                <?php if (!empty($car['mileage'])): ?> · <?= number_format($car['mileage']) ?> KM<?php endif; ?>
                            </p>
                        </div>
                        <?php if (!empty($car['price'])): ?>
                        <div class="text-right">
                            <span class="text-2xl md:text-3xl font-extralight tracking-tighter">$<?= number_format($car['price']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap items-center gap-8 pt-4 border-t border-outline-variant/10">
                        <button class="text-[10px] font-semibold tracking-[0.2em] uppercase text-on-surface hover:text-primary transition-colors flex items-center gap-2"
                                onclick="toggleEdit(<?= (int)$car['car_id'] ?>)" type="button">
                            <span class="material-symbols-outlined text-sm">edit</span> Edit Listing
                        </button>
                        <a class="text-[10px] font-semibold tracking-[0.2em] uppercase text-on-surface hover:text-primary transition-colors flex items-center gap-2"
                           href="car-details.php?id=<?= (int)$car['car_id'] ?>">
                            <span class="material-symbols-outlined text-sm">visibility</span> View
                        </a>
                        <button class="text-[10px] font-semibold tracking-[0.2em] uppercase text-on-surface hover:text-error transition-colors flex items-center gap-2"
                                onclick="uploadCarImage(<?= (int)$car['car_id'] ?>)" data-car-id="<?= (int)$car['car_id'] ?>" type="button">
                            <span class="material-symbols-outlined text-sm">photo_camera</span> Upload Image
                        </button>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="inline" onsubmit="return confirm('Delete this listing?')">
                            <input type="hidden" name="car_id" value="<?= (int)$car['car_id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <button type="submit" name="delete_car" class="text-[10px] font-semibold tracking-[0.2em] uppercase text-on-surface hover:text-error transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">delete</span> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Form (hidden) -->
            <div id="edit-form-<?= (int)$car['car_id'] ?>" class="hidden bg-surface-container-low p-8 md:p-12 mb-4">
                <h3 class="text-xs font-medium tracking-[0.2em] uppercase mb-8 text-on-surface-variant">EDIT: <?= htmlspecialchars(($car['company_name'] ?? '') . ' ' . ($car['car_model'] ?? '')) ?></h3>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <input type="hidden" name="car_id" value="<?= (int)$car['car_id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Brand</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="company" value="<?= htmlspecialchars($car['company_name'] ?? '') ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Model</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="model" value="<?= htmlspecialchars($car['car_model'] ?? '') ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Year</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="year" type="number" value="<?= htmlspecialchars($car_year_field) ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Price</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="price" type="number" step="0.01" value="<?= htmlspecialchars($car['price'] ?? '') ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Mileage (km)</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="mileage" type="number" value="<?= htmlspecialchars($car['mileage'] ?? '') ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Location</label>
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="location" value="<?= htmlspecialchars($car['location'] ?? '') ?>" required/>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Transmission</label>
                            <select class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="transmission" required>
                                <option value="Automatic" <?= ($car['transmission'] ?? '') === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                                <option value="Manual"    <?= ($car['transmission'] ?? '') === 'Manual'    ? 'selected' : '' ?>>Manual</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Fuel Type</label>
                            <select class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="fuelType" required>
                                <option value="Petrol"   <?= ($car['fuel_type'] ?? '') === 'Petrol'   ? 'selected' : '' ?>>Petrol</option>
                                <option value="Diesel"   <?= ($car['fuel_type'] ?? '') === 'Diesel'   ? 'selected' : '' ?>>Diesel</option>
                                <option value="Hybrid"   <?= ($car['fuel_type'] ?? '') === 'Hybrid'   ? 'selected' : '' ?>>Hybrid</option>
                                <option value="Electric" <?= ($car['fuel_type'] ?? '') === 'Electric' ? 'selected' : '' ?>>Electric</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Body Type</label>
                            <select class="w-full bg-transparent border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm" name="bodyType" required>
                                <?php foreach (['Sedan','SUV','Hatchback','Coupe','Convertible','Wagon','Van','Truck'] as $bt): ?>
                                <option value="<?= $bt ?>" <?= ($car['body_type'] ?? '') === $bt ? 'selected' : '' ?>><?= $bt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-10 space-y-2">
                        <label class="block text-[10px] font-medium tracking-[0.15em] uppercase text-outline">Description</label>
                        <textarea class="w-full bg-[#f4f3f3] border-0 border-b border-outline-variant p-4 focus:ring-0 focus:border-primary focus:outline-none font-light text-sm resize-none" name="description" rows="3"><?= htmlspecialchars($car['description'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" name="edit_car" class="px-12 py-4 bg-on-background text-white text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-primary transition-colors active:scale-95">
                        UPDATE LISTING
                    </button>
                </form>
            </div>
        </article>
        <?php endforeach; ?>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<script>
const csrfToken = '<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) ?>';

function toggleEdit(carId) {
    var form = document.getElementById('edit-form-' + carId);
    if (!form) return;
    // Close others
    document.querySelectorAll('[id^="edit-form-"]').forEach(function(f) {
        if (f.id !== 'edit-form-' + carId) f.classList.add('hidden');
    });
    form.classList.toggle('hidden');
}

function uploadCarImage(carId) {
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function(e) {
        var file = e.target.files[0];
        if (!file) return;
        var formData = new FormData();
        formData.append('car_image', file);
        formData.append('car_id', carId);
        formData.append('csrf_token', csrfToken);
        var btn = document.querySelector('[data-car-id="' + carId + '"]');
        btn.textContent = 'UPLOADING...';
        btn.disabled = true;
        fetch('api/upload_handler.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    var carItem = btn.closest('article');
                    var img = carItem.querySelector('img');
                    if (img) img.src = data.image_url;
                    btn.textContent = 'UPLOADED ✓';
                    setTimeout(() => location.reload(), 1200);
                } else {
                    alert('Upload failed: ' + data.message);
                    btn.textContent = 'Upload Image';
                    btn.disabled = false;
                }
            })
            .catch(() => { alert('Upload error.'); btn.textContent = 'Upload Image'; btn.disabled = false; });
    };
    input.click();
}

const carImageInput = document.getElementById('carImageInput');
const dropZone = document.getElementById('dropZone');
const dzPreview = document.getElementById('dzPreview');
const dzIcon = document.getElementById('dzIcon');
const dzText = document.getElementById('dzText');
const dzHint = document.getElementById('dzHint');
const dzFileName = document.getElementById('dzFileName');
const dzClear = document.getElementById('dzClear');

function showDropzoneFile(file) {
    if (!file) {
        return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
        dzPreview.src = e.target.result;
        dzPreview.classList.remove('hidden');
        dzIcon.classList.add('hidden');
        dzText.classList.add('hidden');
        dzHint.classList.add('hidden');
        dzFileName.textContent = file.name;
        dzFileName.classList.remove('hidden');
        dzClear.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function clearDropzone(event) {
    if (event) {
        event.preventDefault();
    }
    carImageInput.value = '';
    dzPreview.src = '';
    dzPreview.classList.add('hidden');
    dzIcon.classList.remove('hidden');
    dzText.classList.remove('hidden');
    dzHint.classList.remove('hidden');
    dzFileName.classList.add('hidden');
    dzFileName.textContent = '';
    dzClear.classList.add('hidden');
}

if (carImageInput && dropZone) {
    carImageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            showDropzoneFile(this.files[0]);
        }
    });

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-[#0051ae]', 'bg-[#f0f4ff]');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-[#0051ae]', 'bg-[#f0f4ff]');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-[#0051ae]', 'bg-[#f0f4ff]');
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            carImageInput.files = e.dataTransfer.files;
            showDropzoneFile(e.dataTransfer.files[0]);
        }
    });
}
</script>
</body>
</html>
