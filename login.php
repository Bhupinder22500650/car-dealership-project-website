<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/create_tables.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: cars.php');
    }
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request token. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $conn->prepare("SELECT user_id, password, user_type FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $hashedPassword, $userType);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                session_regenerate_id(true);
                $_SESSION['user_id']   = $userId;
                $_SESSION['username']  = $username;
                $_SESSION['user_type'] = $userType;

                if ($userType === 'admin') {
                    header('Location: admin_dashboard.php');
                } elseif ($userType === 'seller') {
                    header('Location: cars.php');
                } else {
                    header('Location: search.php');
                }
                exit;
            }
        }
        $error = 'Invalid username or password.';
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | COSS AUTOMOTIVE</title>
    <meta name="description" content="Sign in to your COSS account to access the premium automotive marketplace.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        .luxury-input {
            border-top: none; border-left: none; border-right: none;
            border-bottom: 1px solid #c2c6d5;
            background: transparent; border-radius: 0;
            padding-left: 0; padding-right: 0;
        }
        .luxury-input:focus {
            outline: none; border-bottom-color: #0051ae; border-bottom-width: 2px;
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased overflow-hidden">
<main class="flex min-h-screen w-full">
    <!-- Left Section: Full-height cinematic car photograph -->
    <section class="hidden lg:block lg:w-1/2 relative overflow-hidden">
        <img alt="Cinematic luxury car"
             class="absolute inset-0 w-full h-full object-cover"
             src="https://lh3.googleusercontent.com/aida-public/AB6AXuANLWBSXcfx66OBiyVNMQPKgeIu_SeTEFc6wzno44PTATCCEy2VZSiPdosCHSB1px71bblewtjkfHEh7l8tECa_1JOcFvTSQgXrTzlCiK7XdlkvmwLFJl2CLejsVa0GgTAM12RzQA0gMfv41Bd9La_A1mV11oPu18t3EJJvqP5Lpap2RJXB82DKnrxTgRBXhAHtueyglGZY4-ag7a-dCBeorNmmT4eya-CJI9qkYWPfnKqPLS4U2IjtvyHBkPXgXjyL6a-8DYgPBDg"/>
        <div class="absolute inset-0 bg-black/20"></div>
        <!-- Branding Overlay -->
        <div class="absolute top-12 left-12">
            <a href="index.php" class="text-2xl font-extralight tracking-[0.3em] text-white uppercase hover:opacity-70 transition-opacity">COSS</a>
        </div>
        <div class="absolute bottom-12 left-12 max-w-sm">
            <p class="text-white/60 font-light tracking-[0.1em] uppercase text-[10px] mb-4">ESTABLISHED 2024</p>
            <h2 class="text-white text-3xl font-thin tracking-widest uppercase leading-tight">Defining the future of automotive acquisition.</h2>
        </div>
    </section>

    <!-- Right Section: Clean white panel -->
    <section class="w-full lg:w-1/2 bg-white flex items-center justify-center px-8 md:px-24 overflow-y-auto min-h-screen">
        <div class="w-full max-w-md py-16">
            <!-- Mobile Branding -->
            <div class="lg:hidden mb-12 flex justify-center">
                <a href="index.php" class="text-2xl font-extralight tracking-[0.3em] text-black uppercase">COSS</a>
            </div>

            <div class="mb-12">
                <h1 class="text-4xl font-extralight tracking-[0.15em] text-on-surface uppercase mb-2">WELCOME BACK</h1>
                <div class="w-12 h-[1px] bg-[#0051ae]"></div>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
            <div class="coss-alert-error mb-8"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form class="space-y-10" action="login.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="space-y-2 relative">
                    <label class="block text-[10px] font-medium tracking-[0.2em] text-[#424753] uppercase" for="username">Username / Email</label>
                    <input class="luxury-input w-full py-4 text-sm font-light tracking-wide focus:ring-0"
                           id="username" name="username" placeholder="john.doe@coss.com" type="text"
                           value="<?= htmlspecialchars($username) ?>" required/>
                </div>

                <div class="space-y-2 relative">
                    <div class="flex justify-between items-center">
                        <label class="block text-[10px] font-medium tracking-[0.2em] text-[#424753] uppercase" for="password">Password</label>
                        <a class="text-[9px] font-light tracking-[0.1em] text-[#0051ae] uppercase hover:opacity-70 transition-opacity" href="#">Forgot?</a>
                    </div>
                    <input class="luxury-input w-full py-4 text-sm font-light tracking-wide focus:ring-0"
                           id="password" name="password" placeholder="••••••••" type="password" required/>
                </div>

                <div class="pt-4">
                    <button class="w-full bg-[#1b1c1c] text-white py-5 text-xs font-medium tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-colors duration-300" type="submit">
                        [ LOGIN ]
                    </button>
                </div>
            </form>

            <div class="mt-12 flex flex-col items-center space-y-6">
                <a class="group flex items-center space-x-2 text-[11px] font-light tracking-[0.1em] text-on-surface uppercase transition-all" href="registration.php">
                    <span>Don't have an account? Register</span>
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
                <div class="flex items-center space-x-6">
                    <span class="w-8 h-[1px] bg-[#c2c6d5]/30"></span>
                    <span class="text-[9px] font-light tracking-[0.2em] text-[#727784] uppercase">Secured by COSS Vault</span>
                    <span class="w-8 h-[1px] bg-[#c2c6d5]/30"></span>
                </div>
                <a href="index.php" class="text-[10px] font-light tracking-[0.1em] uppercase text-[#727784] hover:text-[#0051ae] transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Home
                </a>
            </div>
        </div>
    </section>
</main>

<!-- Footer pinned -->
<footer class="fixed bottom-6 right-8 hidden lg:block pointer-events-none">
    <p class="text-[9px] font-light tracking-[0.15em] text-on-surface/40 uppercase">© <?= date('Y') ?> COSS AUTOMOTIVE. ALL RIGHTS RESERVED.</p>
</footer>
</body>
</html>
