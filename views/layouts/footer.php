<?php
// views/layouts/footer.php
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = ($base_path === '/' || $base_path === '\\') ? '' : $base_path;
?>
    </main>

    <!-- Footer Section -->
    <footer class="relative z-10 bg-brandBlack border-t border-white/5 pt-16 pb-8 mt-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_center,rgba(0,104,55,0.04),transparent_60%)] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Col 1: Brand & Slogan -->
                <div class="md:col-span-2">
                    <h2 class="font-serif text-3xl font-bold tracking-tight text-white mb-4">
                        KUET <span class="text-brandRed">Debating</span> Society
                    </h2>
                    <p class="font-serif italic text-gray-400 text-sm mb-6 max-w-sm">
                        "The Voice of Reason"
                    </p>
                    <p class="font-sans font-light text-gray-500 text-xs leading-relaxed max-w-md">
                        KDS is the center of logical debate and rhetorical excellence at Khulna University of Engineering & Technology. We nurture speakers, analysts, and leaders of tomorrow.
                    </p>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h3 class="font-sans text-[11px] font-bold uppercase tracking-widest text-brandRed mb-4">
                        Quick Links
                    </h3>
                    <ul class="space-y-2 text-xs font-sans font-light text-gray-400">
                        <li><a href="<?= $base_path ?>/about" class="hover:text-white transition-colors duration-200">About KDS</a></li>
                        <li><a href="<?= $base_path ?>/events" class="hover:text-white transition-colors duration-200">Upcoming Events</a></li>
                        <li><a href="<?= $base_path ?>/hall-of-fame" class="hover:text-white transition-colors duration-200">Hall of Fame</a></li>
                        <li><a href="<?= $base_path ?>/resources" class="hover:text-white transition-colors duration-200">Motion Bank & Guides</a></li>
                        <li><a href="<?= $base_path ?>/recruitment" class="hover:text-white transition-colors duration-200">Join the Society</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact Info -->
                <div>
                    <h3 class="font-sans text-[11px] font-bold uppercase tracking-widest text-brandRed mb-4">
                        Chamber Address
                    </h3>
                    <p class="text-xs font-sans font-light text-gray-400 leading-relaxed mb-4">
                        KUET Debating Society (KDS)<br>
                        Student Welfare Center (SWC), 2nd Floor<br>
                        Khulna University of Engineering & Technology<br>
                        Khulna-9203, Bangladesh
                    </p>
                    <p class="text-xs font-sans font-light text-gray-400">
                        <span class="text-brandGreen font-semibold">Email:</span> kds@kuet.ac.bd
                    </p>
                </div>
            </div>

            <!-- Footer Divider -->
            <div class="h-[1px] w-full bg-white/5 mb-8"></div>

            <!-- Bottom Row: Social Icons & Copyright -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 font-sans">
                    &copy; <?= date('Y') ?> KUET Debating Society. All Rights Reserved.
                </p>
                
                <!-- Social Channels -->
                <div class="flex items-center gap-6">
                    <a href="https://facebook.com/kuetds" target="_blank" class="text-gray-400 hover:text-brandRed transition-colors duration-300">
                        <span class="text-xs uppercase tracking-widest font-semibold font-sans">Facebook</span>
                    </a>
                    <a href="https://youtube.com" target="_blank" class="text-gray-400 hover:text-brandRed transition-colors duration-300">
                        <span class="text-xs uppercase tracking-widest font-semibold font-sans">YouTube</span>
                    </a>
                    <a href="mailto:kds@kuet.ac.bd" class="text-gray-400 hover:text-brandRed transition-colors duration-300">
                        <span class="text-xs uppercase tracking-widest font-semibold font-sans">Contact Email</span>
                    </a>
                </div>
            </div>

        </div>
    </footer>

    <!-- Main Javascript Helper -->
    <script src="<?= $base_path ?>/assets/js/main.js"></script>
</body>
</html>
