<?php
session_start();
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$me = $_SESSION['user_id'];
$target_id = isset($_GET['id']) ? (int)$_GET['id'] : $me;
$is_me = ($target_id === $me);

$success_msg = '';
$error_msg = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle Update Profile (Only if it's the logged in user)
if ($is_me && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $first = trim($_POST['first_name'] ?? '');
        $last  = trim($_POST['last_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $bio   = trim($_POST['bio'] ?? '');
        
        if ($email) {
            $stmt = $conn->prepare("UPDATE users SET First_name=?, Last_name=?, Phone=?, email=?, bio=? WHERE user_id=?");
            $stmt->bind_param("sssssi", $first, $last, $phone, $email, $bio, $me);
            if ($stmt->execute()) {
                $success_msg = "Profile updated successfully.";
            } else {
                $error_msg = "Could not update profile. Email might be in use.";
            }
            $stmt->close();
        } else {
            $error_msg = "Invalid email address.";
        }
    }
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $target_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user_data) {
    header("Location: index.php");
    exit;
}

// Fetch ratings if seller
$is_seller = ($user_data['user_type'] === 'seller');
$avg_rating = 0;
$review_count = 0;
$reviews = [];

if ($is_seller) {
    // Average rating
    $st = $conn->prepare("SELECT AVG(rating) as avg_r, COUNT(*) as cnt FROM feedback f JOIN cars c ON f.car_id = c.car_id WHERE c.seller_id = ? AND f.rating > 0");
    $st->bind_param("i", $target_id);
    $st->execute();
    $rstat = $st->get_result()->fetch_assoc();
    $avg_rating = round($rstat['avg_r'] ?? 0, 1);
    $review_count = $rstat['cnt'];
    $st->close();

    // Recent reviews
    $st = $conn->prepare("
        SELECT f.rating, f.comment, f.created_at, u.First_name, c.company_name, c.car_model
        FROM feedback f 
        JOIN cars c ON f.car_id = c.car_id 
        JOIN users u ON f.user_id = u.user_id
        WHERE c.seller_id = ? AND f.rating > 0
        ORDER BY f.created_at DESC LIMIT 20
    ");
    $st->bind_param("i", $target_id);
    $st->execute();
    $reviews = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($user_data['First_name']) ?>'s Profile | COSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        .drag-zone {
            border: 1px dashed rgba(194, 198, 213, 0.5);
            transition: all 0.2s;
        }
        .drag-zone.dragging {
            background-color: rgba(0, 81, 174, 0.05);
            border-color: #0051ae;
        }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-[#d8e2ff]">

<?php include 'includes/navbar.php'; ?>

<main class="pt-32 pb-24 min-h-screen px-6 md:px-12 max-w-5xl mx-auto flex flex-col md:flex-row gap-12 text-on-surface hover">
    
    <!-- Left Column: Avatar & Basic Info -->
    <aside class="w-full md:w-1/3 flex flex-col gap-8">
        <div class="bg-white p-8 group border border-[#c2c6d5]/10">
            <div class="relative w-32 h-32 mx-auto rounded-full overflow-hidden mb-6 bg-[#f4f3f3] flex items-center justify-center">
                <?php if ($user_data['profile_photo'] && $user_data['profile_photo'] !== 'assets/img/default-avatar.png'): ?>
                    <img id="avatar-preview" src="<?= htmlspecialchars($user_data['profile_photo']) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <span id="avatar-icon" class="material-symbols-outlined text-5xl text-[#c2c6d5]">account_circle</span>
                    <img id="avatar-preview" class="hidden w-full h-full object-cover">
                <?php endif; ?>
                
                <?php if ($is_me): ?>
                <div id="drop-zone" class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center cursor-pointer transition-all">
                    <span class="material-symbols-outlined text-white">photo_camera</span>
                </div>
                <input type="file" id="photo-input" class="hidden" accept="image/*,.heic,.heif">
                <?php endif; ?>
            </div>
            
            <h1 class="text-2xl font-semibold tracking-tight text-center uppercase"><?= htmlspecialchars($user_data['First_name'] . ' ' . $user_data['Last_name']) ?></h1>
            <p class="text-[10px] tracking-[0.2em] font-medium text-center uppercase text-[#424753]/60 mb-6"><?= htmlspecialchars($user_data['user_type']) ?></p>
            
            <?php if ($is_seller && !$is_me): ?>
                <div class="flex items-center justify-center gap-2 mb-6">
                    <span class="material-symbols-outlined text-[#0051ae]" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="text-sm font-semibold"><?= $avg_rating > 0 ? $avg_rating : 'New' ?></span>
                    <span class="text-xs text-[#424753]">(<?= $review_count ?>)</span>
                </div>
            <?php endif; ?>

            <div class="space-y-4 pt-6 border-t border-[#c2c6d5]/10">
                <div class="flex flex-col gap-1">
                    <span class="text-[9px] tracking-widest uppercase font-medium text-[#424753]/60">Email</span>
                    <span class="text-xs font-light truncate"><?= htmlspecialchars($user_data['email']) ?></span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[9px] tracking-widest uppercase font-medium text-[#424753]/60">Phone</span>
                    <span class="text-xs font-light"><?= htmlspecialchars($user_data['Phone']) ?></span>
                </div>
                <!-- Action button -->
                <?php if (!$is_me && $is_seller): ?>
                    <!-- Optional: Link back to search or messaging, but logic is tightly coupled to a car_id usually. -->
                <?php endif; ?>
            </div>
        </div>
    </aside>

    <!-- Right Column: Edit Form OR Public Showcase -->
    <section class="w-full md:w-2/3 flex flex-col gap-12">
        <?php if ($is_me): ?>
            <!-- Editing Form -->
            <div class="bg-white p-8 md:p-12 border border-[#c2c6d5]/10">
                <h2 class="text-xl font-light tracking-wide uppercase mb-8">Edit Profile</h2>
                <?php if ($success_msg): ?><p class="text-[#0051ae] text-xs font-medium tracking-wide uppercase mb-6"><?= $success_msg ?></p><?php endif; ?>
                <?php if ($error_msg): ?><p class="text-[#ba1a1a] text-xs font-medium tracking-wide uppercase mb-6"><?= $error_msg ?></p><?php endif; ?>
                
                <form method="POST" action="profile.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex flex-col">
                            <label class="text-[9px] uppercase tracking-widest text-[#424753] mb-2 font-medium">First Name</label>
                            <input name="first_name" type="text" required value="<?= htmlspecialchars($user_data['First_name']) ?>" class="w-full bg-transparent border-0 border-b border-[#c2c6d5]/50 py-3 focus:ring-0 focus:border-[#0051ae] focus:outline-none text-xs font-light transition-colors">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[9px] uppercase tracking-widest text-[#424753] mb-2 font-medium">Last Name</label>
                            <input name="last_name" type="text" required value="<?= htmlspecialchars($user_data['Last_name']) ?>" class="w-full bg-transparent border-0 border-b border-[#c2c6d5]/50 py-3 focus:ring-0 focus:border-[#0051ae] focus:outline-none text-xs font-light transition-colors">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="flex flex-col">
                            <label class="text-[9px] uppercase tracking-widest text-[#424753] mb-2 font-medium">Email</label>
                            <input name="email" type="email" required value="<?= htmlspecialchars($user_data['email']) ?>" class="w-full bg-transparent border-0 border-b border-[#c2c6d5]/50 py-3 focus:ring-0 focus:border-[#0051ae] focus:outline-none text-xs font-light transition-colors">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[9px] uppercase tracking-widest text-[#424753] mb-2 font-medium">Phone</label>
                            <input name="phone" type="text" required value="<?= htmlspecialchars($user_data['Phone']) ?>" class="w-full bg-transparent border-0 border-b border-[#c2c6d5]/50 py-3 focus:ring-0 focus:border-[#0051ae] focus:outline-none text-xs font-light transition-colors">
                        </div>
                    </div>
                    
                    <div class="flex flex-col mb-10">
                        <label class="text-[9px] uppercase tracking-widest text-[#424753] mb-2 font-medium">Auto Biography & Policies</label>
                        <textarea name="bio" rows="4" class="w-full bg-transparent border border-[#c2c6d5]/50 p-4 focus:ring-0 focus:border-[#0051ae] focus:outline-none text-xs font-light transition-colors resize-none"><?= htmlspecialchars($user_data['bio']) ?></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#1b1c1c] text-white px-10 py-4 text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-colors">
                            SAVE CHANGES
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Hidden Image Upload Script -->
            <script>
                const dropZone = document.getElementById('drop-zone');
                const fileInput = document.getElementById('photo-input');
                const previewLayer = document.getElementById('avatar-preview');
                const iconLayer = document.getElementById('avatar-icon');

                dropZone.addEventListener('click', () => fileInput.click());

                dropZone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropZone.classList.add('bg-black/70');
                });

                dropZone.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('bg-black/70');
                });

                dropZone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('bg-black/70');
                    if (e.dataTransfer.files.length) uploadPhoto(e.dataTransfer.files[0]);
                });

                fileInput.addEventListener('change', () => {
                    if (fileInput.files.length) uploadPhoto(fileInput.files[0]);
                });

                function uploadPhoto(file) {
                    const formData = new FormData();
                    formData.append('profile_photo', file);

                    dropZone.innerHTML = '<span class="material-symbols-outlined text-white animate-spin">refresh</span>';

                    fetch('api/profile_upload.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (iconLayer) iconLayer.classList.add('hidden');
                            previewLayer.src = data.url;
                            previewLayer.classList.remove('hidden');
                            dropZone.innerHTML = '<span class="material-symbols-outlined text-white">photo_camera</span>';
                        } else {
                            alert(data.message);
                            dropZone.innerHTML = '<span class="material-symbols-outlined text-white">photo_camera</span>';
                        }
                    })
                    .catch(err => {
                        alert('Upload failed.');
                        dropZone.innerHTML = '<span class="material-symbols-outlined text-white">photo_camera</span>';
                    });
                }
            </script>

        <?php else: ?>
            <!-- Public Showcase -->
            <div class="bg-white p-8 md:p-12 border border-[#c2c6d5]/10">
                <h2 class="text-lg font-light tracking-wide uppercase mb-6 border-b border-[#c2c6d5]/10 pb-4">About Me</h2>
                <p class="text-sm font-light text-[#424753] leading-relaxed mb-8">
                    <?= nl2br(htmlspecialchars($user_data['bio'] ?: 'No biography provided yet.')) ?>
                </p>
                
                <?php if ($is_seller): ?>
                <h2 class="text-lg font-light tracking-wide uppercase mb-8 border-b border-[#c2c6d5]/10 pb-4">Seller Reviews (<?= $review_count ?>)</h2>
                <?php if (empty($reviews)): ?>
                    <p class="text-xs text-[#424753]/60 italic">No reviews found.</p>
                <?php else: ?>
                    <div class="space-y-6">
                        <?php foreach ($reviews as $rev): ?>
                        <div class="p-6 bg-[#f4f3f3] border border-[#c2c6d5]/10">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="text-xs font-semibold tracking-wide uppercase"><?= htmlspecialchars($rev['First_name']) ?> <span class="font-light opacity-60 text-[10px] normal-case ml-2">on <?= htmlspecialchars($rev['company_name'] . ' ' . $rev['car_model']) ?></span></h4>
                                </div>
                                <div class="flex gap-1 text-[#0051ae]">
                                    <?php for ($i=1; $i<=5; $i++): ?>
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' <?= $i <= $rev['rating'] ? 1 : 0 ?>;">star</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="text-xs font-light text-[#424753] leading-relaxed">
                                <?= nl2br(htmlspecialchars($rev['comment'])) ?>
                            </p>
                            <p class="text-[9px] uppercase tracking-widest text-[#424753]/50 mt-4"><?= date('M j, Y', strtotime($rev['created_at'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
