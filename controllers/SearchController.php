<?php
// --------------------------------------------------------------------------
// search.php
// --------------------------------------------------------------------------

session_start();

require_once __DIR__ . '/../config/database.php';

$brand        = trim($_GET['brand'] ?? '');
$model        = trim($_GET['model'] ?? '');
$year         = trim($_GET['year'] ?? '');
$price        = trim($_GET['price'] ?? '');
$transmission = trim($_GET['transmission'] ?? '');
$fuel_type    = trim($_GET['fuel_type'] ?? '');
$mileage      = trim($_GET['mileage'] ?? '');
$sort         = trim($_GET['sort'] ?? 'newest');

$conditions = [];
$params = [];
$types = '';

if ($brand !== '') {
    $conditions[] = 'company_name LIKE ?';
    $params[] = "%{$brand}%";
    $types .= 's';
}
if ($model !== '') {
    $conditions[] = 'car_model LIKE ?';
    $params[] = "%{$model}%";
    $types .= 's';
}
if ($year !== '') {
    $conditions[] = 'car_year = ?';
    $params[] = (int) $year;
    $types .= 'i';
}
if ($price !== '') {
    $conditions[] = 'price <= ?';
    $params[] = (float) $price;
    $types .= 'd';
}
if ($transmission !== '') {
    $conditions[] = 'transmission = ?';
    $params[] = $transmission;
    $types .= 's';
}
if ($fuel_type !== '') {
    $conditions[] = 'fuel_type = ?';
    $params[] = $fuel_type;
    $types .= 's';
}
if ($mileage !== '') {
    $conditions[] = 'mileage <= ?';
    $params[] = (int) $mileage;
    $types .= 'i';
}

$hiddenColCheck = $conn->query("SHOW COLUMNS FROM cars LIKE 'is_hidden'");
if ($hiddenColCheck && $hiddenColCheck->num_rows > 0) {
    $conditions[] = '(is_hidden = 0 OR is_hidden IS NULL)';
}

switch ($sort) {
    case 'price_desc':
        $order = 'ORDER BY price DESC';
        break;
    case 'price_asc':
        $order = 'ORDER BY price ASC';
        break;
    default:
        $order = 'ORDER BY car_id DESC';
        $sort = 'newest';
        break;
}

$sql = 'SELECT * FROM cars';
if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}
$sql .= ' ' . $order;

$stmt = $conn->prepare($sql);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$total = count($cars);
$stmt->close();

require_once __DIR__ . '/../views/search.view.php';
