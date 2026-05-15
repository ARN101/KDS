<?php
// src/Controllers/ContactController.php

require_once dirname(__DIR__) . '/utils.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

class ContactController {
    
    public function submit() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/contact');
        }

        // Verify CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/contact');
        }

        // Validate Input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $_SESSION['error_message'] = "All fields are required.";
            redirect('/contact');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "Please provide a valid email address.";
            redirect('/contact');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);

            $_SESSION['success_message'] = "Your message has been sent successfully! We will get back to you shortly.";
            redirect('/contact');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "An error occurred while saving your message. Please try again later.";
            redirect('/contact');
        }
    }
}
