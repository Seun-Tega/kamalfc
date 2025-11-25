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
<!-- <section class="coaches">
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
</section> -->

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
<!-- <section class="testimonials">
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
</section> -->
<!-- Gallery Section -->
<!-- Gallery Section -->
<section class="gallery">
    <div class="container">
        <h2>Our Gallery</h2>
        <div class="gallery-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM gallery WHERE status = 'active' ORDER BY upload_date DESC LIMIT 3");
            $gallery_count = 0;
            while ($gallery = $stmt->fetch()):
                $gallery_count++;
            ?>
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="<?php echo getGalleryImage($gallery['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($gallery['title']); ?>">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h3><?php echo htmlspecialchars($gallery['title']); ?></h3>
                            <p><?php echo htmlspecialchars($gallery['description']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if ($gallery_count === 0): ?>
                <div class="no-gallery-items" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <p style="font-size: 1.1rem; color: var(--gray);">No gallery images available yet.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="gallery-cta">
            <a href="gallery.php" class="btn">View Full Gallery</a>
        </div>
    </div>
</section>

<!-- Videos Section -->
<!-- Videos Section -->
<section class="videos">
    <div class="container">
        <h2>Training Videos</h2>
        <div class="videos-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM videos WHERE status = 'active' ORDER BY upload_date DESC LIMIT 3");
            $video_count = 0;
            while ($video = $stmt->fetch()):
                $video_count++;
                $video_url = getVideoUrl($video['video_path']);
            ?>
            <div class="video-card" data-video="<?php echo $video_url; ?>">
                <div class="video-container">
                    <?php if (!empty($video['thumbnail_path'])): ?>
                        <img src="<?php echo getGalleryImage($video['thumbnail_path']); ?>" 
                             alt="<?php echo htmlspecialchars($video['title']); ?>" 
                             class="video-thumbnail">
                    <?php else: ?>
                        <div class="video-placeholder">
                            <i class="fas fa-play"></i>
                        </div>
                    <?php endif; ?>
                    <div class="video-play-btn">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <div class="video-content">
                    <h3><?php echo htmlspecialchars($video['title']); ?></h3>
                    <p><?php echo htmlspecialchars($video['description']); ?></p>
                    <div class="video-meta">
                        <span class="video-category"><?php echo ucfirst($video['category']); ?></span>
                        <?php if (!empty($video['duration'])): ?>
                            <span class="video-duration"><?php echo $video['duration']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if ($video_count === 0): ?>
                <div class="no-videos" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <p style="font-size: 1.1rem; color: var(--gray);">No videos available yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Video Modal (ONLY ONE - remove the duplicate) -->
<div class="video-modal" id="videoModal">
    <div class="modal-content">
        <button class="close-modal" id="closeModal">
            <i class="fas fa-times"></i>
        </button>
        <video controls class="modal-video" id="modalVideo">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<script>
// Video modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const videoModal = document.getElementById('videoModal');
    const modalVideo = document.getElementById('modalVideo');
    const closeModal = document.getElementById('closeModal');
    const videoCards = document.querySelectorAll('.video-card');
    
    // Open modal when video card is clicked
    videoCards.forEach(card => {
        card.addEventListener('click', function() {
            const videoSrc = this.getAttribute('data-video');
            if (videoSrc) {
                modalVideo.src = videoSrc;
                videoModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close modal
    closeModal.addEventListener('click', function() {
        videoModal.classList.remove('active');
        modalVideo.pause();
        modalVideo.src = '';
        document.body.style.overflow = '';
    });
    
    // Close modal when clicking outside
    videoModal.addEventListener('click', function(e) {
        if (e.target === videoModal) {
            videoModal.classList.remove('active');
            modalVideo.pause();
            modalVideo.src = '';
            document.body.style.overflow = '';
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.classList.contains('active')) {
            videoModal.classList.remove('active');
            modalVideo.pause();
            modalVideo.src = '';
            document.body.style.overflow = '';
        }
    });
});

// Hero Carousel functionality
document.addEventListener('DOMContentLoaded', function() {
    // Hero Carousel
    const heroSlides = document.querySelectorAll('.carousel-slide');
    const heroIndicators = document.querySelectorAll('.carousel-indicators .indicator');
    const prevBtn = document.querySelector('.carousel-control.prev');
    const nextBtn = document.querySelector('.carousel-control.next');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        heroSlides.forEach(slide => slide.classList.remove('active'));
        heroIndicators.forEach(indicator => indicator.classList.remove('active'));
        
        currentSlide = (index + heroSlides.length) % heroSlides.length;
        
        heroSlides[currentSlide].classList.add('active');
        if (heroIndicators[currentSlide]) {
            heroIndicators[currentSlide].classList.add('active');
        }
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Auto-advance slides
    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopSlideShow() {
        clearInterval(slideInterval);
    }

    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);

    heroIndicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            showSlide(index);
            stopSlideShow();
            startSlideShow();
        });
    });

    // Pause on hover
    const carouselContainer = document.querySelector('.carousel-container');
    if (carouselContainer) {
        carouselContainer.addEventListener('mouseenter', stopSlideShow);
        carouselContainer.addEventListener('mouseleave', startSlideShow);
    }

    // Start the slideshow
    startSlideShow();

    // About Carousel functionality - FIXED VERSION
    const aboutSlides = document.querySelectorAll('.about-carousel-slide');
    const aboutIndicators = document.querySelectorAll('.about-carousel-indicators .about-indicator');
    const aboutPrevBtn = document.querySelector('.about-carousel-control.prev');
    const aboutNextBtn = document.querySelector('.about-carousel-control.next');
    
    // Only initialize if elements exist
    if (aboutSlides.length > 0) {
        let currentAboutSlide = 0;
        let aboutSlideInterval;

        function showAboutSlide(index) {
            aboutSlides.forEach(slide => slide.classList.remove('active'));
            aboutIndicators.forEach(indicator => indicator.classList.remove('active'));
            
            currentAboutSlide = (index + aboutSlides.length) % aboutSlides.length;
            
            aboutSlides[currentAboutSlide].classList.add('active');
            if (aboutIndicators[currentAboutSlide]) {
                aboutIndicators[currentAboutSlide].classList.add('active');
            }
        }

        function nextAboutSlide() {
            showAboutSlide(currentAboutSlide + 1);
        }

        // Auto-advance about slides
        function startAboutSlideShow() {
            aboutSlideInterval = setInterval(nextAboutSlide, 4000);
        }

        // Event listeners for about carousel
        if (aboutNextBtn) {
            aboutNextBtn.addEventListener('click', () => {
                nextAboutSlide();
                resetAboutInterval();
            });
        }

        if (aboutPrevBtn) {
            aboutPrevBtn.addEventListener('click', () => {
                showAboutSlide(currentAboutSlide - 1);
                resetAboutInterval();
            });
        }

        if (aboutIndicators.length > 0) {
            aboutIndicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    showAboutSlide(index);
                    resetAboutInterval();
                });
            });
        }

        function resetAboutInterval() {
            clearInterval(aboutSlideInterval);
            startAboutSlideShow();
        }

        // Start about slideshow
        startAboutSlideShow();
    }
});
</script>
<?php include 'includes/footer.php'; ?>