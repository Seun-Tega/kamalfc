<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'academy_db');
define('DB_USER', 'chaomwdk_trip');
define('DB_PASS', 'Trip@1234');

// Website configuration
define('SITE_URL', 'http://localhost/elite-football-academy');
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/elite-football-academy/');

// File upload paths
define('UPLOAD_PATH', SITE_ROOT . 'uploads/');
define('PLAYER_UPLOAD_PATH', UPLOAD_PATH . 'players/');
define('STAFF_UPLOAD_PATH', UPLOAD_PATH . 'staff/');
define('PROGRAM_UPLOAD_PATH', UPLOAD_PATH . 'programs/');
define('PLAYER_UPLOAD_URL', '/elite-football-academy/uploads/players/');
define('STAFF_UPLOAD_URL', '/elite-football-academy/uploads/staff/');
define('PROGRAM_UPLOAD_URL', '/elite-football-academy/uploads/programs/');

// Create database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// Create upload directories if they don't exist
$directories = [UPLOAD_PATH, PLAYER_UPLOAD_PATH, STAFF_UPLOAD_PATH, PROGRAM_UPLOAD_PATH];
foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Player image helper function
function getPlayerImage($image_filename) {
    if (!empty($image_filename)) {
        $full_path = PLAYER_UPLOAD_PATH . $image_filename;
        if (file_exists($full_path)) {
            return PLAYER_UPLOAD_URL . $image_filename;
        }
    }
    // Default image
    return 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80';
}

// Program image helper function
function getProgramImage($image_filename) {
    if (!empty($image_filename)) {
        $full_path = PROGRAM_UPLOAD_PATH . $image_filename;
        if (file_exists($full_path)) {
            return PROGRAM_UPLOAD_URL . $image_filename;
        }
    }
    // Default program image
    return 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80';
}

// Staff image helper function
function getStaffImage($image_filename) {
    if (!empty($image_filename)) {
        $full_path = STAFF_UPLOAD_PATH . $image_filename;
        if (file_exists($full_path)) {
            return STAFF_UPLOAD_URL . $image_filename;
        }
    }
    // Default staff image
    return 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80';
}
?>