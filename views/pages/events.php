<?php
// views/pages/events.php

// 1. Connection & Fetch Events
require_once dirname(__DIR__, 2) . '/config/database.php';
$db = Database::getConnection();

// Fetch all events sorted by date
$stmt = $db->query("SELECT * FROM events ORDER BY event_date DESC, event_time DESC");
$all_events = $stmt->fetchAll();

// Split events into upcoming and past
$upcoming_events = [];
$past_events = [];
$today = date('Y-m-d');

foreach ($all_events as $event) {
    if ($event['event_date'] >= $today) {
        $upcoming_events[] = $event;
    } else {
        $past_events[] = $event;
    }
}

// Include layouts header
require_once dirname(__DIR__) . '/layouts/header.php';
?>

<!-- Ambient Glow Spheres for Cinematic Lighting -->
<div class="absolute top-0 left-0 w-full h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[10%] left-[20%] w-[600px] h-[600px] bg-brandRed/5 rounded-full filter blur-[150px] opacity-70"></div>
    <div class="absolute top-[40%] right-[10%] w-[450px] h-[450px] bg-brandGreen/5 rounded-full filter blur-[120px] opacity-60"></div>
</div>

<!-- ==========================================
     HERO: THE ARENA SCHEDULES
     ========================================== -->
<section class="relative z-10 pt-20 pb-16 text-center px-6 max-w-4xl mx-auto">
    <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Chamber Calendar</span>
    <h1 class="font-serif text-5xl md:text-7xl font-bold tracking-tight text-white mb-6 leading-none">
        Events & <span class="italic font-light text-brandRed font-serif">Schedules</span>
    </h1>
    <p class="text-sm md:text-base font-light text-gray-400 max-w-2xl mx-auto leading-relaxed tracking-wider">
        Track the schedule of rational combat. Join our workshops, register for national tournaments, or spectate intense departmental clashes.
    </p>
</section>

<!-- ==========================================
     SEARCH & DYNAMIC FILTERS BAR
     ========================================== -->
<section class="py-6 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    <div class="glass-panel p-4 rounded-lg flex flex-col md:flex-row items-center justify-between gap-4 border-white/5 bg-brandBlack/60">
        
        <!-- Search input -->
        <div class="relative w-full md:w-80">
            <input type="text" id="event-search" placeholder="Search events..." class="w-full bg-lightGrey border border-white/10 rounded px-4 py-2.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-brandRed transition-colors duration-300">
            <span class="absolute right-3.5 top-3.5 text-gray-500 text-xs">
                &#x1F50E;&#xFE0E;
            </span>
        </div>

        <!-- Category Filters -->
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-start md:justify-end">
            <button class="filter-btn active px-4 py-2 rounded text-[10px] font-semibold uppercase tracking-widest bg-brandRed text-white border border-brandRed transition-all duration-300" data-category="all">
                All Sessions
            </button>
            <button class="filter-btn px-4 py-2 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="Tournament">
                Tournaments
            </button>
            <button class="filter-btn px-4 py-2 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="Workshop">
                Workshops
            </button>
            <button class="filter-btn px-4 py-2 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="Bangla Debate">
                Bangla
            </button>
            <button class="filter-btn px-4 py-2 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="English Debate">
                English
            </button>
        </div>

    </div>
</section>

<!-- ==========================================
     UPCOMING GATHERINGS (UPCOMING EVENTS)
     ========================================== -->
<section class="py-12 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    <div class="flex items-center gap-4 mb-10">
        <span class="w-2.5 h-2.5 bg-brandRed rounded-full animate-pulse"></span>
        <h2 class="font-serif text-2xl md:text-3xl font-bold text-white">Upcoming Assemblies</h2>
        <div class="flex-grow h-[1px] bg-white/5"></div>
    </div>

    <!-- Event Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8" id="upcoming-events-grid">
        <?php if (!empty($upcoming_events)): ?>
            <?php foreach ($upcoming_events as $event): ?>
                <!-- Event Item Card -->
                <div class="event-card glass-panel p-6 md:p-8 rounded flex flex-col md:flex-row gap-6 hover:border-brandRed/20 transition-all duration-300 group" data-category="<?= e($event['category']) ?>">
                    <!-- Image Box -->
                    <div class="w-full md:w-44 h-44 rounded overflow-hidden relative border border-white/5 shrink-0 bg-lightGrey">
                        <img src="<?= e($event['image_path']) ?>" alt="<?= e($event['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-brandBlack/85 text-[9px] uppercase tracking-wider text-brandRed font-semibold border border-brandRed/30 rounded">
                            <?= e($event['category']) ?>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex flex-col justify-between flex-grow">
                        <div>
                            <span class="text-[10px] font-mono text-brandGreen font-bold uppercase tracking-wider block mb-1">
                                <?= date('F j, Y', strtotime($event['event_date'])) ?> &mdash; <?= e($event['event_time']) ?>
                            </span>
                            <h3 class="font-serif text-xl font-bold text-white mb-2 group-hover:text-brandRed transition-colors duration-200">
                                <?= e($event['title']) ?>
                            </h3>
                            <p class="text-[11px] font-light text-gray-400 leading-relaxed mb-4">
                                <?= e($event['description']) ?>
                            </p>
                        </div>

                        <div class="flex items-center justify-between border-t border-white/5 pt-4 mt-2">
                            <span class="text-[10px] font-sans text-gray-500">
                                Venue: <strong class="text-gray-300"><?= e($event['venue']) ?></strong>
                            </span>
                            
                            <?php if (!empty($event['registration_link'])): ?>
                                <a href="<?= e($event['registration_link']) ?>" target="_blank" class="px-4 py-2 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-wider rounded transition-colors duration-200">
                                    Register &rarr;
                                </a>
                            <?php else: ?>
                                <span class="text-[9px] uppercase tracking-widest text-brandGreen font-semibold">Admission Free</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 font-light italic col-span-2">No upcoming assemblies scheduled at this moment. Check back soon!</p>
        <?php endif; ?>
    </div>
</section>

<!-- ==========================================
     HISTORICAL CONFLICTS (PAST EVENTS)
     ========================================== -->
<section class="py-16 relative z-10 max-w-7xl mx-auto px-6 md:px-12 border-t border-white/5 mt-12">
    <div class="flex items-center gap-4 mb-10">
        <span class="w-2.5 h-2.5 bg-brandGreen rounded-full"></span>
        <h2 class="font-serif text-2xl md:text-3xl font-bold text-white">Concluded Archives</h2>
        <div class="flex-grow h-[1px] bg-white/5"></div>
    </div>

    <!-- Past Events Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="past-events-grid">
        <?php if (!empty($past_events)): ?>
            <?php foreach ($past_events as $event): ?>
                <!-- Past Event Card -->
                <div class="event-card glass-panel p-6 rounded hover:border-brandGreen/25 transition-all duration-300 flex flex-col justify-between min-h-[300px] group" data-category="<?= e($event['category']) ?>">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[9px] font-mono text-gray-500 uppercase tracking-wider">
                                <?= date('M Y', strtotime($event['event_date'])) ?>
                            </span>
                            <span class="px-2 py-0.5 bg-white/5 border border-white/10 rounded text-[9px] text-gray-400">
                                <?= e($event['category']) ?>
                            </span>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-white mb-2 group-hover:text-brandGreen transition-colors duration-200">
                            <?= e($event['title']) ?>
                        </h3>
                        <p class="text-[11px] font-light text-gray-400 leading-relaxed mb-6">
                            <?= e($event['description']) ?>
                        </p>
                    </div>

                    <div class="border-t border-white/5 pt-4 mt-2 flex items-center justify-between text-[10px] text-gray-500 font-mono">
                        <span>Venue: <?= e($event['venue']) ?></span>
                        <span class="text-brandGreen">Concluded</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 font-light italic col-span-3">No past assemblies logged in the database.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Interactive Live Filtering JS Script -->
<script>
    const searchInput = document.getElementById('event-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const eventCards = document.querySelectorAll('.event-card');

    let currentCategory = 'all';
    let searchQuery = '';

    const filterEvents = () => {
        eventCards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            const desc = card.querySelector('p').innerText.toLowerCase();
            const category = card.getAttribute('data-category');

            const matchesSearch = title.includes(searchQuery) || desc.includes(searchQuery);
            const matchesCategory = currentCategory === 'all' || category.toLowerCase() === currentCategory.toLowerCase();

            if (matchesSearch && matchesCategory) {
                card.style.display = 'flex';
                // Reset card styling based on grid parent
                if(card.parentElement.id === 'past-events-grid') {
                    card.style.display = 'flex';
                    card.style.flexDirection = 'column';
                }
            } else {
                card.style.display = 'none';
            }
        });
    };

    // Category Buttons click
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes
            filterButtons.forEach(b => {
                b.classList.remove('active', 'bg-brandRed', 'text-white', 'border-brandRed');
                b.classList.add('bg-transparent', 'text-gray-400', 'border-white/10');
            });

            // Set active class
            btn.classList.add('active', 'bg-brandRed', 'text-white', 'border-brandRed');
            btn.classList.remove('bg-transparent', 'text-gray-400', 'border-white/10');

            currentCategory = btn.getAttribute('data-category');
            filterEvents();
        });
    });

    // Search Keyup
    searchInput.addEventListener('keyup', (e) => {
        searchQuery = e.target.value.toLowerCase();
        filterEvents();
    });
</script>

<!-- GSAP Page Transition Script -->
<script>
    gsap.registerPlugin(ScrollTrigger);
    
    // Reveal grids
    gsap.from('#upcoming-events-grid, #past-events-grid', {
        opacity: 0,
        y: 30,
        duration: 1,
        ease: 'power3.out',
        stagger: 0.15
    });
</script>

<?php
// Include layouts footer
require_once dirname(__DIR__) . '/layouts/footer.php';
?>