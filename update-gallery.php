<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE gallery SET status = ? WHERE id = ?");
    $stmt->execute([$status, $image_id]);
    
    header('Location: admin-gallery.php?success=Image status updated');
    exit;
} else {
    header('Location: admin-gallery.php');
    exit;
}
?>