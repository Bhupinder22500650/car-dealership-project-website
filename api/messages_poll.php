<?php
session_start();
require_once dirname(__DIR__) . '/config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$car_id = isset($_GET['car_id']) ? (int) $_GET['car_id'] : 0;
$other_id = isset($_GET['other_id']) ? (int) $_GET['other_id'] : 0;
$after_id = isset($_GET['after_id']) ? (int) $_GET['after_id'] : 0;

if ($car_id <= 0 || $other_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid thread']);
    exit;
}

$memberCheck = $conn->prepare(
    'SELECT 1
     FROM messages
     WHERE car_id = ?
       AND ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
     LIMIT 1'
);
$memberCheck->bind_param('iiiii', $car_id, $user_id, $other_id, $other_id, $user_id);
$memberCheck->execute();
$is_member = $memberCheck->get_result()->num_rows > 0;
$memberCheck->close();

if (!$is_member) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

$stmt = $conn->prepare(
    'SELECT message_id, sender_id, message, message_date
     FROM messages
     WHERE car_id = ?
       AND ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
       AND message_id > ?
     ORDER BY message_id ASC'
);
$stmt->bind_param('iiiiii', $car_id, $user_id, $other_id, $other_id, $user_id, $after_id);
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$messages = [];
$new_ids = [];
foreach ($rows as $row) {
    $message_id = (int) $row['message_id'];
    $is_mine = (int) $row['sender_id'] === $user_id;
    $messages[] = [
        'message_id' => $message_id,
        'is_mine' => $is_mine,
        'message' => $row['message'],
        'time' => date('g:i A M j', strtotime($row['message_date'])),
    ];
    if (!$is_mine) {
        $new_ids[] = $message_id;
    }
}

if (!empty($new_ids)) {
    $id_list = implode(',', array_map('intval', $new_ids));
    $conn->query("UPDATE messages SET is_read = 1 WHERE message_id IN ({$id_list})");
}

echo json_encode([
    'success' => true,
    'messages' => $messages,
]);
?>
