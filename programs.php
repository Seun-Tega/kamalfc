<?php
$pageTitle = "Our Programs";
include 'includes/header.php';

// Get all programs
$stmt = $pdo->query("SELECT * FROM programs ORDER BY id");
$programs = $stmt->fetchAll();
?>

<!-- Programs Section -->
<section class="programs" style="padding-top: 150px;">
    <div class="container">
        <h2>Our Training Programs</h2>
        <p style="text-align: center; max-width: 800px; margin: 0 auto 50px; font-size: 1.1rem;">
            We offer comprehensive football development programs for players of all ages and skill levels. 
            Each program is designed to maximize player potential through professional coaching and modern training methodologies.
        </p>
        
        <?php if (empty($programs)): ?>
            <div style="text-align: center; padding: 40px;">
                <h3>No Programs Available</h3>
                <p>Our program information will be available soon.</p>
            </div>
        <?php else: ?>
            <div class="programs-grid">
                <?php foreach ($programs as $program): ?>
                <div class="program-card">
                    <div class="program-image">
                       <img src="<?php echo getProgramImage($program['image_path']); ?>" alt="<?php echo htmlspecialchars($program['title']); ?>">
                    </div>
                    <div class="program-content">
                        <h3><?php echo htmlspecialchars($program['title']); ?></h3>
                        <p><strong>Age Group:</strong> <?php echo htmlspecialchars($program['age_group']); ?></p>
                        <p><?php echo htmlspecialchars($program['description']); ?></p>
                        <a href="register.php" class="btn">Register Now</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Additional Programs Info -->
        <div style="margin-top: 60px; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <h3 style="text-align: center; margin-bottom: 30px;">Program Features</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem;">
                        <i class="fas fa-futbol"></i>
                    </div>
                    <h4>Professional Coaching</h4>
                    <p>Qualified coaches with UEFA licenses and professional experience</p>
                </div>
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Player Development</h4>
                    <p>Individual development plans and progress tracking</p>
                </div>
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem;">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h4>Competitive Matches</h4>
                    <p>Regular league matches and tournament participation</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>