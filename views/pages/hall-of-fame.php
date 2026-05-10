<?php
// views/pages/hall-of-fame.php

// 1. Establish Database Connection & Query Achievements
require_once dirname(__DIR__, 2) . '/config/database.php';
$db = Database::getConnection();

// Fetch achievements sorted by year DESC
$stmt = $db->query("SELECT * FROM achievements ORDER BY year DESC, id DESC");
$achievements = $stmt->fetchAll();

// Include layouts header
require_once dirname(__DIR__) . '/layouts/header.php';
?>

<!-- Ambient Glow Spheres for Cinematic Lighting -->
<div class="absolute top-0 left-0 w-full h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[10%] left-[20%] w-[600px] h-[600px] bg-brandRed/5 rounded-full filter blur-[150px] opacity-70"></div>
    <div class="absolute top-[40%] right-[10%] w-[450px] h-[450px] bg-brandGreen/5 rounded-full filter blur-[120px] opacity-60"></div>
</div>

<!-- ==========================================
     HERO: THE ARENA DECORATION
     ========================================== -->
<section class="relative z-10 pt-20 pb-16 text-center px-6 max-w-4xl mx-auto">
    <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Chamber Laurels</span>
    <h1 class="font-serif text-5xl md:text-7xl font-bold tracking-tight text-white mb-6 leading-none">
        Hall of <span class="italic font-light text-brandRed font-serif">Fame</span>
    </h1>
    <p class="text-sm md:text-base font-light text-gray-400 max-w-2xl mx-auto leading-relaxed tracking-wider">
        The digital hall of intellectual giants. Celebrating the triumphs, championships, and speaking legends who carried the logic of KUET to the highest national podiums.
    </p>
</section>

<!-- ==========================================
     TROPHY GRID (DYNAMIC ACHIEVEMENTS)
     ========================================== -->
<section class="py-12 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    
    <!-- Year Categories Grouping -->
    <?php if (!empty($achievements)): ?>
        <?php 
        // Group achievements by year
        $grouped = [];
        foreach ($achievements as $ach) {
            $grouped[$ach['year']][] = $ach;
        }
        ?>
        
        <?php foreach ($grouped as $year => $year_achievements): ?>
            <!-- Year Container -->
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-10">
                    <span class="font-serif text-3xl font-bold text-white tracking-tight"><?= e($year) ?></span>
                    <span class="text-xs font-sans tracking-widest text-brandRed font-semibold uppercase">Podiums Secured</span>
                    <div class="flex-grow h-[1px] bg-white/5"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($year_achievements as $ach): ?>
                        
                        <!-- Spotlight Trophy Card -->
                        <div class="spotlight-card glass-panel glass-panel-hover p-8 rounded flex flex-col justify-between min-h-[350px] transition-all duration-300 group">
                            
                            <div>
                                <!-- Award Title -->
                                <div class="flex items-center justify-between mb-6">
                                    <span class="px-3 py-1 bg-brandRed/10 border border-brandRed/20 rounded text-[9px] uppercase tracking-wider text-brandRed font-semibold">
                                        <?= e($ach['title']) ?>
                                    </span>
                                    
                                    <!-- Dynamic Trophy SVG Icon -->
                                    <svg class="w-5 h-5 text-gray-600 group-hover:text-brandRed transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15V17M12 17V19M12 17H15M12 17H9M18.75 6.75H19.5a2.25 2.25 0 012.25 2.25v3a2.25 2.25 0 01-2.25 2.25h-.75M5.25 6.75H4.5A2.25 2.25 0 002.25 9v3a2.25 2.25 0 002.25 2.25h.75m10.5-6v11.25m-6-11.25v11.25M3.75 6.75h16.5M9.75 22h4.5" />
                                    </svg>
                                </div>

                                <h3 class="font-serif text-xl font-bold text-white mb-3 group-hover:text-brandRed transition-colors duration-200">
                                    <?= e($ach['competition']) ?>
                                </h3>

                                <p class="text-xs font-light text-gray-400 leading-relaxed mb-6">
                                    <?= e($ach['description']) ?>
                                </p>
                            </div>

                            <div>
                                <div class="border-t border-white/5 pt-4">
                                    <span class="text-[9px] uppercase tracking-wider text-gray-500 block mb-1">DEBATING SQUAD</span>
                                    <span class="text-xs font-semibold text-gray-300 font-sans">
                                        <?= e($ach['team_members']) ?>
                                    </span>
                                </div>
                            </div>

                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-500 font-light italic text-center py-12">No achievements found in the Hall of Fame archive.</p>
    <?php endif; ?>

</section>

<!-- ==========================================
     LEGENDARY ALUMNI MOTIVATIONAL BOX
     ========================================== -->
<section class="py-20 relative z-10 border-t border-white/5 bg-gradient-to-t from-darkGrey/40 to-brandBlack text-center">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-white mb-6">Are You Ready to Write History?</h2>
        <p class="text-xs font-light text-gray-400 leading-relaxed mb-8 max-w-lg mx-auto">
            Our Hall of Fame continues to grow. Every practice session, every debate motion, and every local debate tournament is a stepping stone to global arenas.
        </p>
        <a href="<?= $base_path ?>/recruitment" class="px-8 py-3.5 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-md inline-block">
            Apply for Next Intake
        </a>
    </div>
</section>

<!-- GSAP ScrollTrigger script -->
<script>
    gsap.registerPlugin(ScrollTrigger);

    // Timeline node fade reveals
    const trophyCards = document.querySelectorAll('.spotlight-card');
    trophyCards.forEach(card => {
        gsap.fromTo(card, 
            { opacity: 0, y: 30 },
            { 
                scrollTrigger: {
                    trigger: card,
                    start: 'top 93%',
                    toggleActions: 'play none none none'
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out'
            }
        );
    });
</script>

<?php
// Include layouts footer
require_once dirname(__DIR__) . '/layouts/footer.php';
?>