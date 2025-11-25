<?php
$pageTitle = "Contact Us";
include 'includes/header.php';

$success = '';
$error = '';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // In a real application, you would send an email here
        // For now, we'll just show a success message
        $success = "Thank you for your message! We will get back to you soon.";
        
        // Clear form
        $_POST = [];
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!-- Contact Section -->
<section class="contact" style="padding-top: 150px;">
    <div class="container">
        <h2>Contact Us</h2>
        
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
                <h3>Get In Touch</h3>
                <p>We'd love to hear from you! Whether you have questions about our programs, want to schedule a trial session, or just want to learn more about our academy, don't hesitate to reach out.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4>Location</h4>
                            <p>TechPro Complex, Ogo-Oluwa Osogbo</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h4>Phone</h4>
                            <p>(234) 7018984316</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p>kamalfootballclub@gmail.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4>Office Hours</h4>
                            <p>Monday - Friday: 9am - 6pm</p>
                            <p>Saturday: 9am - 2pm</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <form method="POST" id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" class="form-control" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" class="form-control" required>
                            <option value="">Select a subject</option>
                            <option value="general" <?php echo ($_POST['subject'] ?? '') == 'general' ? 'selected' : ''; ?>>General Inquiry</option>
                            <option value="registration" <?php echo ($_POST['subject'] ?? '') == 'registration' ? 'selected' : ''; ?>>Player Registration</option>
                            <option value="programs" <?php echo ($_POST['subject'] ?? '') == 'programs' ? 'selected' : ''; ?>>Program Information</option>
                            <option value="trial" <?php echo ($_POST['subject'] ?? '') == 'trial' ? 'selected' : ''; ?>>Trial Session</option>
                            <option value="other" <?php echo ($_POST['subject'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>