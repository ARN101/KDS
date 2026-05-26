<?php
// src/Controllers/AdminController.php

require_once dirname(__DIR__) . '/utils.php';
require_once dirname(__DIR__) . '/Middleware/AuthMiddleware.php';

class AdminController {

    public function __construct() {
        // Enforce administrative permissions for all dashboard methods
        AuthMiddleware::handleAdmin();
    }

    public function membersIndex() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM members ORDER BY id DESC");
            $members = $stmt->fetchAll();
            
            $title = "Manage Members";
            require_once dirname(__DIR__, 2) . '/views/admin/members.php';
        } catch (Exception $e) {
            secure_session_start();
            $_SESSION['error_message'] = "Could not fetch members registry: " . $e->getMessage();
            redirect('/admin/dashboard');
        }
    }

    public function membersCreate() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/members');
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/members');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role_title = trim($_POST['role_title'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $status = trim($_POST['status'] ?? 'active');

        if (empty($name) || empty($role_title)) {
            $_SESSION['error_message'] = "Name and Designation are required fields.";
            redirect('/admin/members');
        }

        // Handle Image Upload
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_path = $this->handleImageUpload($_FILES['image']);
            if (!$image_path) {
                redirect('/admin/members');
            }
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO members (name, email, role_title, bio, image_path, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $role_title, $bio, $image_path, $status]);

            $_SESSION['success_message'] = "Member '{$name}' created successfully.";
            redirect('/admin/members');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to add member to registry. Please try again.";
            redirect('/admin/members');
        }
    }

    public function membersEdit() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/members');
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/members');
        }

        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role_title = trim($_POST['role_title'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $status = trim($_POST['status'] ?? 'active');

        if ($id <= 0 || empty($name) || empty($role_title)) {
            $_SESSION['error_message'] = "Invalid parameters provided.";
            redirect('/admin/members');
        }

        try {
            $db = Database::getConnection();
            
            // Get current member to preserve image if no new image uploaded
            $stmt = $db->prepare("SELECT image_path FROM members WHERE id = ?");
            $stmt->execute([$id]);
            $member = $stmt->fetch();

            if (!$member) {
                $_SESSION['error_message'] = "Member not found.";
                redirect('/admin/members');
            }

            $image_path = $member['image_path'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $new_image = $this->handleImageUpload($_FILES['image']);
                if ($new_image) {
                    $image_path = $new_image;
                    // Delete old local file if exists
                    if (!empty($member['image_path']) && strpos($member['image_path'], 'http') !== 0) {
                        $old_file = dirname(__DIR__, 2) . '/public/' . $member['image_path'];
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                } else {
                    redirect('/admin/members');
                }
            }

            $stmt = $db->prepare("UPDATE members SET name = ?, email = ?, role_title = ?, bio = ?, image_path = ?, status = ? WHERE id = ?");
            $stmt->execute([$name, $email, $role_title, $bio, $image_path, $status, $id]);

            $_SESSION['success_message'] = "Member '{$name}' updated successfully.";
            redirect('/admin/members');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to update member registry. Please try again.";
            redirect('/admin/members');
        }
    }

    public function membersDelete() {
        secure_session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/members');
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/members');
        }

        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error_message'] = "Invalid parameters provided.";
            redirect('/admin/members');
        }

        try {
            $db = Database::getConnection();
            
            // Get image to delete file
            $stmt = $db->prepare("SELECT name, image_path FROM members WHERE id = ?");
            $stmt->execute([$id]);
            $member = $stmt->fetch();

            if (!$member) {
                $_SESSION['error_message'] = "Member not found.";
                redirect('/admin/members');
            }

            // Delete file if local
            if (!empty($member['image_path']) && strpos($member['image_path'], 'http') !== 0) {
                $old_file = dirname(__DIR__, 2) . '/public/' . $member['image_path'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }

            $stmt = $db->prepare("DELETE FROM members WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success_message'] = "Member '{$member['name']}' removed from registry.";
            redirect('/admin/members');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to delete member from database.";
            redirect('/admin/members');
        }
    }

    /**
     * Helper for uploading files securely
     */
    private function handleImageUpload($file) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $file_type = $file['type'];

        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error_message'] = "Invalid file type. Only JPG, PNG, and WEBP images are allowed.";
            return false;
        }

        // Limit size to 2MB
        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['error_message'] = "Image size exceeds the maximum limit of 2MB.";
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('member_') . '.' . $extension;
        
        $upload_dir = dirname(__DIR__, 2) . '/public/assets/uploads/members';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $target_path = $upload_dir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return 'assets/uploads/members/' . $filename;
        }

        $_SESSION['error_message'] = "Failed to save uploaded image file.";
        return false;
    }

    public function eventsIndex() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM events ORDER BY event_date DESC, event_time DESC");
            $events = $stmt->fetchAll();
            $title = "Manage Events";
            require_once dirname(__DIR__, 2) . '/views/admin/events.php';
        } catch (Exception $e) {
            secure_session_start();
            $_SESSION['error_message'] = "Could not fetch events registry: " . $e->getMessage();
            redirect('/admin/dashboard');
        }
    }

    public function eventsCreate() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/events');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/events');
        }

        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $event_date = trim($_POST['event_date'] ?? '');
        $event_time = trim($_POST['event_time'] ?? '');
        $venue = trim($_POST['venue'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $registration_link = trim($_POST['registration_link'] ?? '');
        $status = trim($_POST['status'] ?? 'upcoming');

        if (empty($title) || empty($category) || empty($event_date) || empty($event_time) || empty($venue)) {
            $_SESSION['error_message'] = "Title, Category, Date, Time, and Venue are required.";
            redirect('/admin/events');
        }

        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_path = $this->handleEventImageUpload($_FILES['image']);
            if (!$image_path) {
                redirect('/admin/events');
            }
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO events (title, description, category, event_date, event_time, venue, image_path, registration_link, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $category, $event_date, $event_time, $venue, $image_path, $registration_link, $status]);
            $_SESSION['success_message'] = "Event '{$title}' created successfully.";
            redirect('/admin/events');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to create event. Please try again.";
            redirect('/admin/events');
        }
    }

    public function eventsEdit() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/events');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/events');
        }

        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $event_date = trim($_POST['event_date'] ?? '');
        $event_time = trim($_POST['event_time'] ?? '');
        $venue = trim($_POST['venue'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $registration_link = trim($_POST['registration_link'] ?? '');
        $status = trim($_POST['status'] ?? 'upcoming');

        if ($id <= 0 || empty($title) || empty($category) || empty($event_date) || empty($event_time) || empty($venue)) {
            $_SESSION['error_message'] = "Required fields are missing.";
            redirect('/admin/events');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT image_path FROM events WHERE id = ?");
            $stmt->execute([$id]);
            $event = $stmt->fetch();

            if (!$event) {
                $_SESSION['error_message'] = "Event not found.";
                redirect('/admin/events');
            }

            $image_path = $event['image_path'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $new_image = $this->handleEventImageUpload($_FILES['image']);
                if ($new_image) {
                    $image_path = $new_image;
                    if (!empty($event['image_path']) && strpos($event['image_path'], 'http') !== 0) {
                        $old_file = dirname(__DIR__, 2) . '/public/' . $event['image_path'];
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                } else {
                    redirect('/admin/events');
                }
            }

            $stmt = $db->prepare("UPDATE events SET title = ?, description = ?, category = ?, event_date = ?, event_time = ?, venue = ?, image_path = ?, registration_link = ?, status = ? WHERE id = ?");
            $stmt->execute([$title, $description, $category, $event_date, $event_time, $venue, $image_path, $registration_link, $status, $id]);

            $_SESSION['success_message'] = "Event updated successfully.";
            redirect('/admin/events');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to update event. Please try again.";
            redirect('/admin/events');
        }
    }

    public function eventsDelete() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/events');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/events');
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error_message'] = "Invalid parameters provided.";
            redirect('/admin/events');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT title, image_path FROM events WHERE id = ?");
            $stmt->execute([$id]);
            $event = $stmt->fetch();

            if (!$event) {
                $_SESSION['error_message'] = "Event not found.";
                redirect('/admin/events');
            }

            if (!empty($event['image_path']) && strpos($event['image_path'], 'http') !== 0) {
                $old_file = dirname(__DIR__, 2) . '/public/' . $event['image_path'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }

            $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success_message'] = "Event '{$event['title']}' deleted successfully.";
            redirect('/admin/events');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to delete event.";
            redirect('/admin/events');
        }
    }

    public function debatesIndex() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM debates ORDER BY debate_date DESC, id DESC");
            $debates = $stmt->fetchAll();
            $title = "Manage Debates";
            require_once dirname(__DIR__, 2) . '/views/admin/debates.php';
        } catch (Exception $e) {
            secure_session_start();
            $_SESSION['error_message'] = "Could not fetch debates registry: " . $e->getMessage();
            redirect('/admin/dashboard');
        }
    }

    public function debatesCreate() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/debates');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/debates');
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $debate_type = trim($_POST['debate_type'] ?? '');
        $motion = trim($_POST['motion'] ?? '');
        $video_url = trim($_POST['video_url'] ?? '');
        $debate_date = trim($_POST['debate_date'] ?? '');
        $category = trim($_POST['category'] ?? 'English');
        $participants = trim($_POST['participants'] ?? '');
        $outcome = trim($_POST['outcome'] ?? '');

        if (empty($title) || empty($debate_type) || empty($motion)) {
            $_SESSION['error_message'] = "Title, Debate Type, and Motion are required.";
            redirect('/admin/debates');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO debates (title, description, debate_type, motion, video_url, debate_date, category, participants, outcome) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $debate_type, $motion, $video_url, $debate_date, $category, $participants, $outcome]);

            $_SESSION['success_message'] = "Debate record created successfully.";
            redirect('/admin/debates');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to add debate record.";
            redirect('/admin/debates');
        }
    }

    public function debatesEdit() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/debates');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/debates');
        }

        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $debate_type = trim($_POST['debate_type'] ?? '');
        $motion = trim($_POST['motion'] ?? '');
        $video_url = trim($_POST['video_url'] ?? '');
        $debate_date = trim($_POST['debate_date'] ?? '');
        $category = trim($_POST['category'] ?? 'English');
        $participants = trim($_POST['participants'] ?? '');
        $outcome = trim($_POST['outcome'] ?? '');

        if ($id <= 0 || empty($title) || empty($debate_type) || empty($motion)) {
            $_SESSION['error_message'] = "Required fields are missing.";
            redirect('/admin/debates');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE debates SET title = ?, description = ?, debate_type = ?, motion = ?, video_url = ?, debate_date = ?, category = ?, participants = ?, outcome = ? WHERE id = ?");
            $stmt->execute([$title, $description, $debate_type, $motion, $video_url, $debate_date, $category, $participants, $outcome, $id]);

            $_SESSION['success_message'] = "Debate record updated successfully.";
            redirect('/admin/debates');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to update debate record.";
            redirect('/admin/debates');
        }
    }

    public function debatesDelete() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/debates');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/debates');
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error_message'] = "Invalid parameters provided.";
            redirect('/admin/debates');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM debates WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success_message'] = "Debate record removed.";
            redirect('/admin/debates');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to delete debate record.";
            redirect('/admin/debates');
        }
    }

    public function galleryIndex() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM gallery ORDER BY upload_date DESC, id DESC");
            $photos = $stmt->fetchAll();
            $title = "Gallery Manager";
            require_once dirname(__DIR__, 2) . '/views/admin/gallery.php';
        } catch (Exception $e) {
            secure_session_start();
            $_SESSION['error_message'] = "Could not fetch gallery pictures: " . $e->getMessage();
            redirect('/admin/dashboard');
        }
    }

    public function galleryCreate() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/gallery');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/gallery');
        }

        $title = trim($_POST['title'] ?? '');
        $caption = trim($_POST['caption'] ?? '');
        $category = trim($_POST['category'] ?? '');

        if (empty($title) || empty($category)) {
            $_SESSION['error_message'] = "Title and Category are required.";
            redirect('/admin/gallery');
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_message'] = "Please upload a valid image file.";
            redirect('/admin/gallery');
        }

        $file_path = $this->handleGalleryImageUpload($_FILES['image']);
        if (!$file_path) {
            redirect('/admin/gallery');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO gallery (title, caption, file_path, category) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $caption, $file_path, $category]);

            $_SESSION['success_message'] = "Photo added to gallery successfully.";
            redirect('/admin/gallery');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to save photo record.";
            redirect('/admin/gallery');
        }
    }

    public function galleryDelete() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/gallery');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/gallery');
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error_message'] = "Invalid parameters provided.";
            redirect('/admin/gallery');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT title, file_path FROM gallery WHERE id = ?");
            $stmt->execute([$id]);
            $photo = $stmt->fetch();

            if (!$photo) {
                $_SESSION['error_message'] = "Photo not found.";
                redirect('/admin/gallery');
            }

            if (!empty($photo['file_path']) && strpos($photo['file_path'], 'http') !== 0) {
                $old_file = dirname(__DIR__, 2) . '/public/' . $photo['file_path'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }

            $stmt = $db->prepare("DELETE FROM gallery WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success_message'] = "Photo '{$photo['title']}' removed from gallery.";
            redirect('/admin/gallery');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to delete photo from gallery.";
            redirect('/admin/gallery');
        }
    }

    public function achievementsIndex() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM achievements ORDER BY year DESC, id DESC");
            $achievements = $stmt->fetchAll();
            $title = "Manage Achievements";
            require_once dirname(__DIR__, 2) . '/views/admin/achievements.php';
        } catch (Exception $e) {
            secure_session_start();
            $_SESSION['error_message'] = "Could not fetch achievements record: " . $e->getMessage();
            redirect('/admin/dashboard');
        }
    }

    public function achievementsCreate() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/achievements');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/achievements');
        }

        $title = trim($_POST['title'] ?? '');
        $competition = trim($_POST['competition'] ?? '');
        $year = intval($_POST['year'] ?? date('Y'));
        $team_members = trim($_POST['team_members'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($title) || empty($competition) || empty($team_members) || $year <= 0) {
            $_SESSION['error_message'] = "Title, Competition, Year, and Team Members are required.";
            redirect('/admin/achievements');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO achievements (title, competition, year, team_members, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $competition, $year, $team_members, $description]);

            $_SESSION['success_message'] = "Achievement record added successfully.";
            redirect('/admin/achievements');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to create achievement record.";
            redirect('/admin/achievements');
        }
    }

    public function achievementsEdit() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/achievements');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/achievements');
        }

        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $competition = trim($_POST['competition'] ?? '');
        $year = intval($_POST['year'] ?? date('Y'));
        $team_members = trim($_POST['team_members'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($id <= 0 || empty($title) || empty($competition) || empty($team_members) || $year <= 0) {
            $_SESSION['error_message'] = "Required fields are missing.";
            redirect('/admin/achievements');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE achievements SET title = ?, competition = ?, year = ?, team_members = ?, description = ? WHERE id = ?");
            $stmt->execute([$title, $competition, $year, $team_members, $description, $id]);

            $_SESSION['success_message'] = "Achievement record updated successfully.";
            redirect('/admin/achievements');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to update achievement record.";
            redirect('/admin/achievements');
        }
    }

    public function achievementsDelete() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/achievements');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/achievements');
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error_message'] = "Invalid parameters provided.";
            redirect('/admin/achievements');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM achievements WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['success_message'] = "Achievement record deleted successfully.";
            redirect('/admin/achievements');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to delete achievement record.";
            redirect('/admin/achievements');
        }
    }

    public function recruitmentIndex() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM recruitment ORDER BY applied_at DESC");
            $applicants = $stmt->fetchAll();
            $title = "Recruitment Applications";
            require_once dirname(__DIR__, 2) . '/views/admin/recruitment.php';
        } catch (Exception $e) {
            secure_session_start();
            $_SESSION['error_message'] = "Could not fetch recruitment applications: " . $e->getMessage();
            redirect('/admin/dashboard');
        }
    }

    public function recruitmentStatus() {
        secure_session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/recruitment');
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error_message'] = "Security validation failed. Please try again.";
            redirect('/admin/recruitment');
        }

        $id = intval($_POST['id'] ?? 0);
        $status = trim($_POST['status'] ?? '');

        if ($id <= 0 || !in_array($status, ['approved', 'rejected', 'pending'])) {
            $_SESSION['error_message'] = "Invalid status parameters.";
            redirect('/admin/recruitment');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE recruitment SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);

            $_SESSION['success_message'] = "Application status updated to '{$status}' successfully.";
            redirect('/admin/recruitment');
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to update recruitment status.";
            redirect('/admin/recruitment');
        }
    }

    /**
     * Helpers for uploading event images securely
     */
    private function handleEventImageUpload($file) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $file_type = $file['type'];

        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error_message'] = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
            return false;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['error_message'] = "Image size exceeds 2MB limit.";
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('event_') . '.' . $extension;
        
        $upload_dir = dirname(__DIR__, 2) . '/public/assets/uploads/events';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $target_path = $upload_dir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return 'assets/uploads/events/' . $filename;
        }

        $_SESSION['error_message'] = "Failed to save event image file.";
        return false;
    }

    /**
     * Helpers for uploading gallery images securely
     */
    private function handleGalleryImageUpload($file) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $file_type = $file['type'];

        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error_message'] = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
            return false;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['error_message'] = "Image size exceeds 2MB limit.";
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('gallery_') . '.' . $extension;
        
        $upload_dir = dirname(__DIR__, 2) . '/public/assets/uploads/gallery';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $target_path = $upload_dir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return 'assets/uploads/gallery/' . $filename;
        }

        $_SESSION['error_message'] = "Failed to save gallery image file.";
        return false;
    }
}
