<?php
// Get current page for active link highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="header">
    <div class="header__logo">🚗 COSS</div>
    <button class="mobile-menu-toggle" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <nav class="header__navbar">
        <ul class="navbar__list">
            <li class="navbar__item">
                <a href="index.php" class="navbar__link <?= $current_page === 'index.php' ? 'active' : '' ?>">Home</a>
            </li>
            <li class="navbar__item">
                <a href="search.php" class="navbar__link <?= $current_page === 'search.php' ? 'active' : '' ?>">Search</a>
            </li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li class="navbar__item">
                    <a href="registration.php" class="navbar__link <?= $current_page === 'registration.php' ? 'active' : '' ?>">Register</a>
                </li>
                <li class="navbar__item">
                    <a href="login.php" class="navbar__link <?= $current_page === 'login.php' ? 'active' : '' ?>">Login</a>
                </li>
            <?php else: ?>
                <?php if ($_SESSION['user_type'] === 'admin'): ?>
                    <li class="navbar__item">
                        <a href="admin_dashboard.php" class="navbar__link <?= $current_page === 'admin_dashboard.php' ? 'active' : '' ?>">Admin Panel</a>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['user_type'] === 'seller'): ?>
                    <li class="navbar__item">
                        <a href="cars.php" class="navbar__link <?= $current_page === 'cars.php' ? 'active' : '' ?>">My Cars</a>
                    </li>
                <?php endif; ?>

                <li class="navbar__item">
                    <a href="messages.php" class="navbar__link <?= $current_page === 'messages.php' ? 'active' : '' ?>">Messages</a>
                </li>
                <li class="navbar__item">
                    <a href="api/logout.php" class="navbar__link">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navbar = document.querySelector('.header__navbar');
    const body = document.body;

    mobileMenuToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        navbar.classList.toggle('active');
        body.style.overflow = navbar.classList.contains('active') ? 'hidden' : '';
    });

    // Close menu when clicking on a link
    const navLinks = document.querySelectorAll('.navbar__link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenuToggle.classList.remove('active');
            navbar.classList.remove('active');
            body.style.overflow = '';
        });
    });

    // Mobile oversight fix: resize event to clear mobile states when going back to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            mobileMenuToggle.classList.remove('active');
            navbar.classList.remove('active');
            body.style.overflow = '';
        }
    });
});
</script> 