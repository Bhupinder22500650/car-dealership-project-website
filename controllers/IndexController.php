<?php
class IndexController {
    public function index() {
        global $conn;
        require_once __DIR__ . '/../views/index.view.php';
    }
}
?>
