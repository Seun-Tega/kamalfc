<?php
$pageTitle = "Home";
require_once 'includes/config.php';
include 'includes/header.php';
?>

<!-- Hero Carousel Section -->
<section class="hero-carousel">
    <div class="carousel-container">
        <!-- Slide 1 -->
        <div class="carousel-slide active">
            <div class="slide-image" style="background-image: url('image/hero-slide1.jpg');"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Developing Future Football Stars</h1>
                    <p>At Kamal Football Academy, we provide professional training and development programs for young athletes of all skill levels.</p>
                    <div class="hero-btns">
                        <a href="programs.php" class="btn">Our Programs</a>
                        <a href="register.php" class="btn btn-outline">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 2 -->
        <div class="carousel-slide">
            <div class="slide-image" style="background-image: url('image/hero-slide2.jpg');"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Professional Coaching</h1>
                    <p>Learn from experienced coaches with professional backgrounds and proven track records in player development.</p>
                    <div class="hero-btns">
                        <a href="staff.php" class="btn">Meet Our Coaches</a>
                        <a href="programs.php" class="btn btn-outline">View Programs</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 3 -->
        <div class="carousel-slide">
            <div class="slide-image" style="background-image: url('image/hero-slide3.jpg');"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Competitive Matches</h1>
                    <p>Regular competitive fixtures help our players develop match intelligence and practical game experience.</p>
                    <div class="hero-btns">
                        <a href="matches.php" class="btn">Upcoming Matches</a>
                        <a href="register.php" class="btn btn-outline">Join The Team</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 4 -->
        <div class="carousel-slide">
            <div class="slide-image" style="background-image: url('image/hero-slide4.jpg');"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Join Our Football Family</h1>
                    <p>Become part of our growing community dedicated to excellence in football and personal development.</p>
                    <div class="hero-btns">
                        <a href="register.php" class="btn">Register Now</a>
                        <a href="contact.php" class="btn btn-outline">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carousel Controls -->
        <button class="carousel-control prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-control next">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <span class="indicator active"></span>
            <span class="indicator"></span>
            <span class="indicator"></span>
            <span class="indicator"></span>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about">
    <div class="container">
        <h2>About Our Academy</h2>
        <div class="about-content">
            <div class="about-text">
                <h3>Our Mission at Kamal FA</h3>
                <p>Kamal Football Academy was founded with a simple mission: to develop skilled, confident, and disciplined young footballers through professional coaching in a positive and supportive environment.</p>
                <p>With our signature green and white colors representing growth and purity, we've produced numerous players who have gone on to play at collegiate, semi-professional, and professional levels.</p>
                <a href="about.php" class="btn">Learn More</a>
            </div>
            <div class="about-image">
                <!-- About Image Carousel -->
                <div class="about-carousel">
                    <div class="about-carousel-container">
                        <!-- About Slide 1 -->
                        <div class="about-carousel-slide active">
                            <img src="image/hero5.jpg" alt="Kamal Academy Training Session">
                        </div>
                        
                        <!-- About Slide 2 -->
                        <div class="about-carousel-slide">
                            <img src="image/hero6.jpg" alt="Professional Coaching">
                        </div>
                        
                        <!-- About Slide 3 -->
                        <div class="about-carousel-slide">
                            <img src="image/hero7.jpg" alt="Team Building">
                        </div>
                        
                        <!-- About Slide 4 -->
                        <div class="about-carousel-slide">
                            <img src="image/hero8.jpg" alt="Football Facilities">
                        </div>
                         <!-- About Slide 4 -->
                        <div class="about-carousel-slide">
                            <img src="image/hero9.jpg" alt="Football Facilities">
                        </div>
                         <!-- About Slide 4 -->
                        <div class="about-carousel-slide">
                            <img src="image/hero10.jpg" alt="Football Facilities">
                        </div>
                         <!-- About Slide 4 -->
                        <div class="about-carousel-slide">
                            <img src="image/hero11.jpg" alt="Football Facilities">
                        </div>
                    </div>
                    
                    <!-- About Carousel Controls -->
                    <button class="about-carousel-control prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="about-carousel-control next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- About Carousel Indicators -->
                    <div class="about-carousel-indicators">
                        <span class="about-indicator active"></span>
                        <span class="about-indicator"></span>
                        <span class="about-indicator"></span>
                        <span class="about-indicator"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="programs">
    <div class="container">
        <h2>Our Training Programs</h2>
        <div class="programs-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM programs LIMIT 3");
            while ($program = $stmt->fetch()):
            ?>
            <div class="program-card">
                <div class="program-image">
                    <img src="<?php echo getProgramImage($program['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($program['title']); ?>"
                         onerror="this.src='https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80'">
                </div>
                <div class="program-content">
                    <h3><?php echo htmlspecialchars($program['title']); ?></h3>
                    <p><?php echo htmlspecialchars($program['description']); ?></p>
                    <p><strong>Age Group:</strong> <?php echo htmlspecialchars($program['age_group']); ?></p>
                    <a href="programs.php" class="btn">Learn More</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


<!-- Featured Players Section -->
<section class="coaches">
    <div class="container">
        <h2>Featured Players</h2>
        <div class="coaches-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM players WHERE status = 'approved' LIMIT 3");
            while ($player = $stmt->fetch()):
            ?>
            <div class="coach-card">
                <div class="coach-image">
                    <img src="<?php echo getPlayerImage($player['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($player['name']); ?>"
                         onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
                </div>
                <div class="coach-info">
                    <h3><?php echo htmlspecialchars($player['name']); ?></h3>
                    <p><?php echo htmlspecialchars($player['position']); ?> - <?php echo htmlspecialchars($player['age_group']); ?> Team</p>
                    <?php if ($player['goals'] > 0): ?>
                        <p><strong>Goals:</strong> <?php echo $player['goals']; ?> | <strong>Assists:</strong> <?php echo $player['assists']; ?></p>
                    <?php elseif ($player['clean_sheets'] > 0): ?>
                        <p><strong>Clean Sheets:</strong> <?php echo $player['clean_sheets']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="players.php" class="btn">View All Players</a>
        </div>
    </div>
</section>

<!-- Registration CTA Section -->
<section class="hero" style="background: linear-gradient(rgba(43, 43, 43, 0.9), rgba(43, 43, 43, 0.9)), url('https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80'); margin-top: 0;">
    <div class="container">
        <h2>Ready to Join Kamal Academy?</h2>
        <p>Register now to become part of our football family. Wear our signature green with pride and develop your skills with professional coaching.</p>
        <div class="hero-btns">
            <a href="register.php" class="btn">Register as Player</a>
            <a href="programs.php" class="btn btn-outline">View Programs</a>
        </div>
    </div>
</section>

<!-- Upcoming Matches Section -->
<section class="facilities">
    <div class="container">
        <h2>Upcoming Matches</h2>
        <div class="matches-container">
            <?php
            $stmt = $pdo->query("SELECT * FROM matches WHERE status = 'upcoming' ORDER BY match_date ASC LIMIT 2");
            while ($match = $stmt->fetch()):
            ?>
            <div class="match-card">
                <div class="match-header">
                    <h3><?php echo ucfirst($match['match_type']); ?> Match</h3>
                    <p><?php echo date('l, F j, Y', strtotime($match['match_date'])); ?> | <?php echo date('g:i A', strtotime($match['match_time'])); ?></p>
                </div>
                <div class="match-teams">
                    <div class="team">
                        <div class="team-logo">KFA</div>
                        <h4>Kamal FA</h4>
                    </div>
                    <div class="vs">VS</div>
                    <div class="team">
                        <div class="team-logo"><?php echo substr($match['opponent'], 0, 3); ?></div>
                        <h4><?php echo htmlspecialchars($match['opponent']); ?></h4>
                    </div>
                </div>
                <div class="match-details">
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($match['venue']); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="matches.php" class="btn">View All Matches</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
    <div class="container">
        <h2>What Parents & Players Say</h2>
        <div class="testimonials-container">
            <div class="testimonial">
                <div class="testimonial-text">
                    <p>My son has developed so much both as a player and as a person since joining Kamal Football Academy. The coaches are not just skilled technicians but excellent mentors.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80" alt="Parent">
                    </div>
                    <div class="author-info">
                        <h4>Lisa Thompson</h4>
                        <p>Parent of U12 Player</p>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-text">
                    <p>The training methodology at Kamal FA is exceptional. I've improved my technical skills, tactical understanding, and physical conditioning significantly in just one season.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80" alt="Player">
                    </div>
                    <div class="author-info">
                        <h4>James Wilson</h4>
                        <p>U16 Player</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>