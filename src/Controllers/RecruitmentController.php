<?php
// src/Controllers/RecruitmentController.php

require_once dirname(__DIR__) . '/utils.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

class RecruitmentController {
    
    public function apply() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/recruitment');
        }

        // Verify CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/recruitment');
        }

        // Validate Input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $roll_no = trim($_POST['roll_no'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $debating_experience = trim($_POST['debating_experience'] ?? '');
        $motivation = trim($_POST['motivation'] ?? '');

        if (empty($name) || empty($email) || empty($phone) || empty($roll_no) || empty($department) || empty($academic_year) || empty($motivation)) {
            $_SESSION['error_message'] = "All required fields must be completed.";
            redirect('/recruitment');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "Please provide a valid email address.";
            redirect('/recruitment');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO recruitment (name, email, phone, roll_no, department, academic_year, debating_experience, motivation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $name,
                $email,
                $phone,
                $roll_no,
                $department,
                $academic_year,
                $debating_experience,
                $motivation
            ]);

            $_SESSION['success_message'] = "Your recruitment application has been submitted successfully! KDS executives will review your details soon.";
            redirect('/recruitment');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "An error occurred while saving your application. Please try again.";
            redirect('/recruitment');
        }
    }
}
