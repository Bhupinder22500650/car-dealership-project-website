<?php
// --------------------------------------------------------------------------
// Threaded messaging controller
// --------------------------------------------------------------------------

session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/create_tables.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$user_type = $_SESSION['user_type'] ?? 'buyer';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['message'], $_POST['receiver_id'], $_POST['car_id'])
) {
    $msg_text = trim($_POST['message']);
    $recv_id = (int) $_POST['receiver_id'];
    $car_id = (int) $_POST['car_id'];

    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        if ($msg_text !== '' && $recv_id > 0 && $car_id > 0) {
            $insert = $conn->prepare(
                'INSERT INTO messages (sender_id, receiver_id, car_id, message) VALUES (?, ?, ?, ?)'
            );
            $insert->bind_param('iiis', $user_id, $recv_id, $car_id, $msg_text);
            $insert->execute();
            $insert->close();

            header('Location: messages.php?thread=' . $car_id . '_' . $recv_id);
            exit;
        }
    }
}

$hasProfilePhoto = false;
$profilePhotoCol = $conn->query("SHOW COLUMNS FROM users LIKE 'profile_photo'");
if ($profilePhotoCol && $profilePhotoCol->num_rows > 0) {
    $hasProfilePhoto = true;
}
$senderPhotoSelect = $hasProfilePhoto ? 'sender.profile_photo AS sender_photo' : 'NULL AS sender_photo';
$receiverPhotoSelect = $hasProfilePhoto ? 'receiver.profile_photo AS receiver_photo' : 'NULL AS receiver_photo';

$sql = "
    SELECT
        m.message_id,
        m.message,
        m.message_date,
        m.is_read,
        m.sender_id,
        m.receiver_id,
        c.company_name,
        c.car_model,
        c.car_id,
        sender.First_name AS sender_first,
        sender.Last_name AS sender_last,
        {$senderPhotoSelect},
        receiver.First_name AS receiver_first,
        receiver.Last_name AS receiver_last,
        {$receiverPhotoSelect}
    FROM messages m
    JOIN cars c ON m.car_id = c.car_id
    JOIN users sender ON m.sender_id = sender.user_id
    JOIN users receiver ON m.receiver_id = receiver.user_id
    WHERE m.sender_id = ? OR m.receiver_id = ?
    ORDER BY m.message_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $user_id);
$stmt->execute();
$all_messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$threads = [];
foreach ($all_messages as $msg) {
    $is_mine = ((int) $msg['sender_id'] === $user_id);
    $other_id = $is_mine ? (int) $msg['receiver_id'] : (int) $msg['sender_id'];
    $other_name = $is_mine
        ? trim(($msg['receiver_first'] ?? '') . ' ' . ($msg['receiver_last'] ?? ''))
        : trim(($msg['sender_first'] ?? '') . ' ' . ($msg['sender_last'] ?? ''));
    $other_photo = $is_mine ? ($msg['receiver_photo'] ?? null) : ($msg['sender_photo'] ?? null);

    $thread_key = (int) $msg['car_id'] . '_' . $other_id;
    if (!isset($threads[$thread_key])) {
        $threads[$thread_key] = [
            'key' => $thread_key,
            'car_id' => (int) $msg['car_id'],
            'other_id' => $other_id,
            'other_name' => $other_name !== '' ? $other_name : 'Unknown',
            'other_photo' => $other_photo,
            'car_name' => trim(($msg['company_name'] ?? '') . ' ' . ($msg['car_model'] ?? '')),
            'unread' => 0,
            'messages' => [],
        ];
    }

    if (!$is_mine && (int) $msg['is_read'] === 0) {
        $threads[$thread_key]['unread']++;
    }

    $threads[$thread_key]['messages'][] = $msg;
}

$active_thread_key = $_GET['thread'] ?? null;
if (!$active_thread_key || !isset($threads[$active_thread_key])) {
    $active_thread_key = !empty($threads) ? array_key_first($threads) : null;
}
$active_thread = $active_thread_key ? $threads[$active_thread_key] : null;

if ($active_thread && $active_thread['unread'] > 0) {
    $mark = $conn->prepare(
        'UPDATE messages SET is_read = 1
         WHERE car_id = ? AND sender_id = ? AND receiver_id = ? AND is_read = 0'
    );
    $mark->bind_param(
        'iii',
        $active_thread['car_id'],
        $active_thread['other_id'],
        $user_id
    );
    $mark->execute();
    $mark->close();
    $threads[$active_thread_key]['unread'] = 0;
}

require_once __DIR__ . '/../views/messages.view.php';
