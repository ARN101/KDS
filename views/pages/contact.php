<?php

require_once dirname(__DIR__) . '/layouts/header.php';
?>


<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[20%] left-[20%] w-[450px] h-[450px] bg-brandRed/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 10s;"></div>
    <div class="absolute top-[30%] right-[5%] w-[450px] h-[450px] bg-brandGreen/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 14s;"></div>
</div>

<div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-12">
    
    
    <div class="text-center mb-16 max-w-2xl mx-auto">
        <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Chamber Communication</span>
        <h1 class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-white mb-6 leading-tight">
            Connect With KDS
        </h1>
        <p class="text-sm md:text-base font-light text-gray-400 leading-relaxed tracking-wider">
            Have questions about events, membership, or collaborations? Drop us a line and the Voice of Reason will respond.
        </p>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        
        <div class="lg:col-span-5 space-y-8 lg:sticky lg:top-32">
            <div class="glass-panel p-8 rounded relative overflow-hidden">
                <h2 class="font-serif text-2xl font-bold text-white mb-6">Contact Registry</h2>
                
                <div class="space-y-6 text-sm font-light text-gray-300">
                    
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-brandRed font-semibold block mb-1">HQ CHAMBERS</span>
                        <p class="leading-relaxed">
                            KUET Debating Society (KDS)<br>
                            Student Welfare Center (SWC), 2nd Floor<br>
                            Khulna University of Engineering & Technology<br>
                            Khulna-9203, Bangladesh
                        </p>
                    </div>

                    
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-brandGreen font-semibold block mb-1">GENERAL MAIL</span>
                        <a href="mailto:kds@kuet.ac.bd" class="hover:text-brandRed transition-colors duration-300 font-semibold font-sans">kds@kuet.ac.bd</a>
                    </div>

                    
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-brandRed font-semibold block mb-1">SESSION HOURS</span>
                        <p>Saturdays &mdash; 03:00 PM to 06:00 PM</p>
                    </div>
                </div>

                
                <div class="h-[1px] w-full bg-white/5 my-8"></div>

                
                <div>
                    <span class="text-[9px] uppercase tracking-widest text-gray-500 font-semibold block mb-3">FOLLOW OUR CHANNELS</span>
                    <div class="flex gap-4">
                        <a href="https://www.facebook.com/KUETDebatingSociety" target="_blank" class="px-4 py-2 border border-white/5 bg-white/5 hover:border-brandRed hover:bg-brandRed/10 text-white text-xs tracking-wider uppercase rounded transition-all duration-300">
                            Facebook
                        </a>
                        <a href="https://www.youtube.com/@kuetdebatingsociety2750" target="_blank" class="px-4 py-2 border border-white/5 bg-white/5 hover:border-brandRed hover:bg-brandRed/10 text-white text-xs tracking-wider uppercase rounded transition-all duration-300">
                            YouTube
                        </a>
                        <a href="https://www.linkedin.com/company/kuet-debating-society/" target="_blank" class="px-4 py-2 border border-white/5 bg-white/5 hover:border-brandRed hover:bg-brandRed/10 text-white text-xs tracking-wider uppercase rounded transition-all duration-300">
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="lg:col-span-7">
            <div class="glass-panel p-8 md:p-12 rounded">
                <h2 class="font-serif text-2xl font-bold text-white mb-6">Send Message</h2>

                
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

                <form action="<?= $base_path ?>/contact" method="POST" class="space-y-6">
                    
                    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

                    
                    <div class="flex flex-col">
                        <label for="name" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Your Name *</label>
                        <input type="text" id="name" name="name" required placeholder="e.g. John Doe" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                    </div>

                    
                    <div class="flex flex-col">
                        <label for="email" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Email Address *</label>
                        <input type="email" id="email" name="email" required placeholder="e.g. name@student.kuet.ac.bd" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                    </div>

                    
                    <div class="flex flex-col">
                        <label for="subject" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Subject *</label>
                        <input type="text" id="subject" name="subject" required placeholder="e.g. Inquiry about Intra debate championship" class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300">
                    </div>

                    
                    <div class="flex flex-col">
                        <label for="message" class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Your Message *</label>
                        <textarea id="message" name="message" required rows="5" placeholder="Write details of your message here..." class="px-4 py-3 bg-black/60 border border-white/10 rounded focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed text-sm text-white placeholder-gray-600 transition-all duration-300"></textarea>
                    </div>

                    
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20">
                            Deliver Message
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>