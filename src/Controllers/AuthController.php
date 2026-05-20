<?php
// src/Controllers/AuthController.php

require_once dirname(__DIR__) . '/utils.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

class AuthController {
    
    /**
     * Handle user login POST requests
     */
    public function login() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/login');
        }

        // Verify CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error_message'] = "Both email and password are required.";
            redirect('/login');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                $_SESSION['success_message'] = "Welcome back, " . $user['name'] . "!";
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    redirect('/admin/dashboard');
                } else {
                    redirect('/');
                }
            } else {
                $_SESSION['error_message'] = "Invalid email or password.";
                $_SESSION['old_email'] = $email;
                redirect('/login');
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "An authentication error occurred. Please try again later.";
            redirect('/login');
        }
    }

    /**
     * Handle user registration POST requests
     */
    public function register() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/register');
        }

        // Verify CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/register');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if (empty($name) || empty($email) || empty($password) || empty($password_confirm)) {
            $_SESSION['error_message'] = "All fields are required.";
            $_SESSION['old_name'] = $name;
            $_SESSION['old_email'] = $email;
            redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "Please enter a valid email address.";
            $_SESSION['old_name'] = $name;
            redirect('/register');
        }

        if (strlen($password) < 6) {
            $_SESSION['error_message'] = "Password must be at least 6 characters long.";
            $_SESSION['old_name'] = $name;
            $_SESSION['old_email'] = $email;
            redirect('/register');
        }

        if ($password !== $password_confirm) {
            $_SESSION['error_message'] = "Passwords do not match.";
            $_SESSION['old_name'] = $name;
            $_SESSION['old_email'] = $email;
            redirect('/register');
        }

        try {
            $db = Database::getConnection();
            
            // Check if email already exists
            $stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $exists = $stmt->fetch()['count'] > 0;

            if ($exists) {
                $_SESSION['error_message'] = "An account with this email already exists.";
                $_SESSION['old_name'] = $name;
                redirect('/register');
            }

            // Hash password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Insert user
            $stmt = $db->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, 'member')");
            $stmt->execute([$name, $email, $password_hash]);

            $_SESSION['success_message'] = "Registration successful! Please log in.";
            redirect('/login');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "A registration error occurred. Please try again later.";
            $_SESSION['old_name'] = $name;
            $_SESSION['old_email'] = $email;
            redirect('/register');
        }
    }

    /**
     * Handle user logout GET requests
     */
    public function logout() {
        secure_session_start();
        
        // Unset all session values
        $_SESSION = [];

        // Destroy session cookie if set
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        
        secure_session_start();
        $_SESSION['success_message'] = "You have logged out successfully.";
        redirect('/');
    }
}
