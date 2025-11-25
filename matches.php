<?php
$pageTitle = "Matches & Fixtures";
include 'includes/header.php';

// Get upcoming matches
$upcoming_matches = $pdo->query("SELECT * FROM matches WHERE status = 'upcoming' ORDER BY match_date ASC")->fetchAll();

// Get completed matches
$completed_matches = $pdo->query("SELECT * FROM matches WHERE status = 'completed' ORDER BY match_date DESC LIMIT 10")->fetchAll();
?>

<!-- Matches Section -->
<section class="facilities" style="padding-top: 150px;">
    <div class="container">
        <h2>Matches & Fixtures</h2>
        
        <!-- Upcoming Matches -->
        <div style="margin-bottom: 60px;">
            <h3 style="text-align: center; margin-bottom: 30px; color: var(--primary);">Upcoming Matches</h3>
            
            <?php if (empty($upcoming_matches)): ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
                    <h4>No Upcoming Matches</h4>
                    <p>Check back later for upcoming fixtures.</p>
                </div>
            <?php else: ?>
                <div class="matches-container">
                    <?php foreach ($upcoming_matches as $match): ?>
                    <div class="match-card">
                        <div class="match-header">
                            <h3><?php echo ucfirst($match['match_type']); ?> Match</h3>
                            <p><?php echo date('l, F j, Y', strtotime($match['match_date'])); ?> | <?php echo date('g:i A', strtotime($match['match_time'])); ?></p>
                        </div>
                        <div class="match-teams">
                            <div class="team">
                                <div class="team-logo">KFA</div>
                                <h4>Kamal FA</h4>
                            </div>
                            <div class="vs">VS</div>
                            <div class="team">
                                <div class="team-logo"><?php echo substr($match['opponent'], 0, 3); ?></div>
                                <h4><?php echo htmlspecialchars($match['opponent']); ?></h4>
                            </div>
                        </div>
                        <div class="match-details">
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($match['venue']); ?></p>
                            <p><i class="fas fa-calendar"></i> <?php echo date('M j, Y', strtotime($match['match_date'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Recent Results -->
        <div>
            <h3 style="text-align: center; margin-bottom: 30px; color: var(--primary);">Recent Results</h3>
            
            <?php if (empty($completed_matches)): ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
                    <h4>No Match Results</h4>
                    <p>Match results will appear here once available.</p>
                </div>
            <?php else: ?>
                <div class="matches-container">
                    <?php foreach ($completed_matches as $match): ?>
                    <div class="match-card">
                        <div class="match-header" style="background: var(--secondary);">
                            <h3><?php echo ucfirst($match['match_type']); ?> Match - Result</h3>
                            <p><?php echo date('l, F j, Y', strtotime($match['match_date'])); ?></p>
                        </div>
                        <div class="match-teams">
                            <div class="team">
                                <div class="team-logo">EFA</div>
                                <h4>Elite FA</h4>
                                <div class="match-score"><?php echo $match['our_score']; ?></div>
                            </div>
                            <div class="vs">VS</div>
                            <div class="team">
                                <div class="team-logo"><?php echo substr($match['opponent'], 0, 3); ?></div>
                                <h4><?php echo htmlspecialchars($match['opponent']); ?></h4>
                                <div class="match-score"><?php echo $match['opponent_score']; ?></div>
                            </div>
                        </div>
                        <div class="match-details">
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($match['venue']); ?></p>
                            <p><strong>Status:</strong> Completed</p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>