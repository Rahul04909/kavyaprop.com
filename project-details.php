<?php
/**
 * Dholera Premium Project Details Page
 * Developed by Expert UI/UX Designer & Developer
 */

// 1. Include Secure DB Connection
require_once __DIR__ . '/includes/db.php';

// Fetch URL Query ID parameter
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. Retrieve Selected Project from Database
try {
    if ($project_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $project_id]);
        $project = $stmt->fetch();
    }
    
    // Fallback to the first project if no valid project ID is provided or found
    if (empty($project)) {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY id ASC LIMIT 1");
        $project = $stmt->fetch();
    }
    
    if (!$project) {
        die("<div style='font-family: sans-serif; text-align: center; padding: 50px;'><h3>Database Initialization Incomplete</h3><p>Please ensure your database is seeded. Access the administrative dashboard to register new projects.</p></div>");
    }
    
} catch (PDOException $e) {
    die("Database Connection Failure: " . $e->getMessage());
}

// 3. Decode JSON structures securely with fallbacks
$thumbs    = json_decode($project['thumbs'],    true) ?: [$project['main_image']];
$amenities = json_decode($project['amenities'], true) ?: [];

// 4. Pull flash messages set by process-enquiry.php
$enq_success = $_SESSION['enq_success'] ?? '';
$enq_error   = $_SESSION['enq_error']   ?? '';
$enq_old     = $_SESSION['enq_old']     ?? [];
unset($_SESSION['enq_success'], $_SESSION['enq_error'], $_SESSION['enq_old']);

// 5. Generate CSRF token
$csrf = generateCSRFToken();

// Helper to render stars
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- High-End SEO Optimization of Projects -->
  <title><?php echo htmlspecialchars($project['seo_title'] ?: $project['title']); ?> - Dholera Smart City</title>
  <meta name="description" content="<?php echo htmlspecialchars($project['seo_description'] ?: substr(strip_tags($project['description']), 0, 160)); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($project['seo_keywords'] ?? 'dholera plots, smart green city, gujarat real estate'); ?>">
  
  <!-- Preconnect and Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Page Styling Sheets -->
  <link rel="stylesheet" href="assets/css/project-details.css">
</head>
<body>

  <!-- 1. Header include -->
  <?php include 'includes/header.php'; ?>

  <!-- 2. Breadcrumbs Navigation (Professional UX) -->
  <nav class="dh-details-breadcrumbs" aria-label="Breadcrumb">
    <div class="dh-details-breadcrumbs-container">
      <a href="index.php">Home</a>
      <span>/</span>
      <a href="index.php#projects">Projects</a>
      <span>/</span>
      <span style="color: #334155; font-weight: 600; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><?php echo htmlspecialchars($project['title']); ?></span>
    </div>
  </nav>

  <!-- 3. Title Showcase block -->
  <header class="dh-details-header-section">
    <div class="dh-details-header-container">
      <span class="dh-details-category"><?php echo htmlspecialchars($project['category']); ?></span>
      <h1 class="dh-details-title"><?php echo htmlspecialchars($project['title']); ?></h1>
      
      <div class="dh-details-meta">
        <div class="dh-details-rating-row">
          <span class="dh-details-rating-val"><?php echo number_format($project['rating'], 1); ?></span>
          <span class="dh-details-stars">
            <?php echo renderDhStars($project['rating']); ?>
          </span>
          <span>(<?php echo htmlspecialchars($project['reviews']); ?> reviews)</span>
        </div>
        
        <span class="dh-details-meta-item">
          <i class="fa-solid fa-location-dot"></i>
          <?php echo htmlspecialchars($project['location']); ?>
        </span>
        
        <span class="dh-details-meta-item">
          <i class="fa-solid fa-file-shield"></i>
          RERA Approved
        </span>
      </div>
    </div>
  </header>

  <!-- 4. Two-Column Main Content Block -->
  <section class="dh-details-main-section">
    <div class="dh-details-main-grid">
      
      <!-- Left Column: Specs, Gallery, About -->
      <div class="dh-details-content-column">
        
        <!-- Interactive Image Gallery -->
        <div class="dh-details-gallery" aria-label="Project Gallery">
          <div class="dh-details-gallery-main">
            <img src="<?php echo htmlspecialchars($project['main_image']); ?>" id="dhDetailsMainImage" alt="<?php echo htmlspecialchars($project['title']); ?> Large Showcase">
          </div>
          
          <!-- Thumbnail Click Selectors -->
          <div class="dh-details-gallery-thumbs">
            <?php foreach ($thumbs as $index => $thumb): ?>
              <button class="dh-details-gallery-thumb <?php echo ($index === 0) ? 'dh-active' : ''; ?>" onclick="swapDetailsGallery(this, '<?php echo htmlspecialchars(addslashes($thumb)); ?>')" aria-label="Showcase Thumbnail <?php echo $index + 1; ?>">
                <img src="<?php echo htmlspecialchars($thumb); ?>" alt="Thumbnail Visual <?php echo $index + 1; ?>">
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Project Parameter Specifications -->
        <div class="dh-details-specs-card">
          <h3 class="dh-details-section-title">Property Specifications</h3>
          <div class="dh-details-specs-grid">
            
            <div class="dh-details-specs-item">
              <i class="fa-solid fa-compass-drafting dh-details-specs-icon"></i>
              <div class="dh-details-specs-info">
                <span class="dh-details-specs-label">Plot Sizes</span>
                <span class="dh-details-specs-value"><?php echo htmlspecialchars($project['size']); ?></span>
              </div>
            </div>
            
            <div class="dh-details-specs-item">
              <i class="fa-solid fa-building-circle-check dh-details-specs-icon"></i>
              <div class="dh-details-specs-info">
                <span class="dh-details-specs-label">Registry Status</span>
                <span class="dh-details-specs-value"><?php echo htmlspecialchars($project['status']); ?></span>
              </div>
            </div>
            
            <div class="dh-details-specs-item">
              <i class="fa-solid fa-road dh-details-specs-icon"></i>
              <div class="dh-details-specs-info">
                <span class="dh-details-specs-label">Internal Road Width</span>
                <span class="dh-details-specs-value"><?php echo htmlspecialchars($project['road']); ?></span>
              </div>
            </div>
            
            <div class="dh-details-specs-item">
              <i class="fa-solid fa-bolt dh-details-specs-icon"></i>
              <div class="dh-details-specs-info">
                <span class="dh-details-specs-label">Power Utilities</span>
                <span class="dh-details-specs-value"><?php echo htmlspecialchars($project['power']); ?></span>
              </div>
            </div>
            
            <div class="dh-details-specs-item">
              <i class="fa-solid fa-faucet-drip dh-details-specs-icon"></i>
              <div class="dh-details-specs-info">
                <span class="dh-details-specs-label">Water Network</span>
                <span class="dh-details-specs-value"><?php echo htmlspecialchars($project['water']); ?></span>
              </div>
            </div>
            
            <div class="dh-details-specs-item">
              <i class="fa-solid fa-signature dh-details-specs-icon"></i>
              <div class="dh-details-specs-info">
                <span class="dh-details-specs-label">RERA Registration</span>
                <span class="dh-details-specs-value" style="font-size: 11px; word-break: break-all;"><?php echo htmlspecialchars($project['rera']); ?></span>
              </div>
            </div>

          </div>
        </div>

        <!-- Description Paragraph Section -->
        <div class="dh-details-description-card">
          <h3 class="dh-details-section-title">Project Overview</h3>
          <div class="dh-details-description-text">
            <!-- Allow rich HTML content for Trumbowyg rendering -->
            <p><?php echo $project['description']; ?></p>
          </div>
        </div>

        <!-- Amenities Checklist Section -->
        <?php if (!empty($amenities)): ?>
            <div class="dh-details-amenities-card">
              <h3 class="dh-details-section-title">Central Smart Amenities</h3>
              <div class="dh-details-amenities-grid">
                <?php foreach ($amenities as $amenity): ?>
                  <div class="dh-details-amenity-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($amenity); ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
        <?php endif; ?>

      </div>

      <!-- Right Column: Sticky Enquiry Sidebar -->
      <div class="dh-details-sidebar-column">
        <div class="dh-details-sidebar-card">
          
          <div class="dh-details-sidebar-price">
            <span class="dh-details-sidebar-price-label">Investment Rate</span>
            <span class="dh-details-sidebar-price-val"><?php echo htmlspecialchars($project['price']); ?></span>
            <span class="dh-details-sidebar-price-sub"><?php echo htmlspecialchars($project['price_sub']); ?></span>
          </div>
          
          <!-- Sticky Sidebar Enquiry Form -->

          <!-- Flash Messages -->
          <?php if (!empty($enq_success)): ?>
            <div class="dh-pd-alert dh-pd-alert-success" id="pdAlertSuccess">
              <i class="fa-solid fa-circle-check"></i>
              <span><?php echo htmlspecialchars($enq_success); ?></span>
              <button onclick="document.getElementById('pdAlertSuccess').remove()">&times;</button>
            </div>
          <?php endif; ?>
          <?php if (!empty($enq_error)): ?>
            <div class="dh-pd-alert dh-pd-alert-error" id="pdAlertError">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span><?php echo htmlspecialchars($enq_error); ?></span>
              <button onclick="document.getElementById('pdAlertError').remove()">&times;</button>
            </div>
          <?php endif; ?>

          <form class="dh-details-sidebar-form" action="process-enquiry.php" method="POST" id="pdEnqForm" novalidate>

            <!-- Hidden: CSRF + project context -->
            <input type="hidden" name="csrf_token"    value="<?php echo $csrf; ?>">
            <input type="hidden" name="project_id"    value="<?php echo (int)$project['id']; ?>">
            <input type="hidden" name="interest"      value="project-<?php echo htmlspecialchars($project['category']); ?>">
            <input type="hidden" name="message"       id="pdAutoMsg" value="">

            <input class="dh-details-sidebar-input"
                   type="text" name="name" id="pdName"
                   placeholder="Full Name"
                   value="<?php echo htmlspecialchars($enq_old['name'] ?? ''); ?>"
                   required maxlength="150">

            <input class="dh-details-sidebar-input"
                   type="email" name="email" id="pdEmail"
                   placeholder="Email Address"
                   value="<?php echo htmlspecialchars($enq_old['email'] ?? ''); ?>"
                   required maxlength="255">

            <input class="dh-details-sidebar-input"
                   type="tel" name="phone" id="pdPhone"
                   placeholder="Phone Number"
                   value="<?php echo htmlspecialchars($enq_old['phone'] ?? ''); ?>"
                   required maxlength="20">

            <button class="dh-details-sidebar-btn" type="submit" id="pdSubmitBtn">
              <span class="pd-btn-text"><i class="fa-solid fa-file-arrow-down"></i> Download Brochure &amp; Enquire</span>
              <span class="pd-btn-loader" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i> Submitting…</span>
            </button>
            
            <a href="tel:+919220551771" class="dh-details-sidebar-sec-btn">
              <i class="fa-solid fa-phone"></i> Call Agent Direct
            </a>
          </form>

        </div>
      </div>

    </div>
  </section>

  <!-- 5. Footer include -->
  <?php include 'includes/footer.php'; ?>

  <!-- Gallery Switcher JavaScript Mechanics -->
  <script>
  function swapDetailsGallery(thumbElement, imageSrc) {
    // 1. Swap main image source with dynamic smooth opacity fade transition
    const mainImg = document.getElementById('dhDetailsMainImage');
    mainImg.style.opacity = 0;
    
    setTimeout(() => {
      mainImg.src = imageSrc;
      mainImg.style.opacity = 1;
    }, 200);

    // 2. Toggle active borders on thumbnails
    const thumbs = document.querySelectorAll('.dh-details-gallery-thumb');
    thumbs.forEach(thumb => {
      thumb.classList.remove('dh-active');
    });
    thumbElement.classList.add('dh-active');
  }

  // ── Sidebar Enquiry Form ──────────────────────────────────────────────
  (function () {
    const form    = document.getElementById('pdEnqForm');
    const btn     = document.getElementById('pdSubmitBtn');
    const autoMsg = document.getElementById('pdAutoMsg');

    if (!form || !btn || !autoMsg) return;

    // Auto-populate hidden message field with project context before submit
    form.addEventListener('submit', function (e) {
      const name    = document.getElementById('pdName')?.value.trim()  || '';
      const phone   = document.getElementById('pdPhone')?.value.trim() || '';
      const project = form.querySelector('[name="project_id"]')?.value  || '';

      autoMsg.value = `Enquiry from project details page. Project ID: ${project}. `
                    + `Visitor ${name} (${phone}) is interested in this project and requests a brochure or callback.`;

      // Show loading spinner
      btn.querySelector('.pd-btn-text').style.display  = 'none';
      btn.querySelector('.pd-btn-loader').style.display = 'inline-flex';
      btn.disabled = true;
    });

    // Auto-scroll to alert if success/error present on load
    const successAlert = document.getElementById('pdAlertSuccess');
    const errorAlert   = document.getElementById('pdAlertError');
    const alertEl      = successAlert || errorAlert;
    if (alertEl) {
      setTimeout(() => alertEl.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
    }
  })();
  </script>
</body>
</html>
