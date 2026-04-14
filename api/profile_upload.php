<?php
session_start();
require_once dirname(__DIR__) . '/config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Please login to upload your profile photo.']);
    exit;
}
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request token.']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    if (!isset($_FILES['profile_photo'])) {
        throw new RuntimeException('No file uploaded.');
    }

    $file = $_FILES['profile_photo'];

    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK: break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE: throw new RuntimeException('Exceeded filesize limit.');
        case UPLOAD_ERR_NO_FILE: throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_NO_TMP_DIR: throw new RuntimeException('Missing a temporary folder.');
        case UPLOAD_ERR_CANT_WRITE: throw new RuntimeException('Failed to write file to disk.');
        case UPLOAD_ERR_EXTENSION: throw new RuntimeException('A PHP extension stopped the file upload.');
        default: throw new RuntimeException('Unknown upload error.');
    }

    if ($file['size'] > 10485760) { // 10MB limit
        throw new RuntimeException('File too large. Maximum size is 10MB.');
    }

    // Restrict uploads to safe raster formats only
    $mime_type = mime_content_type($file['tmp_name']);
    $allowed_mimes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
        'image/avif' => 'avif'
    ];

    if ($mime_type === false || !array_key_exists($mime_type, $allowed_mimes)) {
        throw new RuntimeException('Invalid file format.');
    }
    $ext = $allowed_mimes[$mime_type];

    // Generate unique name
    $new_filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);
    $upload_dir = dirname(__DIR__) . '/assets/img/profiles/';
    $destination = $upload_dir . $new_filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    // Update DB
    $db_path = 'assets/img/profiles/' . $new_filename;
    $stmt = $conn->prepare('UPDATE users SET profile_photo = ? WHERE user_id = ?');
    $stmt->bind_param('si', $db_path, $user_id);
    if (!$stmt->execute()) {
        throw new RuntimeException('Failed to update database.');
    }
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Profile photo updated successfully',
        'url' => $db_path
    ]);

} catch (RuntimeException $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
