<?php
// src/Middleware/AuthMiddleware.php

require_once dirname(__DIR__) . '/utils.php';

class AuthMiddleware {
    
    /**
     * Guard that allows only authenticated administrators.
     * Redirects non-admins to the login page with an error.
     */
    public static function handleAdmin() {
        require_admin();
    }

    /**
     * Guard that allows only authenticated users (members or admins).
     * Redirects guest users to the login page.
     */
    public static function handleAuth() {
        if (!is_authenticated()) {
            $_SESSION['error_message'] = "Please log in to access this page.";
            redirect('/login');
        }
    }
}
