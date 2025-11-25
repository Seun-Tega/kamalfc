<?php
$pageTitle = "Our Players";
require_once 'includes/config.php';
include 'includes/header.php';

// Players per page configuration
$viewType = isset($_GET['view']) ? $_GET['view'] : 'default';
switch($viewType) {
    case 'compact':
        $playersPerPage = 20;
        $viewClass = 'compact';
        break;
    case 'very-compact':
        $playersPerPage = 30;
        $viewClass = 'very-compact';
        break;
    case 'list':
        $playersPerPage = 40;
        $viewClass = 'list-view';
        break;
    default:
        $playersPerPage = 12;
        $viewClass = '';
        break;
}

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $playersPerPage;

// Get total number of approved players
$totalStmt = $pdo->query("SELECT COUNT(*) FROM players WHERE status = 'approved'");
$totalPlayers = $totalStmt->fetchColumn();
$totalPages = ceil($totalPlayers / $playersPerPage);

// Get players for current page
$stmt = $pdo->prepare("
    SELECT * FROM players 
    WHERE status = 'approved' 
    ORDER BY name 
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $playersPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$players = $stmt->fetchAll();
?>

<!-- Players Section -->
<section class="players-page">
    <div class="container">
        <h2>Our Players</h2>
        
        <!-- Search and Filter Section -->
        <div class="players-controls">
            <div class="search-filter-container">
                <div class="search-box">
                    <input type="text" id="playerSearch" placeholder="Search players by name..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <div class="filter-dropdown">
                    <select id="positionFilter" class="filter-select">
                        <option value="">All Positions</option>
                        <option value="Goalkeeper">Goalkeeper</option>
                        <option value="Defender">Defender</option>
                        <option value="Midfielder">Midfielder</option>
                        <option value="Forward">Forward</option>
                    </select>
                </div>
                
                <div class="filter-dropdown">
                    <select id="ageGroupFilter" class="filter-select">
                        <option value="">All Age Groups</option>
                        <option value="U8">U8</option>
                        <option value="U10">U10</option>
                        <option value="U12">U12</option>
                        <option value="U14">U14</option>
                        <option value="U16">U16</option>
                        <option value="U18">U18</option>
                        <option value="Senior">Senior</option>
                    </select>
                </div>
            </div>
            
            <div class="view-controls">
                <div class="view-toggle">
                    <button class="view-btn <?php echo $viewClass === '' ? 'active' : ''; ?>" 
                            onclick="changeView('default')" title="Default View (12 per page)">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="view-btn <?php echo $viewClass === 'compact' ? 'active' : ''; ?>" 
                            onclick="changeView('compact')" title="Compact View (20 per page)">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button class="view-btn <?php echo $viewClass === 'very-compact' ? 'active' : ''; ?>" 
                            onclick="changeView('very-compact')" title="Very Compact View (30 per page)">
                        <i class="fas fa-th-list"></i>
                    </button>
                    <button class="view-btn <?php echo $viewClass === 'list-view' ? 'active' : ''; ?>" 
                            onclick="changeView('list')" title="List View (40 per page)">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
                
                <div class="register-btn-container">
                    <a href="register.php" class="btn">Register as Player</a>
                </div>
            </div>
        </div>
        
        <!-- Players Stats -->
        <div class="players-stats">
            <p>Showing <?php echo count($players); ?> of <?php echo $totalPlayers; ?> players 
               (<?php echo $playersPerPage; ?> per page) - <?php echo ucfirst(str_replace('-', ' ', $viewType)); ?> View</p>
        </div>
        
        <?php if (empty($players)): ?>
            <div class="no-players">
                <h3>No Players Found</h3>
                <p>Try adjusting your search criteria or register to become our first player!</p>
                <a href="register.php" class="btn">Register Now</a>
            </div>
        <?php else: ?>
            <div class="players-grid <?php echo $viewClass; ?>" id="playersContainer">
                <?php foreach ($players as $player): ?>
                <div class="player-card <?php echo $viewClass; ?>" 
                     data-position="<?php echo htmlspecialchars($player['position']); ?>" 
                     data-age-group="<?php echo htmlspecialchars($player['age_group']); ?>"
                     data-name="<?php echo strtolower(htmlspecialchars($player['name'])); ?>">
                    <div class="player-image">
                        <img src="<?php echo getPlayerImage($player['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($player['name']); ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80'">
                        <div class="player-badge"><?php echo htmlspecialchars($player['age_group']); ?></div>
                    </div>
                    <div class="player-info">
                        <?php if ($viewClass === 'list-view'): ?>
                            <div class="player-main-info">
                                <h3><?php echo htmlspecialchars($player['name']); ?></h3>
                                <p class="player-position"><?php echo htmlspecialchars($player['position']); ?></p>
                            </div>
                            
                            <div class="player-stats">
                                <?php if ($player['position'] == 'Goalkeeper'): ?>
                                    <div class="stat-item">
                                        <span class="stat-label">Clean Sheets:</span>
                                        <span class="stat-value"><?php echo $player['clean_sheets']; ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="stat-item">
                                        <span class="stat-label">Goals:</span>
                                        <span class="stat-value"><?php echo $player['goals']; ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Assists:</span>
                                        <span class="stat-value"><?php echo $player['assists']; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <h3><?php echo htmlspecialchars($player['name']); ?></h3>
                            <p class="player-position"><?php echo htmlspecialchars($player['position']); ?></p>
                            
                            <div class="player-stats">
                                <?php if ($player['position'] == 'Goalkeeper'): ?>
                                    <div class="stat-item">
                                        <span class="stat-label">Clean Sheets:</span>
                                        <span class="stat-value"><?php echo $player['clean_sheets']; ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="stat-item">
                                        <span class="stat-label">Goals:</span>
                                        <span class="stat-value"><?php echo $player['goals']; ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Assists:</span>
                                        <span class="stat-value"><?php echo $player['assists']; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($player['height']) || !empty($player['weight'])): ?>
                                <div class="player-physical">
                                    <?php if (!empty($player['height'])): ?>
                                        <span class="physical-item"><?php echo $player['height']; ?> cm</span>
                                    <?php endif; ?>
                                    <?php if (!empty($player['weight'])): ?>
                                        <span class="physical-item"><?php echo $player['weight']; ?> kg</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($player['bio']) && $viewClass !== 'very-compact'): ?>
                                <div class="player-bio">
                                    <?php echo htmlspecialchars(substr($player['bio'], 0, 120)); ?>
                                    <?php if (strlen($player['bio']) > 120): ?>...<?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                       <button class="view-profile-btn" onclick="viewPlayerProfile(<?php echo $player['id']; ?>)">
    View Profile
</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?php echo $currentPage - 1; ?>&view=<?php echo $viewType; ?>" class="page-link prev">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                <?php endif; ?>
                
                <div class="page-numbers">
                    <?php
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $currentPage + 2);
                    
                    for ($page = $startPage; $page <= $endPage; $page++):
                    ?>
                        <a href="?page=<?php echo $page; ?>&view=<?php echo $viewType; ?>" 
                           class="page-link <?php echo $page == $currentPage ? 'active' : ''; ?>">
                            <?php echo $page; ?>
                        </a>
                    <?php endfor; ?>
                </div>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>&view=<?php echo $viewType; ?>" class="page-link next">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<script>
// Change view type
function changeView(viewType) {
    window.location.href = `players.php?view=${viewType}&page=1`;
}

// Search and Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('playerSearch');
    const positionFilter = document.getElementById('positionFilter');
    const ageGroupFilter = document.getElementById('ageGroupFilter');
    const playerCards = document.querySelectorAll('.player-card');
    const playersStats = document.querySelector('.players-stats p');
    
    function filterPlayers() {
        const searchTerm = searchInput.value.toLowerCase();
        const positionValue = positionFilter.value;
        const ageGroupValue = ageGroupFilter.value;
        let visibleCount = 0;
        
        playerCards.forEach(card => {
            const name = card.getAttribute('data-name');
            const position = card.getAttribute('data-position');
            const ageGroup = card.getAttribute('data-age-group');
            
            const matchesSearch = name.includes(searchTerm);
            const matchesPosition = !positionValue || position === positionValue;
            const matchesAgeGroup = !ageGroupValue || ageGroup === ageGroupValue;
            
            if (matchesSearch && matchesPosition && matchesAgeGroup) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update stats
        if (playersStats) {
            playersStats.textContent = `Showing ${visibleCount} of <?php echo $totalPlayers; ?> players (<?php echo $playersPerPage; ?> per page) - <?php echo ucfirst(str_replace('-', ' ', $viewType)); ?> View`;
        }
    }
    
    searchInput.addEventListener('input', filterPlayers);
    positionFilter.addEventListener('change', filterPlayers);
    ageGroupFilter.addEventListener('change', filterPlayers);
});

// View player profile
function viewPlayerProfile(playerId) {
    // You can implement AJAX to load player details or redirect to profile page
    window.location.href = 'player-profile.php?id=' + playerId;
}
// View player profile
function viewPlayerProfile(playerId) {
    window.location.href = 'player-profile.php?id=' + playerId;
}
</script>

<?php include 'includes/footer.php'; ?>