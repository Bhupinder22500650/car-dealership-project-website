<?php $current_year = date("Y"); ?>
<!-- Footer - Stitch Design -->
<footer class="bg-[#262626] w-full border-0">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-8 md:px-16 py-16 md:py-20 w-full">
        <!-- Brand -->
        <div class="md:col-span-1 space-y-6">
            <div class="text-xl font-thin tracking-[0.2em] text-white uppercase">COSS</div>
            <p class="text-gray-400 font-light tracking-[0.05em] uppercase text-[10px] leading-loose max-w-xs">
                Defining the standard for premium automotive commerce in the South Pacific.
            </p>
        </div>
        <!-- Directory -->
        <div class="flex flex-col space-y-4">
            <h5 class="text-white font-bold tracking-[0.2em] text-[10px] mb-2">DIRECTORY</h5>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="index.php">MODELS</a>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="search.php">SEARCH</a>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="cars.php">SELL</a>
        </div>
        <!-- Account -->
        <div class="flex flex-col space-y-4">
            <h5 class="text-white font-bold tracking-[0.2em] text-[10px] mb-2">ACCOUNT</h5>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="login.php">LOGIN</a>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="registration.php">REGISTER</a>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="messages.php">MESSAGES</a>
            <a class="text-gray-400 hover:text-blue-400 transition-colors font-light tracking-[0.05em] uppercase text-[10px]" href="feedback.php">FEEDBACK</a>
        </div>
        <!-- Address -->
        <div class="md:col-span-1">
            <h5 class="text-white font-bold tracking-[0.2em] text-[10px] mb-6">OFFICES</h5>
            <p class="text-gray-400 font-light tracking-[0.05em] uppercase text-[10px] leading-relaxed">
                102 CUSTOMS STREET WEST<br>
                AUCKLAND CBD, 1010<br>
                NEW ZEALAND
            </p>
            <p class="mt-4 text-[10px] text-gray-500">
                <a href="mailto:support@coss.nz" class="hover:text-blue-400 transition-colors">support@coss.nz</a>
            </p>
        </div>
    </div>
    <div class="px-8 md:px-16 py-6 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-gray-500 font-light tracking-[0.05em] uppercase text-[10px]">© <?= $current_year ?> COSS AUTOMOTIVE. ALL RIGHTS RESERVED.</p>
        <div class="flex space-x-5 text-[10px] text-gray-500 font-light tracking-widest uppercase">
            <span>Privacy</span>
            <span>Terms</span>
            <span>Contact</span>
        </div>
    </div>
</footer>