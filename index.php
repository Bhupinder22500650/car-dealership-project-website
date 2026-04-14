<?php
// --------------------------------------------------------------------------
// Initialize session for tracking logged‐in users across pages
// --------------------------------------------------------------------------
session_start();

// --------------------------------------------------------------------------
// Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/config/database.php';

require_once __DIR__ . '/controllers/IndexController.php';
$controller = new IndexController();
$controller->index();
?>
