<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_video'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];
    $duration = trim($_POST['duration']);
    
    // Validate input
    if (empty($title) || empty($category)) {
        header('Location: admin-videos.php?error=Please fill all required fields');
        exit;
    }
    
    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $video_file = $_FILES['video'];
        $allowed_types = ['video/mp4', 'video/webm', 'video/ogg'];
        $max_size = 50 * 1024 * 1024; // 50MB
        
        // Validate file type
        if (!in_array($video_file['type'], $allowed_types)) {
            header('Location: admin-videos.php?error=Invalid file type. Please upload MP4, WebM, or OGG videos.');
            exit;
        }
        
        // Validate file size
        if ($video_file['size'] > $max_size) {
            header('Location: admin-videos.php?error=File too large. Maximum size is 50MB.');
            exit;
        }
        
        // Generate unique filename for video
        $video_extension = pathinfo($video_file['name'], PATHINFO_EXTENSION);
        $video_filename = uniqid() . '_' . time() . '.' . $video_extension;
        $video_destination = VIDEO_UPLOAD_PATH . $video_filename;
        
        // Handle thumbnail upload
        $thumbnail_filename = null;
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnail_file = $_FILES['thumbnail'];
            $allowed_thumb_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            if (in_array($thumbnail_file['type'], $allowed_thumb_types)) {
                $thumb_extension = pathinfo($thumbnail_file['name'], PATHINFO_EXTENSION);
                $thumbnail_filename = 'thumb_' . uniqid() . '_' . time() . '.' . $thumb_extension;
                $thumb_destination = GALLERY_UPLOAD_PATH . $thumbnail_filename;
                
                if (!move_uploaded_file($thumbnail_file['tmp_name'], $thumb_destination)) {
                    $thumbnail_filename = null;
                }
            }
        }
        
        // Move uploaded video
        if (move_uploaded_file($video_file['tmp_name'], $video_destination)) {
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO videos (title, description, video_path, thumbnail_path, category, duration) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $video_filename, $thumbnail_filename, $category, $duration]);
            
            header('Location: admin-videos.php?success=Video uploaded successfully');
            exit;
        } else {
            header('Location: admin-videos.php?error=Failed to upload video');
            exit;
        }
    } else {
        header('Location: admin-videos.php?error=Please select a video file');
        exit;
    }
} else {
    header('Location: admin-videos.php');
    exit;
}
?>