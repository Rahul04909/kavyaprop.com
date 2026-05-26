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
        <a href="index.php" class="dh-footer-logo-link" title="Kavya Prop - Home">
          <img src="assets/images/logo.png" alt="Kavya Prop Logo" class="dh-footer-logo-img" style="height: 48px; width: auto; object-fit: contain; filter: brightness(0) invert(1);">
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
            <span>Shop No.125, First Floor Shubham Tower, Near Fortis, Neelam Bata Road, N.I.T Faridabad-121001</span>
          </div>
          <!-- Phone -->
          <div class="dh-footer-info-item">
            <i class="fa-solid fa-phone"></i>
            <a href="tel:+917056721800">+91 70567 21800</a>
          </div>
          <!-- Email -->
          <div class="dh-footer-info-item">
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:info@kavyaprop.com">info@kavyaprop.com</a>
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
          <a href="https://www.instagram.com/kavya_prop_com_?igsh=aTZ0emRjZHRvdWR6" target="_blank" rel="noopener noreferrer" class="dh-footer-social-link" title="Instagram">
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
        &copy; <?php echo date('Y'); ?> <a href="https://kavyaprop.com" style="color: inherit; text-decoration: none;">kavyaprop.com</a>. All rights reserved. Designed by <a href="https://mineib.com" target="_blank" rel="noopener noreferrer" style="color: var(--dh-orange, #ef7d00); text-decoration: none; font-weight: 600; transition: color 0.2s ease;">Mineib</a>
      </div>
      <div class="dh-footer-bottom-links">
        <a href="#about-us">Privacy Policy</a>
        <a href="#about-us">Terms & Conditions</a>
      </div>
    </div>
  </div>

</footer>
