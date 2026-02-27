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
            <?php if (!isset($_SESSION['seller_id'])): ?>
                <li class="navbar__item">
                    <a href="registration.php" class="navbar__link <?= $current_page === 'registration.php' ? 'active' : '' ?>">Register</a>
                </li>
                <li class="navbar__item">
                    <a href="login.php" class="navbar__link <?= $current_page === 'login.php' ? 'active' : '' ?>">Login</a>
                </li>
            <?php else: ?>
                <li class="navbar__item">
                    <a href="cars.php" class="navbar__link <?= $current_page === 'cars.php' ? 'active' : '' ?>">Cars</a>
                </li>
                <li class="navbar__item">
                    <a href="logout.php" class="navbar__link">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<style>
.header {
    background-color: #1e1e1e;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    position: relative;
    z-index: 1001;
}

.header__logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #00ffae;
    z-index: 1002;
    margin-right: 1rem;
}

.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 1002;
    margin-left: 1rem;
}

.mobile-menu-toggle span {
    display: block;
    width: 28px;
    height: 3px;
    background-color: #00ffae;
    border-radius: 3px;
    margin: 4px 0;
    transition: all 0.3s ease;
}

.header__navbar {
    display: flex;
    align-items: center;
}

.navbar__list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 1.5rem;
}

.navbar__item {
    margin: 0;
}

.navbar__link {
    color: #e0e0e0;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.navbar__link:hover {
    background-color: #2c2c2c;
    color: #00ffae;
}

.navbar__link.active {
    background-color: #00ffae;
    color: #121212;
}

@media (max-width: 768px) {
    .mobile-menu-toggle {
        display: flex;
    }

    .header__navbar {
        position: fixed;
        top: 0;
        right: -100%;
        width: 100vw;
        height: 100vh;
        background: rgba(30,30,30,0.98);
        padding: 0;
        transition: right 0.3s cubic-bezier(.77,0,.18,1);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .header__navbar.active {
        right: 0;
    }

    .navbar__list {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.2rem;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .navbar__item {
        width: 100vw;
        display: flex;
        justify-content: center;
    }

    .navbar__link {
        font-size: 1.2rem;
        padding: 0.8rem 2rem;
        width: auto;
        text-align: center;
        border-radius: 8px;
        display: inline-block;
    }

    /* Hamburger animation */
    .mobile-menu-toggle.active span:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }
    .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    .mobile-menu-toggle.active span:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
    }
}
</style>

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
});
</script> 