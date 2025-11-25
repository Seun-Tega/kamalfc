<?php
$pageTitle = "Admin Dashboard";
require_once 'includes/auth.php';
requireAuth();
include 'includes/header.php';
?>

<!-- Admin Panel -->
<section class="admin-panel">
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <h3>Admin Panel</h3>
            <ul class="admin-nav">
                <li><a href="admin-dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin-players.php"><i class="fas fa-users"></i> Manage Players</a></li>
                <li><a href="admin-matches.php"><i class="fas fa-futbol"></i> Manage Matches</a></li>
                <li><a href="admin-staff.php"><i class="fas fa-user-tie"></i> Manage Staff</a></li>
                <li><a href="admin-gallery.php"><i class="fas fa-images"></i> Manage Gallery</a></li>
                <li><a href="admin-videos.php"><i class="fas fa-video"></i> Manage Videos</a></li>
                <li><a href="admin-content.php"><i class="fas fa-edit"></i> Manage Content</a></li>
                <li><a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="admin-content">
            <div class="admin-header">
                <h2>Dashboard</h2>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            </div>

            <div class="admin-card">
                <h3>Quick Stats</h3>
                <div class="stats-grid">
                    <?php
                    // Get counts
                    $players_count = $pdo->query("SELECT COUNT(*) FROM players")->fetchColumn();
                    $matches_count = $pdo->query("SELECT COUNT(*) FROM matches WHERE status = 'upcoming'")->fetchColumn();
                    $staff_count = $pdo->query("SELECT COUNT(*) FROM staff")->fetchColumn();
                    $programs_count = $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn();
                    $gallery_count = $pdo->query("SELECT COUNT(*) FROM gallery WHERE status = 'active'")->fetchColumn();
                    $videos_count = $pdo->query("SELECT COUNT(*) FROM videos WHERE status = 'active'")->fetchColumn();
                    ?>
                    <div class="stat-card">
                        <h3><?php echo $players_count; ?></h3>
                        <p>Total Players</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $matches_count; ?></h3>
                        <p>Upcoming Matches</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $staff_count; ?></h3>
                        <p>Coaching Staff</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $programs_count; ?></h3>
                        <p>Active Programs</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $gallery_count; ?></h3>
                        <p>Gallery Images</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $videos_count; ?></h3>
                        <p>Training Videos</p>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h3>Recent Activity</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Activity</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo date('Y-m-d H:i'); ?></td>
                                <td>Admin login</td>
                                <td><?php echo htmlspecialchars($_SESSION['admin_username']); ?></td>
                                <td><span class="status-badge success">Success</span></td>
                            </tr>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime('-1 day')); ?></td>
                                <td>New player registration</td>
                                <td>System</td>
                                <td><span class="status-badge info">Pending</span></td>
                            </tr>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime('-2 days')); ?></td>
                                <td>Gallery image uploaded</td>
                                <td><?php echo htmlspecialchars($_SESSION['admin_username']); ?></td>
                                <td><span class="status-badge success">Completed</span></td>
                            </tr>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime('-3 days')); ?></td>
                                <td>Match schedule updated</td>
                                <td>Coach</td>
                                <td><span class="status-badge warning">In Progress</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-card">
                <h3>Quick Actions</h3>
                <div class="quick-actions">
                    <a href="admin-players.php" class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        <span>Add New Player</span>
                    </a>
                    <a href="admin-matches.php" class="action-btn">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Schedule Match</span>
                    </a>
                    <a href="admin-gallery.php" class="action-btn">
                        <i class="fas fa-upload"></i>
                        <span>Upload Images</span>
                    </a>
                    <a href="admin-videos.php" class="action-btn">
                        <i class="fas fa-video"></i>
                        <span>Upload Video</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Handle logout
if (isset($_GET['logout'])) {
    logout();
}
include 'includes/footer.php';
?>