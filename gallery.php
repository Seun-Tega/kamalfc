<?php
$pageTitle = "Gallery";
require_once 'includes/config.php';
include 'includes/header.php';
?>

<section class="gallery-page">
    <div class="container">
        <h2>Our Gallery</h2>
        <p class="gallery-intro">
            Explore moments from our training sessions, matches, and academy life
        </p>
        
        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="training">Training</button>
            <button class="filter-btn" data-filter="matches">Matches</button>
            <button class="filter-btn" data-filter="events">Events</button>
            <button class="filter-btn" data-filter="facilities">Facilities</button>
        </div>
        
        <div class="gallery-page-grid" id="galleryGrid">
            <?php
            $stmt = $pdo->query("SELECT * FROM gallery WHERE status = 'active' ORDER BY upload_date DESC");
            while ($gallery = $stmt->fetch()):
            ?>
            <div class="gallery-page-item" data-category="<?php echo htmlspecialchars($gallery['category']); ?>">
                <div class="gallery-page-image">
                    <img src="<?php echo getGalleryImage($gallery['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($gallery['title']); ?>">
                    <div class="gallery-page-overlay">
                        <div class="gallery-page-info">
                            <h3><?php echo htmlspecialchars($gallery['title']); ?></h3>
                            <p><?php echo htmlspecialchars($gallery['description']); ?></p>
                            <span class="gallery-category"><?php echo ucfirst($gallery['category']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <div class="load-more" id="loadMoreContainer">
            <button class="btn" id="loadMore">Load More Images</button>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script>
// Gallery filtering and load more functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-page-item');
    const loadMoreBtn = document.getElementById('loadMore');
    const loadMoreContainer = document.getElementById('loadMoreContainer');
    let visibleItems = 12;
    let currentFilter = 'all';
    
    // Filter functionality
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            currentFilter = filter;
            
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            let visibleCount = 0;
            galleryItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Reset visible items count when filtering
            visibleItems = 12;
            showMoreItems();
            
            // Hide load more if fewer items than initial visible count
            if (visibleCount <= 12) {
                loadMoreContainer.style.display = 'none';
            } else {
                loadMoreContainer.style.display = 'block';
            }
        });
    });
    
    // Load more functionality
    function showMoreItems() {
        const items = document.querySelectorAll('.gallery-page-item[style="display: block"], .gallery-page-item:not([style])');
        let shownCount = 0;
        
        items.forEach((item, index) => {
            if (index < visibleItems) {
                item.style.display = 'block';
                shownCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Hide load more button if all items are visible
        if (visibleItems >= items.length) {
            loadMoreBtn.style.display = 'none';
        } else {
            loadMoreBtn.style.display = 'inline-flex';
        }
    }
    
    loadMoreBtn.addEventListener('click', function() {
        visibleItems += 12;
        showMoreItems();
    });
    
    // Initialize
    showMoreItems();
});
</script>