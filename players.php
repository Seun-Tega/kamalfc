<?php
$pageTitle = "Our Players";
require_once 'includes/config.php';
include 'includes/header.php';

// Get only approved players
$stmt = $pdo->query("SELECT * FROM players WHERE status = 'approved' ORDER BY name");
$players = $stmt->fetchAll();
?>

<!-- Players Section -->
<section class="coaches" style="padding-top: 150px;">
    <div class="container">
        <h2>Our Players</h2>
        
        <div style="text-align: center; margin-bottom: 30px;">
            <a href="register.php" class="btn">Register as Player</a>
        </div>
        
        <?php if (empty($players)): ?>
            <div style="text-align: center; padding: 40px;">
                <h3>No Players Yet</h3>
                <p>Be the first to register and join our academy!</p>
                <a href="register.php" class="btn">Register Now</a>
            </div>
        <?php else: ?>
           <div class="players-grid">
    <?php foreach ($players as $player): ?>
    <div class="player-card">
        <div class="player-image">
            <img src="<?php echo getPlayerImage($player['image_path']); ?>" 
                 alt="<?php echo htmlspecialchars($player['name']); ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
        </div>
        <div class="player-info">
            <h3><?php echo htmlspecialchars($player['name']); ?></h3>
            <p><?php echo htmlspecialchars($player['position']); ?> | <?php echo htmlspecialchars($player['age_group']); ?> Team</p>
            
            <?php if ($player['position'] == 'Goalkeeper'): ?>
                <p><strong>Clean Sheets:</strong> <?php echo $player['clean_sheets']; ?></p>
            <?php else: ?>
                <p><strong>Goals:</strong> <?php echo $player['goals']; ?> | <strong>Assists:</strong> <?php echo $player['assists']; ?></p>
            <?php endif; ?>
            
            <?php if (!empty($player['height']) || !empty($player['weight'])): ?>
                <p>
                    <?php if (!empty($player['height'])): ?>
                        <strong>Height:</strong> <?php echo $player['height']; ?> cm
                    <?php endif; ?>
                    <?php if (!empty($player['height']) && !empty($player['weight'])): ?> | <?php endif; ?>
                    <?php if (!empty($player['weight'])): ?>
                        <strong>Weight:</strong> <?php echo $player['weight']; ?> kg
                    <?php endif; ?>
                </p>
            <?php endif; ?>
            
            <?php if (!empty($player['bio'])): ?>
                <p style="margin-top: 10px; font-size: 0.9em; color: #666; line-height: 1.4;">
                    <?php echo htmlspecialchars(substr($player['bio'], 0, 100)); ?>
                    <?php if (strlen($player['bio']) > 100): ?>...<?php endif; ?>
                </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Additional CSS for Players Page */
.players-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    padding: 20px 0;
}

.player-card {
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 2px solid var(--border);
    position: relative;
}

.player-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    border-color: var(--primary);
}

.player-image {
    height: 250px;
    overflow: hidden;
    position: relative;
    background: linear-gradient(135deg, var(--light) 0%, #e8f5e8 100%);
}

.player-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.player-card:hover .player-image img {
    transform: scale(1.08);
}

.player-info {
    padding: 20px;
}

.player-info h3 {
    margin-bottom: 8px;
    color: var(--primary);
    font-size: 1.3rem;
    font-weight: 600;
}

.player-info p {
    color: var(--text);
    margin-bottom: 8px;
    line-height: 1.5;
}

.player-info p:first-of-type {
    color: var(--secondary);
    font-weight: 500;
    font-size: 0.95rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .players-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .player-image {
        height: 220px;
    }
}

@media (max-width: 576px) {
    .players-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .player-card {
        margin: 0 10px;
    }
    
    .player-image {
        height: 200px;
    }
    
    .player-info {
        padding: 15px;
    }
}
</style>

<?php include 'includes/footer.php'; ?>