<?php
// src/Controllers/AuthController.php

require_once dirname(__DIR__) . '/utils.php';

class AuthController {
    
    public function login() {
        // Will be implemented in Phase 7
        echo "Processing Login POST Request...";
    }

    public function register() {
        // Will be implemented in Phase 7
        echo "Processing Registration POST Request...";
    }

    public function logout() {
        // Will be implemented in Phase 7
        secure_session_start();
        session_destroy();
        redirect('/');
    }
}
