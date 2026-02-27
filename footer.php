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
    background-color: #1e1e1e;
    padding: 2rem;
    margin-top: 3rem;
    text-align: center;
    border-top: 1px solid #333;
    position: relative;
    bottom: 0;
    width: 100%;
}

.footer__content {
    max-width: 1200px;
    margin: 0 auto;
}

.footer__text {
    color: #888;
    margin: 0.5rem 0;
    font-size: 0.9rem;
}

.footer__link {
    color: #00ffae;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer__link:hover {
    color: #00c68e;
    text-decoration: underline;
}
</style> 