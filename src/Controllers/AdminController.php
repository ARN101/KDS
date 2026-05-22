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
        echo "Admin: Events Management List - To be implemented in Phase 9";
    }

    public function eventsCreate() {
        echo "Admin: Creating Event - To be implemented in Phase 9";
    }

    public function eventsEdit() {
        echo "Admin: Editing Event - To be implemented in Phase 9";
    }

    public function eventsDelete() {
        echo "Admin: Deleting Event - To be implemented in Phase 9";
    }

    public function debatesIndex() {
        echo "Admin: Debates Management List - To be implemented in Phase 9";
    }

    public function debatesCreate() {
        echo "Admin: Creating Debate - To be implemented in Phase 9";
    }

    public function debatesEdit() {
        echo "Admin: Editing Debate - To be implemented in Phase 9";
    }

    public function debatesDelete() {
        echo "Admin: Deleting Debate - To be implemented in Phase 9";
    }

    public function galleryIndex() {
        echo "Admin: Gallery Management List - To be implemented in Phase 9";
    }

    public function galleryCreate() {
        echo "Admin: Creating Gallery Photo - To be implemented in Phase 9";
    }

    public function galleryDelete() {
        echo "Admin: Deleting Gallery Photo - To be implemented in Phase 9";
    }

    public function achievementsIndex() {
        echo "Admin: Achievements Management List - To be implemented in Phase 9";
    }

    public function achievementsCreate() {
        echo "Admin: Creating Achievement - To be implemented in Phase 9";
    }

    public function achievementsEdit() {
        echo "Admin: Editing Achievement - To be implemented in Phase 9";
    }

    public function achievementsDelete() {
        echo "Admin: Deleting Achievement - To be implemented in Phase 9";
    }

    public function recruitmentIndex() {
        echo "Admin: Recruitment Applications Review Panel - To be implemented in Phase 9";
    }

    public function recruitmentStatus() {
        echo "Admin: Updating Recruitment Status - To be implemented in Phase 9";
    }
}
