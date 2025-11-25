<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) {
    $video_id = $_POST['video_id'];
    
    // Get video info
    $stmt = $pdo->prepare("SELECT video_path, thumbnail_path FROM videos WHERE id = ?");
    $stmt->execute([$video_id]);
    $video = $stmt->fetch();
    
    if ($video) {
        // Delete video file
        $video_path = VIDEO_UPLOAD_PATH . $video['video_path'];
        if (file_exists($video_path)) {
            unlink($video_path);
        }
        
        // Delete thumbnail file if exists
        if ($video['thumbnail_path']) {
            $thumb_path = GALLERY_UPLOAD_PATH . $video['thumbnail_path'];
            if (file_exists($thumb_path)) {
                unlink($thumb_path);
            }
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
        $stmt->execute([$video_id]);
        
        header('Location: admin-videos.php?success=Video deleted successfully');
        exit;
    }
}

header('Location: admin-videos.php');
exit;
?>