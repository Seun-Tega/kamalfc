<?php
session_start();
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrange Staff Order - Admin</title>
    <link rel="stylesheet" href="../css/players.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <style>
        .admin-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 100px 20px 40px;
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .staff-order-list {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        
        .staff-item {
            display: flex;
            align-items: center;
            padding: 20px;
            margin: 15px 0;
            background: var(--light);
            border-radius: 10px;
            border: 2px solid var(--border);
            cursor: move;
            transition: all 0.3s ease;
        }
        
        .staff-item.sortable-ghost {
            opacity: 0.6;
            background: var(--primary);
            color: white;
        }
        
        .staff-item.sortable-chosen {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .handle {
            margin-right: 20px;
            color: var(--gray);
            font-size: 1.3rem;
            cursor: move;
            padding: 10px;
        }
        
        .staff-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
            border: 3px solid var(--primary);
        }
        
        .staff-info {
            flex: 1;
        }
        
        .staff-info h3 {
            color: var(--primary);
            margin-bottom: 5px;
            font-size: 1.3rem;
        }
        
        .staff-role {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 8px !important;
        }
        
        .order-badge {
            background: var(--accent);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-left: 15px;
        }
        
        .admin-actions {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-success {
            background: var(--primary);
            color: white;
        }
        
        .btn-secondary {
            background: var(--gray);
            color: white;
        }
        
        #message {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .message-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .instructions {
            text-align: center;
            color: var(--gray);
            margin-bottom: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <div class="admin-header">
            <h1>Arrange Staff Display Order</h1>
            <p class="instructions">Drag and drop staff members to set their display order on the website</p>
        </div>
        
        <div id="message"></div>
        
        <div class="staff-order-list">
            <div id="staffList">
                <?php foreach ($staff as $index => $member): ?>
                <div class="staff-item" data-id="<?php echo $member['id']; ?>">
                    <div class="handle">
                        <i class="fas fa-bars"></i>
                    </div>
                    <img src="<?php echo getStaffImage($member['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($member['name']); ?>" 
                         class="staff-image"
                         onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
                    <div class="staff-info">
                        <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                        <p class="staff-role"><?php echo htmlspecialchars($member['role']); ?></p>
                        <?php if (!empty($member['bio'])): ?>
                            <p style="color: var(--text); font-size: 0.9rem;">
                                <?php echo htmlspecialchars(substr($member['bio'], 0, 100)); ?>
                                <?php if (strlen($member['bio']) > 100): ?>...<?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="order-badge">
                        Position: <?php echo $index + 1; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="admin-actions">
            <button onclick="saveOrder()" class="btn btn-success">
                <i class="fas fa-save"></i> Save New Order
            </button>
            <a href="staff.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Staff Management
            </a>
            <a href="../staff.php" class="btn" style="background: var(--accent); color: white;">
                <i class="fas fa-eye"></i> View Live Staff Page
            </a>
        </div>
    </div>

    <script>
        // Initialize drag & drop
        const staffList = document.getElementById('staffList');
        const sortable = new Sortable(staffList, {
            handle: '.handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            animation: 150,
            onUpdate: function() {
                updatePositionNumbers();
            }
        });

        // Update position numbers visually
        function updatePositionNumbers() {
            const items = staffList.getElementsByClassName('staff-item');
            for (let i = 0; i < items.length; i++) {
                const badge = items[i].querySelector('.order-badge');
                if (badge) {
                    badge.textContent = 'Position: ' + (i + 1);
                }
            }
        }

        // Save order to database
        function saveOrder() {
            const order = [];
            const items = staffList.getElementsByClassName('staff-item');
            
            for (let i = 0; i < items.length; i++) {
                order.push(items[i].getAttribute('data-id'));
            }
            
            // Show loading state
            const messageDiv = document.getElementById('message');
            messageDiv.innerHTML = '<div class="message-info">Saving order...</div>';
            
            // Send AJAX request
            fetch('staff-order-drag.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'order=' + JSON.stringify(order)
            })
            .then(response => response.text())
            .then(data => {
                messageDiv.innerHTML = '<div class="message-success">' + data + '</div>';
                
                // Update position numbers after save
                updatePositionNumbers();
                
                // Hide message after 3 seconds
                setTimeout(() => {
                    messageDiv.innerHTML = '';
                }, 3000);
            })
            .catch(error => {
                messageDiv.innerHTML = '<div class="message-error">Error saving order. Please try again.</div>';
                console.error('Error:', error);
            });
        }

        // Auto-save when order changes (optional - uncomment if you want auto-save)
        /*
        sortable.option('onEnd', function() {
            saveOrder();
        });
        */
    </script>
</body>
</html>