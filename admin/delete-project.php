<?php
/**
 * Secure Project Deletion Endpoint
 * Developed by Expert Security Developer
 */

// 1. Include Secure DB & Commons
require_once __DIR__ . '/../includes/db.php';

// 2. Enforce active administrator authentication gate
enforceAdminAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CSRF Protection validation
    $submitted_csrf = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($submitted_csrf)) {
        $_SESSION['proj_error'] = 'Security Alert: Unauthorized CSRF submission token. Deletion aborted.';
        header("Location: manage-projects.php");
        exit;
    }
    
    $proj_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    if ($proj_id <= 0) {
        $_SESSION['proj_error'] = 'Error: Invalid project registry selected.';
        header("Location: manage-projects.php");
        exit;
    }
    
    try {
        // Fetch project record first to purge file storage
        $stmt = $pdo->prepare("SELECT main_image, thumbs FROM projects WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $proj_id]);
        $project = $stmt->fetch();
        
        if ($project) {
            
            // A. Remove primary image if not standard seed image
            $main_img = $project['main_image'];
            if (!empty($main_img) && !str_starts_with($main_img, 'assets/images/')) {
                $main_path = __DIR__ . '/../' . $main_img;
                if (file_exists($main_path)) {
                    @unlink($main_path);
                }
            }
            
            // B. Remove thumbnails if not standard seed images
            $thumbs_json = $project['thumbs'];
            if (!empty($thumbs_json)) {
                $thumbs = json_decode($thumbs_json, true);
                if (is_array($thumbs)) {
                    foreach ($thumbs as $thumb) {
                        if (!empty($thumb) && !str_starts_with($thumb, 'assets/images/')) {
                            $thumb_path = __DIR__ . '/../' . $thumb;
                            if (file_exists($thumb_path)) {
                                @unlink($thumb_path);
                            }
                        }
                    }
                }
            }
            
            // C. Delete database record
            $del_stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
            $del_stmt->execute(['id' => $proj_id]);
            
            $_SESSION['proj_success'] = 'Smart plot record removed from database successfully.';
        } else {
            $_SESSION['proj_error'] = 'Error: Project record not found.';
        }
    } catch (PDOException $e) {
        $_SESSION['proj_error'] = 'Database Error: Failed to remove project. Details: ' . $e->getMessage();
    }
}

header("Location: manage-projects.php");
exit;
