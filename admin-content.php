<?php
$pageTitle = "Manage Content";
require_once 'includes/auth.php';
requireAuth();
include 'includes/header.php';


// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_program'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $age_group = $_POST['age_group'];
        
        // Handle image upload - STORE ONLY FILENAME like players
        $image_filename = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= $max_size) {
                $filename = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
                $target_path = PROGRAM_UPLOAD_PATH . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $image_filename = $filename; // Store only filename like players
                }
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO programs (title, description, age_group, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $age_group, $image_filename]);
        $success = "Program added successfully!";
    }
    
    // Handle program image update
    if (isset($_POST['update_program_image'])) {
        $program_id = $_POST['program_id'];
        
        if (isset($_FILES['program_image']) && $_FILES['program_image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024;
            
            if (in_array($_FILES['program_image']['type'], $allowed_types) && $_FILES['program_image']['size'] <= $max_size) {
                $filename = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['program_image']['name']);
                $target_path = PROGRAM_UPLOAD_PATH . $filename;
                
                if (move_uploaded_file($_FILES['program_image']['tmp_name'], $target_path)) {
                    // First, get old image to delete it
                    $stmt = $pdo->prepare("SELECT image_path FROM programs WHERE id = ?");
                    $stmt->execute([$program_id]);
                    $old_program = $stmt->fetch();
                    
                    // Delete old image file
                    if ($old_program && $old_program['image_path']) {
                        $old_file_path = PROGRAM_UPLOAD_PATH . $old_program['image_path'];
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
                    }
                    
                    // Update with new image filename ONLY
                    $stmt = $pdo->prepare("UPDATE programs SET image_path = ? WHERE id = ?");
                    $stmt->execute([$filename, $program_id]);
                    $success = "Program image updated successfully!";
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid image file. Please upload JPEG, PNG, or GIF under 5MB.";
            }
        } else {
            $error = "Please select an image file.";
        }
    }
    
    if (isset($_POST['delete_program'])) {
        $program_id = $_POST['program_id'];
        
        // Get image path to delete file
        $stmt = $pdo->prepare("SELECT image_path FROM programs WHERE id = ?");
        $stmt->execute([$program_id]);
        $program = $stmt->fetch();
        
        if ($program && $program['image_path']) {
            $file_path = PROGRAM_UPLOAD_PATH . $program['image_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $stmt = $pdo->prepare("DELETE FROM programs WHERE id = ?");
        $stmt->execute([$program_id]);
        $success = "Program deleted successfully!";
    }
}

// Get all programs
$programs = $pdo->query("SELECT * FROM programs ORDER BY title")->fetchAll();
?>

<section class="admin-panel">
    <div class="admin-container">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Content</h2>
            </div>

            <?php if (isset($success)): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <h3>Add New Program</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Program Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Age Group *</label>
                            <input type="text" name="age_group" class="form-control" required placeholder="e.g., 5-10 years, 11-16 years">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Program Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small>JPEG, PNG, or GIF (max 5MB)</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description *</label>
                        <textarea name="description" class="form-control" rows="4" required placeholder="Describe the program, training focus, benefits, etc."></textarea>
                    </div>
                    <button type="submit" name="add_program" class="btn">Add Program</button>
                </form>
            </div>

            <div class="admin-card">
                <h3>All Programs</h3>
                
                <?php if (empty($programs)): ?>
                    <p>No programs found.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Age Group</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($programs as $program): ?>
                                <tr>
                                    <td>
                                        <?php if ($program['image_path']): ?>
                                            <img src="<?php echo getProgramImage($program['image_path']); ?>" 
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;"
                                                 alt="<?php echo htmlspecialchars($program['title']); ?>"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div style="display: none; width: 60px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                                <i class="fas fa-futbol"></i>
                                            </div>
                                        <?php else: ?>
                                            <div style="width: 60px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                                <i class="fas fa-futbol"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($program['title']); ?></td>
                                    <td><?php echo htmlspecialchars($program['age_group']); ?></td>
                                    <td>
                                        <small><?php echo htmlspecialchars(substr($program['description'], 0, 100)); ?>...</small>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <button type="button" class="action-btn edit-btn" 
                                                    onclick="openEditModal(<?php echo $program['id']; ?>, '<?php echo htmlspecialchars($program['title']); ?>')">
                                                Edit Image
                                            </button>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="program_id" value="<?php echo $program['id']; ?>">
                                                <button type="submit" name="delete_program" class="action-btn delete-btn" 
                                                        onclick="return confirm('Are you sure you want to delete this program?')">
                                                    Delete
                                                </button>
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

<!-- Edit Image Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 8px; width: 90%; max-width: 500px;">
        <h3>Update Program Image</h3>
        <p id="modalProgramTitle" style="margin-bottom: 20px; color: var(--primary); font-weight: 500;"></p>
        
        <form method="POST" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="program_id" id="modalProgramId">
            
            <div class="form-group">
                <label><strong>Select New Image:</strong></label>
                <input type="file" name="program_image" class="form-control" accept="image/*" required>
                <small>JPEG, PNG, or GIF (max 5MB)</small>
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 25px;">
                <button type="submit" name="update_program_image" class="btn">Update Image</button>
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(programId, programTitle) {
    document.getElementById('modalProgramId').value = programId;
    document.getElementById('modalProgramTitle').textContent = 'Update image for: ' + programTitle;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editForm').reset();
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>

<?php include 'includes/footer.php'; ?>