<?php
$pageTitle = "Manage Staff";
require_once 'includes/auth.php';
requireAuth();
require_once 'includes/config.php';
include 'includes/header.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_staff'])) {
        $name = trim($_POST['name']);
        $role = trim($_POST['role']);
        $bio = trim($_POST['bio']);
        
        // Handle image upload
        $image_filename = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= $max_size) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image_filename = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
                $target_path = STAFF_UPLOAD_PATH . $image_filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    // File uploaded successfully
                }
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO staff (name, role, bio, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $role, $bio, $image_filename]);
        $success = "Staff member added successfully!";
    }
    
    if (isset($_POST['delete_staff'])) {
        $staff_id = $_POST['staff_id'];
        
        // Get image path to delete file
        $stmt = $pdo->prepare("SELECT image_path FROM staff WHERE id = ?");
        $stmt->execute([$staff_id]);
        $staff = $stmt->fetch();
        
        if ($staff && $staff['image_path']) {
            $file_path = STAFF_UPLOAD_PATH . $staff['image_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $stmt = $pdo->prepare("DELETE FROM staff WHERE id = ?");
        $stmt->execute([$staff_id]);
        $success = "Staff member deleted successfully!";
    }
}

// Get all staff
$staff = $pdo->query("SELECT * FROM staff ORDER BY name")->fetchAll();
?>

<section class="admin-panel">
    <div class="admin-container">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Staff</h2>
            </div>

            <?php if (isset($success)): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <h3>Add New Staff Member</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Role *</label>
                            <input type="text" name="role" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Profile Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small>JPEG, PNG, or GIF (max 5MB)</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control" rows="4" placeholder="Enter staff member's biography, qualifications, and experience"></textarea>
                    </div>
                    <button type="submit" name="add_staff" class="btn">Add Staff Member</button>
                </form>
            </div>

            <div class="admin-card">
                <h3>All Staff Members</h3>
                
                <?php if (empty($staff)): ?>
                    <p>No staff members found.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Bio</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staff as $member): ?>
                                <tr>
                                    <td>
                                        <?php if ($member['image_path']): ?>
                                            <img src="<?php echo getStaffImage($member['image_path']); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            <div style="width: 60px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                                    <td><?php echo htmlspecialchars($member['role']); ?></td>
                                    <td>
                                        <?php if (!empty($member['bio'])): ?>
                                            <small><?php echo htmlspecialchars(substr($member['bio'], 0, 100)); ?>...</small>
                                        <?php else: ?>
                                            <small style="color: #999;">No bio provided</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="staff_id" value="<?php echo $member['id']; ?>">
                                            <button type="submit" name="delete_staff" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</button>
                                        </form>
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

<?php include 'includes/footer.php'; ?>