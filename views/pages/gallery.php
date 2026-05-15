<?php
// views/pages/gallery.php

require_once dirname(__DIR__, 2) . '/config/database.php';
$db = Database::getConnection();

// Fetch gallery items
$stmt = $db->query("SELECT * FROM gallery ORDER BY upload_date DESC");
$gallery_items = $stmt->fetchAll();

// Include layouts header
require_once dirname(__DIR__) . '/layouts/header.php';
?>

<!-- Ambient Glow Spheres for Cinematic Lighting -->
<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[20%] left-[30%] w-[450px] h-[450px] bg-brandRed/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 9s;"></div>
    <div class="absolute top-[20%] right-[10%] w-[450px] h-[450px] bg-brandGreen/5 rounded-full filter blur-[120px] animate-pulse" style="animation-duration: 15s;"></div>
</div>

<div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-12">
    
    <!-- Title Area -->
    <div class="text-center mb-16 max-w-2xl mx-auto">
        <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Visual Registry</span>
        <h1 class="font-serif text-4xl md:text-6xl font-bold tracking-tight text-white mb-6 leading-tight">
            Chamber Moments
        </h1>
        <p class="text-sm md:text-base font-light text-gray-400 leading-relaxed tracking-wider">
            Explore snapshots of intellectual battles, national triumphs, training workshops, and weekly assemblies where the Voice of Reason takes shape.
        </p>
    </div>

    <!-- Interactive Category Filter -->
    <div class="flex flex-wrap justify-center items-center gap-3 md:gap-4 mb-16" id="filter-nav">
        <button class="filter-btn active px-5 py-2.5 rounded text-[10px] font-semibold uppercase tracking-widest bg-brandRed text-white border border-brandRed transition-all duration-300" data-category="all">
            All Moments
        </button>
        <button class="filter-btn px-5 py-2.5 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="Weekly Sessions">
            Weekly Sessions
        </button>
        <button class="filter-btn px-5 py-2.5 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="National Tournaments">
            National Tournaments
        </button>
        <button class="filter-btn px-5 py-2.5 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="Workshops">
            Workshops
        </button>
        <button class="filter-btn px-5 py-2.5 rounded text-[10px] font-semibold uppercase tracking-widest bg-transparent text-gray-400 border border-white/10 hover:border-white hover:text-white transition-all duration-300" data-category="Social Events">
            Social Events
        </button>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="gallery-grid">
        <?php if (!empty($gallery_items)): ?>
            <?php foreach ($gallery_items as $item): ?>
                <div class="gallery-card group spotlight-card glass-panel rounded overflow-hidden aspect-[4/3] relative cursor-pointer z-10 transition-all duration-500" data-category="<?= e($item['category']) ?>">
                    <!-- Card Background Image -->
                    <img src="<?= e($item['file_path']) ?>" alt="<?= e($item['title']) ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 scale-100 group-hover:scale-105 transition-all duration-700 ease-out z-0">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/45 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300 z-10"></div>
                    
                    <!-- Content overlay -->
                    <div class="absolute bottom-0 left-0 w-full p-6 z-20 flex flex-col justify-end">
                        <span class="text-[9px] uppercase tracking-wider text-brandRed font-semibold mb-1.5 block">
                            <?= e($item['category']) ?>
                        </span>
                        <h3 class="font-serif text-lg font-bold text-white mb-2 leading-snug group-hover:text-brandRed transition-colors duration-300">
                            <?= e($item['title']) ?>
                        </h3>
                        <p class="text-xs text-gray-400 leading-normal line-clamp-2 font-light opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-75">
                            <?= e($item['caption']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 font-light italic col-span-3 text-center py-12">No media files currently archived in the database.</p>
        <?php endif; ?>
    </div>

</div>

<!-- Lightbox Modal container -->
<div id="lightbox-modal" class="fixed inset-0 w-full h-full bg-black/95 z-[999] opacity-0 pointer-events-none flex flex-col justify-center items-center transition-all duration-500 ease-in-out p-6">
    <div class="absolute top-6 right-6 z-50">
        <button id="close-lightbox" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center bg-black/50 text-white hover:text-brandRed hover:border-brandRed/30 transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <div class="max-w-5xl max-h-[75vh] relative flex items-center justify-center z-10 overflow-hidden shadow-2xl rounded border border-white/5 bg-darkGrey">
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[75vh] object-contain">
    </div>
    
    <div class="text-center mt-6 max-w-2xl relative z-10">
        <span id="lightbox-category" class="text-[9px] uppercase tracking-widest text-brandRed font-mono font-semibold block mb-1">Category</span>
        <h3 id="lightbox-title" class="font-serif text-xl font-bold text-white mb-2">Title</h3>
        <p id="lightbox-caption" class="text-xs text-gray-400 font-light max-w-xl mx-auto">Caption</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Grid Category Filter Script
        const filterButtons = document.querySelectorAll('#filter-nav .filter-btn');
        const cards = document.querySelectorAll('#gallery-grid .gallery-card');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Toggle active class on button
                filterButtons.forEach(b => {
                    b.classList.remove('bg-brandRed', 'text-white', 'border-brandRed', 'active');
                    b.classList.add('bg-transparent', 'text-gray-400', 'border-white/10');
                });
                btn.classList.add('bg-brandRed', 'text-white', 'border-brandRed', 'active');
                btn.classList.remove('bg-transparent', 'text-gray-400', 'border-white/10');

                const selectedCategory = btn.getAttribute('data-category');

                // Animate filter elements with GSAP
                gsap.to(cards, {
                    opacity: 0,
                    scale: 0.95,
                    duration: 0.3,
                    ease: 'power2.inOut',
                    onComplete: () => {
                        cards.forEach(card => {
                            const cardCategory = card.getAttribute('data-category');
                            if (selectedCategory === 'all' || cardCategory === selectedCategory) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        gsap.to(cards, {
                            opacity: 1,
                            scale: 1,
                            duration: 0.4,
                            ease: 'power2.out',
                            stagger: 0.05
                        });
                    }
                });
            });
        });

        // 2. Lightbox Modal Trigger Script
        const lightboxModal = document.getElementById('lightbox-modal');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCategory = document.getElementById('lightbox-category');
        const lightboxTitle = document.getElementById('lightbox-title');
        const lightboxCaption = document.getElementById('lightbox-caption');
        const closeBtn = document.getElementById('close-lightbox');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const img = card.querySelector('img');
                const title = card.querySelector('h3').innerText;
                const category = card.querySelector('span').innerText;
                const caption = card.querySelector('p') ? card.querySelector('p').innerText : '';

                // Populate lightbox data
                lightboxImg.src = img.src;
                lightboxTitle.innerText = title;
                lightboxCategory.innerText = category;
                lightboxCaption.innerText = caption;

                // Show modal with GSAP
                lightboxModal.classList.remove('pointer-events-none');
                gsap.to(lightboxModal, {
                    opacity: 1,
                    duration: 0.4,
                    ease: 'power2.out',
                    onStart: () => {
                        if (window.lenis) window.lenis.stop(); // Stop page scrolling
                    }
                });
            });
        });

        const closeModal = () => {
            gsap.to(lightboxModal, {
                opacity: 0,
                duration: 0.3,
                ease: 'power2.inOut',
                onComplete: () => {
                    lightboxModal.classList.add('pointer-events-none');
                    lightboxImg.src = '';
                    if (window.lenis) window.lenis.start(); // Allow scrolling again
                }
            });
        };

        closeBtn.addEventListener('click', closeModal);
        lightboxModal.addEventListener('click', (e) => {
            if (e.target === lightboxModal) {
                closeModal();
            }
        });
    });
</script>

<?php
// Include layouts footer
require_once dirname(__DIR__) . '/layouts/footer.php';
?>