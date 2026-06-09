<?php

require_once dirname(__DIR__) . '/layouts/header.php';
?>

<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[20%] left-[10%] w-[450px] h-[450px] bg-brandRed/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 11s;"></div>
    <div class="absolute top-[40%] right-[10%] w-[450px] h-[450px] bg-brandGreen/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 16s;"></div>
</div>

<div class="relative z-10 max-w-4xl mx-auto px-6 md:px-12 py-12">
    
    
    <div class="text-center mb-16 max-w-2xl mx-auto">
        <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Recruitment Registry</span>
        <h1 class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-white mb-6 leading-tight">
            Join the Arena
        </h1>
        <p class="text-sm md:text-base font-light text-gray-400 leading-relaxed tracking-wider">
            Become a part of the premier intellectual society at KUET. Challenge your cognitive boundaries, sharpen your articulation, and learn to voice logic.
        </p>
    </div>

    
    <div class="glass-panel p-8 md:p-12 rounded relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(237,28,36,0.03),transparent_50%)] pointer-events-none"></div>
        
        <h2 class="font-serif text-2xl font-bold text-white mb-6 border-b border-white/5 pb-4">
            Candidate Application Form
        </h2>

        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mb-8 p-4 bg-brandGreen/10 border border-brandGreen/30 text-white rounded text-xs animate-fade-in">
                <?= e($_SESSION['success_message']) ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="mb-8 p-4 bg-brandRed/10 border border-brandRed/30 text-white rounded text-xs animate-fade-in">
                <?= e($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form action="<?= $base_path ?>/recruitment" method="POST" class="space-y-8">
            
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="flex flex-col">
                    <label for="name" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Full Name *</label>
                    <input type="text" id="name" name="name" required placeholder="e.g. Adnan Rahman" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                </div>

                
                <div class="flex flex-col">
                    <label for="email" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Email Address *</label>
                    <input type="email" id="email" name="email" required placeholder="e.g. name@student.kuet.ac.bd" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                </div>

                
                <div class="flex flex-col">
                    <label for="phone" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Phone Number *</label>
                    <input type="text" id="phone" name="phone" required placeholder="e.g. 017XXXXXXXX" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                </div>

                
                <div class="flex flex-col">
                    <label for="roll_no" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Student Roll No *</label>
                    <input type="text" id="roll_no" name="roll_no" required placeholder="e.g. 2007001" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                </div>

                
                <div class="flex flex-col">
                    <label for="department" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Department *</label>
                    <input type="text" id="department" name="department" required placeholder="e.g. CSE, EEE, ME" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                </div>

                
                <div class="flex flex-col">
                    <label for="academic_year" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Academic Year *</label>
                    <select id="academic_year" name="academic_year" required class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white transition-all duration-300">
                        <option value="" disabled selected class="bg-darkGrey text-gray-600">Select Year</option>
                        <option value="1st Year" class="bg-darkGrey text-white">1st Year</option>
                        <option value="2nd Year" class="bg-darkGrey text-white">2nd Year</option>
                        <option value="3rd Year" class="bg-darkGrey text-white">3rd Year</option>
                        <option value="4th Year" class="bg-darkGrey text-white">4th Year</option>
                    </select>
                </div>
            </div>

            
            <div class="flex flex-col">
                <label for="debating_experience" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Prior Debating / Speaking Experience (Optional)</label>
                <textarea id="debating_experience" name="debating_experience" rows="3" placeholder="Briefly detail any school/college debate experience or public speaking engagements..." class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300"></textarea>
            </div>

            
            <div class="flex flex-col">
                <label for="motivation" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Why do you want to join KDS? *</label>
                <textarea id="motivation" name="motivation" required rows="5" placeholder="Detail your motivation, goals, and what you hope to contribute to the society..." class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300"></textarea>
            </div>

            
            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/25">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>