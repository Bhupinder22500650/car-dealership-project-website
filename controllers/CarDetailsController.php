<?php
// --------------------------------------------------------------------------
// Car details page controller
// --------------------------------------------------------------------------

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../config/database.php';

$car_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($car_id <= 0) {
    header('Location: index.php');
    exit;
}

$hasProfilePhoto = false;
$profilePhotoCol = $conn->query("SHOW COLUMNS FROM users LIKE 'profile_photo'");
if ($profilePhotoCol && $profilePhotoCol->num_rows > 0) {
    $hasProfilePhoto = true;
}

$sellerPhotoSelect = $hasProfilePhoto ? 'u.profile_photo AS seller_photo' : 'NULL AS seller_photo';
$carSql = "
    SELECT c.*, u.username AS seller_name, {$sellerPhotoSelect}
    FROM cars c
    LEFT JOIN users u ON c.seller_id = u.user_id
    WHERE c.car_id = ?
";

$stmt = $conn->prepare($carSql);
$stmt->bind_param('i', $car_id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$car) {
    header('Location: index.php');
    exit;
}

$reviews = [];
$reviewsStmt = $conn->prepare(
    'SELECT f.comment, u.First_name, u.Last_name, f.created_at
     FROM feedback f
     JOIN users u ON f.user_id = u.user_id
     WHERE f.car_id = ?
     ORDER BY f.created_at DESC
     LIMIT 3'
);
$reviewsStmt->bind_param('i', $car_id);
$reviewsStmt->execute();
$reviews = $reviewsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$reviewsStmt->close();

$car_year_field = $car['car_year'] ?? $car['year'] ?? '';
$img_src = !empty($car['image_url']) ? $car['image_url'] : (
    !empty($car['image_path']) && file_exists(dirname(__DIR__) . '/' . $car['image_path'])
        ? $car['image_path']
        : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAUmzoNC3_kYzGOSktHvv0BK03IOM2m6XmxESHsbnA9v7379skYWZt30hAOEQnGj_H05R-AhJJFXhlGqAEMTaaPGDCzjmvWLJfK8TxmPIg9bqJxf-Sege9PAnLKZ-3LeNGp39LnfqdNbbjBJ4z0hMSUcVY9gwhtXzx7t_qUrF1Mppa3JKSRE5uNZRd2HW9lnueM3lZui-M-8ntiwEdrmGFwIbt_7-_2fnIUgIurfAXjLf20Fn7wGiXxORZbCrAFEW7xCC6ZYgH1QGs'
);

require_once __DIR__ . '/../views/car-details.view.php';
