    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>Kamal Football Academy</h3>
                    <p>Developing skilled, confident, and disciplined young footballers through professional coaching in a positive and supportive environment. Proudly wearing our signature green and white.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="programs.php">Programs</a></li>
                        <li><a href="players.php">Players</a></li>
                        <li><a href="matches.php">Matches</a></li>
                        <li><a href="staff.php">Crew</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Programs</h3>
                    <ul class="footer-links">
                        <li><a href="programs.php">Junior Development</a></li>
                        <li><a href="programs.php">Elite Training</a></li>
                        <li><a href="programs.php">Goalkeeper Academy</a></li>
                        <li><a href="programs.php">Summer Camps</a></li>
                        <li><a href="programs.php">Private Training</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Info</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> TechPro Complex, Ogo-Oluwa Osogbo</li>
                        <li><i class="fas fa-phone"></i> (+234) 7018984316</li>
                        <li><i class="fas fa-envelope"></i> kamalfootballclub@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Kamal Football Academy. All Rights Reserved. | Proudly Green & White</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script>
    // Hero Carousel Functionality
    document.addEventListener('DOMContentLoaded', function() {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.indicator');
        const prevButton = document.querySelector('.carousel-control.prev');
        const nextButton = document.querySelector('.carousel-control.next');
        let slideInterval;

        // Only initialize if carousel exists on page
        if (slides.length > 0) {
            function showSlide(n) {
                // Remove active class from all slides and indicators
                slides.forEach(slide => slide.classList.remove('active'));
                indicators.forEach(indicator => indicator.classList.remove('active'));
                
                // Calculate new slide index
                currentSlide = (n + slides.length) % slides.length;
                
                // Add active class to current slide and indicator
                slides[currentSlide].classList.add('active');
                if (indicators[currentSlide]) {
                    indicators[currentSlide].classList.add('active');
                }
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function goToSlide(n) {
                showSlide(n);
            }

            function resetInterval() {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000);
            }

            // Add click events to indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToSlide(index);
                    resetInterval();
                });
            });

            // Add click events to control buttons
            if (prevButton) {
                prevButton.addEventListener('click', () => {
                    prevSlide();
                    resetInterval();
                });
            }
            
            if (nextButton) {
                nextButton.addEventListener('click', () => {
                    nextSlide();
                    resetInterval();
                });
            }

            // Auto-advance slides every 5 seconds
            slideInterval = setInterval(nextSlide, 5000);

            // Pause auto-advance on hover
            const carousel = document.querySelector('.carousel-container');
            if (carousel) {
                carousel.addEventListener('mouseenter', () => clearInterval(slideInterval));
                carousel.addEventListener('mouseleave', () => {
                    slideInterval = setInterval(nextSlide, 5000);
                });

                // Touch swipe support for mobile
                let touchStartX = 0;
                let touchEndX = 0;

                carousel.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                    clearInterval(slideInterval);
                });

                carousel.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                    resetInterval();
                });

                function handleSwipe() {
                    const swipeThreshold = 50;
                    const diff = touchStartX - touchEndX;
                    
                    if (Math.abs(diff) > swipeThreshold) {
                        if (diff > 0) {
                            nextSlide(); // Swipe left - next slide
                        } else {
                            prevSlide(); // Swipe right - previous slide
                        }
                    }
                }
            }
        }
    });
        // About Section Carousel Functionality
    document.addEventListener('DOMContentLoaded', function() {
        let aboutCurrentSlide = 0;
        const aboutSlides = document.querySelectorAll('.about-carousel-slide');
        const aboutIndicators = document.querySelectorAll('.about-indicator');
        const aboutPrevButton = document.querySelector('.about-carousel-control.prev');
        const aboutNextButton = document.querySelector('.about-carousel-control.next');
        let aboutSlideInterval;

        // Only initialize if about carousel exists on page
        if (aboutSlides.length > 0) {
            function showAboutSlide(n) {
                // Remove active class from all slides and indicators
                aboutSlides.forEach(slide => slide.classList.remove('active'));
                aboutIndicators.forEach(indicator => indicator.classList.remove('active'));
                
                // Calculate new slide index
                aboutCurrentSlide = (n + aboutSlides.length) % aboutSlides.length;
                
                // Add active class to current slide and indicator
                aboutSlides[aboutCurrentSlide].classList.add('active');
                if (aboutIndicators[aboutCurrentSlide]) {
                    aboutIndicators[aboutCurrentSlide].classList.add('active');
                }
            }

            function nextAboutSlide() {
                showAboutSlide(aboutCurrentSlide + 1);
            }

            function prevAboutSlide() {
                showAboutSlide(aboutCurrentSlide - 1);
            }

            function goToAboutSlide(n) {
                showAboutSlide(n);
            }

            function resetAboutInterval() {
                clearInterval(aboutSlideInterval);
                aboutSlideInterval = setInterval(nextAboutSlide, 4000); // 4 seconds for about carousel
            }

            // Add click events to indicators
            aboutIndicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToAboutSlide(index);
                    resetAboutInterval();
                });
            });

            // Add click events to control buttons
            if (aboutPrevButton) {
                aboutPrevButton.addEventListener('click', () => {
                    prevAboutSlide();
                    resetAboutInterval();
                });
            }
            
            if (aboutNextButton) {
                aboutNextButton.addEventListener('click', () => {
                    nextAboutSlide();
                    resetAboutInterval();
                });
            }

            // Auto-advance slides every 4 seconds
            aboutSlideInterval = setInterval(nextAboutSlide, 4000);

            // Pause auto-advance on hover
            const aboutCarousel = document.querySelector('.about-carousel');
            if (aboutCarousel) {
                aboutCarousel.addEventListener('mouseenter', () => clearInterval(aboutSlideInterval));
                aboutCarousel.addEventListener('mouseleave', () => {
                    aboutSlideInterval = setInterval(nextAboutSlide, 4000);
                });
            }
        }
    });
    </script>
</body>
</html>