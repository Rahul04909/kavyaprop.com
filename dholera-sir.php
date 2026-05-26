<?php
/**
 * Dholera SIR Premium Smart City Promotional Page
 * Fully dynamic and conversion-oriented landing page.
 * Developed by Expert Developer & UI/UX Designer.
 */
require_once 'includes/db.php';

// Fetch registered projects dynamically from DB
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC LIMIT 6");
    $db_projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $db_projects = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dholera Greenfield Smart City - India's Next Global Investment Hub. Discover premium smart plot projects, expressway, airport proximity, and high ROI investment benefits in DSIR near Ahmedabad, Gujarat.">
  <title>Dholera Greenfield Smart City | DSIR Investment Hub</title>
  
  <!-- Montserrat and Outfit Google Fonts & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Global Base Styles & Custom Page Styles -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/dholera-sir.css">
</head>
<body>

  <!-- Include Interactive Responsive Header Component -->
  <?php include 'includes/header.php'; ?>

  <!-- dsir-page-wrapper starts -->
  <div class="dsir-page-wrapper">
    
    <!-- 🔥 1. Limited Plots Banner Highlight -->
    <div class="dsir-limited-banner">
      <i class="fa-solid fa-fire-flame-curved fa-bounce" style="color: #222;"></i>
      <span><strong>LIMITED INVESTMENT PLOTS:</strong> High-ROI smart plots near the Dholera International Airport are booking fast!</span>
      <a href="#enquire-now" class="dsir-btn-primary dsir-btn-glow" style="padding: 6px 14px; font-size: 0.8rem; border-radius: 20px; font-weight: 700; text-transform: uppercase;">Enquire Now</a>
    </div>

    <!-- 🔷 2. HERO SECTION (First fold - Conversion Focused) -->
    <section class="dsir-hero">
      <div class="dsir-hero-grid">
        <!-- Hero Left Info -->
        <div class="dsir-hero-info">
          <span class="dsir-hero-tag"><i class="fa-solid fa-circle-check"></i> WELCOME TO DHOLERA GREENFIELD SMARTCITY</span>
          <h1 class="dsir-hero-title">Dholera Greenfield <br><span>Smart City Investment</span></h1>
          <p class="dsir-hero-subtitle">
            Experience the future of global investment. Dholera SIR is India's premier planned greenfield industrial city near Ahmedabad, featuring world-class multi-modal logistics and plug-and-play utility networks.
          </p>
          <div class="dsir-hero-actions">
            <a href="#projects" class="dsir-btn-primary dsir-btn-glow"><i class="fa-solid fa-compass-drafting"></i> Explore Projects</a>
            <a href="#enquire-now" class="dsir-btn-secondary"><i class="fa-solid fa-cloud-arrow-down"></i> Download Brochure</a>
          </div>
        </div>
        
        <!-- Hero Right Graphic (Visual Badge Card) -->
        <div class="dsir-hero-graphic">
          <div class="dsir-map-badge">
            <h3 class="dsir-badge-title"><i class="fa-solid fa-seedling"></i> DSIR Quick Stats</h3>
            <div class="dsir-badge-stat">
              <span>Total Planned Area</span>
              <span>920 Sq. Km</span>
            </div>
            <div class="dsir-badge-stat">
              <span>Expressway Access</span>
              <span>Ahmedabad-Dholera</span>
            </div>
            <div class="dsir-badge-stat">
              <span>International Airport</span>
              <span>Cargo & Passenger</span>
            </div>
            <div class="dsir-badge-stat">
              <span>Development Stage</span>
              <span>Phase 1 Operational</span>
            </div>
            <div class="dsir-badge-highlight">
              <i class="fa-solid fa-award mr-1"></i> Shanghai Model Infrastructure
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 🔷 3. ABOUT DHOLERA SECTION (2-Column Premium Grid) -->
    <section class="dsir-about" id="about-us">
      <div class="dsir-about-container">
        
        <!-- Left Content -->
        <div class="dsir-about-content">
          <span class="dsir-about-tag">Visionary Smart City</span>
          <h2 class="dsir-about-title">Dholera Special Investment Region (DSIR)</h2>
          <p class="dsir-about-text">
            Dholera SIR is a planned greenfield industrial city developed by the Government of Gujarat. Positioned strategically inside the Delhi-Mumbai Industrial Corridor (DMIC), Dholera lies just 100 km from the metropolitan center of Ahmedabad. It is meticulously engineered to provide sustainable economic hubs and high-quality lifestyles.
          </p>
          
          <!-- Mini Icon Grid -->
          <div class="dsir-about-icon-grid">
            <div class="dsir-about-icon-card">
              <div class="dsir-about-icon-box"><i class="fa-solid fa-industry"></i></div>
              <div>
                <h4>Industrial Hub</h4>
                <p>Plug-and-play setup for Defence & IT</p>
              </div>
            </div>
            
            <div class="dsir-about-icon-card">
              <div class="dsir-about-icon-box"><i class="fa-solid fa-plane-departure"></i></div>
              <div>
                <h4>Airport Planned</h4>
                <p>New International cargo runways</p>
              </div>
            </div>
            
            <div class="dsir-about-icon-card">
              <div class="dsir-about-icon-box"><i class="fa-solid fa-train-subway"></i></div>
              <div>
                <h4>Metro Connectivity</h4>
                <p>High-speed corridor linking Ahmedabad</p>
              </div>
            </div>
            
            <div class="dsir-about-icon-card">
              <div class="dsir-about-icon-box"><i class="fa-solid fa-shield-halved"></i></div>
              <div>
                <h4>Smart Infrastructure</h4>
                <p>Self-healing networks & ICT desks</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right Graphic Visual Card -->
        <div class="dsir-about-graphic" style="background: none; padding: 0; box-shadow: none;">
          <div class="dsir-about-image-container" style="width: 100%; border-radius: 0; overflow: hidden; border: 2px solid #e2e8f0; position: relative; background-color: var(--dsir-light-bg);">
            <img src="assets/images/overview_1779178715.png" alt="Dholera SIR Connectivity Map Overview" style="width: 100%; height: auto; display: block;">
          </div>
        </div>

      </div>
    </section>

    <!-- 🔷 4. PROJECTS SECTION (MySQL Dynamic Integrated Udemy Scroller Style) -->
    <?php include 'components/projects.php'; ?>

    <!-- 🔷 5. USP / INVESTMENT BENEFITS (Grid & Stats) -->
    <section class="dsir-usp" id="usp">
      <div class="dsir-usp-container">
        
        <div class="dsir-section-heading">
          <span class="dsir-section-subtitle">Why Invest In Dholera?</span>
          <h2 class="dsir-section-title">Exponential Growth <span>& Benefits</span></h2>
        </div>
        
        <!-- USP Cards Grid -->
        <div class="dsir-usp-grid">
          <!-- 1. Airport -->
          <div class="dsir-usp-card">
            <div class="dsir-usp-icon"><i class="fa-solid fa-plane-up"></i></div>
            <h3>International Airport</h3>
            <p>A cargo & passenger international airport handles heavy logisitcs routes directly linking Gujarat to international destinations.</p>
          </div>
          
          <!-- 2. Expressway -->
          <div class="dsir-usp-card">
            <div class="dsir-usp-icon"><i class="fa-solid fa-road"></i></div>
            <h3>6-Lane Expressway</h3>
            <p>The Ahmedabad-Dholera Expressway shrinks transit time to under 1 hour, enabling rapid freight operations.</p>
          </div>
          
          <!-- 3. Metro -->
          <div class="dsir-usp-card">
            <div class="dsir-usp-icon"><i class="fa-solid fa-train"></i></div>
            <h3>Metro Connectivity</h3>
            <p>Extended transit lines connecting major cities directly to the smart townships within DSIR.</p>
          </div>
          
          <!-- 4. Industrial Hub -->
          <div class="dsir-usp-card">
            <div class="dsir-usp-icon"><i class="fa-solid fa-microchip"></i></div>
            <h3>Industrial Powerhouse</h3>
            <p>Dedicated spaces for tech sectors, pharmaceutical plants, semiconductor lines, and defense setups.</p>
          </div>
          
          <!-- 5. ROI -->
          <div class="dsir-usp-card">
            <div class="dsir-usp-icon"><i class="fa-solid fa-chart-line"></i></div>
            <h3>High-Yield ROI Zone</h3>
            <p>Early-stage greenfield land plots show strong annual capital appreciation ratios due to rapid development.</p>
          </div>
          
          <!-- 6. Shanghai Model -->
          <div class="dsir-usp-card">
            <div class="dsir-usp-icon"><i class="fa-solid fa-city"></i></div>
            <h3>Shanghai Model</h3>
            <p>Meticulously designed on futuristic development principles with fully underground unified smart utility trenches.</p>
          </div>
        </div>

        <!-- Real-Estate Stats Counter Banner -->
        <div class="dsir-stats-grid">
          <div class="dsir-stat-card">
            <span class="dsir-stat-num">6X</span>
            <span class="dsir-stat-lbl">Bigger Than Shanghai</span>
          </div>
          <div class="dsir-stat-card">
            <span class="dsir-stat-num">₹3K+ Cr</span>
            <span class="dsir-stat-lbl">Infrastructure Investment</span>
          </div>
          <div class="dsir-stat-card">
            <span class="dsir-stat-num">250%</span>
            <span class="dsir-stat-lbl">Expected 5-Year Capital ROI</span>
          </div>
          <div class="dsir-stat-card">
            <span class="dsir-stat-num">100%</span>
            <span class="dsir-stat-lbl">Underground Smart Utilities</span>
          </div>
        </div>

      </div>
    </section>

    <!-- 🔷 6. INFRASTRUCTURE HIGHLIGHTS (Horizontal Premium Timeline Scroller) -->
    <section class="dsir-infra" id="infrastructure">
      <div class="dsir-infra-container" style="max-width: 1200px; position: relative;">
        
        <div class="dsir-section-heading">
          <span class="dsir-section-subtitle">Mega Infrastructure Projects</span>
          <h2 class="dsir-section-title">Timeline of <span>Growth</span></h2>
        </div>
        
        <!-- Cards Row and Slider Wrappers (Udemy Scroller Style) -->
        <div class="dh-projects-slider-wrapper">
          
          <!-- Circular Left Arrow Button (udemy overlap style) -->
          <button class="dh-project-arrow dh-project-arrow-left" id="dhRoadmapArrowLeft" aria-label="Scroll Left">
            <i class="fa-solid fa-chevron-left"></i>
          </button>

          <!-- Horizontal Cards Scroller Container -->
          <div class="dh-projects-cards-container" id="dhRoadmapCardsContainer">
            
            <!-- Card 1: Airport -->
            <a href="#enquire-now" class="dh-project-card dsir-roadmap-card">
              <!-- Top Rounded Card Thumbnail -->
              <div class="dh-project-card-image-box">
                <img src="assets/images/banner3.png" alt="Dholera International Airport" class="dh-project-card-image" loading="lazy">
                <!-- Phase Floating Badge -->
                <span class="dsir-roadmap-num-badge">Phase 01</span>
              </div>

              <!-- Card Descriptions -->
              <div class="dh-project-card-body">
                <div>
                  <span class="badge badge-soon px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block; border-radius: 4px;">UNDER DEVELOPMENT</span>
                </div>
                <h3 class="dh-project-card-title" title="Dholera International Airport">
                  Dholera International Airport
                </h3>
                <p class="dh-project-card-author text-muted" style="margin-bottom: 8px;">
                  <i class="fa-solid fa-location-dot text-danger mr-1"></i> Navagam, Dholera SIR
                </p>
                <p class="dsir-roadmap-desc" style="font-family: 'Outfit', sans-serif; font-size: 13px; color: #64748b; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 78px; margin: 0;">
                  Under construction across 1,426 hectares near Navagam. Planned as a premier cargo and aviation center supporting heavy international trade corridors.
                </p>
              </div>
            </a>
            
            <!-- Card 2: Expressway -->
            <a href="#enquire-now" class="dh-project-card dsir-roadmap-card">
              <!-- Top Rounded Card Thumbnail -->
              <div class="dh-project-card-image-box">
                <img src="assets/images/banner2.png" alt="Ahmedabad-Dholera Expressway" class="dh-project-card-image" loading="lazy">
                <!-- Phase Floating Badge -->
                <span class="dsir-roadmap-num-badge">Phase 02</span>
              </div>

              <!-- Card Descriptions -->
              <div class="dh-project-card-body">
                <div>
                  <span class="badge badge-soon px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block; border-radius: 4px;">COMPLETION NEAR</span>
                </div>
                <h3 class="dh-project-card-title" title="Ahmedabad-Dholera Expressway">
                  Ahmedabad-Dholera Expressway
                </h3>
                <p class="dh-project-card-author text-muted" style="margin-bottom: 8px;">
                  <i class="fa-solid fa-location-dot text-danger mr-1"></i> Ahmedabad-Dholera Corridor
                </p>
                <p class="dsir-roadmap-desc" style="font-family: 'Outfit', sans-serif; font-size: 13px; color: #64748b; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 78px; margin: 0;">
                  6-lane wide highway corridor built to slash transit time to under 1 hour. Seamlessly connects the Ahmedabad metropolis directly to Dholera.
                </p>
              </div>
            </a>
            
            <!-- Card 3: Metro -->
            <a href="#enquire-now" class="dh-project-card dsir-roadmap-card">
              <!-- Top Rounded Card Thumbnail -->
              <div class="dh-project-card-image-box">
                <img src="assets/images/hero-bg.png" alt="Metro Transit Network" class="dh-project-card-image" loading="lazy">
                <!-- Phase Floating Badge -->
                <span class="dsir-roadmap-num-badge">Phase 03</span>
              </div>

              <!-- Card Descriptions -->
              <div class="dh-project-card-body">
                <div>
                  <span class="badge badge-planned px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block; border-radius: 4px;">PLANNED & APPROVED</span>
                </div>
                <h3 class="dh-project-card-title" title="Metro Transit Network">
                  Metro Transit Network
                </h3>
                <p class="dh-project-card-author text-muted" style="margin-bottom: 8px;">
                  <i class="fa-solid fa-location-dot text-danger mr-1"></i> DSIR Transit Corridor
                </p>
                <p class="dsir-roadmap-desc" style="font-family: 'Outfit', sans-serif; font-size: 13px; color: #64748b; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 78px; margin: 0;">
                  High-speed metro rail extensions linking the city core directly to key residential, logistics, and CBD business zones inside DSIR.
                </p>
              </div>
            </a>
            
            <!-- Card 4: Utilities -->
            <a href="#enquire-now" class="dh-project-card dsir-roadmap-card">
              <!-- Top Rounded Card Thumbnail -->
              <div class="dh-project-card-image-box">
                <img src="assets/images/thumb4.png" alt="Underground Smart Utilities" class="dh-project-card-image" loading="lazy">
                <!-- Phase Floating Badge -->
                <span class="dsir-roadmap-num-badge">Phase 04</span>
              </div>

              <!-- Card Descriptions -->
              <div class="dh-project-card-body">
                <div>
                  <span class="badge badge-active px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block; border-radius: 4px;">FULLY OPERATIONAL</span>
                </div>
                <h3 class="dh-project-card-title" title="Underground Smart Utilities">
                  Underground Smart Utilities
                </h3>
                <p class="dh-project-card-author text-muted" style="margin-bottom: 8px;">
                  <i class="fa-solid fa-location-dot text-danger mr-1"></i> Underground Plug-and-Play
                </p>
                <p class="dsir-roadmap-desc" style="font-family: 'Outfit', sans-serif; font-size: 13px; color: #64748b; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 78px; margin: 0;">
                  All plug-and-play utilities (gas pipelines, raw water channels, high-voltage cabling, fiber lines) are unified completely underground.
                </p>
              </div>
            </a>
            
            <!-- Card 5: Industrial -->
            <a href="#enquire-now" class="dh-project-card dsir-roadmap-card">
              <!-- Top Rounded Card Thumbnail -->
              <div class="dh-project-card-image-box">
                <img src="assets/images/thumb5.png" alt="Industrial Activation Zones" class="dh-project-card-image" loading="lazy">
                <!-- Phase Floating Badge -->
                <span class="dsir-roadmap-num-badge">Phase 05</span>
              </div>

              <!-- Card Descriptions -->
              <div class="dh-project-card-body">
                <div>
                  <span class="badge badge-active px-2 py-1 mb-2 font-weight-bold" style="font-size: 10px; display: inline-block; border-radius: 4px;">ANCHOR UNITS ACTIVE</span>
                </div>
                <h3 class="dh-project-card-title" title="Industrial Activation Zones">
                  Industrial Activation Zones
                </h3>
                <p class="dh-project-card-author text-muted" style="margin-bottom: 8px;">
                  <i class="fa-solid fa-location-dot text-danger mr-1"></i> DSIR Activation Zone
                </p>
                <p class="dsir-roadmap-desc" style="font-family: 'Outfit', sans-serif; font-size: 13px; color: #64748b; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 78px; margin: 0;">
                  Dedicated industrial acreage seed-funded and actively running defense manufacturing, semiconductor lines, and IT centers.
                </p>
              </div>
            </a>

          </div>

          <!-- Circular Right Arrow Button (udemy overlap style) -->
          <button class="dh-project-arrow dh-project-arrow-right" id="dhRoadmapArrowRight" aria-label="Scroll Right">
            <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>

      </div>
    </section>

    <!-- Roadmap Horizontal Slider Controls JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('dhRoadmapCardsContainer');
      const leftArrow = document.getElementById('dhRoadmapArrowLeft');
      const rightArrow = document.getElementById('dhRoadmapArrowRight');

      if (!container || !leftArrow || !rightArrow) return;

      // Determine boundaries and toggle circular arrow overlay visibilities
      const updateArrowVisibility = () => {
        const scrollLeft = container.scrollLeft;
        const maxScrollLeft = container.scrollWidth - container.clientWidth;

        if (scrollLeft > 5) {
          leftArrow.classList.add('dh-arrow-visible');
        } else {
          leftArrow.classList.remove('dh-arrow-visible');
        }

        if (scrollLeft < maxScrollLeft - 5) {
          rightArrow.classList.add('dh-arrow-visible');
        } else {
          rightArrow.classList.remove('dh-arrow-visible');
        }
      };

      container.addEventListener('scroll', updateArrowVisibility);
      window.addEventListener('resize', updateArrowVisibility);
      setTimeout(updateArrowVisibility, 300);

      // Scroll calculation formula
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

    <!-- 🔷 7. MEGA DEVELOPERS TICKER SECTION -->
    <section class="dsir-gallery" id="developers" style="padding: 80px 0; background-color: var(--dsir-white);">
      <div class="dsir-gallery-container" style="max-width: 100%; width: 100%; padding: 0;">
        
        <div class="dsir-section-heading" style="max-width: 1200px; margin: 0 auto 50px auto; padding: 0 20px; box-sizing: border-box;">
          <span class="dsir-section-subtitle">Mega Developers &amp; Partners</span>
          <h2 class="dsir-section-title">Major Giants Behind <span>Dholera SIR</span></h2>
        </div>
        
        <!-- Infinite Brand Logo Ticker (News Ticker Style) -->
        <div class="dsir-ticker-wrapper">
          <div class="dsir-ticker">
            
            <!-- First Group (Original) -->
            <div class="dsir-ticker-group">
              <!-- Logo 1: TATA -->
              <div class="dsir-ticker-logo" title="TATA Conglomerate">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="900" font-size="20" fill="#005a9c" text-anchor="middle" letter-spacing="1.5">TATA</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="2.5">POWER &amp; LOGISTICS</text>
                </svg>
              </div>
              
              <!-- Logo 2: L&T -->
              <div class="dsir-ticker-logo" title="Larsen &amp; Toubro">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="22" fill="#1e3a8a" text-anchor="middle" letter-spacing="-0.5">L&amp;T</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="3">CONSTRUCTION</text>
                </svg>
              </div>
              
              <!-- Logo 3: ADANI -->
              <div class="dsir-ticker-logo" title="Adani Group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="20" fill="#006400" text-anchor="middle">adani</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="2">RENEWABLES</text>
                </svg>
              </div>
              
              <!-- Logo 4: TORRENT -->
              <div class="dsir-ticker-logo" title="Torrent Power">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="18" fill="#ef7d00" text-anchor="middle" letter-spacing="0.5">torrent</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="3.5">POWER</text>
                </svg>
              </div>
              
              <!-- Logo 5: GMR -->
              <div class="dsir-ticker-logo" title="GMR Infrastructure">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="900" font-size="22" fill="#d97706" text-anchor="middle">GMR</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="1.5">INFRASTRUCTURE</text>
                </svg>
              </div>
              
              <!-- Logo 6: RENEW -->
              <div class="dsir-ticker-logo" title="ReNew Power">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="19" fill="#059669" text-anchor="middle" letter-spacing="0.5">ReNew</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="2">POWER &amp; UTILITIES</text>
                </svg>
              </div>
            </div>
            
            <!-- Second Group (Clone for infinite seamless loop scroll) -->
            <div class="dsir-ticker-group" aria-hidden="true">
              <!-- Logo 1: TATA -->
              <div class="dsir-ticker-logo" title="TATA Conglomerate">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="900" font-size="20" fill="#005a9c" text-anchor="middle" letter-spacing="1.5">TATA</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="2.5">POWER &amp; LOGISTICS</text>
                </svg>
              </div>
              
              <!-- Logo 2: L&T -->
              <div class="dsir-ticker-logo" title="Larsen &amp; Toubro">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="22" fill="#1e3a8a" text-anchor="middle" letter-spacing="-0.5">L&amp;T</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="3">CONSTRUCTION</text>
                </svg>
              </div>
              
              <!-- Logo 3: ADANI -->
              <div class="dsir-ticker-logo" title="Adani Group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="20" fill="#006400" text-anchor="middle">adani</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="2">RENEWABLES</text>
                </svg>
              </div>
              
              <!-- Logo 4: TORRENT -->
              <div class="dsir-ticker-logo" title="Torrent Power">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="18" fill="#ef7d00" text-anchor="middle" letter-spacing="0.5">torrent</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="3.5">POWER</text>
                </svg>
              </div>
              
              <!-- Logo 5: GMR -->
              <div class="dsir-ticker-logo" title="GMR Infrastructure">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="900" font-size="22" fill="#d97706" text-anchor="middle">GMR</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="1.5">INFRASTRUCTURE</text>
                </svg>
              </div>
              
              <!-- Logo 6: RENEW -->
              <div class="dsir-ticker-logo" title="ReNew Power">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 50" width="120" height="50">
                  <text x="50%" y="28" font-family="'Montserrat', sans-serif" font-weight="800" font-size="19" fill="#059669" text-anchor="middle" letter-spacing="0.5">ReNew</text>
                  <text x="50%" y="42" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.5" fill="#64748b" text-anchor="middle" letter-spacing="2">POWER &amp; UTILITIES</text>
                </svg>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 🔷 8. TESTIMONIAL SECTION (Premium Autoplay Quote Slider) -->
    <section class="dsir-testimonial" id="testimonials">
      <div class="dsir-testimonial-container">
        
        <div class="dsir-section-heading">
          <span class="dsir-section-subtitle">Client Reviews</span>
          <h2 class="dsir-section-title">What Investors <span>Say About Us</span></h2>
        </div>
        
        <!-- Testimonial Slider Outer Box -->
        <div class="dsir-testimonial-slider-wrapper">
          <div class="dsir-testimonial-slides" id="dsirTestimonialSlides">
            
            <!-- Slide 1: Pritesh Shah -->
            <div class="dsir-testimonial-slide active">
              <div class="dsir-testimonial-card">
                <span class="dsir-card-quote"><i class="fa-solid fa-quote-left"></i></span>
                <!-- Star Trust Ratings -->
                <div class="dsir-testimonial-stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
                <p class="dsir-testimonial-text">
                  "Dholera SIR offers the most transparent, high-appreciation property investment avenue in India. The infrastructure stage is highly advanced, and having a planned airport nearby secures absolute capital growth."
                </p>
                <div class="dsir-testimonial-author">
                  <img src="assets/images/avatar_pritesh.png" alt="Mr. Pritesh Shah" class="dsir-author-img">
                  <div>
                    <h4 class="dsir-author-name">Mr. Pritesh Shah</h4>
                    <span class="dsir-author-title">Premium Real-Estate Investor, Baroda</span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Slide 2: Ananya Iyer -->
            <div class="dsir-testimonial-slide">
              <div class="dsir-testimonial-card">
                <span class="dsir-card-quote"><i class="fa-solid fa-quote-left"></i></span>
                <div class="dsir-testimonial-stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
                <p class="dsir-testimonial-text">
                  "Investing in Dholera smart plots from London was incredibly seamless. The RERA compliance is clear, utility connections are pre-laid, and the government support ensures absolute security for NRI capital."
                </p>
                <div class="dsir-testimonial-author">
                  <img src="assets/images/avatar_ananya.png" alt="Mrs. Ananya Iyer" class="dsir-author-img">
                  <div>
                    <h4 class="dsir-author-name">Mrs. Ananya Iyer</h4>
                    <span class="dsir-author-title">NRI Business Executive, London</span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Slide 3: Vikram Malhotra -->
            <div class="dsir-testimonial-slide">
              <div class="dsir-testimonial-card">
                <span class="dsir-card-quote"><i class="fa-solid fa-quote-left"></i></span>
                <div class="dsir-testimonial-stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
                <p class="dsir-testimonial-text">
                  "As a financial advisor, I highly recommend Dholera SIR. Early-stage smart industrial cities offer unmatched land value appreciation. The direct Ahmedabad-Dholera Expressway is a major game changer."
                </p>
                <div class="dsir-testimonial-author">
                  <img src="assets/images/avatar_vikram.png" alt="Mr. Vikram Malhotra" class="dsir-author-img">
                  <div>
                    <h4 class="dsir-author-name">Mr. Vikram Malhotra</h4>
                    <span class="dsir-author-title">Senior Corporate Finance Advisor, Mumbai</span>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Dot Indicators -->
          <div class="dsir-testimonial-dots" id="dsirTestimonialDots">
            <span class="dsir-dot active" onclick="setTestimonialSlide(0)"></span>
            <span class="dsir-dot" onclick="setTestimonialSlide(1)"></span>
            <span class="dsir-dot" onclick="setTestimonialSlide(2)"></span>
          </div>

        </div>

      </div>
    </section>

    <!-- Autoplay Testimonials Control JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const slides = document.querySelectorAll('.dsir-testimonial-slide');
      const dots = document.querySelectorAll('.dsir-dot');
      let currentSlide = 0;
      let autoplayInterval;

      if (slides.length === 0) return;

      // Handle active slide state transitions manually
      window.setTestimonialSlide = (index) => {
        clearInterval(autoplayInterval);
        
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');

        currentSlide = index;

        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');

        startAutoplay();
      };

      // Auto rotation logic
      const nextSlide = () => {
        let nextIndex = (currentSlide + 1) % slides.length;
        
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');

        currentSlide = nextIndex;

        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
      };

      const startAutoplay = () => {
        autoplayInterval = setInterval(nextSlide, 5000); // 5 seconds interval
      };

      startAutoplay();
    });
    </script>

    <!-- 🔷 9. FAQ SECTION (Accordion) -->
    <section class="dsir-faq" id="faq">
      <div class="dsir-faq-container">
        
        <div class="dsir-section-heading">
          <span class="dsir-section-subtitle">FAQ Desk</span>
          <h2 class="dsir-section-title">Frequently Asked <span>Questions</span></h2>
        </div>
        
        <!-- Accordion list -->
        <div class="dsir-faq-list">
          
          <!-- Item 1 -->
          <div class="dsir-faq-item">
            <button class="dsir-faq-trigger">
              <span>What is Dholera Special Investment Region (DSIR)?</span>
              <span class="dsir-faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="dsir-faq-panel">
              <div class="dsir-faq-content">
                Dholera SIR is a massive greenfield industrial township planned by the Government of Gujarat. Spanning over 920 square kilometers, it is designed with world-class plug-and-play smart utility networks, highways, expressways, and high-speed rail links under the Delhi-Mumbai Industrial Corridor (DMIC).
              </div>
            </div>
          </div>
          
          <!-- Item 2 -->
          <div class="dsir-faq-item">
            <button class="dsir-faq-trigger">
              <span>Who is eligible to invest in Dholera smart plots?</span>
              <span class="dsir-faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="dsir-faq-panel">
              <div class="dsir-faq-content">
                Any Indian citizen, corporate group, partnership firm, or Non-Resident Indian (NRI) is fully authorized to acquire real estate residential plots, commercial sectors, or industrial warehousing land inside the Dholera Special Investment Region.
              </div>
            </div>
          </div>
          
          <!-- Item 3 -->
          <div class="dsir-faq-item">
            <button class="dsir-faq-trigger">
              <span>Why is Dholera SIR considered a high-growth investment destination?</span>
              <span class="dsir-faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="dsir-faq-panel">
              <div class="dsir-faq-content">
                Dholera features double-digit capital appreciation parameters. Major catalysts like the under-construction Dholera International Airport, the 6-lane wide Expressway, connecting metro tracks, and major anchor setups (e.g. Tata semiconductor plant, defense IT lines) fuel continuous high capital yield.
              </div>
            </div>
          </div>
          
          <!-- Item 4 -->
          <div class="dsir-faq-item">
            <button class="dsir-faq-trigger">
              <span>What are the legal compliance standards for NRI investors?</span>
              <span class="dsir-faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div class="dsir-faq-panel">
              <div class="dsir-faq-content">
                NRIs can acquire residential or commercial property inside Dholera in accordance with FEMA regulations. The transactions must be routed through non-resident bank channels (NRE/NRO accounts). All plots listed inside our inventory are completely RERA-registered and feature clear legal title documentation.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 🔷 10. CONTACT / ENQUIRY SECTION (Original Lead Generation Block) -->
    <?php include 'components/contact.php'; ?>

    <!-- 🟢 11. FLOATING WHATSAPP BUTTON -->
    <a href="https://wa.me/919220551771?text=Hello!%20I%20am%20interested%20in%20Dholera%20Greenfield%20Smart%20City%20plots.%20Please%20send%20me%20pricing%20sheets%20and%20layout%20details." class="dsir-whatsapp-float" target="_blank" rel="noopener noreferrer" title="WhatsApp Enquiry Chat">
      <i class="fa-brands fa-whatsapp"></i>
    </a>

  </div>
  <!-- dsir-page-wrapper ends -->

  <!-- Include Responsive Footer Component -->
  <?php include 'includes/footer.php'; ?>

  <!-- Accordion Collapse JavaScript Mechanics -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const faqItems = document.querySelectorAll('.dsir-faq-item');
    
    faqItems.forEach(item => {
      const trigger = item.querySelector('.dsir-faq-trigger');
      const panel = item.querySelector('.dsir-faq-panel');
      
      trigger.addEventListener('click', () => {
        const isActive = item.classList.contains('active');
        
        // Collapse all other active items first for smooth visual accordion action
        faqItems.forEach(otherItem => {
          if (otherItem !== item && otherItem.classList.contains('active')) {
            otherItem.classList.remove('active');
            otherItem.querySelector('.dsir-faq-panel').style.maxHeight = null;
          }
        });
        
        // Toggle current item
        if (!isActive) {
          item.classList.add('active');
          panel.style.maxHeight = panel.scrollHeight + "px";
        } else {
          item.classList.remove('active');
          panel.style.maxHeight = null;
        }
      });
    });
  });
  </script>
</body>
</html>
