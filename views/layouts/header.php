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
                <div class="w-10 h-10 border border-brandRed flex items-center justify-center font-serif text-brandRed font-black text-xl bg-black rounded shadow-lg shadow-brandRed/10 transition-all duration-300 group-hover:scale-105 group-hover:shadow-brandRed/30">
                    K
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-serif text-xl tracking-tight text-white font-bold group-hover:text-brandRed transition-colors duration-300">KDS</span>
                    <span class="text-[9px] uppercase tracking-[0.25em] text-gray-500 font-sans mt-0.5">KUET DEBATING SOCIETY</span>
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

            <!-- Authentication Actions -->
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

            <!-- Mobile Menu Burger Button -->
            <button id="mobile-menu-btn" class="lg:hidden relative z-50 w-8 h-8 flex flex-col justify-center items-center gap-1.5 focus:outline-none">
                <span class="w-6 h-0.5 bg-white transition-all duration-300" id="burger-top"></span>
                <span class="w-6 h-0.5 bg-white transition-all duration-300" id="burger-mid"></span>
                <span class="w-6 h-0.5 bg-white transition-all duration-300" id="burger-bottom"></span>
            </button>
        </div>

        <!-- Mobile Full-screen Dropdown Menu -->
        <div id="mobile-menu" class="fixed inset-0 w-full h-screen bg-brandBlack z-40 flex flex-col justify-center items-center opacity-0 pointer-events-none transition-all duration-500">
            <div class="absolute inset-0 z-0 bg-[radial-gradient(circle_at_center,rgba(237,28,36,0.06),transparent_70%)] pointer-events-none"></div>
            <nav class="relative z-10 flex flex-col items-center gap-6 text-center">
                <a href="<?= $base_path ?>/" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Home</a>
                <a href="<?= $base_path ?>/about" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">About Us</a>
                <a href="<?= $base_path ?>/events" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Events</a>
                <a href="<?= $base_path ?>/hall-of-fame" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Hall of Fame</a>
                <a href="<?= $base_path ?>/resources" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Resources</a>
                <a href="<?= $base_path ?>/gallery" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Gallery</a>
                <a href="<?= $base_path ?>/recruitment" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Join KDS</a>
                <a href="<?= $base_path ?>/contact" class="font-serif text-2xl hover:text-brandRed transition-colors duration-300">Contact</a>
                
                <div class="h-[1px] w-24 bg-white/10 my-4"></div>
                
                <?php if (is_authenticated()): ?>
                    <?php if (is_admin()): ?>
                        <a href="<?= $base_path ?>/admin/dashboard" class="px-6 py-2.5 bg-brandGreen/25 border border-brandGreen hover:bg-brandGreen text-white text-xs tracking-widest uppercase rounded">
                            Dashboard
                        </a>
                    <?php endif; ?>
                    <a href="<?= $base_path ?>/logout" class="px-6 py-2.5 border border-white/20 hover:border-brandRed hover:bg-brandRed text-white text-xs tracking-widest uppercase rounded mt-2">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= $base_path ?>/login" class="px-6 py-2.5 bg-brandRed border border-brandRed hover:bg-transparent text-white text-xs tracking-widest uppercase rounded shadow-lg shadow-brandRed/25">
                        Portal Login
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu Script Trigger -->
    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const burgerTop = document.getElementById('burger-top');
        const burgerMid = document.getElementById('burger-mid');
        const burgerBottom = document.getElementById('burger-bottom');

        let isMenuOpen = false;

        menuBtn.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen;
            if (isMenuOpen) {
                // Open menu
                mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
                mobileMenu.classList.add('opacity-100', 'pointer-events-auto');
                
                // Animate burger to Close (X)
                burgerTop.style.transform = 'translateY(8px) rotate(45deg)';
                burgerMid.style.opacity = '0';
                burgerBottom.style.transform = 'translateY(-8px) rotate(-45deg)';
                
                // Block scroll via Lenis if running
                if(window.lenis) window.lenis.stop();
            } else {
                // Close menu
                mobileMenu.classList.add('opacity-0', 'pointer-events-none');
                mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
                
                // Animate burger back to normal
                burgerTop.style.transform = 'none';
                burgerMid.style.opacity = '1';
                burgerBottom.style.transform = 'none';
                
                // Allow scroll
                if(window.lenis) window.lenis.start();
            }
        });
    </script>

    <!-- Content Wrapper (Offsets fixed header) -->
    <main class="flex-grow pt-24 relative z-10">
