<?php
// views/admin/layouts/header.php
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = ($base_path === '/' || $base_path === '\\') ? '' : $base_path;

$request_uri = $_SERVER['REQUEST_URI'];

function is_admin_active($route, $base_path) {
    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $check_path = $base_path . $route;
    return $request_path === $check_path;
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) . " | KDS Admin" : "KDS Admin Chambers" ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brandBlack: '#020202',
                        brandWhite: '#FFFFFF',
                        brandRed: '#ED1C24',
                        brandGreen: '#006837',
                        darkGrey: '#0A0A0A',
                        lightGrey: '#151515',
                        gray: {
                            100: '#F3F4F6',
                            200: '#E5E7EB',
                            300: '#D1D5DB',
                            400: '#CBD5E1',
                            500: '#94A3B8',
                            600: '#475569',
                            700: '#334155',
                            800: '#1E293B',
                            900: '#0F172A',
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
    
    <!-- GSAP for Admin Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body class="bg-brandBlack text-brandWhite min-h-screen flex selection:bg-brandRed selection:text-white">

    <!-- Sidebar Navigation -->
    <aside class="w-64 fixed inset-y-0 left-0 bg-darkGrey border-r border-white/5 flex flex-col justify-between z-30 transition-transform duration-300 transform -translate-x-full md:translate-x-0" id="admin-sidebar">
        <div>
            <!-- Header/Logo area -->
            <div class="px-6 py-6 border-b border-white/5 flex items-center justify-between">
                <a href="<?= $base_path ?>/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 border border-white/10 flex items-center justify-center overflow-hidden bg-black rounded shadow-md group-hover:border-brandRed/50 transition-colors duration-300">
                        <img src="<?= $base_path ?>/assets/images/logo.jpg" alt="KDS Logo" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="font-serif text-lg tracking-tight text-white font-bold group-hover:text-brandRed transition-colors duration-300">KDS Admin</span>
                        <span class="text-[8px] uppercase tracking-wider text-gray-500 font-sans mt-0.5">Voice of Reason</span>
                    </div>
                </a>
                
                <!-- Mobile close button -->
                <button class="md:hidden text-gray-400 hover:text-white" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Menu items -->
            <nav class="px-4 py-6 space-y-1.5">
                <a href="<?= $base_path ?>/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/dashboard', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                    </svg>
                    Overview
                </a>
                
                <a href="<?= $base_path ?>/admin/members" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/members', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Members
                </a>
                
                <a href="<?= $base_path ?>/admin/events" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/events', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Events
                </a>
                
                <a href="<?= $base_path ?>/admin/debates" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/debates', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Debates
                </a>

                <a href="<?= $base_path ?>/admin/achievements" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/achievements', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    Achievements
                </a>
                
                <a href="<?= $base_path ?>/admin/gallery" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/gallery', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Gallery
                </a>
                
                <a href="<?= $base_path ?>/admin/recruitment" class="flex items-center gap-3 px-4 py-3 rounded text-xs uppercase tracking-wider font-semibold transition-all duration-300 <?= is_admin_active('/admin/recruitment', $base_path) ? 'bg-brandRed text-white shadow-md shadow-brandRed/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Recruitment
                </a>
            </nav>
        </div>
        
        <!-- Sidebar Footer/Logout -->
        <div class="p-4 border-t border-white/5 bg-black/40">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-xs font-semibold text-white">
                    A
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-semibold text-white truncate"><?= e($_SESSION['user_name']) ?></span>
                    <span class="text-[9px] text-gray-500 truncate"><?= e($_SESSION['user_email']) ?></span>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="<?= $base_path ?>/" class="flex-1 text-center py-2 bg-white/5 hover:bg-white/10 text-white rounded text-[10px] uppercase tracking-widest transition-all duration-300">
                    Public site
                </a>
                <a href="<?= $base_path ?>/logout" class="flex-1 text-center py-2 bg-brandRed/20 hover:bg-brandRed hover:text-white text-brandRed rounded text-[10px] uppercase tracking-widest transition-all duration-300">
                    Logout
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col md:pl-64 min-w-0">
        <!-- Top Navbar -->
        <header class="h-16 border-b border-white/5 bg-darkGrey/80 backdrop-blur flex items-center justify-between px-6 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <!-- Hamburger for mobile -->
                <button class="md:hidden text-gray-400 hover:text-white" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="font-serif text-lg md:text-xl font-bold tracking-tight text-white">
                    <?= isset($title) ? e($title) : "Dashboard" ?>
                </h1>
            </div>
            
            <div class="text-[10px] text-gray-500 font-mono hidden sm:block">
                SYSTEM TIME: <?= date('Y-m-d H:i') ?>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-grow p-6 md:p-8 relative z-10">
            
            <!-- Global Flash Messages inside Admin Area -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="mb-6 p-4 bg-brandGreen/10 border border-brandGreen/30 text-white rounded text-xs animate-fade-in">
                    <?= e($_SESSION['success_message']) ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="mb-6 p-4 bg-brandRed/10 border border-brandRed/30 text-white rounded text-xs animate-fade-in">
                    <?= e($_SESSION['error_message']) ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
