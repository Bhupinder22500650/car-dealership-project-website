<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Messages – COSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/script.js" defer></script>
    <style>
        .messages-container {
            max-width: 800px;
            margin: 4rem auto;
            padding: 2rem;
            background: #111111;
            border: 1px solid #333333;
            min-height: 50vh;
        }

        .messages__title {
            text-align: center;
            color: #ffffff;
            margin-bottom: 2rem;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .message-card {
            background-color: #1a1a1a;
            border-left: 4px solid #444444;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .message-card.unread {
            border-left-color: #e11a22; /* Acura Red for unread/important */
        }
        
        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 1px solid #333;
            padding-bottom: 0.5rem;
        }

        .message-car {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
        }

        .message-date {
            font-size: 0.85rem;
            color: #888888;
        }

        .message-body {
            color: #cccccc;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .message-footer {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #aaaaaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .message-footer strong {
            color: #ffffff;
        }

        .empty-state {
            text-align: center;
            color: #888888;
            padding: 3rem;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 1px dashed #333;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <main class="messages-container reveal-3d">
        <h2 class="messages__title">Your Messages</h2>

        <?php if (empty($messages)): ?>
            <div class="empty-state">
                You have no messages yet.
            </div>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <?php 
                    $sender_name = htmlspecialchars(($msg['sender_first'] && $msg['sender_last']) ? ($msg['sender_first'].' '.$msg['sender_last']) : 'Unknown Sender');
                    $receiver_name = htmlspecialchars(($msg['receiver_first'] && $msg['receiver_last']) ? ($msg['receiver_first'].' '.$msg['receiver_last']) : 'Unknown Receiver');
                    
                    $is_my_message = ($msg['sender_id'] == $user_id);
                    // Determine style for unread messages that I received
                    $is_unread_for_me = ($msg['is_read'] == 0 && $msg['receiver_id'] == $user_id);
                ?>
                <div class="message-card <?= $is_unread_for_me ? 'unread' : '' ?>">
                    <div class="message-header">
                        <span class="message-car">
                            <?php if ($is_my_message): ?>
                                <span style="color: #aaa; margin-right: 8px;">[Sent]</span> 
                            <?php else: ?>
                                <span style="color: #e11a22; margin-right: 8px;">[Received]</span> 
                            <?php endif; ?>
                            🚙 <?= htmlspecialchars($msg['company_name'] . ' ' . $msg['car_model']) ?>
                        </span>
                        <span class="message-date"><?= date('M j, Y g:i A', strtotime($msg['message_date'])) ?></span>
                    </div>
                    
                    <div class="message-body">
                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                    </div>

                    <div class="message-footer">
                        <span>From: <strong><?= $is_my_message ? 'You' : $sender_name ?></strong></span>
                        <span>To: <strong><?= !$is_my_message ? 'You' : $receiver_name ?></strong></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
