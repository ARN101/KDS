<?php
// views/layouts/header.php
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = ($base_path === '/' || $base_path === '\\') ? '' : $base_path;

// Establish active page for navigation highlight
$request_uri = $_SERVER['REQUEST_URI'];
$active_class = "text-brandRed border-b-2 border-brandRed font-semibold";
$inactive_class = "text-gray-300 hover:text-white transition-all duration-300 animated-underline";

function is_active_route($route, $base_path) {
    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // Normalize path
    $check_path = $base_path . $route;
    if ($route === '/' && ($request_path === $base_path . '/' || $request_path === $base_path || $request_path === '')) {
        return true;
    }
    return $route !== '/' && strpos($request_path, $check_path) === 0;
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) . " | KUET Debating Society" : "KUET Debating Society | The Voice of Reason" ?></title>
    
    <!-- Meta tags for SEO -->
    <meta name="description" content="KUET Debating Society (KDS) is the premier platform for intellectual discourse, logical reasoning, and competitive public speaking at Khulna University of Engineering & Technology.">
    <meta name="keywords" content="KUET, Debating, KDS, Debate Club, Khulna University of Engineering, BP format, public speaking, the voice of reason">
    <meta name="author" content="KUET Debating Society">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brandBlack: '#000000',
                        brandWhite: '#FFFFFF',
                        brandRed: '#ED1C24',
                        brandGreen: '#006837',
                        darkGrey: '#0F0F0F',
                        lightGrey: '#1C1C1C',
                        gray: {
                            100: '#F3F4F6',
                            200: '#E5E7EB',
                            300: '#D1D5DB',
                            400: '#CBD5E1', // increased brightness
                            500: '#94A3B8', // increased brightness
                            600: '#64748B',
                            700: '#475569',
                            800: '#334155',
                            900: '#1E293B',
                        }
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="<?= $base_path ?>/assets/css/main.css">
    
    <!-- GSAP & Lenis Smooth Scroll CDNs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.34/dist/lenis.min.js"></script>
    
    <!-- Page Transition Overlay -->
    <div class="page-transition-overlay"></div>
</head>
<body class="bg-brandBlack text-brandWhite min-h-screen relative flex flex-col justify-between selection:bg-brandRed selection:text-white">

    <!-- Global Floating Particles Background (Canvas) -->
    <div class="fixed inset-0 w-full h-full z-0 pointer-events-none opacity-40">
        <canvas id="particles-canvas"></canvas>
    </div>

    <!-- Header Navigation -->
    <header class="fixed top-0 left-0 w-full z-50 bg-transparent py-6 border-b border-transparent transition-all duration-500">
        <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center justify-between">
            
            <!-- Logo Section -->
            <a href="<?= $base_path ?>/" class="flex items-center gap-3 group relative z-50">
                <div class="w-10 h-10 border border-white/10 flex items-center justify-center overflow-hidden bg-black rounded shadow-lg shadow-brandRed/10 transition-all duration-300 group-hover:scale-105 group-hover:shadow-brandRed/30 group-hover:border-brandRed/50">
                    <img src="<?= $base_path ?>/assets/images/logo.jpg" alt="KDS Logo" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-serif text-xl tracking-tight text-white font-bold group-hover:text-brandRed transition-colors duration-300">KDS</span>
                    <span class="text-[9px] uppercase tracking-[0.25em] text-gray-400 font-sans mt-0.5">KUET DEBATING SOCIETY</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden lg:flex items-center gap-8">
                <a href="<?= $base_path ?>/" class="<?= is_active_route('/', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Home</a>
                <a href="<?= $base_path ?>/about" class="<?= is_active_route('/about', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">About Us</a>
                <a href="<?= $base_path ?>/events" class="<?= is_active_route('/events', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Events</a>
                <a href="<?= $base_path ?>/hall-of-fame" class="<?= is_active_route('/hall-of-fame', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Hall of Fame</a>
                <a href="<?= $base_path ?>/resources" class="<?= is_active_route('/resources', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Resources</a>
                <a href="<?= $base_path ?>/gallery" class="<?= is_active_route('/gallery', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Gallery</a>
                <a href="<?= $base_path ?>/recruitment" class="<?= is_active_route('/recruitment', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Join KDS</a>
                <a href="<?= $base_path ?>/contact" class="<?= is_active_route('/contact', $base_path) ? $active_class : $inactive_class ?> text-xs uppercase tracking-widest py-1">Contact</a>
            </nav>

            <!-- Action & Navigation Area (Right side) -->
            <div class="flex items-center gap-4">
                <!-- Authentication Actions (Desktop Only) -->
                <div class="hidden lg:flex items-center gap-4">
                    <?php if (is_authenticated()): ?>
                        <?php if (is_admin()): ?>
                            <a href="<?= $base_path ?>/admin/dashboard" class="px-5 py-2 border border-brandGreen/40 bg-brandGreen/10 hover:bg-brandGreen hover:border-brandGreen text-white text-[11px] font-semibold tracking-widest uppercase transition-all duration-300 rounded shadow-md shadow-brandGreen/5">
                                Dashboard
                            </a>
                        <?php endif; ?>
                        <a href="<?= $base_path ?>/logout" class="px-5 py-2 border border-white/20 hover:border-brandRed hover:bg-brandRed text-white text-[11px] font-semibold tracking-widest uppercase transition-all duration-300 rounded">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="<?= $base_path ?>/login" class="px-5 py-2 border border-brandRed bg-brandRed/10 hover:bg-brandRed hover:shadow-lg hover:shadow-brandRed/20 text-white text-[11px] font-semibold tracking-widest uppercase transition-all duration-300 rounded">
                            Portal Login
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Stylized Asymmetric Menu Toggle (Mobile & Desktop) -->
                <button id="chambers-menu-btn" class="relative z-50 w-10 h-10 rounded-full bg-white/5 border border-white/10 flex flex-col justify-center items-center focus:outline-none hover:border-brandRed hover:bg-brandRed/10 transition-all duration-300 shadow-lg" title="Open Chambers Navigation">
                    <div class="flex flex-col gap-1.5 items-end justify-center w-5">
                        <span class="w-5 h-0.5 bg-white transition-all duration-300 bar-1"></span>
                        <span class="w-3 h-0.5 bg-white transition-all duration-300 bar-2"></span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Soft Backdrop Overlay (Click to close) -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-black/40 backdrop-blur-[1px] opacity-0 pointer-events-none transition-all duration-500 z-40"></div>

        <!-- Sliding Navigation Sidebar Drawer -->
        <div id="chambers-sidebar" class="fixed inset-y-0 right-0 w-80 md:w-96 bg-black/95 backdrop-blur-2xl border-l border-white/10 z-50 shadow-2xl translate-x-full transition-transform duration-500 ease-out flex flex-col justify-between p-8">
            <!-- Sidebar Header -->
            <div class="flex items-center gap-3 border-b border-white/5 pb-6">
                <div class="w-8 h-8 border border-white/10 flex items-center justify-center overflow-hidden bg-black rounded">
                    <img src="<?= $base_path ?>/assets/images/logo.jpg" alt="KDS Logo" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-serif text-sm tracking-tight text-white font-bold">Chamber Portal</span>
                    <span class="text-[8px] uppercase tracking-[0.2em] text-gray-500 font-sans mt-0.5">Voice of Reason</span>
                </div>
            </div>

            <!-- Staggered Navigation Links -->
            <nav class="flex flex-col gap-4 py-8">
                <a href="<?= $base_path ?>/" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Home</a>
                <a href="<?= $base_path ?>/about" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">About Us</a>
                <a href="<?= $base_path ?>/events" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Events</a>
                <a href="<?= $base_path ?>/hall-of-fame" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Hall of Fame</a>
                <a href="<?= $base_path ?>/resources" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Resources</a>
                <a href="<?= $base_path ?>/gallery" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Gallery</a>
                <a href="<?= $base_path ?>/recruitment" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Join KDS</a>
                <a href="<?= $base_path ?>/contact" class="sidebar-link font-serif text-xl md:text-2xl font-bold tracking-tight text-white hover:text-brandRed" style="opacity: 0; transform: translateX(20px);">Contact</a>
            </nav>

            <!-- Sidebar Footer Area -->
            <div class="border-t border-white/5 pt-6 space-y-5">
                <!-- Portal Access Status -->
                <div>
                    <?php if (is_authenticated()): ?>
                        <div class="flex flex-col gap-2">
                            <span class="text-[8px] uppercase tracking-widest text-gray-500 block mb-1">Logged as: <strong class="text-white"><?= e($_SESSION['user_name']) ?></strong></span>
                            <div class="flex gap-2">
                                <?php if (is_admin()): ?>
                                    <a href="<?= $base_path ?>/admin/dashboard" class="flex-1 text-center py-2 bg-brandGreen/20 hover:bg-brandGreen border border-brandGreen/30 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                                        Dashboard
                                    </a>
                                <?php endif; ?>
                                <a href="<?= $base_path ?>/logout" class="flex-1 text-center py-2 bg-brandRed/20 hover:bg-brandRed border border-brandRed/30 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= $base_path ?>/login" class="w-full text-center py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all block shadow-md shadow-brandRed/20">
                            Portal Login
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Clock & Social Icons -->
                <div class="flex items-center justify-between text-[9px] text-gray-500 font-mono">
                    <span id="chrono-clock">--:--:--</span>
                    <div class="flex gap-2.5">
                        <a href="https://facebook.com" target="_blank" class="hover:text-white transition-colors">FB</a>
                        <span>•</span>
                        <a href="https://youtube.com" target="_blank" class="hover:text-white transition-colors">YT</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Stylized Sidebar CSS Animations -->
    <style>
        /* Asymmetric Hamburger Menu Toggle morphing into X */
        #chambers-menu-btn.active .bar-1 {
            transform: translateY(3.5px) rotate(45deg);
            background-color: #ED1C24;
        }
        #chambers-menu-btn.active .bar-2 {
            width: 20px;
            transform: translateY(-3.5px) rotate(-45deg);
            background-color: #ED1C24;
        }
        #chambers-menu-btn:hover .bar-1,
        #chambers-menu-btn:hover .bar-2 {
            background-color: #ED1C24;
        }

        /* Hover animation for sidebar links */
        .sidebar-link {
            position: relative;
            padding-left: 0;
            transition: padding-left 0.3s ease, color 0.3s ease;
        }
        .sidebar-link:hover {
            padding-left: 8px;
        }
    </style>

    <!-- Chambers Menu Script Trigger -->
    <script>
        const chambersBtn = document.getElementById('chambers-menu-btn');
        const chambersSidebar = document.getElementById('chambers-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        const chronoClock = document.getElementById('chrono-clock');

        let isSidebarOpen = false;

        // Clock Update
        function updateChrono() {
            if (!chronoClock) return;
            const now = new Date();
            const hrs = String(now.getHours()).padStart(2, '0');
            const mins = String(now.getMinutes()).padStart(2, '0');
            const secs = String(now.getSeconds()).padStart(2, '0');
            chronoClock.innerText = `${hrs}:${mins}:${secs}`;
        }
        setInterval(updateChrono, 1000);
        updateChrono();

        function toggleSidebar(open) {
            isSidebarOpen = open;
            if (isSidebarOpen) {
                chambersBtn.classList.add('active');
                sidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                sidebarBackdrop.classList.add('opacity-100', 'pointer-events-auto');
                chambersSidebar.classList.remove('translate-x-full');

                // Stagger link entrance with GSAP
                gsap.killTweensOf(".sidebar-link");
                gsap.fromTo(".sidebar-link", 
                    { opacity: 0, x: 20 }, 
                    { opacity: 1, x: 0, duration: 0.4, stagger: 0.04, ease: "power2.out", delay: 0.15 }
                );

                // Stop scrolling
                if (window.lenis) window.lenis.stop();
            } else {
                chambersBtn.classList.remove('active');
                sidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
                sidebarBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
                chambersSidebar.classList.add('translate-x-full');

                // Allow scrolling
                if (window.lenis) window.lenis.start();
            }
        }

        chambersBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar(!isSidebarOpen);
        });

        // Close on clicking backdrop
        sidebarBackdrop.addEventListener('click', () => {
            toggleSidebar(false);
        });

        // Close on clicking links
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                toggleSidebar(false);
            });
        });
    </script>

    <!-- Content Wrapper (Offsets fixed header) -->
    <main class="flex-grow pt-24 relative z-10">
