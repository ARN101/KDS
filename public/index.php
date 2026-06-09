<?php
// public/index.php

// 1. Load Utilities & Session Management
require_once dirname(__DIR__) . '/src/utils.php';
secure_session_start();

// 2. Load Routing Infrastructure
require_once dirname(__DIR__) . '/src/Router.php';
require_once dirname(__DIR__) . '/src/Middleware/AuthMiddleware.php';

// 3. Initialize Router
$router = new Router();

// ==========================================
// PUBLIC FRONTEND ROUTES
// ==========================================

// Homepage
$router->get('/', function() {
    $title = "Home";
    require_once dirname(__DIR__) . '/views/pages/home.php';
});

// About KDS
$router->get('/about', function() {
    $title = "About Us";
    require_once dirname(__DIR__) . '/views/pages/about.php';
});

// Events
$router->get('/events', function() {
    $title = "Events";
    require_once dirname(__DIR__) . '/views/pages/events.php';
});

// Hall of Fame
$router->get('/hall-of-fame', function() {
    $title = "Hall of Fame";
    require_once dirname(__DIR__) . '/views/pages/hall-of-fame.php';
});

// Debate Resources
$router->get('/resources', function() {
    $title = "Debate Resources";
    require_once dirname(__DIR__) . '/views/pages/resources.php';
});

// Gallery
$router->get('/gallery', function() {
    $title = "Gallery";
    require_once dirname(__DIR__) . '/views/pages/gallery.php';
});

// Recruitment (Apply)
$router->get('/recruitment', function() {
    $title = "Join KDS";
    require_once dirname(__DIR__) . '/views/pages/recruitment.php';
});
$router->post('/recruitment', 'RecruitmentController@apply');

// Contact
$router->get('/contact', function() {
    $title = "Contact Us";
    require_once dirname(__DIR__) . '/views/pages/contact.php';
});
$router->post('/contact', 'ContactController@submit');


// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

// Login
$router->get('/login', function() {
    if (is_authenticated()) {
        redirect(is_admin() ? '/admin/dashboard' : '/');
    }
    $title = "Login";
    require_once dirname(__DIR__) . '/views/pages/login.php';
});
$router->post('/login', 'AuthController@login');

// Register
$router->get('/register', function() {
    if (is_authenticated()) {
        redirect('/');
    }
    $title = "Register";
    require_once dirname(__DIR__) . '/views/pages/register.php';
});
$router->post('/register', 'AuthController@register');

// Logout
$router->get('/logout', 'AuthController@logout');


// ==========================================
// ADMIN DASHBOARD ROUTES (Gated)
// ==========================================

// Dashboard Home
$router->get('/admin/dashboard', function() {
    AuthMiddleware::handleAdmin();
    $title = "Admin Dashboard";
    require_once dirname(__DIR__) . '/views/admin/dashboard.php';
});
$router->post('/admin/contacts/delete', 'AdminController@contactsDelete');

// Member CRUD
$router->get('/admin/members', 'AdminController@membersIndex');
$router->post('/admin/members/create', 'AdminController@membersCreate');
$router->post('/admin/members/edit', 'AdminController@membersEdit');
$router->post('/admin/members/delete', 'AdminController@membersDelete');

// Event CRUD
$router->get('/admin/events', 'AdminController@eventsIndex');
$router->post('/admin/events/create', 'AdminController@eventsCreate');
$router->post('/admin/events/edit', 'AdminController@eventsEdit');
$router->post('/admin/events/delete', 'AdminController@eventsDelete');

// Debate CRUD
$router->get('/admin/debates', 'AdminController@debatesIndex');
$router->post('/admin/debates/create', 'AdminController@debatesCreate');
$router->post('/admin/debates/edit', 'AdminController@debatesEdit');
$router->post('/admin/debates/delete', 'AdminController@debatesDelete');

// Gallery CRUD
$router->get('/admin/gallery', 'AdminController@galleryIndex');
$router->post('/admin/gallery/create', 'AdminController@galleryCreate');
$router->post('/admin/gallery/delete', 'AdminController@galleryDelete');

// Achievement CRUD
$router->get('/admin/achievements', 'AdminController@achievementsIndex');
$router->post('/admin/achievements/create', 'AdminController@achievementsCreate');
$router->post('/admin/achievements/edit', 'AdminController@achievementsEdit');
$router->post('/admin/achievements/delete', 'AdminController@achievementsDelete');

// Recruitment Review CRUD
$router->get('/admin/recruitment', 'AdminController@recruitmentIndex');
$router->post('/admin/recruitment/status', 'AdminController@recruitmentStatus');


// 4. Dispatch Request
$router->dispatch();
