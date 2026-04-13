<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>COSS | CREATE ACCOUNT</title>
    <meta name="description" content="Create your COSS account to buy and sell premium vehicles on New Zealand's finest automotive marketplace.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        input:focus, select:focus, textarea:focus { outline: none !important; box-shadow: none !important; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">

<!-- Minimal fixed header -->
<header class="fixed top-0 left-0 w-full z-50 px-8 md:px-12 py-7 flex justify-between items-center bg-transparent">
    <a href="index.php" class="text-2xl font-extralight tracking-widest text-white md:text-black uppercase hover:opacity-70 transition-opacity mix-blend-difference">COSS</a>
    <a class="font-light tracking-[0.1em] uppercase text-xs text-white mix-blend-difference hover:text-[#adc6ff] transition-colors" href="login.php">LOGIN</a>
</header>

<main class="flex min-h-screen w-full">
    <!-- Left Side: Cinematic Photo -->
    <section class="hidden lg:block w-1/2 h-screen sticky top-0 bg-black overflow-hidden">
        <div class="w-full h-full bg-cover bg-center opacity-90 scale-105"
             style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDHdsWFr5acEXErRKpNcaM5LdCiey58ZGIzsyg6OoBi0HouzlYzZNT0UwHR59usUbrOq-YukQdBQENTKcdbbaoTa2uJae1ZF72Uqs7pnr5im0FD5hbn9UxW5b7fxi1xxplRLYGgVhm6m22OJdR5-OtX0XeuI7ED2t6Z9GEZiF0GqEfFIq7JXVg3AtVq-1faX_fbYooJUEEJ4Zp7OMQY5EZ4NOF1bAPEQLvEWwQSS30Lml8OxfxaMD6OaimRLgFkmDXUsKgNJ2AKBT0');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
    </section>

    <!-- Right Side: White Panel -->
    <section class="w-full lg:w-1/2 bg-white flex flex-col justify-center px-8 md:px-20 lg:px-24 py-28 overflow-y-auto">
        <div class="max-w-xl w-full mx-auto">
            <h1 class="text-4xl md:text-5xl font-extralight tracking-tight text-on-surface mb-2 uppercase">CREATE ACCOUNT</h1>
            <p class="font-light tracking-[0.05em] uppercase text-[10px] text-[#727784] mb-12">Step into the future of automotive excellence.</p>

            <!-- Alerts -->
            <?php if ($errors): ?>
            <div class="coss-alert-error mb-8">
                <?php foreach ($errors as $e): ?>
                <p>• <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if ($success): ?>
            <div class="coss-alert-success mb-8"><?= $success ?></div>
            <?php endif; ?>

            <form class="space-y-12" action="registration.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <!-- Role Selector -->
                <div class="space-y-4">
                    <label class="font-light tracking-[0.1em] uppercase text-[10px] text-[#424753] block">I WANT TO</label>
                    <div class="grid grid-cols-2 gap-0 border border-[#c2c6d5]/30">
                        <label id="buyer-card" class="relative group cursor-pointer p-8 bg-[#1b1c1c] text-white transition-all duration-300 block text-center">
                            <input id="buyer" class="hidden" name="userType" type="radio" value="buyer" checked/>
                            <span class="material-symbols-outlined block mb-4" style="font-variation-settings: 'wght' 200;">shopping_bag</span>
                            <span class="font-light tracking-widest text-sm uppercase">BUYER</span>
                        </label>
                        <label id="seller-card" class="relative group cursor-pointer p-8 bg-transparent text-on-surface hover:bg-[#efeded] transition-all duration-300 block text-center">
                            <input id="seller" class="hidden" name="userType" type="radio" value="seller"/>
                            <span class="material-symbols-outlined block mb-4 opacity-60" style="font-variation-settings: 'wght' 200;">sell</span>
                            <span class="font-light tracking-widest text-sm uppercase opacity-60">SELLER</span>
                        </label>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    <div class="relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">First Name</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="firstName" placeholder="Alexander" type="text" value="<?= htmlspecialchars($firstName) ?>" required/>
                    </div>
                    <div class="relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">Last Name</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="lastName" placeholder="Vance" type="text" value="<?= htmlspecialchars($lastName) ?>" required/>
                    </div>
                    <div class="md:col-span-2 relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">Full Address</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="address" placeholder="123 Performance Way, Auckland 1010" type="text" value="<?= htmlspecialchars($address) ?>" required/>
                    </div>
                    <div class="relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">Phone Number</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="phone" placeholder="+64 9 000 0000" type="tel" value="<?= htmlspecialchars($phone) ?>" required/>
                    </div>
                    <div class="relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">Email Address</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="email" placeholder="alex@coss.com" type="email" value="<?= htmlspecialchars($email) ?>" required/>
                    </div>
                </div>

                <!-- Security -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10 pt-4">
                    <div class="relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">Username</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="username" placeholder="avance_01" type="text" value="<?= htmlspecialchars($username) ?>" required/>
                    </div>
                    <div class="relative border-b border-[#c2c6d5]/50 focus-within:border-[#0051ae] transition-colors py-2">
                        <label class="absolute -top-6 left-0 font-light tracking-[0.1em] uppercase text-[10px] text-[#424753]">Password</label>
                        <input class="w-full bg-transparent border-none p-0 text-sm tracking-wide font-light" name="password" placeholder="••••••••••••" type="password" required/>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button class="w-full bg-[#1b1c1c] text-white font-light tracking-[0.2em] uppercase text-sm py-6 transition-all duration-300 hover:bg-[#0051ae] active:scale-[0.98]" type="submit">
                        CREATE ACCOUNT
                    </button>
                    <p class="mt-6 text-center font-light tracking-widest text-[10px] text-[#727784] uppercase">
                        Already have an account?
                        <a class="text-on-surface border-b border-on-surface/20 hover:border-[#0051ae] transition-colors" href="login.php">Sign In</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="w-full bg-[#262626] py-10 px-8 md:px-16">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-xl font-thin tracking-[0.2em] text-white uppercase">COSS</div>
        <div class="flex gap-8">
            <a class="font-light tracking-[0.05em] uppercase text-[10px] text-gray-400 hover:text-white transition-colors" href="#">PRIVACY</a>
            <a class="font-light tracking-[0.05em] uppercase text-[10px] text-gray-400 hover:text-white transition-colors" href="#">CONTACT</a>
            <a class="font-light tracking-[0.05em] uppercase text-[10px] text-gray-400 hover:text-white transition-colors" href="#">TERMS</a>
        </div>
        <div class="font-light tracking-[0.05em] uppercase text-[10px] text-gray-400">© <?= date('Y') ?> COSS AUTOMOTIVE. ALL RIGHTS RESERVED.</div>
    </div>
</footer>

<script>
// Role selector toggle visual
document.querySelectorAll('input[name="userType"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var buyerCard = document.getElementById('buyer-card');
        var sellerCard = document.getElementById('seller-card');
        var buyerIcon = buyerCard.querySelector('.material-symbols-outlined');
        var sellerLabel = sellerCard.querySelector('span:last-child');
        var buyerLabel = buyerCard.querySelector('span:last-child');
        var sellerIcon = sellerCard.querySelector('.material-symbols-outlined');

        if (this.value === 'buyer') {
            buyerCard.classList.add('bg-[#1b1c1c]', 'text-white');
            buyerCard.classList.remove('bg-transparent', 'text-on-surface');
            sellerCard.classList.remove('bg-[#1b1c1c]', 'text-white');
            sellerCard.classList.add('bg-transparent', 'text-on-surface');
        } else {
            sellerCard.classList.add('bg-[#1b1c1c]', 'text-white');
            sellerCard.classList.remove('bg-transparent', 'text-on-surface');
            buyerCard.classList.remove('bg-[#1b1c1c]', 'text-white');
            buyerCard.classList.add('bg-transparent', 'text-on-surface');
        }
    });
});
</script>
</body>
</html>
