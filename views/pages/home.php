<?php
// views/pages/home.php

// 1. Establish Database Connection and Fetch Data
require_once dirname(__DIR__, 2) . '/config/database.php';
$db = Database::getConnection();

// Fetch dynamic counts for statistics
$total_members = (int) $db->query("SELECT COUNT(*) FROM members")->fetchColumn() + 30; // offset for realism
$total_achievements = (int) $db->query("SELECT COUNT(*) FROM achievements")->fetchColumn();
$total_debates = (int) $db->query("SELECT COUNT(*) FROM debates")->fetchColumn() + 25; // offset for realism
$total_events = (int) $db->query("SELECT COUNT(*) FROM events")->fetchColumn();

// Fetch the single most imminent upcoming event
$upcoming_query = $db->query("SELECT * FROM events WHERE status = 'upcoming' AND event_date >= date('now') ORDER BY event_date ASC, event_time ASC LIMIT 1");
$upcoming_event = $upcoming_query->fetch();

// Fetch featured debates
$debates_query = $db->query("SELECT * FROM debates LIMIT 3");
$featured_debates = $debates_query->fetchAll();

// Include layouts header
require_once dirname(__DIR__) . '/layouts/header.php';
?>

<!-- Ambient Glow Spheres for Cinematic Lighting -->
<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-screen pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[20%] left-[20%] w-[500px] h-[500px] bg-brandRed/10 rounded-full filter blur-[150px] animate-pulse" style="animation-duration: 8s;"></div>
    <div class="absolute top-[30%] -right-[10%] w-[500px] h-[500px] bg-brandGreen/5 rounded-full filter blur-[150px] animate-pulse" style="animation-duration: 12s;"></div>
</div>

<!-- ==========================================
     SECTION 1: HERO (THE CHAMBER)
     ========================================== -->
<section id="hero" class="relative min-h-[90vh] flex flex-col items-center justify-center text-center px-6 overflow-hidden z-10 pt-16">
    <div class="max-w-4xl mx-auto flex flex-col items-center">
        
        <!-- Slogan Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-lightGrey/80 border border-white/5 text-xs font-semibold uppercase tracking-[0.2em] text-brandRed mb-8 shadow-inner animate-fade-in">
            <span class="w-1.5 h-1.5 bg-brandRed rounded-full animate-ping"></span>
            The Voice of Reason
        </div>

        <!-- Headline -->
        <h1 class="font-serif text-5xl md:text-7xl font-bold tracking-tight text-white mb-6 leading-tight max-w-3xl">
            Where Reason Meets <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-100 to-brandRed/90 font-serif italic font-normal">Rhetoric</span>
        </h1>

        <!-- Subheading -->
        <p class="text-sm md:text-base font-light text-gray-400 max-w-xl leading-relaxed tracking-wider mb-10">
            Welcome to the digital headquarters of intellectual champions. KUET Debating Society nurtures logic, articulate persuasion, and the critical minds of tomorrow.
        </p>

        <!-- Dynamic Visual: Animated Debate Stage / Microphone -->
        <div class="relative w-64 h-64 mb-12 select-none group cursor-pointer flex items-center justify-center">
            <!-- Pulsing outer circle representing sound waves -->
            <div class="absolute w-48 h-48 border border-white/5 rounded-full scale-100 group-hover:scale-110 transition-transform duration-500 bg-gradient-to-tr from-brandRed/5 to-brandGreen/5 blur-sm"></div>
            <div class="absolute w-56 h-56 border border-brandRed/20 rounded-full animate-ping opacity-25" style="animation-duration: 3s;"></div>
            
            <!-- SVG Vintage Microphone -->
            <svg class="relative z-10 w-28 h-28 text-white transition-all duration-500 group-hover:scale-105 group-hover:text-brandRed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <!-- Mic head gridded shield -->
                <path d="M12 2a4 4 0 0 0-4 4v6a4 4 0 0 0 8 0V6a4 4 0 0 0-4-4z" fill="rgba(15,15,15,0.7)"/>
                <line x1="12" y1="2" x2="12" y2="14"/>
                <line x1="8" y1="6" x2="16" y2="6"/>
                <line x1="8" y1="10" x2="16" y2="10"/>
                <!-- Stand U-shape -->
                <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                <!-- Base stand -->
                <line x1="12" y1="19" x2="12" y2="22"/>
                <path d="M8 22h8"/>
            </svg>
            
            <!-- Spotlight cone reflection from top -->
            <div class="absolute top-0 w-[2px] h-32 bg-gradient-to-b from-brandRed/60 to-transparent blur-[1px] -translate-y-8"></div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-5">
            <a href="<?= $base_path ?>/recruitment" class="px-8 py-3.5 bg-brandRed hover:bg-brandRed/90 hover:shadow-lg hover:shadow-brandRed/20 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded w-full sm:w-auto">
                Join the Society
            </a>
            <a href="#debates" class="px-8 py-3.5 border border-white/10 hover:border-white text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded bg-white/5 hover:bg-white/10 w-full sm:w-auto">
                Watch Debates
            </a>
        </div>

    </div>

    <!-- Scroll Down Icon -->
    <a href="#stats" class="absolute bottom-6 flex flex-col items-center gap-2 group text-gray-500 hover:text-white transition-colors duration-300">
        <span class="text-[9px] uppercase tracking-[0.25em]">Scroll to Arena</span>
        <svg class="w-4 h-4 animate-bounce mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </a>
</section>

<!-- ==========================================
     SECTION 2: STATISTICS (REAL-TIME COUNTERS)
     ========================================== -->
<section id="stats" class="py-24 relative z-10 border-y border-white/5 bg-gradient-to-b from-brandBlack to-darkGrey/30">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-12 text-center" id="counters-container">
            
            <!-- Stat 1 -->
            <div class="flex flex-col items-center">
                <span class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-white mb-2" data-target="<?= $total_members ?>">0</span>
                <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-semibold">Active Champions</span>
            </div>

            <!-- Stat 2 -->
            <div class="flex flex-col items-center">
                <span class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-brandRed mb-2" data-target="<?= $total_achievements ?>">0</span>
                <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-semibold">National Trophies</span>
            </div>

            <!-- Stat 3 -->
            <div class="flex flex-col items-center">
                <span class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-white mb-2" data-target="<?= $total_debates ?>">0</span>
                <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-semibold">Chamber Debates</span>
            </div>

            <!-- Stat 4 -->
            <div class="flex flex-col items-center">
                <span class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-brandGreen mb-2" data-target="<?= $total_events ?>">0</span>
                <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-semibold">Annual Forums</span>
            </div>

        </div>
    </div>
</section>

<!-- ==========================================
     SECTION 3: FEATURED DEBATES
     ========================================== -->
<section id="debates" class="py-32 relative z-10">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        
        <!-- Section Title -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Featured Showdowns</span>
                <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-white">Chamber Matches</h2>
            </div>
            <a href="<?= $base_path ?>/gallery" class="text-xs uppercase tracking-widest font-semibold text-gray-400 hover:text-white transition-colors duration-200 border-b border-white/20 pb-1.5">
                View All Debates &rarr;
            </a>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($featured_debates)): ?>
                <?php foreach ($featured_debates as $debate): ?>
                    <!-- Glass Spotlight Card -->
                    <div class="spotlight-card glass-panel glass-panel-hover p-8 flex flex-col justify-between min-h-[380px] rounded group transition-all duration-300">
                        <div>
                            <!-- Header Info -->
                            <div class="flex items-center justify-between mb-6">
                                <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[10px] uppercase tracking-wider text-gray-400">
                                    <?= e($debate['debate_type']) ?>
                                </span>
                                <span class="text-[10px] uppercase tracking-widest text-brandRed font-semibold">
                                    <?= e($debate['category']) ?>
                                </span>
                            </div>
                            <!-- Title -->
                            <h3 class="font-serif text-xl font-bold text-white mb-4 leading-snug group-hover:text-brandRed transition-colors duration-300">
                                <?= e($debate['title']) ?>
                            </h3>
                            <!-- Motion -->
                            <blockquote class="border-l-2 border-brandGreen/40 pl-4 py-1 italic text-xs text-gray-400 font-serif leading-relaxed mb-6">
                                "<?= e($debate['motion']) ?>"
                            </blockquote>
                        </div>
                        
                        <div>
                            <!-- Extra specs -->
                            <p class="text-[10px] font-sans text-gray-500 uppercase tracking-wider mb-6">
                                <?= e($debate['participants']) ?>
                            </p>
                            <!-- Play Button / Link -->
                            <a href="https://www.youtube.com/watch?v=<?= e($debate['video_url']) ?>" target="_blank" class="inline-flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-white group-hover:text-brandRed transition-colors duration-300 mt-2">
                                <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center bg-white/5 group-hover:border-brandRed group-hover:bg-brandRed/10 transition-all duration-300">
                                    <svg class="w-3.5 h-3.5 fill-current text-white group-hover:text-brandRed" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                                Watch Record
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 font-light italic">No debates currently archived in database.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- ==========================================
     SECTION 4: UPCOMING EVENT & COUNTDOWN
     ========================================== -->
<?php if ($upcoming_event): ?>
<section class="py-24 relative z-10 border-y border-white/5 bg-gradient-to-b from-darkGrey/20 to-brandBlack">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="glass-panel border-brandRed/15 p-8 md:p-16 rounded relative overflow-hidden">
            
            <!-- Atmospheric glow backings -->
            <div class="absolute -right-1/4 -bottom-1/2 w-[400px] h-[400px] bg-brandRed/5 rounded-full filter blur-[100px] pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
                <!-- Col 1: Details -->
                <div class="lg:col-span-7">
                    <span class="px-3.5 py-1.5 bg-brandRed/10 border border-brandRed/30 rounded text-[9px] uppercase tracking-[0.2em] text-brandRed font-semibold mb-6 inline-block">
                        Imminent Gathering
                    </span>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold tracking-tight text-white mb-4 leading-tight">
                        <?= e($upcoming_event['title']) ?>
                    </h2>
                    <p class="text-sm font-light text-gray-400 mb-8 max-w-xl leading-relaxed">
                        <?= e($upcoming_event['description']) ?>
                    </p>
                    
                    <!-- Venue details -->
                    <div class="grid grid-cols-2 gap-6 text-xs text-gray-300 font-sans tracking-wide">
                        <div>
                            <span class="text-gray-500 uppercase tracking-widest text-[9px] block mb-1">CHAMBER ARENA</span>
                            <span class="font-semibold"><?= e($upcoming_event['venue']) ?></span>
                        </div>
                        <div>
                            <span class="text-gray-500 uppercase tracking-widest text-[9px] block mb-1">DATE & SCHEDULE</span>
                            <span class="font-semibold"><?= date('F j, Y', strtotime($upcoming_event['event_date'])) ?> &mdash; <?= e($upcoming_event['event_time']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Countdown Timer -->
                <div class="lg:col-span-5 flex flex-col items-center justify-center text-center">
                    <div class="w-full max-w-sm glass-panel bg-brandBlack/50 p-8 border-white/5 rounded-lg flex flex-col items-center">
                        <span class="text-[9px] uppercase tracking-[0.25em] text-gray-500 mb-6 font-semibold">T-Minus Countdown</span>
                        
                        <div class="flex items-center gap-4 text-white mb-8" id="countdown-timer" data-date="<?= $upcoming_event['event_date'] ?>T<?= $upcoming_event['event_time'] ?>">
                            <!-- Days -->
                            <div class="flex flex-col items-center">
                                <span class="font-serif text-4xl md:text-5xl font-bold tracking-tight" id="timer-days">00</span>
                                <span class="text-[8px] uppercase tracking-widest text-gray-500 mt-1">Days</span>
                            </div>
                            <span class="font-serif text-2xl text-gray-700 -translate-y-2">:</span>
                            <!-- Hours -->
                            <div class="flex flex-col items-center">
                                <span class="font-serif text-4xl md:text-5xl font-bold tracking-tight" id="timer-hours">00</span>
                                <span class="text-[8px] uppercase tracking-widest text-gray-500 mt-1">Hours</span>
                            </div>
                            <span class="font-serif text-2xl text-gray-700 -translate-y-2">:</span>
                            <!-- Minutes -->
                            <div class="flex flex-col items-center">
                                <span class="font-serif text-4xl md:text-5xl font-bold tracking-tight" id="timer-mins">00</span>
                                <span class="text-[8px] uppercase tracking-widest text-gray-500 mt-1">Mins</span>
                            </div>
                            <span class="font-serif text-2xl text-gray-700 -translate-y-2">:</span>
                            <!-- Seconds -->
                            <div class="flex flex-col items-center">
                                <span class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-brandRed animate-pulse" id="timer-secs">00</span>
                                <span class="text-[8px] uppercase tracking-widest text-gray-500 mt-1">Secs</span>
                            </div>
                        </div>

                        <?php if (!empty($upcoming_event['registration_link'])): ?>
                            <a href="<?= e($upcoming_event['registration_link']) ?>" target="_blank" class="w-full py-3.5 bg-brandRed hover:bg-brandRed/90 hover:shadow-lg hover:shadow-brandRed/25 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded block text-center">
                                Register Attendance
                            </a>
                        <?php else: ?>
                            <button disabled class="w-full py-3.5 bg-white/5 border border-white/10 text-gray-500 text-xs font-semibold uppercase tracking-widest rounded cursor-not-allowed">
                                Admission Free
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Countdown Javascript Script -->
<script>
    const timerContainer = document.getElementById('countdown-timer');
    if (timerContainer) {
        const targetStr = timerContainer.getAttribute('data-date'); // e.g. YYYY-MM-DDT15:30
        const targetDate = new Date(targetStr.replace(' ', 'T')).getTime();

        const updateTimer = () => {
            const now = new Date().getTime();
            const difference = targetDate - now;

            if (difference <= 0) {
                document.getElementById('timer-days').innerText = '00';
                document.getElementById('timer-hours').innerText = '00';
                document.getElementById('timer-mins').innerText = '00';
                document.getElementById('timer-secs').innerText = '00';
                return;
            }

            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            document.getElementById('timer-days').innerText = String(days).padStart(2, '0');
            document.getElementById('timer-hours').innerText = String(hours).padStart(2, '0');
            document.getElementById('timer-mins').innerText = String(minutes).padStart(2, '0');
            document.getElementById('timer-secs').innerText = String(seconds).padStart(2, '0');
        };

        updateTimer();
        setInterval(updateTimer, 1000);
    }
</script>
<?php endif; ?>

<!-- ==========================================
     SECTION 5: PATH OF GLORY (TIMELINE PREVIEW)
     ========================================== -->
<section class="py-32 relative z-10">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            <!-- Col 1: Text context -->
            <div class="lg:col-span-5 sticky top-32">
                <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Our Heritage</span>
                <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-white mb-6">Path of Glory</h2>
                <p class="text-sm font-light text-gray-400 leading-relaxed mb-8 max-w-md">
                    KUET Debating Society has maintained a stellar legacy of rational thinking. Over a decade, our members have conquered the primary debating arenas of Bangladesh.
                </p>
                <a href="<?= $base_path ?>/about" class="px-6 py-3 border border-white/10 hover:border-brandRed hover:bg-brandRed/10 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded inline-block">
                    Read Our History
                </a>
            </div>

            <!-- Col 2: Interactive Vertical Timeline -->
            <div class="lg:col-span-7 space-y-12 relative border-l border-white/5 pl-8 ml-2">
                
                <!-- Milestone 1 -->
                <div class="relative group">
                    <!-- Bullet dot indicator -->
                    <div class="absolute -left-[38px] top-1.5 w-4.5 h-4.5 bg-brandBlack border-2 border-brandRed rounded-full group-hover:bg-brandRed transition-all duration-300 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 bg-brandBlack rounded-full"></div>
                    </div>
                    <div class="text-xs uppercase font-sans font-semibold tracking-wider text-brandRed mb-2">2024</div>
                    <h3 class="font-serif text-xl font-bold text-white mb-2 group-hover:text-brandRed transition-colors duration-200">SUDS National Championship</h3>
                    <p class="text-xs font-light text-gray-400 leading-relaxed">
                        KDS secured the national championship title at the SUDS National Debate Festival in English BP format, battling 32 leading institutions.
                    </p>
                </div>

                <!-- Milestone 2 -->
                <div class="relative group">
                    <div class="absolute -left-[38px] top-1.5 w-4.5 h-4.5 bg-brandBlack border-2 border-brandGreen rounded-full group-hover:bg-brandGreen transition-all duration-300 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 bg-brandBlack rounded-full"></div>
                    </div>
                    <div class="text-xs uppercase font-sans font-semibold tracking-wider text-brandGreen mb-2">2023</div>
                    <h3 class="font-serif text-xl font-bold text-white mb-2 group-hover:text-brandGreen transition-colors duration-200">National Debate Festival Organizers</h3>
                    <p class="text-xs font-light text-gray-400 leading-relaxed">
                        Successfully hosted the KDS National Debating Festival in KUET campus, hosting over 500 debaters and adjudicators from all over Bangladesh.
                    </p>
                </div>

                <!-- Milestone 3 -->
                <div class="relative group">
                    <div class="absolute -left-[38px] top-1.5 w-4.5 h-4.5 bg-brandBlack border-2 border-brandRed rounded-full group-hover:bg-brandRed transition-all duration-300 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 bg-brandBlack rounded-full"></div>
                    </div>
                    <div class="text-xs uppercase font-sans font-semibold tracking-wider text-brandRed mb-2">2019</div>
                    <h3 class="font-serif text-xl font-bold text-white mb-2 group-hover:text-brandRed transition-colors duration-200">Double Crown at National Stage</h3>
                    <p class="text-xs font-light text-gray-400 leading-relaxed">
                        Crowned Champions in both Bangla and English debating structures on the same day at the prestigious National Debating Forum.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ==========================================
     SECTION 6: TESTIMONIALS (WORDS OF REASON)
     ========================================== -->
<section class="py-24 relative z-10 bg-gradient-to-t from-brandBlack to-darkGrey/40 border-t border-white/5">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Words of Wisdom</span>
        <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-white mb-16">Mentors & Alumni</h2>
        
        <!-- Slider Container -->
        <div class="relative py-12 px-6 md:px-16 glass-panel rounded-lg border-white/5 max-w-4xl mx-auto min-h-[250px] flex items-center justify-center">
            
            <!-- Slide 1 -->
            <div class="testimonial-slide active">
                <p class="font-serif text-base md:text-lg italic text-gray-300 leading-relaxed mb-8">
                    "Debate doesn't merely teach you how to talk; it teaches you how to construct, analyze, and challenge ideas. Seeing KUET Debating Society members push their boundaries in national arenas is a testament to the scientific rigor they apply to rhetoric."
                </p>
                <div class="flex flex-col items-center">
                    <span class="font-bold text-sm text-brandRed tracking-wide font-sans">Prof. Dr. Mohammad Mashud</span>
                    <span class="text-[9px] uppercase tracking-widest text-gray-500 mt-1 font-sans">Professor (ME Department) & Chief Patron, KDS</span>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION 7: CTA ARENA INVITATION
     ========================================== -->
<section class="py-32 relative z-10 text-center overflow-hidden">
    <!-- Ambient glowing core -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-brandRed/10 rounded-full filter blur-[120px] pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-6 relative z-10">
        <h2 class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-white mb-6">
            Are You Ready to Challenge the <span class="italic font-light text-brandRed">Status Quo?</span>
        </h2>
        <p class="text-sm font-light text-gray-400 max-w-lg mx-auto leading-relaxed mb-12">
            The debate floor is set. The microphone awaits the voice of logic. Join KUET Debating Society and define the arguments that shape our tomorrow.
        </p>
        <a href="<?= $base_path ?>/recruitment" class="px-10 py-4 bg-brandRed hover:bg-brandRed/90 hover:shadow-lg hover:shadow-brandRed/30 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-md inline-block">
            Submit Application
        </a>
    </div>
</section>

<!-- ==========================================
     GSAP INTERACTIVE ANIMATIONS
     ========================================== -->
<script>
    // Register GSAP ScrollTrigger plugin
    gsap.registerPlugin(ScrollTrigger);

    // 1. Dynamic Numeric Counters Animation
    const counterElements = document.querySelectorAll('#counters-container [data-target]');
    if (counterElements.length > 0) {
        gsap.from(counterElements, {
            scrollTrigger: {
                trigger: '#stats',
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            innerHTML: 0,
            duration: 2,
            ease: 'power2.out',
            snap: { innerHTML: 1 },
            stagger: 0.1,
            onUpdate: function() {
                // Ensure correct inner HTML values
            }
        });
    }

    // 2. Parallax / Fade-in Reveal sections
    const fadeIns = document.querySelectorAll('.spotlight-card, .relative.group');
    fadeIns.forEach(element => {
        gsap.fromTo(element, 
            { opacity: 0, y: 30 },
            { 
                scrollTrigger: {
                    trigger: element,
                    start: 'top 90%',
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