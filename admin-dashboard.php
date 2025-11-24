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
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <?php
                    // Get counts
                    $players_count = $pdo->query("SELECT COUNT(*) FROM players")->fetchColumn();
                    $matches_count = $pdo->query("SELECT COUNT(*) FROM matches WHERE status = 'upcoming'")->fetchColumn();
                    $staff_count = $pdo->query("SELECT COUNT(*) FROM staff")->fetchColumn();
                    $programs_count = $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn();
                    ?>
                    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;"><?php echo $players_count; ?></h3>
                        <p>Total Players</p>
                    </div>
                    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;"><?php echo $matches_count; ?></h3>
                        <p>Upcoming Matches</p>
                    </div>
                    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;"><?php echo $staff_count; ?></h3>
                        <p>Coaching Staff</p>
                    </div>
                    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;"><?php echo $programs_count; ?></h3>
                        <p>Active Programs</p>
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo date('Y-m-d'); ?></td>
                                <td>You logged in</td>
                                <td><?php echo htmlspecialchars($_SESSION['admin_username']); ?></td>
                            </tr>
                            <tr>
                                <td>2023-11-15</td>
                                <td>New player registered</td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td>2023-11-14</td>
                                <td>Match result updated</td>
                                <td>Coach John</td>
                            </tr>
                        </tbody>
                    </table>
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