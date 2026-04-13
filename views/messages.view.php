<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages | COSS</title>
    <meta name="description" content="View and manage your automotive conversations on COSS.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/stitch_head.php'; ?>
    <style>
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e3e2e2; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-[#d8e2ff]">

<?php include 'includes/navbar.php'; ?>

<main class="pt-24 min-h-screen">

    <?php if (empty($threads)): ?>
    <div class="flex flex-col items-center justify-center py-32 px-6 text-center">
        <span class="material-symbols-outlined text-6xl text-[#c2c6d5] mb-8" style="font-variation-settings:'FILL' 0,'wght' 100,'GRAD' 0,'opsz' 48;">chat_bubble</span>
        <h1 class="text-3xl font-extralight tracking-tight uppercase text-on-surface mb-4">No Messages Yet</h1>
        <p class="text-[#424753] font-light text-xs tracking-[0.15em] uppercase max-w-xs mb-12">Start a conversation by viewing a car listing and sending the seller a message.</p>
        <a href="search.php" class="bg-[#1b1c1c] text-white px-10 py-4 text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-colors">
            BROWSE LISTINGS
        </a>
    </div>

    <?php else: ?>
    <!-- Messages Layout -->
    <div class="flex h-[calc(100vh-96px)] overflow-hidden">

        <!-- Left Panel: Conversation List -->
        <aside class="w-full md:w-[380px] flex-shrink-0 bg-[#f4f3f3] border-r border-[#c2c6d5]/10 overflow-y-auto z-10">
            <div class="p-8 border-b border-[#c2c6d5]/10 flex justify-between items-center bg-[#f4f3f3]/80 backdrop-blur-md sticky top-0 z-10">
                <h1 class="text-xs font-light tracking-[0.2em] uppercase">Conversations</h1>
                <span class="material-symbols-outlined cursor-pointer hover:text-[#0051ae] transition-colors">edit_square</span>
            </div>

            <div class="divide-y divide-[#c2c6d5]/5">
                <?php foreach ($threads as $t):
                    $latest_msg = $t['messages'][0];
                    $is_latest_mine = ($latest_msg['sender_id'] == $user_id);
                    $date_str = date('g:i A', strtotime($latest_msg['message_date']));
                    $active = ($t['key'] === $active_thread_key) ? 'bg-white' : 'hover:bg-white/60';
                ?>
                <a href="messages.php?thread=<?= $t['key'] ?>" class="block p-6 <?= $active ?> flex gap-4 transition-all relative group">
                    <div class="w-12 h-12 flex-shrink-0 bg-[#e3e2e2] flex items-center justify-center overflow-hidden z-20">
                        <?php if ($t['other_photo'] && $t['other_photo'] !== 'assets/img/default-avatar.png'): ?>
                            <img src="<?= htmlspecialchars($t['other_photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-[#424753]">account_circle</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0 z-20">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-<?= ($t['unread']>0) ? 'semibold' : 'light' ?> tracking-wide uppercase truncate"><?= htmlspecialchars($t['other_name']) ?></span>
                            <span class="text-[10px] font-light text-[#424753]/60 uppercase ml-2 flex-shrink-0"><?= $date_str ?></span>
                        </div>
                        <div class="text-[10px] text-[#0051ae] tracking-widest uppercase mb-1 font-medium truncate"><?= htmlspecialchars($t['car_name']) ?></div>
                        <p class="text-xs text-[#424753]/70 truncate font-light leading-relaxed <?= ($t['unread']>0) ? 'text-[#1c69d4] font-semibold' : '' ?>">
                            <?= $is_latest_mine ? 'You: ' : '' ?><?= htmlspecialchars($latest_msg['message']) ?>
                        </p>
                    </div>
                    <?php if ($t['unread'] > 0): ?>
                    <div class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-[#1c69d4] rounded-full z-20"></div>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </aside>

        <!-- Right Panel: Message Thread -->
        <section class="hidden md:flex flex-1 flex-col bg-surface overflow-hidden relative">
            <?php if ($active_thread): ?>
            <!-- Thread Header -->
            <header class="p-8 border-b border-[#c2c6d5]/10 flex items-center justify-between bg-white/80 backdrop-blur-md z-10">
                <a href="profile.php?id=<?= $active_thread['other_id'] ?>" class="flex items-center gap-6 group z-20 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-[#e3e2e2] flex items-center justify-center overflow-hidden">
                        <?php if ($active_thread['other_photo'] && $active_thread['other_photo'] !== 'assets/img/default-avatar.png'): ?>
                            <img src="<?= htmlspecialchars($active_thread['other_photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-[#424753]">account_circle</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold tracking-wide uppercase group-hover:text-[#0051ae] transition-colors"><?= htmlspecialchars($active_thread['other_name']) ?></h2>
                        <div class="text-[9px] tracking-[0.2em] uppercase text-[#424753]/60 mt-1">View Profile</div>
                    </div>
                </a>
                <a href="car-details.php?id=<?= $active_thread['car_id'] ?>" class="bg-[#e3e2e2] hover:bg-[#c2c6d5] transition-colors px-4 py-1.5 flex items-center gap-3 cursor-pointer z-20">
                    <span class="text-[9px] font-medium tracking-[0.15em] uppercase text-on-surface">
                        <?= htmlspecialchars($active_thread['car_name']) ?>
                    </span>
                    <span class="material-symbols-outlined" style="font-size:14px;">arrow_forward_ios</span>
                </a>
            </header>

            <!-- Message Area -->
            <div id="message-area" class="flex-1 overflow-y-auto p-8 md:p-12 space-y-8 flex flex-col-reverse">
                <?php foreach ($active_thread['messages'] as $msg):
                    $is_sent = ($msg['sender_id'] == $user_id);
                    $time = date('g:i A M j', strtotime($msg['message_date']));
                ?>
                <?php if ($is_sent): ?>
                <!-- Sent -->
                <div class="flex justify-end">
                    <div class="max-w-[70%] bg-[#1b1c1c] p-6">
                        <p class="text-sm font-light text-white leading-relaxed"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                        <div class="mt-2 text-[9px] font-light text-white/50 uppercase"><?= $time ?></div>
                    </div>
                </div>
                <?php else: ?>
                <!-- Received -->
                <div class="flex items-end gap-4 max-w-[70%]">
                    <a href="profile.php?id=<?= $active_thread['other_id'] ?>" class="w-8 h-8 flex-shrink-0 bg-[#e3e2e2] flex items-center justify-center mb-1 overflow-hidden hover:opacity-80 transition-opacity">
                        <?php if ($active_thread['other_photo'] && $active_thread['other_photo'] !== 'assets/img/default-avatar.png'): ?>
                            <img src="<?= htmlspecialchars($active_thread['other_photo']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-sm text-[#424753]">person</span>
                        <?php endif; ?>
                    </a>
                    <div class="bg-[#efeded] p-6">
                        <p class="text-sm font-light leading-relaxed"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                        <div class="mt-2 text-[9px] font-light text-[#424753]/50 uppercase"><?= $time ?></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Message Input Form -->
            <footer class="p-6 md:p-8 bg-white border-t border-[#c2c6d5]/10">
                <form action="messages.php" method="POST" class="flex items-center gap-6">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"/>
                    <input type="hidden" name="receiver_id" value="<?= $active_thread['other_id'] ?>"/>
                    <input type="hidden" name="car_id" value="<?= $active_thread['car_id'] ?>"/>
                    <div class="flex-1 relative">
                        <input name="message" required id="messageField" autocomplete="off" class="w-full bg-transparent border-0 border-b border-[#c2c6d5]/70 py-2 focus:ring-0 focus:border-[#0051ae] focus:outline-none text-xs font-light tracking-[0.05em] uppercase placeholder:text-[#424753]/40"
                               placeholder="WRITE YOUR REPLY..." type="text"/>
                    </div>
                    <button type="submit" class="px-8 py-3 bg-[#1b1c1c] text-white text-[10px] font-semibold tracking-[0.2em] uppercase hover:bg-[#0051ae] transition-all">
                        SEND
                    </button>
                </form>
            </footer>
            <?php endif; ?>
        </section>
    </div>
    <?php endif; ?>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("messageField");
        if(input) input.focus();
        
        // Scroll to bottom
        const messageArea = document.getElementById("message-area");
        if(messageArea) {
            messageArea.scrollTop = messageArea.scrollHeight;
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
