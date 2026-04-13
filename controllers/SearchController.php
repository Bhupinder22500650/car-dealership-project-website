<?php
// --------------------------------------------------------------------------
// search.php
// --------------------------------------------------------------------------

// 1. Initialize session (in case you need user context later)
// --------------------------------------------------------------------------
session_start();

// 2. Include database connection
// --------------------------------------------------------------------------
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/create_tables.php';

// 3. Collect and sanitize GET inputs
// --------------------------------------------------------------------------
$brand        = trim($_GET['brand'] ?? '');
$model        = trim($_GET['model'] ?? '');
$year         = trim($_GET['year']  ?? '');
$price        = trim($_GET['price'] ?? '');
$transmission = trim($_GET['transmission'] ?? '');
$fuel_type    = trim($_GET['fuel_type'] ?? '');
$mileage      = trim($_GET['mileage'] ?? '');

// 4. Build dynamic WHERE clause based on provided filters
// --------------------------------------------------------------------------
$conditions = [];
$params     = [];
$types      = '';

if ($brand !== '') {
    $conditions[] = "company_name LIKE ?";
    $params[]     = "%{$brand}%";
    $types       .= 's';
}

if ($model !== '') {
    $conditions[] = "car_model LIKE ?";
    $params[]     = "%{$model}%";
    $types       .= 's';
}
if ($year !== '') {
    $conditions[] = "car_year = ?";
    $params[]     = (int)$year;
    $types       .= 'i';
}
if ($price !== '') {
    $conditions[] = "price <= ?";
    $params[]     = (float)$price;
    $types       .= 'd';
}
if ($transmission !== '') {
    $conditions[] = "transmission = ?";
    $params[]     = $transmission;
    $types       .= 's';
}
if ($fuel_type !== '') {
    $conditions[] = "fuel_type = ?";
    $params[]     = $fuel_type;
    $types       .= 's';
}
if ($mileage !== '') {
    $conditions[] = "mileage <= ?";
    $params[]     = (int)$mileage;
    $types       .= 'i';
}

$sql = "SELECT * FROM cars";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// 5. Prepare and execute statement
// --------------------------------------------------------------------------
$stmt = $conn->prepare($sql);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// 6. Close DB handles
// --------------------------------------------------------------------------
$stmt->close();
// $conn->close();

require_once __DIR__ . '/../views/search.view.php';
