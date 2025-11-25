<?php
$pageTitle = "Arrange Staff Order";
require_once 'includes/auth.php';
requireAuth();
include 'includes/header.php';

// Handle AJAX order update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $order = json_decode($_POST['order'], true);
    
    foreach ($order as $position => $staff_id) {
        $stmt = $pdo->prepare("UPDATE staff SET display_order = ? WHERE id = ?");
        $stmt->execute([$position, $staff_id]);
    }
    echo "Staff order updated successfully!";
    exit();
}

// Get all staff members ordered by current display order
$stmt = $pdo->query("SELECT * FROM staff ORDER BY display_order ASC, name ASC");
$staff = $stmt->fetchAll();
?>

<!-- Admin Panel -->
<section class="admin-panel">
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <h3>Admin Panel</h3>
            <ul class="admin-nav">
                <li><a href="admin-dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin-players.php"><i class="fas fa-users"></i> Manage Players</a></li>
                <li><a href="admin-matches.php"><i class="fas fa-futbol"></i> Manage Matches</a></li>
                <li><a href="admin-staff.php"><i class="fas fa-user-tie"></i> Manage Staff</a></li>
                <li><a href="admin-staff-order.php" class="active"><i class="fas fa-sort"></i> Arrange Staff Order</a></li>
                <li><a href="admin-gallery.php"><i class="fas fa-images"></i> Manage Gallery</a></li>
                <li><a href="admin-videos.php"><i class="fas fa-video"></i> Manage Videos</a></li>
                <li><a href="admin-content.php"><i class="fas fa-edit"></i> Manage Content</a></li>
                <li><a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="admin-content">
            <div class="admin-header">
                <h2>Arrange Staff Display Order</h2>
                <p>Drag and drop staff members to set their display order on the website</p>
            </div>

            <div class="admin-card">
                <h3>Staff Members</h3>
                <div id="message" style="margin: 15px 0;"></div>
                
                <div class="staff-order-container">
                    <div id="staffList" class="staff-order-list">
                        <?php foreach ($staff as $index => $member): ?>
                        <div class="staff-order-item" data-id="<?php echo $member['id']; ?>">
                            <div class="staff-order-handle">
                                <i class="fas fa-bars"></i>
                            </div>
                            <img src="<?php echo getStaffImage($member['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($member['name']); ?>" 
                                 class="staff-order-image"
                                 onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
                            <div class="staff-order-info">
                                <h4><?php echo htmlspecialchars($member['name']); ?></h4>
                                <p class="staff-order-role"><?php echo htmlspecialchars($member['role']); ?></p>
                                <?php if (!empty($member['bio'])): ?>
                                    <p class="staff-order-bio">
                                        <?php echo htmlspecialchars(substr($member['bio'], 0, 100)); ?>
                                        <?php if (strlen($member['bio']) > 100): ?>...<?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="staff-order-position">
                                Position: <span class="position-number"><?php echo $index + 1; ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="admin-actions" style="margin-top: 30px;">
                    <button onclick="saveStaffOrder()" class="btn" style="background: var(--primary); color: white;">
                        <i class="fas fa-save"></i> Save New Order
                    </button>
                    <a href="admin-staff.php" class="btn" style="background: var(--gray); color: white;">
                        <i class="fas fa-arrow-left"></i> Back to Staff Management
                    </a>
                    <a href="staff.php" class="btn" style="background: var(--accent); color: white;">
                        <i class="fas fa-eye"></i> View Live Staff Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
// Initialize drag & drop
const staffList = document.getElementById('staffList');
const sortable = new Sortable(staffList, {
    handle: '.staff-order-handle',
    ghostClass: 'staff-order-ghost',
    chosenClass: 'staff-order-chosen',
    animation: 150,
    onUpdate: function() {
        updatePositionNumbers();
    }
});

// Update position numbers visually
function updatePositionNumbers() {
    const items = staffList.getElementsByClassName('staff-order-item');
    for (let i = 0; i < items.length; i++) {
        const positionSpan = items[i].querySelector('.position-number');
        if (positionSpan) {
            positionSpan.textContent = i + 1;
        }
    }
}

// Save order to database
function saveStaffOrder() {
    const order = [];
    const items = staffList.getElementsByClassName('staff-order-item');
    
    for (let i = 0; i < items.length; i++) {
        order.push(items[i].getAttribute('data-id'));
    }
    
    // Show loading state
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '<div style="padding: 10px; background: #e2f0ff; color: #004085; border-radius: 4px;">Saving order...</div>';
    
    // Send AJAX request
    fetch('admin-staff-order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'order=' + JSON.stringify(order)
    })
    .then(response => response.text())
    .then(data => {
        messageDiv.innerHTML = '<div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 4px;">' + data + '</div>';
        
        // Update position numbers after save
        updatePositionNumbers();
        
        // Hide message after 3 seconds
        setTimeout(() => {
            messageDiv.innerHTML = '';
        }, 3000);
    })
    .catch(error => {
        messageDiv.innerHTML = '<div style="padding: 10px; background: #f8d7da; color: #721c24; border-radius: 4px;">Error saving order. Please try again.</div>';
        console.error('Error:', error);
    });
}

// Auto-save when order changes (optional)
// sortable.option('onEnd', function() {
//     saveStaffOrder();
// });
</script>

<style>
.staff-order-container {
    background: white;
    border-radius: 8px;
    border: 1px solid var(--border);
    margin: 20px 0;
}

.staff-order-list {
    padding: 20px;
}

.staff-order-item {
    display: flex;
    align-items: center;
    padding: 15px;
    margin: 10px 0;
    background: var(--light);
    border-radius: 8px;
    border: 2px solid var(--border);
    cursor: move;
    transition: all 0.3s ease;
}

.staff-order-item.staff-order-ghost {
    opacity: 0.6;
    background: var(--primary);
    color: white;
}

.staff-order-item.staff-order-chosen {
    transform: scale(1.02);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.staff-order-handle {
    margin-right: 15px;
    color: var(--gray);
    font-size: 1.2rem;
    cursor: move;
    padding: 10px;
}

.staff-order-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
    border: 2px solid var(--primary);
}

.staff-order-info {
    flex: 1;
}

.staff-order-info h4 {
    color: var(--primary);
    margin-bottom: 5px;
    font-size: 1.1rem;
}

.staff-order-role {
    color: var(--secondary);
    font-weight: 600;
    margin-bottom: 5px !important;
}

.staff-order-bio {
    color: var(--gray);
    font-size: 0.9rem;
    margin-bottom: 0 !important;
}

.staff-order-position {
    background: var(--accent);
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-left: 15px;
}

.admin-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
</style>

<?php
// Handle logout
if (isset($_GET['logout'])) {
    logout();
}
include 'includes/footer.php';
?>