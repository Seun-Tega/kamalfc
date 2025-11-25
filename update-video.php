<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) {
    $video_id = $_POST['video_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE videos SET status = ? WHERE id = ?");
    $stmt->execute([$status, $video_id]);
    
    header('Location: admin-videos.php?success=Video status updated');
    exit;
} else {
    header('Location: admin-videos.php');
    exit;
}
?>