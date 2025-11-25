<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];
    
    // Get image info
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch();
    
    if ($image) {
        // Delete file
        $file_path = GALLERY_UPLOAD_PATH . $image['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$image_id]);
        
        header('Location: admin-gallery.php?success=Image deleted successfully');
        exit;
    }
}

header('Location: admin-gallery.php');
exit;
?>