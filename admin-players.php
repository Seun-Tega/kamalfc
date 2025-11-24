<?php
$pageTitle = "Manage Players";
require_once 'includes/auth.php';
requireAuth();
include 'includes/header.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve_player'])) {
        $player_id = $_POST['player_id'];
        $stmt = $pdo->prepare("UPDATE players SET status = 'approved', approved_at = NOW(), approved_by = ? WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id'], $player_id]);
        $success = "Player approved successfully!";
    }
    
    if (isset($_POST['reject_player'])) {
        $player_id = $_POST['player_id'];
        $stmt = $pdo->prepare("UPDATE players SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$player_id]);
        $success = "Player rejected successfully!";
    }
    
    if (isset($_POST['delete_player'])) {
        $player_id = $_POST['player_id'];
        
        // Get image path to delete file
        $stmt = $pdo->prepare("SELECT image_path FROM players WHERE id = ?");
        $stmt->execute([$player_id]);
        $player = $stmt->fetch();
        
        if ($player && $player['image_path']) {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/elite-football-academy/' . $player['image_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $stmt = $pdo->prepare("DELETE FROM players WHERE id = ?");
        $stmt->execute([$player_id]);
        $success = "Player deleted successfully!";
    }
    
    if (isset($_POST['update_stats'])) {
        $player_id = $_POST['player_id'];
        $goals = $_POST['goals'];
        $assists = $_POST['assists'];
        $clean_sheets = $_POST['clean_sheets'];
        
        $stmt = $pdo->prepare("UPDATE players SET goals = ?, assists = ?, clean_sheets = ? WHERE id = ?");
        $stmt->execute([$goals, $assists, $clean_sheets, $player_id]);
        $success = "Player stats updated successfully!";
    }
}

// Get players based on filter
$filter = $_GET['filter'] ?? 'all';
$query = "SELECT p.*, a.username as approved_by_name FROM players p LEFT JOIN admin_users a ON p.approved_by = a.id";

switch ($filter) {
    case 'pending':
        $query .= " WHERE p.status = 'pending'";
        break;
    case 'approved':
        $query .= " WHERE p.status = 'approved'";
        break;
    case 'rejected':
        $query .= " WHERE p.status = 'rejected'";
        break;
    default:
        $query .= " WHERE 1=1";
}

$query .= " ORDER BY p.registration_date DESC";
$players = $pdo->query($query)->fetchAll();

// Get counts for dashboard
$pending_count = $pdo->query("SELECT COUNT(*) FROM players WHERE status = 'pending'")->fetchColumn();
$approved_count = $pdo->query("SELECT COUNT(*) FROM players WHERE status = 'approved'")->fetchColumn();
$rejected_count = $pdo->query("SELECT COUNT(*) FROM players WHERE status = 'rejected'")->fetchColumn();
$total_count = $pdo->query("SELECT COUNT(*) FROM players")->fetchColumn();
?>

<section class="admin-panel">
    <div class="admin-container">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Players</h2>
                <div>
                    <a href="?filter=all" class="btn <?php echo $filter == 'all' ? 'active' : 'btn-outline'; ?>" style="margin-right: 5px;">All (<?php echo $total_count; ?>)</a>
                    <a href="?filter=pending" class="btn <?php echo $filter == 'pending' ? 'active' : 'btn-outline'; ?>" style="margin-right: 5px;">Pending (<?php echo $pending_count; ?>)</a>
                    <a href="?filter=approved" class="btn <?php echo $filter == 'approved' ? 'active' : 'btn-outline'; ?>" style="margin-right: 5px;">Approved (<?php echo $approved_count; ?>)</a>
                    <a href="?filter=rejected" class="btn <?php echo $filter == 'rejected' ? 'active' : 'btn-outline'; ?>">Rejected (<?php echo $rejected_count; ?>)</a>
                </div>
            </div>

            <?php if (isset($success)): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <h3>Player Registrations (<?php echo ucfirst($filter); ?>)</h3>
                
                <?php if (empty($players)): ?>
                    <p>No players found.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Player Info</th>
                                    <th>Contact</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players as $player): ?>
                                <tr>
                                    <td>
    <?php 
    // Use the helper function to get correct image URL
    $player_image = getPlayerImage($player['image_path']);
    ?>
    <img src="<?php echo $player_image; ?>" 
         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;"
         alt="<?php echo htmlspecialchars($player['name']); ?>"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
    <div style="display: none; width: 60px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
        <i class="fas fa-user"></i>
    </div>
</td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($player['name']); ?></strong><br>
                                        <small>Position: <?php echo htmlspecialchars($player['position']); ?></small><br>
                                        <small>Age Group: <?php echo htmlspecialchars($player['age_group']); ?></small><br>
                                        <small>Registered: <?php echo date('M j, Y', strtotime($player['registration_date'])); ?></small>
                                    </td>
                                    <td>
                                        <small>Email: <?php echo htmlspecialchars($player['email']); ?></small><br>
                                        <small>Phone: <?php echo htmlspecialchars($player['phone']); ?></small><br>
                                        <small>Emergency: <?php echo htmlspecialchars($player['emergency_contact_name']); ?> (<?php echo htmlspecialchars($player['emergency_contact_phone']); ?>)</small>
                                    </td>
                                    <td>
                                        <small>DOB: <?php echo date('M j, Y', strtotime($player['date_of_birth'])); ?></small><br>
                                        <small>Height: <?php echo $player['height'] ? $player['height'] . ' cm' : 'N/A'; ?></small><br>
                                        <small>Weight: <?php echo $player['weight'] ? $player['weight'] . ' kg' : 'N/A'; ?></small><br>
                                        <?php if ($player['medical_conditions']): ?>
                                            <small style="color: #dc3545;">Medical: Yes</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; 
                                            background: <?php echo $player['status'] == 'approved' ? '#d4edda' : ($player['status'] == 'pending' ? '#fff3cd' : '#f8d7da'); ?>;
                                            color: <?php echo $player['status'] == 'approved' ? '#155724' : ($player['status'] == 'pending' ? '#856404' : '#721c24'); ?>;">
                                            <?php echo ucfirst($player['status']); ?>
                                        </span>
                                        <?php if ($player['status'] == 'approved' && $player['approved_by_name']): ?>
                                            <br><small>By: <?php echo htmlspecialchars($player['approved_by_name']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <?php if ($player['status'] == 'pending'): ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                                                    <button type="submit" name="approve_player" class="action-btn edit-btn">Approve</button>
                                                </form>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                                                    <button type="submit" name="reject_player" class="action-btn delete-btn">Reject</button>
                                                </form>
                                            <?php elseif ($player['status'] == 'approved'): ?>
                                                <button type="button" class="action-btn edit-btn" onclick="openStatsModal(<?php echo $player['id']; ?>, <?php echo $player['goals']; ?>, <?php echo $player['assists']; ?>, <?php echo $player['clean_sheets']; ?>)">Update Stats</button>
                                            <?php endif; ?>
                                            
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                                                <button type="submit" name="delete_player" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this player?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Stats Update Modal -->
<div id="statsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 8px; width: 90%; max-width: 400px;">
        <h3>Update Player Stats</h3>
        <form method="POST" id="statsForm">
            <input type="hidden" name="player_id" id="modalPlayerId">
            <div class="form-group">
                <label>Goals</label>
                <input type="number" name="goals" id="modalGoals" class="form-control" min="0">
            </div>
            <div class="form-group">
                <label>Assists</label>
                <input type="number" name="assists" id="modalAssists" class="form-control" min="0">
            </div>
            <div class="form-group">
                <label>Clean Sheets</label>
                <input type="number" name="clean_sheets" id="modalCleanSheets" class="form-control" min="0">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" name="update_stats" class="btn">Update Stats</button>
                <button type="button" class="btn btn-outline" onclick="closeStatsModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStatsModal(playerId, goals, assists, cleanSheets) {
    document.getElementById('modalPlayerId').value = playerId;
    document.getElementById('modalGoals').value = goals;
    document.getElementById('modalAssists').value = assists;
    document.getElementById('modalCleanSheets').value = cleanSheets;
    document.getElementById('statsModal').style.display = 'flex';
}

function closeStatsModal() {
    document.getElementById('statsModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('statsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatsModal();
    }
});
</script>

<?php include 'includes/footer.php'; ?>