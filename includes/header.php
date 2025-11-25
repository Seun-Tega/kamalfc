<?php
// Start session and include config if not already included
if (!isset($pdo)) {
    require_once 'config.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' : ''; ?>Kamal Football Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/players.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="image/logo.jpg" alt="Kamal Football Academy Logo" onerror="this.style.display='none'" style="height: 40px;width: 40px;">
                <h1>Kamal <span>Football</span> Academy</h1>
            </div>
            <nav>
                <div class="mobile-menu">
                    <i class="fas fa-bars"></i>
                </div>
                <ul>
                    <li><a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>Home</a></li>
                    <li><a href="about.php" <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'class="active"' : ''; ?>>About</a></li>
                    <li><a href="programs.php" <?php echo basename($_SERVER['PHP_SELF']) == 'programs.php' ? 'class="active"' : ''; ?>>Programs</a></li>
                    <li><a href="players.php" <?php echo basename($_SERVER['PHP_SELF']) == 'players.php' ? 'class="active"' : ''; ?>>Players</a></li>
                    <li><a href="matches.php" <?php echo basename($_SERVER['PHP_SELF']) == 'matches.php' ? 'class="active"' : ''; ?>>Matches</a></li>
                    <li><a href="staff.php" <?php echo basename($_SERVER['PHP_SELF']) == 'staff.php' ? 'class="active"' : ''; ?>>Crew</a></li>
                    <li><a href="contact.php" <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : ''; ?>>Contact</a></li>
                    <li><a href="register.php" <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'class="active"' : ''; ?>>Register</a></li>
                    <li><a href="admin-login.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin-login.php' || strpos($_SERVER['PHP_SELF'], 'admin-') !== false ? 'class="active"' : ''; ?>>Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>