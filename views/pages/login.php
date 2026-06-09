<?php

require_once dirname(__DIR__) . '/layouts/header.php';
?>

<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[10%] left-[25%] w-[400px] h-[400px] bg-brandRed/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 8s;"></div>
    <div class="absolute top-[20%] right-[20%] w-[400px] h-[400px] bg-brandGreen/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 12s;"></div>
</div>

<div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-16 flex items-center justify-center min-h-[70vh]">
    
    <div class="w-full max-w-md glass-panel p-8 md:p-10 rounded-lg relative overflow-hidden spotlight-card">
        
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 border border-white/10 flex items-center justify-center overflow-hidden bg-black rounded-full mx-auto mb-4 shadow-lg shadow-brandRed/20 transition-all duration-300 hover:scale-105 hover:border-brandRed/50">
                <img src="<?= $base_path ?>/assets/images/logo.jpg" alt="KDS Logo" class="w-full h-full object-cover">
            </div>
            <span class="text-[9px] uppercase tracking-[0.25em] text-brandRed font-semibold block mb-1">Chamber Access Portal</span>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-white mb-2">Portal Login</h2>
            <p class="text-xs text-gray-400 font-light leading-relaxed">
                Unlock the debating archives and administration desk.
            </p>
        </div>

        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mb-6 p-4 bg-brandGreen/10 border border-brandGreen/30 text-white rounded text-xs animate-fade-in">
                <?= e($_SESSION['success_message']) ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="mb-6 p-4 bg-brandRed/10 border border-brandRed/30 text-white rounded text-xs animate-fade-in">
                <?= e($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        
        <form action="<?= $base_path ?>/login" method="POST" class="space-y-6 relative z-10">
            
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            
            <div class="flex flex-col">
                <label for="email" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Email Address</label>
                <input type="email" id="email" name="email" required 
                       value="<?= isset($_SESSION['old_email']) ? e($_SESSION['old_email']) : '' ?>" 
                       placeholder="e.g. admin@kds.org" 
                       class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                <?php unset($_SESSION['old_email']); ?>
            </div>

            
            <div class="flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Password</label>
                </div>
                <input type="password" id="password" name="password" required 
                       placeholder="••••••••" 
                       class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
            </div>

            
            <div class="pt-2">
                <button type="submit" class="w-full py-4 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20">
                    Authorize & Enter
                </button>
            </div>
        </form>

        <div class="h-[1px] w-full bg-white/5 my-6"></div>

        
        <p class="text-xs text-center text-gray-400 font-light">
            Don't have a portal account? 
            <a href="<?= $base_path ?>/register" class="text-white hover:text-brandRed font-semibold transition-colors duration-300 ml-1">Register Here</a>
        </p>

    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>