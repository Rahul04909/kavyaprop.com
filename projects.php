<?php
/**
 * Dholera Premium Projects Catalog Page
 * Meticulous search, category filtering, sidebar, and robust pagination.
 * Developed by Expert Developer & UI/UX Designer.
 */
require_once 'includes/db.php';

// 1. Initialize query parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 4; // Show 4 items per page to elegantly demonstrate pagination
$offset = ($page - 1) * $limit;

// 2. Fetch category counts dynamically for the sidebar filter
$catCounts = [];
try {
    $countsStmt = $pdo->query("SELECT category, COUNT(*) as cnt FROM projects GROUP BY category");
    while ($row = $countsStmt->fetch()) {
        $catCounts[$row['category']] = $row['cnt'];
    }
} catch (PDOException $e) {
    // Fail silently
}

// 3. Build filtered SQL statements
$sql = "SELECT * FROM projects WHERE 1=1";
$countSql = "SELECT COUNT(*) FROM projects WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (title LIKE :search OR description LIKE :search OR location LIKE :search)";
    $countSql .= " AND (title LIKE :search OR description LIKE :search OR location LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if (!empty($category)) {
    $sql .= " AND category = :category";
    $countSql .= " AND category = :category";
    $params[':category'] = $category;
}

// Order logically
$sql .= " ORDER BY id ASC";

// 4. Fetch total records for pagination
try {
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $total_records = (int)$countStmt->fetchColumn();
} catch (PDOException $e) {
    $total_records = 0;
}

$total_pages = ceil($total_records / $limit);
if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
    $offset = ($page - 1) * $limit;
}

// 5. Fetch paginated records securely
try {
    $stmt = $pdo->prepare($sql . " LIMIT :limit OFFSET :offset");
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    $projects_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $projects_list = [];
}

// helper function to render rating stars
if (!function_exists('renderListStars')) {
    function renderListStars($rating) {
        $full = floor($rating);
        $half = ($rating - $full) >= 0.5 ? 1 : 0;
        $empty = 5 - ($full + $half);
        
        $starsHtml = '';
        for ($i = 0; $i < $full; $i++) {
            $starsHtml .= '<i class="fa-solid fa-star"></i>';
        }
        if ($half) {
            $starsHtml .= '<i class="fa-solid fa-star-half-stroke"></i>';
        }
        for ($i = 0; $i < $empty; $i++) {
            $starsHtml .= '<i class="fa-regular fa-star"></i>';
        }
        return $starsHtml;
    }
}

// Categories list helper
$allCategories = [
    'Residential Villa Plots',
    'Industrial Economic Land',
    'Commercial Infrastructure Space',
    'Premium Residential Land',
    'Logistics & Warehousing Land'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Explore Dholera Smart City Projects catalog. Discover premium residential, commercial, industrial and warehousing plot investments near Dholera International Airport with RERA titles.">
  <title>Premium Smart Plots &amp; Investments | Dholera Projects</title>
  
  <!-- Fonts & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Global Base Styles & Custom Page Styles -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/projects.css">
  <link rel="stylesheet" href="assets/css/projects-list.css">
</head>
<body>

  <!-- Include Sticky Navigation Header -->
  <?php include 'includes/header.php'; ?>

  <!-- 🔷 Page Hero Banner Section -->
  <section class="dh-projlist-hero">
    <h1>Explore Premium Dholera Projects</h1>
    <p>Discover government-approved, registry-ready smart plots with plug-and-play underground utility connectivity.</p>
  </section>

  <!-- 🔷 Main List Section with Sidebar & Grid -->
  <section class="dh-projlist-section">
    <div class="dh-projlist-container">
      
      <!-- 🔷 1. LEFT SIDEBAR: FILTERS -->
      <aside class="dh-projlist-sidebar">
        
        <!-- Search Form Widget -->
        <div>
          <h3 class="dh-sidebar-widget-title">Search Projects</h3>
          <form method="GET" action="projects.php" class="dh-search-box">
            <?php if (!empty($category)): ?>
              <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <?php endif; ?>
            <input type="text" name="search" class="dh-search-input" placeholder="Type keyword..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="dh-search-btn" aria-label="Submit Search">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </form>
        </div>
        
        <!-- Category Filter Widget -->
        <div>
          <h3 class="dh-sidebar-widget-title">Categories</h3>
          <div class="dh-filter-list">
            <a href="projects.php?<?php echo !empty($search) ? 'search='.urlencode($search) : ''; ?>" class="dh-filter-link <?php echo empty($category) ? 'active' : ''; ?>">
              <span>All Categories</span>
              <span class="dh-filter-count"><?php echo array_sum($catCounts); ?></span>
            </a>
            <?php foreach ($allCategories as $cat): ?>
              <?php 
              $activeClass = ($category === $cat) ? 'active' : '';
              $countVal = isset($catCounts[$cat]) ? $catCounts[$cat] : 0;
              $catQuery = 'category=' . urlencode($cat) . (!empty($search) ? '&search=' . urlencode($search) : '');
              ?>
              <a href="projects.php?<?php echo $catQuery; ?>" class="dh-filter-link <?php echo $activeClass; ?>">
                <span><?php echo htmlspecialchars($cat); ?></span>
                <span class="dh-filter-count"><?php echo $countVal; ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        

        
        <!-- Reset Widget (Only visible if active filter is applied) -->
        <?php if (!empty($search) || !empty($category)): ?>
          <a href="projects.php" class="dh-reset-btn">
            <i class="fa-solid fa-rotate-left mr-1"></i> Reset All Filters
          </a>
        <?php endif; ?>

      </aside>
      
      <!-- 🔷 2. RIGHT SIDE: CONTENT & CARDS GRID -->
      <main class="dh-projlist-main">
        
        <!-- Search Results Counter Info Bar -->
        <div class="dh-projlist-header-bar">
          <p class="dh-results-count">
            Showing <?php echo empty($projects_list) ? 0 : ($offset + 1); ?> - <?php echo min($offset + $limit, $total_records); ?> of <?php echo $total_records; ?> premium results
            <?php if (!empty($search)) echo ' for "' . htmlspecialchars($search) . '"'; ?>
          </p>
        </div>
        
        <!-- Projects Grid -->
        <div class="dh-projlist-grid">
          <?php if (empty($projects_list)): ?>
            <div style="grid-column: span 3; text-align: center; padding: 60px 20px; background: #ffffff; border: 2px dashed #cbd5e1; border-radius: 12px; color: #64748b;">
              <i class="fa-solid fa-folder-open fa-3x mb-3" style="color: #cbd5e1;"></i>
              <h3 style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #334155; margin-bottom: 8px;">No Smart Plots Found</h3>
              <p style="margin: 0; font-size: 14px;">Try loosening your keyword search or select "All Categories" to see available smart plots.</p>
            </div>
          <?php else: ?>
            <?php foreach ($projects_list as $proj): ?>
              <a href="project-details.php?id=<?php echo $proj['id']; ?>" class="dh-project-card">
                <!-- Top Rounded Card Thumbnail -->
                <div class="dh-project-card-image-box">
                  <img src="<?php echo htmlspecialchars($proj['main_image']); ?>" alt="<?php echo htmlspecialchars($proj['title']); ?>" class="dh-project-card-image" loading="lazy">
                </div>

                <!-- Card Body -->
                <div class="dh-project-card-body">
                  <span class="badge badge-success px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block; background-color: var(--dh-green, #2b6009); color: #fff; border-radius: 4px;"><?php echo htmlspecialchars($proj['category']); ?></span>
                  <h3 class="dh-project-card-title" title="<?php echo htmlspecialchars($proj['title']); ?>">
                    <?php echo htmlspecialchars($proj['title']); ?>
                  </h3>
                  <p class="dh-project-card-author text-muted" style="margin-bottom: 2px;">
                    <i class="fa-solid fa-location-dot text-danger mr-1"></i> <?php echo htmlspecialchars($proj['location']); ?>
                  </p>
                  
                  <!-- RERA Registration details (extremely professional context) -->
                  <p class="dh-project-card-rera">
                    <i class="fa-solid fa-shield-halved text-success mr-1"></i> RERA: <?php echo htmlspecialchars($proj['rera']); ?>
                  </p>
                  
                  <!-- Star Ratings -->
                  <div class="dh-project-card-rating mt-2">
                    <span class="dh-project-rating-val"><?php echo number_format($proj['rating'], 1); ?></span>
                    <span class="dh-project-stars">
                      <?php echo renderListStars($proj['rating']); ?>
                    </span>
                    <span class="dh-project-reviews-count">(<?php echo htmlspecialchars($proj['reviews']); ?> reviews)</span>
                  </div>
                  
                  <!-- View Details Button -->
                  <div class="dh-project-btn-box">
                    <span class="dh-project-view-btn" style="display: block; text-align: center;">View Details <i class="fa-solid fa-angle-right"></i></span>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        
        <!-- 🔷 3. PAGINATION SECTION -->
        <?php if ($total_pages > 1): ?>
          <div class="dh-pagination-wrapper">
            <ul class="dh-pagination">
              
              <!-- Previous Page Button -->
              <?php 
              $prevPage = $page - 1;
              $prevDisabled = ($page <= 1) ? 'disabled' : '';
              $prevQuery = http_build_query(array_merge($_GET, ['page' => $prevPage]));
              ?>
              <li class="dh-page-item <?php echo $prevDisabled; ?>">
                <a class="dh-page-link dh-page-link-nav" href="projects.php?<?php echo $prevQuery; ?>" aria-label="Previous">
                  <i class="fa-solid fa-chevron-left mr-1"></i> Prev
                </a>
              </li>
              
              <!-- Page Number Buttons -->
              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php 
                $activeItem = ($page === $i) ? 'active' : '';
                $numQuery = http_build_query(array_merge($_GET, ['page' => $i]));
                ?>
                <li class="dh-page-item <?php echo $activeItem; ?>">
                  <a class="dh-page-link" href="projects.php?<?php echo $numQuery; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              
              <!-- Next Page Button -->
              <?php 
              $nextPage = $page + 1;
              $nextDisabled = ($page >= $total_pages) ? 'disabled' : '';
              $nextQuery = http_build_query(array_merge($_GET, ['page' => $nextPage]));
              ?>
              <li class="dh-page-item <?php echo $nextDisabled; ?>">
                <a class="dh-page-link dh-page-link-nav" href="projects.php?<?php echo $nextQuery; ?>" aria-label="Next">
                  Next <i class="fa-solid fa-chevron-right ml-1"></i>
                </a>
              </li>
              
            </ul>
          </div>
        <?php endif; ?>

      </main>

    </div>
  </section>

  <!-- Include Responsive Footer Component -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
