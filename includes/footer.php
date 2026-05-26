<?php
/**
 * Dholera Responsive Footer Component
 * Developed by Expert UI/UX Designer & Developer
 */
?>
<!-- Load Footer Component Stylesheet -->
<link rel="stylesheet" href="assets/css/footer.css">

<footer class="dh-footer-wrapper">
  
  <!-- 1. Main Footer Grid -->
  <div class="dh-footer-main">
    <div class="dh-footer-grid">
      
      <!-- Column 1: Brand Info -->
      <div class="dh-footer-column">
        <a href="index.php" class="dh-footer-logo-link" title="Dholera - Home">
          <!-- High contrast white version of the header SVG logo -->
          <svg class="dh-footer-logo-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 65" width="160" height="52">
            <!-- White/orange wavy graphics -->
            <g>
              <path d="M 12 18 C 22 8, 32 10, 42 20 C 50 28, 56 12, 66 14 C 74 16, 80 22, 86 18" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="2.5" stroke-linecap="round"/>
              <path d="M 8 23 C 18 12, 28 14, 38 24 C 46 32, 52 16, 62 16 C 70 16, 76 26, 82 23" fill="none" stroke="var(--dh-orange, #ef7d00)" stroke-width="2.5" stroke-linecap="round"/>
              <path d="M 16 14 C 24 6, 34 8, 44 16 C 52 24, 58 10, 68 11 C 76 12, 82 18, 88 15" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2.5" stroke-linecap="round"/>
            </g>
            <text x="6" y="47" font-family="'Montserrat', sans-serif" font-weight="800" font-size="28" fill="#ffffff" letter-spacing="-0.5">Dholera</text>
            <text x="7" y="58" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.2" fill="#94a3b8" letter-spacing="0.1">HUMAN BUILT ON TRUST. ALWAYS.</text>
          </svg>
        </a>
        <p class="dh-footer-about">
          India's premier development alliance coordinating transparent bookings, legal property registries, and world-class infrastructure layout systems within Dholera Special Investment Region.
        </p>
      </div>
      
      <!-- Column 2: Navigation Links -->
      <div class="dh-footer-column">
        <h4 class="dh-footer-title">Navigation</h4>
        <ul class="dh-footer-links">
          <li class="dh-footer-link-item"><a href="index.php"><i class="fa-solid fa-angle-right"></i> Home</a></li>
          <li class="dh-footer-link-item"><a href="index.php#about-us"><i class="fa-solid fa-angle-right"></i> About Us</a></li>
          <li class="dh-footer-link-item"><a href="index.php#projects"><i class="fa-solid fa-angle-right"></i> Smart Projects</a></li>
          <li class="dh-footer-link-item"><a href="dholera-sir.php"><i class="fa-solid fa-angle-right"></i> Dholera SIR</a></li>
          <li class="dh-footer-link-item"><a href="index.php#contact"><i class="fa-solid fa-angle-right"></i> Contact Us</a></li>
        </ul>
      </div>
      
      <!-- Column 3: Support Info -->
      <div class="dh-footer-column">
        <h4 class="dh-footer-title">Support Desk</h4>
        <div class="dh-footer-info-list">
          <!-- Address -->
          <div class="dh-footer-info-item">
            <i class="fa-solid fa-location-dot"></i>
            <span>Dholera SIR, District Ahmedabad, Gujarat, India</span>
          </div>
          <!-- Phone -->
          <div class="dh-footer-info-item">
            <i class="fa-solid fa-phone"></i>
            <a href="tel:+919220551771">+91 92205 51771</a>
          </div>
          <!-- Email -->
          <div class="dh-footer-info-item">
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:info@dholerasmartcity.com">info@dholerasmartcity.com</a>
          </div>
        </div>
        <div class="dh-footer-hours">
          * Hotline Active: Mon - Sat (9 AM - 7 PM)
        </div>
      </div>
      
      <!-- Column 4: Newsletter & Socials -->
      <div class="dh-footer-column">
        <h4 class="dh-footer-title">Newsletter</h4>
        <p class="dh-footer-newsletter-text">
          Subscribe to receive property status releases and immediate updates.
        </p>
        <!-- Form -->
        <form class="dh-footer-form" action="#" method="POST" onsubmit="event.preventDefault(); alert('Subscribed to Dholera newsletter updates successfully!'); this.reset();">
          <input class="dh-footer-input" type="email" placeholder="Email Address" required>
          <button class="dh-footer-submit-btn" type="submit" aria-label="Subscribe">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
        
        <!-- Social links matching header styling but for dark footer -->
        <div class="dh-footer-socials">
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="dh-footer-social-link" title="Facebook">
            <i class="fa-brands fa-facebook-f"></i>
          </a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="dh-footer-social-link" title="Instagram">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="dh-footer-social-link" title="X (Twitter)">
            <i class="fa-brands fa-x-twitter"></i>
          </a>
          <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="dh-footer-social-link" title="YouTube">
            <i class="fa-brands fa-youtube"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
  
  <!-- 2. Copyright Bottom Bar -->
  <div class="dh-footer-bottom">
    <div class="dh-footer-bottom-container">
      <div>
        &copy; <?php echo date('Y'); ?> Dholera Smart City Alliance. All rights reserved. Created by Professional UX/UI Team.
      </div>
      <div class="dh-footer-bottom-links">
        <a href="#about-us">Privacy Policy</a>
        <a href="#about-us">Terms & Conditions</a>
      </div>
    </div>
  </div>

</footer>
