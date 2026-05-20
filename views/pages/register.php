<?php
// views/pages/register.php
require_once dirname(__DIR__) . '/layouts/header.php';
?>

<!-- Ambient Glow Spheres for Cinematic Lighting -->
<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[10%] left-[20%] w-[400px] h-[400px] bg-brandGreen/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 9s;"></div>
    <div class="absolute top-[20%] right-[25%] w-[400px] h-[400px] bg-brandRed/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 11s;"></div>
</div>

<div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-16 flex items-center justify-center min-h-[70vh]">
    
    <div class="w-full max-w-md glass-panel p-8 md:p-10 rounded-lg relative overflow-hidden spotlight-card">
        
        <!-- Logo and Slogan -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 border border-white/10 flex items-center justify-center overflow-hidden bg-black rounded-full mx-auto mb-4 shadow-lg shadow-brandGreen/20 transition-all duration-300 hover:scale-105 hover:border-brandGreen/50">
                <img src="<?= $base_path ?>/assets/images/logo.jpg" alt="KDS Logo" class="w-full h-full object-cover">
            </div>
            <span class="text-[9px] uppercase tracking-[0.25em] text-brandGreen font-semibold block mb-1">Society Membership Registry</span>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-white mb-2">Create Account</h2>
            <p class="text-xs text-gray-400 font-light leading-relaxed">
                Register as a society member to access resources and profiles.
            </p>
        </div>

        <!-- Flash Messages -->
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

        <!-- Form -->
        <form action="<?= $base_path ?>/register" method="POST" class="space-y-5 relative z-10">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            <!-- Full Name -->
            <div class="flex flex-col">
                <label for="name" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Full Name *</label>
                <input type="text" id="name" name="name" required 
                       value="<?= isset($_SESSION['old_name']) ? e($_SESSION['old_name']) : '' ?>" 
                       placeholder="e.g. John Doe" 
                       class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandGreen focus:outline-none focus:ring-1 focus:ring-brandGreen text-sm text-white placeholder-gray-600 transition-all duration-300">
                <?php unset($_SESSION['old_name']); ?>
            </div>

            <!-- Email -->
            <div class="flex flex-col">
                <label for="email" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Email Address *</label>
                <input type="email" id="email" name="email" required 
                       value="<?= isset($_SESSION['old_email']) ? e($_SESSION['old_email']) : '' ?>" 
                       placeholder="e.g. name@student.kuet.ac.bd" 
                       class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandGreen focus:outline-none focus:ring-1 focus:ring-brandGreen text-sm text-white placeholder-gray-600 transition-all duration-300">
                <?php unset($_SESSION['old_email']); ?>
            </div>

            <!-- Password -->
            <div class="flex flex-col">
                <label for="password" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Password * (Min 6 chars)</label>
                <input type="password" id="password" name="password" required 
                       placeholder="••••••••" 
                       class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandGreen focus:outline-none focus:ring-1 focus:ring-brandGreen text-sm text-white placeholder-gray-600 transition-all duration-300">
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col">
                <label for="password_confirm" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Confirm Password *</label>
                <input type="password" id="password_confirm" name="password_confirm" required 
                       placeholder="••••••••" 
                       class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandGreen focus:outline-none focus:ring-1 focus:ring-brandGreen text-sm text-white placeholder-gray-600 transition-all duration-300">
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-4 bg-brandGreen hover:bg-brandGreen/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandGreen/20">
                    Register Account
                </button>
            </div>
        </form>

        <div class="h-[1px] w-full bg-white/5 my-6"></div>

        <!-- Login CTA -->
        <p class="text-xs text-center text-gray-400 font-light">
            Already have a portal account? 
            <a href="<?= $base_path ?>/login" class="text-white hover:text-brandGreen font-semibold transition-colors duration-300 ml-1">Login Here</a>
        </p>

    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>