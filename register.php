<?php
$pageTitle = "Player Registration";
require_once 'includes/config.php';
include 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $position = $_POST['position'] ?? '';
        $address = trim($_POST['address'] ?? '');
        $emergency_contact_name = trim($_POST['emergency_contact_name'] ?? '');
        $emergency_contact_phone = trim($_POST['emergency_contact_phone'] ?? '');
        $medical_conditions = trim($_POST['medical_conditions'] ?? '');
        $previous_clubs = trim($_POST['previous_clubs'] ?? '');
        
        $height = !empty($_POST['height']) ? $_POST['height'] : null;
        $weight = !empty($_POST['weight']) ? $_POST['weight'] : null;
        $bio = trim($_POST['bio'] ?? '');

        // Validate required fields
        if (empty($name) || empty($email) || empty($phone) || empty($date_of_birth) || empty($position) || empty($emergency_contact_name) || empty($emergency_contact_phone)) {
            throw new Exception("Please fill in all required fields.");
        }

        // Calculate age group
        $age = date_diff(date_create($date_of_birth), date_create('today'))->y;
        $age_group = calculateAgeGroup($age);

        // Handle image upload - SIMPLIFIED AND CORRECTED
        $image_filename = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024;
            
            if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= $max_size) {
                $image_filename = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
                $target_path = PLAYER_UPLOAD_PATH . $image_filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    // Success - $image_filename now contains just the filename
                } else {
                    throw new Exception("Failed to upload image. Please try again.");
                }
            } else {
                throw new Exception("Invalid image file. Please upload JPEG, PNG, or GIF under 5MB.");
            }
        }

        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM players WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            throw new Exception("A player with this email is already registered.");
        }
        
        // Insert player - store only filename in database
        $stmt = $pdo->prepare("INSERT INTO players (name, email, phone, date_of_birth, position, age_group, address, emergency_contact_name, emergency_contact_phone, medical_conditions, previous_clubs, height, weight, image_path, bio, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        
        $result = $stmt->execute([
            $name, $email, $phone, $date_of_birth, $position, $age_group, 
            $address, $emergency_contact_name, $emergency_contact_phone, 
            $medical_conditions, $previous_clubs, $height, $weight, 
            $image_filename, $bio
        ]);
        
        if ($result) {
            $success = "Thank you for your registration! Your application is under review. We will contact you once it's approved.";
            $_POST = [];
        } else {
            throw new Exception("Registration failed. Please try again.");
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

function calculateAgeGroup($age) {
    if ($age <= 8) return 'U8';
    if ($age <= 10) return 'U10';
    if ($age <= 12) return 'U12';
    if ($age <= 14) return 'U14';
    if ($age <= 16) return 'U16';
    return 'U18';
}
?>

<section class="contact" style="padding-top: 150px;">
    <div class="container">
        <h2>Player Registration</h2>
        
        <?php if ($success): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="contact-container">
            <div class="contact-info">
                <h3>Join Our Academy</h3>
                <p>Fill out the form to register as a player. All applications are reviewed by our coaching staff.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4>Processing Time</h4>
                            <p>Applications are typically reviewed within 2-3 business days</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h4>Requirements</h4>
                            <p>Please provide accurate information and a recent photo</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <form method="POST" enctype="multipart/form-data" id="registrationForm">
                    <h3>Player Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input type="tel" name="phone" class="form-control" required value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Date of Birth *</label>
                            <input type="date" name="date_of_birth" class="form-control" required value="<?php echo htmlspecialchars($_POST['date_of_birth'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Preferred Position *</label>
                            <select name="position" class="form-control" required>
                                <option value="">Select Position</option>
                                <option value="Goalkeeper" <?php echo ($_POST['position'] ?? '') == 'Goalkeeper' ? 'selected' : ''; ?>>Goalkeeper</option>
                                <option value="Defender" <?php echo ($_POST['position'] ?? '') == 'Defender' ? 'selected' : ''; ?>>Defender</option>
                                <option value="Midfielder" <?php echo ($_POST['position'] ?? '') == 'Midfielder' ? 'selected' : ''; ?>>Midfielder</option>
                                <option value="Forward" <?php echo ($_POST['position'] ?? '') == 'Forward' ? 'selected' : ''; ?>>Forward</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Player Photo</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small>JPEG, PNG, or GIF (max 5MB)</small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Height (cm)</label>
                            <input type="number" name="height" class="form-control" min="100" max="250" step="0.1" value="<?php echo htmlspecialchars($_POST['height'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" min="20" max="150" step="0.1" value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="2"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                    </div>
                    
                    <h4 style="margin-top: 30px; margin-bottom: 15px;">Emergency Contact</h4>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Emergency Contact Name *</label>
                            <input type="text" name="emergency_contact_name" class="form-control" required value="<?php echo htmlspecialchars($_POST['emergency_contact_name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Emergency Contact Phone *</label>
                            <input type="tel" name="emergency_contact_phone" class="form-control" required value="<?php echo htmlspecialchars($_POST['emergency_contact_phone'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Medical Conditions / Allergies</label>
                        <textarea name="medical_conditions" class="form-control" rows="3" placeholder="List any medical conditions, allergies, or medications"><?php echo htmlspecialchars($_POST['medical_conditions'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Previous Football Clubs / Experience</label>
                        <textarea name="previous_clubs" class="form-control" rows="3" placeholder="List any previous clubs or football experience"><?php echo htmlspecialchars($_POST['previous_clubs'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Personal Bio / Football Ambitions</label>
                        <textarea name="bio" class="form-control" rows="4" placeholder="Tell us about your football experience, strengths, and ambitions"><?php echo htmlspecialchars($_POST['bio'] ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%;">Submit Registration</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>