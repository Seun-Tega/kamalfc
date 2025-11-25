<?php
$pageTitle = "Manage Videos";
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
                <li><a href="admin-gallery.php"><i class="fas fa-images"></i> Manage Gallery</a></li>
                <li><a href="admin-videos.php" class="active"><i class="fas fa-video"></i> Manage Videos</a></li>
                <li><a href="admin-content.php"><i class="fas fa-edit"></i> Manage Content</a></li>
                <li><a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Videos</h2>
                <p>Upload and manage training videos</p>
            </div>

            <!-- Upload Form -->
            <div class="admin-card">
                <h3>Upload New Video</h3>
                <form action="upload-video.php" method="POST" enctype="multipart/form-data" id="videoForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Video Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category *</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="training">Training</option>
                                <option value="matches">Matches</option>
                                <option value="tutorials">Tutorials</option>
                                <option value="highlights">Highlights</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="duration">Duration (optional)</label>
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g., 2:30">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail (optional)</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="video">Video File *</label>
                        <input type="file" class="form-control" id="video" name="video" accept="video/*" required>
                        <small class="form-text text-muted">Supported formats: MP4, WebM, OGG. Max size: 50MB</small>
                    </div>
                    <button type="submit" class="btn" name="upload_video">Upload Video</button>
                </form>
            </div>

            <!-- Videos List -->
            <div class="admin-card">
                <h3>Videos</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Duration</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM videos ORDER BY upload_date DESC");
                            while ($video = $stmt->fetch()):
                            ?>
                            <tr>
                                <td>
                                    <?php if (!empty($video['thumbnail_path'])): ?>
                                        <img src="<?php echo getGalleryImage($video['thumbnail_path']); ?>" 
                                             alt="<?php echo htmlspecialchars($video['title']); ?>"
                                             style="width: 80px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 80px; height: 60px; background: var(--light); display: flex; align-items: center; justify-content: center; color: var(--gray);">
                                            <i class="fas fa-video"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($video['title']); ?></td>
                                <td><?php echo ucfirst($video['category']); ?></td>
                                <td><?php echo $video['duration'] ?: 'N/A'; ?></td>
                                <td><?php echo date('M j, Y', strtotime($video['upload_date'])); ?></td>
                                <td>
                                    <span style="color: <?php echo $video['status'] == 'active' ? 'var(--primary)' : 'var(--secondary)'; ?>">
                                        <?php echo ucfirst($video['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="update-video.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
                                        <input type="hidden" name="status" value="<?php echo $video['status'] == 'active' ? 'inactive' : 'active'; ?>">
                                        <button type="submit" class="action-btn" style="background: var(--primary); color: white;">
                                            <?php echo $video['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                    </form>
                                    <form action="delete-video.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                        <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
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