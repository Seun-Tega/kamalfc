<!-- Admin Sidebar -->
<div class="admin-sidebar">
    <h3>Admin Panel</h3>
    <ul class="admin-nav">
        <li><a href="admin-dashboard.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'class="active"' : ''; ?>><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="admin-players.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin-players.php' ? 'class="active"' : ''; ?>><i class="fas fa-users"></i> Manage Players</a></li>
        <li><a href="admin-matches.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin-matches.php' ? 'class="active"' : ''; ?>><i class="fas fa-futbol"></i> Manage Matches</a></li>
        <li><a href="admin-staff.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin-staff.php' ? 'class="active"' : ''; ?>><i class="fas fa-user-tie"></i> Manage Staff</a></li>
        <li><a href="admin-content.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin-content.php' ? 'class="active"' : ''; ?>><i class="fas fa-edit"></i> Manage Content</a></li>
        <li><a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>