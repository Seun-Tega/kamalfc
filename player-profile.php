<?php
$pageTitle = "Player Profile";
require_once 'includes/config.php';
include 'includes/header.php';

// Check if player ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: players.php');
    exit();
}

$player_id = (int)$_GET['id'];

// Get player details
$stmt = $pdo->prepare("SELECT * FROM players WHERE id = ? AND status = 'approved'");
$stmt->execute([$player_id]);
$player = $stmt->fetch();

// If player not found or not approved, redirect
if (!$player) {
    header('Location: players.php');
    exit();
}
?>

<!-- Player Profile Section -->
<section class="players-page" style="padding-top: 150px;">
    <div class="container">
        <div class="player-profile-header">
            <a href="players.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Players
            </a>
            <h2>Player Profile</h2>
        </div>

        <div class="player-profile-content">
            <div class="profile-main">
                <div class="profile-image-section">
                    <div class="profile-image">
                        <img src="<?php echo getPlayerImage($player['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($player['name']); ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
                    </div>
                    <div class="player-badge-large"><?php echo htmlspecialchars($player['age_group']); ?></div>
                </div>

                <div class="profile-details">
                    <h1><?php echo htmlspecialchars($player['name']); ?></h1>
                    <p class="player-position-large"><?php echo htmlspecialchars($player['position']); ?></p>
                    
                    <div class="profile-stats">
                        <?php if ($player['position'] == 'Goalkeeper'): ?>
                            <div class="stat-card">
                                <div class="stat-number"><?php echo $player['clean_sheets']; ?></div>
                                <div class="stat-label">Clean Sheets</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number"><?php echo $player['matches_played']; ?></div>
                                <div class="stat-label">Matches Played</div>
                            </div>
                        <?php else: ?>
                            <div class="stat-card">
                                <div class="stat-number"><?php echo $player['goals']; ?></div>
                                <div class="stat-label">Goals</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number"><?php echo $player['assists']; ?></div>
                                <div class="stat-label">Assists</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number"><?php echo $player['matches_played']; ?></div>
                                <div class="stat-label">Matches Played</div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($player['height']) || !empty($player['weight'])): ?>
                    <div class="physical-info">
                        <h3>Physical Attributes</h3>
                        <div class="physical-grid">
                            <?php if (!empty($player['height'])): ?>
                            <div class="physical-item">
                                <i class="fas fa-ruler-vertical"></i>
                                <span class="label">Height:</span>
                                <span class="value"><?php echo $player['height']; ?> cm</span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($player['weight'])): ?>
                            <div class="physical-item">
                                <i class="fas fa-weight"></i>
                                <span class="label">Weight:</span>
                                <span class="value"><?php echo $player['weight']; ?> kg</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($player['bio'])): ?>
            <div class="player-bio-section">
                <h3>About <?php echo htmlspecialchars(explode(' ', $player['name'])[0]); ?></h3>
                <div class="bio-content">
                    <?php echo nl2br(htmlspecialchars($player['bio'])); ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="player-additional-info">
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-tshirt"></i>
                        <div class="info-content">
                            <span class="info-label">Preferred Position</span>
                            <span class="info-value"><?php echo htmlspecialchars($player['position']); ?></span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-users"></i>
                        <div class="info-content">
                            <span class="info-label">Age Group</span>
                            <span class="info-value"><?php echo htmlspecialchars($player['age_group']); ?> Team</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-shoe-prints"></i>
                        <div class="info-content">
                            <span class="info-label">Strong Foot</span>
                            <span class="info-value"><?php echo !empty($player['strong_foot']) ? htmlspecialchars($player['strong_foot']) : 'Right'; ?></span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="info-content">
                            <span class="info-label">Joined Academy</span>
                            <span class="info-value">
                                <?php echo !empty($player['joined_date']) ? date('F Y', strtotime($player['joined_date'])) : 'Recent'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>