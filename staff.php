<?php
$pageTitle = "Our Staff";
require_once 'includes/config.php';
include 'includes/header.php';

// Get all staff members
$stmt = $pdo->query("SELECT * FROM staff ORDER BY name");
$staff = $stmt->fetchAll();
?>

<!-- Staff Section -->
<section class="coaches" style="padding-top: 150px;">
    <div class="container">
        <h2>Our Crew</h2>
        
        <?php if (empty($staff)): ?>
            <div style="text-align: center; padding: 40px;">
                <h3>No Staff Members</h3>
                <p>Our coaching team information will be available soon.</p>
            </div>
        <?php else: ?>
         <div class="staff-grid">
    <?php foreach ($staff as $member): ?>
    <div class="staff-card">
        <div class="staff-image">
            <img src="<?php echo getStaffImage($member['image_path']); ?>" 
                 alt="<?php echo htmlspecialchars($member['name']); ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
        </div>
        <div class="staff-info">
            <h3><?php echo htmlspecialchars($member['name']); ?></h3>
            <p class="staff-role"><?php echo htmlspecialchars($member['role']); ?></p>
            <?php if (!empty($member['bio'])): ?>
                <p><?php echo htmlspecialchars($member['bio']); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>