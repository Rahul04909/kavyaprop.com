<?php
/**
 * Dholera Premium Projects Component (Udemy/Course Style)
 * Developed by Expert UI/UX Designer & Developer
 */

// 1. Include Secure DB & Commons
require_once __DIR__ . '/../includes/db.php';

// 2. Query all projects from database
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY id ASC");
    $dh_projects_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $dh_projects_list = [];
}

// Inline helper function to render beautiful gold rating stars
if (!function_exists('renderDhStars')) {
    function renderDhStars($rating) {
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
?>

<!-- Load Projects Stylesheet -->
<link rel="stylesheet" href="assets/css/projects.css">

<section class="dh-projects-section" id="projects">
  <div class="dh-projects-container">
    
    <!-- Title and Subtitle Block -->
    <div class="dh-projects-header">
      <span class="dh-projects-subtitle">Featured Smart Plots</span>
      <h2 class="dh-projects-title">Explore Premium Dholera Projects</h2>
    </div>

    <!-- Cards Row and Slider Wrappers -->
    <div class="dh-projects-slider-wrapper">
      
      <!-- Circular Left Arrow Button (udemy overlap style) -->
      <button class="dh-project-arrow dh-project-arrow-left" id="dhProjArrowLeft" aria-label="Scroll Left">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <!-- Horizontal Cards Scroller Container -->
      <div class="dh-projects-cards-container" id="dhProjCardsContainer">
        <?php if (empty($dh_projects_list)): ?>
          <div class="w-100 text-center py-5 text-muted">
            <i class="fa-solid fa-folder-open display-4 mb-3 d-block text-secondary"></i>
            No plots are currently available. Check back soon!
          </div>
        <?php else: ?>
          <?php foreach ($dh_projects_list as $proj): ?>
            <a href="project-details.php?id=<?php echo $proj['id']; ?>" class="dh-project-card">
              <!-- Top Rounded Card Thumbnail -->
              <div class="dh-project-card-image-box">
                <img src="<?php echo htmlspecialchars($proj['main_image']); ?>" alt="<?php echo htmlspecialchars($proj['title']); ?>" class="dh-project-card-image" loading="lazy">
              </div>

              <!-- Card Descriptions -->
              <div class="dh-project-card-body">
                <span class="badge badge-success px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block;"><?php echo htmlspecialchars($proj['category']); ?></span>
                <h3 class="dh-project-card-title" title="<?php echo htmlspecialchars($proj['title']); ?>">
                  <?php echo htmlspecialchars($proj['title']); ?>
                </h3>
                <p class="dh-project-card-author text-muted">
                  <i class="fa-solid fa-location-dot text-danger mr-1"></i> <?php echo htmlspecialchars($proj['location']); ?>
                </p>
                
                <!-- Star Ratings -->
                <div class="dh-project-card-rating mt-2">
                  <span class="dh-project-rating-val"><?php echo number_format($proj['rating'], 1); ?></span>
                  <span class="dh-project-stars">
                    <?php echo renderDhStars($proj['rating']); ?>
                  </span>
                  <span class="dh-project-reviews-count">(<?php echo htmlspecialchars($proj['reviews']); ?> ratings)</span>
                </div>
                
                <!-- View Details Button -->
                <div class="dh-project-btn-box mt-3">
                  <span class="dh-project-view-btn" style="display: block; text-align: center;">View Details <i class="fa-solid fa-angle-right"></i></span>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Circular Right Arrow Button (udemy overlap style) -->
      <button class="dh-project-arrow dh-project-arrow-right" id="dhProjArrowRight" aria-label="Scroll Right">
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>

    <!-- Bottom "Show All" Link -->
    <div class="dh-projects-showall">
      <a href="#about-us" class="dh-projects-link">
        Show all Dholera Smart City Projects <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>

  </div>
</section>

<!-- Cards Navigation Control Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('dhProjCardsContainer');
  const leftArrow = document.getElementById('dhProjArrowLeft');
  const rightArrow = document.getElementById('dhProjArrowRight');

  if (!container || !leftArrow || !rightArrow) return;

  // A. Determine scroll metrics and update arrow visibilities dynamically
  const updateArrowVisibility = () => {
    const scrollLeft = container.scrollLeft;
    const maxScrollLeft = container.scrollWidth - container.clientWidth;

    // Show left arrow if scrolled past start
    if (scrollLeft > 5) {
      leftArrow.classList.add('dh-arrow-visible');
    } else {
      leftArrow.classList.remove('dh-arrow-visible');
    }

    // Show right arrow if there is scrollable content remaining on the right
    if (scrollLeft < maxScrollLeft - 5) {
      rightArrow.classList.add('dh-arrow-visible');
    } else {
      rightArrow.classList.remove('dh-arrow-visible');
    }
  };

  // B. Attach scroll listener to update visibility in real-time
  container.addEventListener('scroll', updateArrowVisibility);
  
  // Also run on resize to adapt boundaries
  window.addEventListener('resize', updateArrowVisibility);

  // Initial trigger
  setTimeout(updateArrowVisibility, 300);

  // C. Arrow Click scrolling calculations
  const getScrollDistance = () => {
    return container.clientWidth * 0.75;
  };

  leftArrow.addEventListener('click', () => {
    container.scrollBy({
      left: -getScrollDistance(),
      behavior: 'smooth'
    });
  });

  rightArrow.addEventListener('click', () => {
    container.scrollBy({
      left: getScrollDistance(),
      behavior: 'smooth'
    });
  });
});
</script>
