<?php
// src/utils.php

/**
 * Securely starts session if not already started
 */
function secure_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        // Set secure session parameters
        session_start([
            'cookie_lifetime' => 86400,
            'cookie_secure' => isset($_SERVER['HTTPS']),
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
        ]);
    }
}

/**
 * Generates and returns a CSRF token, saving it to session
 */
function get_csrf_token() {
    secure_session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verifies if the provided token matches the session token
 */
function verify_csrf_token($token) {
    secure_session_start();
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Escapes HTML output to prevent XSS
 */
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize variables for general use
 */
function sanitize_input($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

/**
 * Redirect to a specific path
 */
function redirect($path) {
    // If the path doesn't start with / and we are in a subdirectory like /KDS/public/
    // we want to resolve it. We will handle relative routing cleanly.
    $root = dirname($_SERVER['SCRIPT_NAME']);
    $root = ($root === '/' || $root === '\\') ? '' : $root;
    header("Location: " . $root . $path);
    exit;
}

/**
 * Check if the user is authenticated
 */
function is_authenticated() {
    secure_session_start();
    return isset($_SESSION['user_id']);
}

/**
 * Check if the authenticated user is an administrator
 */
function is_admin() {
    secure_session_start();
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Ensure user is administrator, otherwise redirect to login or error
 */
function require_admin() {
    if (!is_admin()) {
        $_SESSION['error_message'] = "Unauthorized access. Administrator privileges required.";
        redirect('/login');
    }
}

/**
 * Get active user details from session
 */
function get_current_user_details() {
    secure_session_start();
    if (is_authenticated()) {
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];
    }
    return null;
}

function get_youtube_url($input) {
    $input = trim($input ?? '');
    if (empty($input)) {
        return '';
    }
    if (strpos($input, 'youtube.com') !== false || strpos($input, 'youtu.be') !== false) {
        return $input;
    }
    return 'https://www.youtube.com/watch?v=' . $input;
}
