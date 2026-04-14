<?php
// --------------------------------------------------------------------------
// Global Error Handling (Production Ready)
// --------------------------------------------------------------------------
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error_log.txt');

// --------------------------------------------------------------------------
// Database Connection
// --------------------------------------------------------------------------
mysqli_report(MYSQLI_REPORT_OFF);

// Primary credentials from environment; fallback to current InfinityFree values.
$dbUser = getenv('DB_USER') ?: 'if0_41538800';
$dbPass = getenv('DB_PASS');
$dbName = getenv('DB_NAME') ?: 'if0_41538800_coss';
$dbHostFromEnv = getenv('DB_HOST');

if ($dbPass === false) {
    $dbPass = 'eijblXG0bJg';
}

// InfinityFree can expose host aliases; try env host first, then common fallbacks.
$candidateHosts = [];
if (!empty($dbHostFromEnv)) {
    $candidateHosts[] = $dbHostFromEnv;
}
$candidateHosts[] = 'sql112.infinityfree.com';
$candidateHosts[] = 'sql112.byetcluster.com';
$candidateHosts[] = 'localhost';
$candidateHosts = array_values(array_unique($candidateHosts));

$conn = null;
$lastError = '';

foreach ($candidateHosts as $candidateHost) {
    $tryConn = @new mysqli($candidateHost, $dbUser, $dbPass, $dbName);
    if (!$tryConn->connect_error) {
        $conn = $tryConn;
        break;
    }
    $lastError = $candidateHost . ' => ' . $tryConn->connect_error;
    $tryConn->close();
}

if (!$conn) {
    error_log('Database connection failed. Last attempt: ' . $lastError);
    die('A database error occurred. Please try again later.');
}

$conn->set_charset('utf8mb4');
?>
