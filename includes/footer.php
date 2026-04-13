<?php
// Ensure we have access to the current year
$current_year = date("Y");
?>
<footer class="footer">
    <div class="footer__content">
        <p class="footer__text">&copy; <?= $current_year ?> Car Online Sale System (COSS)</p>
        <p class="footer__text">Built with ❤️ in New Zealand</p>
        <p class="footer__text">
            <a href="mailto:support@coss.nz" class="footer__link">support@coss.nz</a>
        </p>
    </div>
</footer>

<style>
.footer {
    background-color: #0a0a0a;
    padding: 2rem;
    margin-top: 3rem;
    text-align: center;
    border-top: 2px solid #333333;
    position: relative;
    bottom: 0;
    width: 100%;
}

.footer__content {
    max-width: 1200px;
    margin: 0 auto;
}

.footer__text {
    color: #888888;
    margin: 0.5rem 0;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer__link {
    color: #ffffff;
    text-decoration: none;
    font-weight: 700;
    transition: color 0.2s linear;
}

.footer__link:hover {
    color: #e11a22; /* Acura Red */
    text-decoration: none;
}
</style> 