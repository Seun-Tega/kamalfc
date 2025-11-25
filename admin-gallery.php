<?php
$pageTitle = "Manage Gallery";
require_once 'includes/auth.php';
requireAuth();
include 'includes/header.php';
?>

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
                <li><a href="admin-gallery.php" class="active"><i class="fas fa-images"></i> Manage Gallery</a></li>
                <li><a href="admin-videos.php"><i class="fas fa-video"></i> Manage Videos</a></li>
                <li><a href="admin-content.php"><i class="fas fa-edit"></i> Manage Content</a></li>
                <li><a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Gallery</h2>
                <p>Upload and manage gallery images</p>
            </div>

            <!-- Upload Form -->
            <div class="admin-card">
                <h3>Upload New Image</h3>
                <form action="upload-gallery.php" method="POST" enctype="multipart/form-data" id="galleryForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Image Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category *</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="training">Training</option>
                                <option value="matches">Matches</option>
                                <option value="events">Events</option>
                                <option value="facilities">Facilities</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image *</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <small class="form-text text-muted">Supported formats: JPG, PNG, GIF. Max size: 5MB</small>
                    </div>
                    <button type="submit" class="btn" name="upload_gallery">Upload Image</button>
                </form>
            </div>

            <!-- Gallery Images List -->
            <div class="admin-card">
                <h3>Gallery Images</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM gallery ORDER BY upload_date DESC");
                            while ($image = $stmt->fetch()):
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo getGalleryImage($image['image_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($image['title']); ?>"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                </td>
                                <td><?php echo htmlspecialchars($image['title']); ?></td>
                                <td><?php echo ucfirst($image['category']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($image['upload_date'])); ?></td>
                                <td>
                                    <span style="color: <?php echo $image['status'] == 'active' ? 'var(--primary)' : 'var(--secondary)'; ?>">
                                        <?php echo ucfirst($image['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="update-gallery.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                                        <input type="hidden" name="status" value="<?php echo $image['status'] == 'active' ? 'inactive' : 'active'; ?>">
                                        <button type="submit" class="action-btn" style="background: var(--primary); color: white;">
                                            <?php echo $image['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                    </form>
                                    <form action="delete-gallery.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                        <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                                        <button type="submit" class="action-btn delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>