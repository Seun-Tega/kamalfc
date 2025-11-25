<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_gallery'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];
    
    // Validate input
    if (empty($title) || empty($category)) {
        header('Location: admin-gallery.php?error=Please fill all required fields');
        exit;
    }
    
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        // Validate file type
        if (!in_array($file['type'], $allowed_types)) {
            header('Location: admin-gallery.php?error=Invalid file type. Please upload JPG, PNG, or GIF images.');
            exit;
        }
        
        // Validate file size
        if ($file['size'] > $max_size) {
            header('Location: admin-gallery.php?error=File too large. Maximum size is 5MB.');
            exit;
        }
        
        // Generate unique filename
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $file_extension;
        $destination = GALLERY_UPLOAD_PATH . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO gallery (title, description, image_path, category) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $description, $filename, $category]);
            
            header('Location: admin-gallery.php?success=Image uploaded successfully');
            exit;
        } else {
            header('Location: admin-gallery.php?error=Failed to upload image');
            exit;
        }
    } else {
        header('Location: admin-gallery.php?error=Please select an image file');
        exit;
    }
} else {
    header('Location: admin-gallery.php');
    exit;
}
?>