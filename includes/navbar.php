<?php
// Get current page for active link highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- TopNavBar - Stitch Design -->
<nav id="coss-navbar" class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl border-b border-transparent transition-all duration-300">
    <div class="flex justify-between items-center px-8 md:px-12 py-5 w-full max-w-full">
        <!-- Logo -->
        <a href="index.php" class="text-2xl font-extralight tracking-widest text-black uppercase hover:opacity-70 transition-opacity">
            COSS
        </a>

        <!-- Desktop Nav Links -->
        <div class="hidden md:flex space-x-10 items-center">
            <a href="index.php" 
               class="font-light tracking-[0.1em] uppercase text-xs transition-all duration-200 <?= $current_page === 'index.php' ? 'text-[#0051ae] font-medium border-b-2 border-[#0051ae]' : 'text-black opacity-70 hover:text-[#0051ae] hover:opacity-100' ?>">
                MODELS
            </a>
            <a href="search.php" 
               class="font-light tracking-[0.1em] uppercase text-xs transition-all duration-200 <?= $current_page === 'search.php' ? 'text-[#0051ae] font-medium border-b-2 border-[#0051ae]' : 'text-black opacity-70 hover:text-[#0051ae] hover:opacity-100' ?>">
                SEARCH
            </a>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'seller'): ?>
            <a href="cars.php" 
               class="font-light tracking-[0.1em] uppercase text-xs transition-all duration-200 <?= $current_page === 'cars.php' ? 'text-[#0051ae] font-medium border-b-2 border-[#0051ae]' : 'text-black opacity-70 hover:text-[#0051ae] hover:opacity-100' ?>">
                SELL
            </a>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php" 
               class="font-light tracking-[0.1em] uppercase text-xs transition-all duration-200 <?= $current_page === 'login.php' ? 'text-[#0051ae] font-medium border-b-2 border-[#0051ae]' : 'text-black opacity-70 hover:text-[#0051ae] hover:opacity-100' ?>">
                LOGIN
            </a>
            <?php endif; ?>
        </div>

        <!-- Right Icons -->
        <div class="flex items-center space-x-5">
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="text-black opacity-70 hover:opacity-100 hover:text-[#0051ae] transition-all" title="My Profile">
                <span class="material-symbols-outlined" style="font-size:22px; font-variation-settings:'FILL' 0,'wght' 300,'GRAD' 0,'opsz' 24;">account_circle</span>
            </a>
            <a href="messages.php" class="text-black opacity-70 hover:opacity-100 hover:text-[#0051ae] transition-all" title="Messages">
                <span class="material-symbols-outlined" style="font-size:22px; font-variation-settings:'FILL' 0,'wght' 300,'GRAD' 0,'opsz' 24;">message</span>
            </a>
            <?php if ($_SESSION['user_type'] === 'admin'): ?>
            <a href="search.php" class="text-black opacity-70 hover:opacity-100 hover:text-[#0051ae] transition-all" title="Admin">
                <span class="material-symbols-outlined" style="font-size:22px; font-variation-settings:'FILL' 0,'wght' 300,'GRAD' 0,'opsz' 24;">admin_panel_settings</span>
            </a>
            <?php endif; ?>
            <a href="api/logout.php" class="font-light tracking-[0.1em] uppercase text-xs text-black opacity-70 hover:text-[#0051ae] hover:opacity-100 transition-all duration-200">
                LOGOUT
            </a>
            <?php else: ?>
            <a href="registration.php" class="font-light tracking-[0.1em] uppercase text-xs text-black opacity-70 hover:text-[#0051ae] hover:opacity-100 transition-all duration-200">
                REGISTER
            </a>
            <?php endif; ?>

            <!-- Mobile Hamburger -->
            <button id="mobile-menu-btn" class="md:hidden flex flex-col space-y-1.5 p-1" aria-label="Toggle menu">
                <span class="w-6 h-0.5 bg-black transition-all duration-300" id="ham1"></span>
                <span class="w-6 h-0.5 bg-black transition-all duration-300" id="ham2"></span>
                <span class="w-6 h-0.5 bg-black transition-all duration-300" id="ham3"></span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 px-8 pb-6 pt-4">
        <div class="flex flex-col space-y-5">
            <a href="index.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">MODELS</a>
            <a href="search.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">SEARCH</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['user_type'] === 'seller'): ?>
                <a href="cars.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">SELL</a>
                <?php endif; ?>
                <a href="profile.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">PROFILE</a>
                <a href="messages.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">MESSAGES</a>
                <a href="api/logout.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">LOGOUT</a>
            <?php else: ?>
                <a href="login.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">LOGIN</a>
                <a href="registration.php" class="text-xs font-light tracking-[0.15em] uppercase text-black opacity-70 hover:text-[#0051ae] transition-colors">REGISTER</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const h1 = document.getElementById('ham1');
    const h2 = document.getElementById('ham2');
    const h3 = document.getElementById('ham3');
    let open = false;

    btn.addEventListener('click', function() {
        open = !open;
        menu.classList.toggle('hidden', !open);
        if (open) {
            h1.style.transform = 'rotate(45deg) translate(4px, 4px)';
            h2.style.opacity = '0';
            h3.style.transform = 'rotate(-45deg) translate(4px, -4px)';
        } else {
            h1.style.transform = '';
            h2.style.opacity = '';
            h3.style.transform = '';
        }
    });

    // Scroll shadow effect
    const navbar = document.getElementById('coss-navbar');
    window.addEventListener('scroll', function(){
        if(window.scrollY > 20){
            navbar.classList.add('shadow-sm');
        } else {
            navbar.classList.remove('shadow-sm');
        }
    });
});
</script>