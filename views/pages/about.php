<?php

require_once dirname(__DIR__, 2) . '/config/database.php';
$db = Database::getConnection();

$patrons_stmt = $db->query("SELECT * FROM members WHERE role_title LIKE '%Patron%' OR role_title LIKE '%Advisor%' ORDER BY id ASC");
$patrons = $patrons_stmt->fetchAll();

$execs_stmt = $db->query("SELECT * FROM members WHERE status = 'active' AND role_title NOT LIKE '%Patron%' AND role_title NOT LIKE '%Advisor%' ORDER BY id ASC");
$executive_committee = $execs_stmt->fetchAll();

$alumni_stmt = $db->query("SELECT * FROM members WHERE status = 'alumni' ORDER BY id ASC");
$alumni_board = $alumni_stmt->fetchAll();

$timeline_stmt = $db->query("SELECT * FROM achievements ORDER BY year DESC, id DESC");
$timeline_achievements = $timeline_stmt->fetchAll();

require_once dirname(__DIR__) . '/layouts/header.php';
?>

<div class="absolute top-0 left-0 w-full h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[10%] left-[10%] w-[600px] h-[600px] bg-brandRed/5 rounded-full filter blur-[150px] opacity-70"></div>
    <div class="absolute top-[40%] right-[5%] w-[400px] h-[400px] bg-brandGreen/5 rounded-full filter blur-[120px] opacity-60"></div>
</div>

<section class="relative z-10 pt-20 pb-16 text-center px-6 max-w-4xl mx-auto">
    <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Chamber Origins</span>
    <h1 class="font-serif text-5xl md:text-7xl font-bold tracking-tight text-white mb-6 leading-none">
        The Chronicles of <span class="italic font-light text-brandRed">Reason</span>
    </h1>
    <p class="text-sm md:text-base font-light text-gray-400 max-w-2xl mx-auto leading-relaxed tracking-wider">
        Founded on the principles of rational discourse, logical consistency, and public persuasion, the KUET Debating Society (KDS) has been the beacon of intellectual integrity at Khulna University of Engineering & Technology since its inception.
    </p>
</section>

<section class="py-12 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        
        <div class="glass-panel p-8 md:p-12 rounded relative overflow-hidden group hover:border-brandRed/20 transition-all duration-300">
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-brandRed/5 rounded-full filter blur-[40px]"></div>
            <h3 class="font-serif text-2xl font-bold text-white mb-4 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-brandRed block"></span> The Thesis (Mission)
            </h3>
            <p class="text-xs font-light text-gray-400 leading-relaxed tracking-wide">
                To equip the engineers and science scholars of KUET with analytical minds, sound logic, and the persuasive voice required to articulate complex truths. We foster an environment where disagreement is celebrated as a tool for progress, and logic remains the ultimate arbiter.
            </p>
        </div>

        
        <div class="glass-panel p-8 md:p-12 rounded relative overflow-hidden group hover:border-brandGreen/20 transition-all duration-300">
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-brandGreen/5 rounded-full filter blur-[40px]"></div>
            <h3 class="font-serif text-2xl font-bold text-white mb-4 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-brandGreen block"></span> The Synthesis (Vision)
            </h3>
            <p class="text-xs font-light text-gray-400 leading-relaxed tracking-wide">
                To establish KDS as a world-class debating society that consistently shapes regional and national discourse. We aim to breed generations of articulate leaders who utilize critical thinking to address global crises, legislative structures, and technological ethics.
            </p>
        </div>

    </div>
</section>

<section class="py-24 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    <div class="text-center mb-16">
        <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Leadership</span>
        <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-white">The Governing Board</h2>
    </div>

    
    <?php if (!empty($patrons)): ?>
    <div class="mb-16">
        <h3 class="text-xs uppercase tracking-widest text-gray-500 font-semibold mb-8 text-center">Patrons & Advisors</h3>
        <div class="flex flex-wrap justify-center gap-8">
            <?php foreach ($patrons as $p): ?>
                <div class="spotlight-card glass-panel glass-panel-hover p-8 rounded max-w-sm w-full transition-all duration-300 flex items-center gap-6">
                    <img src="<?= e($p['image_path']) ?>" alt="<?= e($p['name']) ?>" class="w-16 h-16 rounded-full object-cover border border-white/10 shadow-lg">
                    <div class="flex flex-col">
                        <span class="font-serif text-lg font-bold text-white leading-tight"><?= e($p['name']) ?></span>
                        <span class="text-[10px] uppercase tracking-wider text-brandRed font-semibold mt-1"><?= e($p['role_title']) ?></span>
                        <span class="text-[9px] text-gray-500 mt-2 font-mono"><?= e($p['email']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="mb-16">
        <h3 class="text-xs uppercase tracking-widest text-gray-500 font-semibold mb-8 text-center">Executive Committee</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($executive_committee)): ?>
                <?php foreach ($executive_committee as $ex): ?>
                    
                    <div class="spotlight-card glass-panel glass-panel-hover p-8 rounded flex flex-col justify-between min-h-[320px] transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <img src="<?= e($ex['image_path']) ?>" alt="<?= e($ex['name']) ?>" class="w-16 h-16 rounded-full object-cover border border-white/10 shadow-md">
                            <div>
                                <h4 class="font-serif text-lg font-bold text-white leading-tight group-hover:text-brandRed transition-colors duration-200"><?= e($ex['name']) ?></h4>
                                <span class="text-[10px] uppercase tracking-wider text-brandRed font-semibold block mt-1"><?= e($ex['role_title']) ?></span>
                                <span class="text-[9px] text-gray-500 font-mono block mt-1"><?= e($ex['email']) ?></span>
                            </div>
                        </div>
                        <p class="text-xs font-light text-gray-400 leading-relaxed mt-6 mb-6">
                            <?= e($ex['bio']) ?>
                        </p>
                        <div class="border-t border-white/5 pt-4 text-[9px] uppercase tracking-widest text-gray-500 font-mono">
                            Status: Active Representative
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 font-light italic col-span-3 text-center">No active executive members found in database.</p>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if (!empty($alumni_board)): ?>
    <div>
        <h3 class="text-xs uppercase tracking-widest text-gray-500 font-semibold mb-8 text-center">Alumni Board</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <?php foreach ($alumni_board as $a): ?>
                <div class="spotlight-card glass-panel glass-panel-hover p-6 rounded flex items-center gap-6 transition-all duration-300">
                    <img src="<?= e($a['image_path']) ?>" alt="<?= e($a['name']) ?>" class="w-14 h-14 rounded-full object-cover border border-white/10">
                    <div>
                        <h4 class="font-serif text-base font-bold text-white leading-tight"><?= e($a['name']) ?></h4>
                        <span class="text-[9px] uppercase tracking-wider text-brandGreen font-semibold block mt-0.5"><?= e($a['role_title']) ?></span>
                        <p class="text-[11px] text-gray-400 font-light mt-2 max-w-sm"><?= e($a['bio']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</section>

<section class="py-24 relative z-10 border-t border-white/5 bg-gradient-to-b from-brandBlack to-darkGrey/30">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="text-center mb-20">
            <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Timeline of Pride</span>
            <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-white">Championship History</h2>
            <p class="text-xs text-gray-500 font-light mt-3 max-w-md mx-auto leading-relaxed">
                A chronicled index of tournaments won, podium finishes, and debate speaker achievements secured on the national circuit.
            </p>
        </div>

        
        <div class="relative border-l border-white/5 pl-8 ml-4 space-y-16">
            <?php if (!empty($timeline_achievements)): ?>
                <?php foreach ($timeline_achievements as $index => $ach): ?>
                    <?php 
                    
                    $colorClass = ($index % 2 === 0) ? 'border-brandRed group-hover:bg-brandRed' : 'border-brandGreen group-hover:bg-brandGreen';
                    $textBadge = ($index % 2 === 0) ? 'text-brandRed' : 'text-brandGreen';
                    ?>
                    
                    <div class="relative group">
                        
                        
                        <div class="absolute -left-[38px] top-1.5 w-4.5 h-4.5 bg-brandBlack border-2 <?= $colorClass ?> rounded-full transition-all duration-300 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-brandBlack rounded-full"></div>
                        </div>

                        
                        <span class="text-xs font-mono font-bold <?= $textBadge ?> uppercase tracking-wider block mb-2">
                            Year <?= e($ach['year']) ?> &mdash; <?= e($ach['title']) ?>
                        </span>

                        
                        <div class="glass-panel p-6 rounded group-hover:border-white/10 transition-all duration-300">
                            <h3 class="font-serif text-xl font-bold text-white mb-2 leading-tight group-hover:text-brandRed transition-colors duration-200">
                                <?= e($ach['competition']) ?>
                            </h3>
                            <p class="text-xs text-gray-400 font-light leading-relaxed mb-4">
                                <?= e($ach['description']) ?>
                            </p>
                            <div class="flex items-center gap-2 text-[10px] uppercase tracking-wider text-gray-500 font-mono">
                                <span class="text-white/60">Champions:</span> <?= e($ach['team_members']) ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 font-light italic text-center">No timeline achievements logged yet.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<script>
    gsap.registerPlugin(ScrollTrigger);

    
    const reveals = document.querySelectorAll('.spotlight-card, .relative.group');
    reveals.forEach(element => {
        gsap.fromTo(element, 
            { opacity: 0, y: 30 },
            { 
                scrollTrigger: {
                    trigger: element,
                    start: 'top 92%',
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

require_once dirname(__DIR__) . '/layouts/footer.php';
?>