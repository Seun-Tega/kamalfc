<?php
$pageTitle = "Manage Matches";
require_once 'includes/auth.php';
requireAuth();
include 'includes/header.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_match'])) {
        $match_type = $_POST['match_type'];
        $opponent = $_POST['opponent'];
        $match_date = $_POST['match_date'];
        $match_time = $_POST['match_time'];
        $venue = $_POST['venue'];
        $our_score = $_POST['our_score'] ?? null;
        $opponent_score = $_POST['opponent_score'] ?? null;
        $status = $_POST['status'];
        
        $stmt = $pdo->prepare("INSERT INTO matches (match_type, opponent, match_date, match_time, venue, our_score, opponent_score, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$match_type, $opponent, $match_date, $match_time, $venue, $our_score, $opponent_score, $status]);
        $success = "Match added successfully!";
    }
    
    if (isset($_POST['update_match'])) {
        $match_id = $_POST['match_id'];
        $our_score = $_POST['our_score'];
        $opponent_score = $_POST['opponent_score'];
        $status = $_POST['status'];
        
        $stmt = $pdo->prepare("UPDATE matches SET our_score = ?, opponent_score = ?, status = ? WHERE id = ?");
        $stmt->execute([$our_score, $opponent_score, $status, $match_id]);
        $success = "Match updated successfully!";
    }
    
    if (isset($_POST['delete_match'])) {
        $match_id = $_POST['match_id'];
        $stmt = $pdo->prepare("DELETE FROM matches WHERE id = ?");
        $stmt->execute([$match_id]);
        $success = "Match deleted successfully!";
    }
}

// Get all matches
$matches = $pdo->query("SELECT * FROM matches ORDER BY match_date DESC")->fetchAll();
?>

<section class="admin-panel">
    <div class="admin-container">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Matches</h2>
            </div>

            <?php if (isset($success)): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <h3>Add New Match</h3>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Match Type</label>
                            <select name="match_type" class="form-control" required>
                                <option value="league">League</option>
                                <option value="friendly">Friendly</option>
                                <option value="tournament">Tournament</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Opponent</label>
                            <input type="text" name="opponent" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Match Date</label>
                            <input type="date" name="match_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Match Time</label>
                            <input type="time" name="match_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Venue</label>
                            <input type="text" name="venue" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Our Score (if completed)</label>
                            <input type="number" name="our_score" class="form-control" min="0">
                        </div>
                        <div class="form-group">
                            <label>Opponent Score (if completed)</label>
                            <input type="number" name="opponent_score" class="form-control" min="0">
                        </div>
                    </div>
                    <button type="submit" name="add_match" class="btn">Add Match</button>
                </form>
            </div>

            <div class="admin-card">
                <h3>All Matches</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Opponent</th>
                                <th>Venue</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matches as $match): ?>
                            <tr>
                                <td><?php echo date('M j, Y', strtotime($match['match_date'])); ?></td>
                                <td><?php echo ucfirst($match['match_type']); ?></td>
                                <td><?php echo htmlspecialchars($match['opponent']); ?></td>
                                <td><?php echo htmlspecialchars($match['venue']); ?></td>
                                <td>
                                    <?php if ($match['status'] == 'completed'): ?>
                                        <?php echo $match['our_score'] . ' - ' . $match['opponent_score']; ?>
                                    <?php else: ?>
                                        vs
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; 
                                        background: <?php echo $match['status'] == 'upcoming' ? '#fff3cd' : ($match['status'] == 'completed' ? '#d1ecf1' : '#f8d7da'); ?>;
                                        color: <?php echo $match['status'] == 'upcoming' ? '#856404' : ($match['status'] == 'completed' ? '#0c5460' : '#721c24'); ?>;">
                                        <?php echo ucfirst($match['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="match_id" value="<?php echo $match['id']; ?>">
                                        <button type="submit" name="delete_match" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>