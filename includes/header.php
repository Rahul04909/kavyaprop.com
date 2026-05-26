<?php
/**
 * Dholera Interactive Header Component
 * Developed by Expert UI/UX Designer & Developer
 */
?>
<!-- Include Fonts & FontAwesome Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Load Header CSS Stylesheet -->
<link rel="stylesheet" href="assets/css/header.css">

<header class="dh-header-wrapper" id="dhHeader">
  <!-- 1. Top Bar Information Block -->
  <div class="dh-top-bar">
    <div class="dh-top-bar-left">
      <div class="dh-top-bar-socials">
        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="dh-social-link" title="Facebook" aria-label="Facebook">
          <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="dh-social-link" title="Instagram" aria-label="Instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="dh-social-link" title="X (Twitter)" aria-label="X (Twitter)">
          <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="dh-social-link" title="YouTube" aria-label="YouTube">
          <i class="fa-brands fa-youtube"></i>
        </a>
      </div>
    </div>
    
    <div class="dh-top-bar-right">
      <div class="dh-info-group">
        <span class="dh-info-item">
          <i class="fa-solid fa-location-dot"></i>
          Dholera is located in district Ahmedabad, Gujarat
        </span>
        <a href="tel:+919220551771" class="dh-info-item dh-phone-link">
          <i class="fa-solid fa-phone"></i>
          +91 92205 51771
        </a>
      </div>
    </div>
  </div>

  <!-- 2. Main Navigation Header Bar -->
  <div class="dh-main-header">
    <!-- Brand Logo -->
    <a href="index.php" class="dh-brand-logo" title="Dholera - Home">
      <!-- High-fidelity Inline vector SVG replicating the official Dholera Branding -->
      <svg class="dh-logo-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 65" width="200" height="65">
        <!-- Colorful Artistic Abstract Ribbon Icon -->
        <g id="logo-ribbon">
          <!-- Deep Blue Waves -->
          <path d="M 12 18 C 22 8, 32 10, 42 20 C 50 28, 56 12, 66 14 C 74 16, 80 22, 86 18" fill="none" stroke="#00a0e9" stroke-width="3" stroke-linecap="round"/>
          <!-- Orange Waves -->
          <path d="M 8 23 C 18 12, 28 14, 38 24 C 46 32, 52 16, 62 16 C 70 16, 76 26, 82 23" fill="none" stroke="#ef7d00" stroke-width="3" stroke-linecap="round"/>
          <!-- Vibrant Green Waves -->
          <path d="M 16 14 C 24 6, 34 8, 44 16 C 52 24, 58 10, 68 11 C 76 12, 82 18, 88 15" fill="none" stroke="#2b6009" stroke-width="3" stroke-linecap="round"/>
          <!-- Birds hovering (aesthetic micro-details) -->
          <path d="M 45 6 Q 47 4 49 6 Q 51 4 53 6" fill="none" stroke="#718096" stroke-width="0.8" stroke-linecap="round"/>
          <path d="M 64 5 Q 66 3 68 5 Q 70 3 72 5" fill="none" stroke="#718096" stroke-width="0.8" stroke-linecap="round"/>
        </g>
        
        <!-- Typography -->
        <text x="6" y="47" font-family="'Montserrat', sans-serif" font-weight="800" font-size="28" fill="#3a3a3a" letter-spacing="-0.5">Dholera</text>
        <text x="7" y="58" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.2" fill="#718096" letter-spacing="0.1">HUMAN BUILT ON TRUST. ALWAYS.</text>
      </svg>
    </a>

    <!-- Center Navigation Menu (Desktop) -->
    <nav class="dh-nav-menu-container">
      <ul class="dh-nav-menu">
        <li class="dh-nav-item"><a href="index.php" class="dh-nav-link">Home</a></li>
        <li class="dh-nav-item"><a href="projects.php" class="dh-nav-link">Projects</a></li>
        <li class="dh-nav-item"><a href="dholera-sir.php" class="dh-nav-link">Dholera SIR</a></li>
        <li class="dh-nav-item"><a href="about.php" class="dh-nav-link">About Us</a></li>
        <li class="dh-nav-item"><a href="contact.php" class="dh-nav-link">Contact Us</a></li>
      </ul>
    </nav>

    <!-- Right-aligned Header Actions -->
    <div class="dh-header-actions">
      <a href="contact.php" class="dh-cta-button">Enquire Now</a>
      
      <!-- Hamburger Toggle Button (Mobile/Tablet) -->
      <button class="dh-hamburger-btn" id="dhHamburgerBtn" aria-label="Toggle Menu" aria-expanded="false">
        <span class="dh-hamburger-bar"></span>
        <span class="dh-hamburger-bar"></span>
        <span class="dh-hamburger-bar"></span>
      </button>
    </div>
  </div>
</header>

<!-- 3. Mobile Navigation Drawer (Sidebar) -->
<div class="dh-sidebar-overlay" id="dhSidebarOverlay"></div>
<div class="dh-sidebar-drawer" id="dhSidebarDrawer">
  <!-- Drawer Header -->
  <div class="dh-drawer-header">
    <svg class="dh-drawer-logo-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 65" width="160" height="52">
      <!-- Replicating exact logo for sidebar drawer -->
      <use href="#logo-ribbon"/>
      <text x="6" y="47" font-family="'Montserrat', sans-serif" font-weight="800" font-size="28" fill="#3a3a3a" letter-spacing="-0.5">Dholera</text>
      <text x="7" y="58" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.2" fill="#718096" letter-spacing="0.1">HUMAN BUILT ON TRUST. ALWAYS.</text>
    </svg>
  </div>

  <!-- Drawer Body Navigation -->
  <div class="dh-drawer-body">
    <ul class="dh-drawer-menu">
      <li class="dh-drawer-item"><a href="index.php" class="dh-drawer-link">Home <i class="fa-solid fa-chevron-right"></i></a></li>
      <li class="dh-drawer-item"><a href="projects.php" class="dh-drawer-link">Projects <i class="fa-solid fa-chevron-right"></i></a></li>
      <li class="dh-drawer-item"><a href="dholera-sir.php" class="dh-drawer-link">Dholera SIR <i class="fa-solid fa-chevron-right"></i></a></li>
      <li class="dh-drawer-item"><a href="about.php" class="dh-drawer-link">About Us <i class="fa-solid fa-chevron-right"></i></a></li>
      <li class="dh-drawer-item"><a href="index.php#blog" class="dh-drawer-link">Blog <i class="fa-solid fa-chevron-right"></i></a></li>
      <li class="dh-drawer-item"><a href="index.php#news" class="dh-drawer-link">News <i class="fa-solid fa-chevron-right"></i></a></li>
      <li class="dh-drawer-item"><a href="contact.php" class="dh-drawer-link">Contact Us <i class="fa-solid fa-chevron-right"></i></a></li>
    </ul>
  </div>

  <!-- Drawer Footer (CTA, Contact & Social Links) -->
  <div class="dh-drawer-footer">
    <a href="contact.php" class="dh-cta-button">Enquire Now</a>
    
    <div class="dh-drawer-info">
      <div class="dh-drawer-info-item">
        <i class="fa-solid fa-location-dot"></i>
        <span>Dholera is located in district Ahmedabad, Gujarat</span>
      </div>
      <a href="tel:+919220551771" class="dh-drawer-info-item">
        <i class="fa-solid fa-phone"></i>
        <span>+91 92205 51771</span>
      </a>
    </div>

    <div class="dh-drawer-socials">
      <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="dh-drawer-social-link">
        <i class="fa-brands fa-facebook-f"></i>
      </a>
      <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="dh-drawer-social-link">
        <i class="fa-brands fa-instagram"></i>
      </a>
      <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="dh-drawer-social-link">
        <i class="fa-brands fa-x-twitter"></i>
      </a>
      <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="dh-drawer-social-link">
        <i class="fa-brands fa-youtube"></i>
      </a>
    </div>
  </div>
</div>

<!-- 4. Interactive Header Mechanics (JavaScript) -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const header = document.getElementById('dhHeader');
  const hamburgerBtn = document.getElementById('dhHamburgerBtn');
  const sidebarOverlay = document.getElementById('dhSidebarOverlay');
  const sidebarDrawer = document.getElementById('dhSidebarDrawer');
  
  // A. Sticky Shrink Interaction on Scroll
  const handleScroll = () => {
    if (window.scrollY > 60) {
      header.classList.add('dh-sticky');
    } else {
      header.classList.remove('dh-sticky');
    }
  };
  
  window.addEventListener('scroll', handleScroll);
  // Initial check on load
  handleScroll();

  // B. Drawer Open/Close Mechanics
  const toggleDrawer = () => {
    const isOpen = sidebarDrawer.classList.contains('dh-open');
    
    hamburgerBtn.classList.toggle('dh-active');
    sidebarOverlay.classList.toggle('dh-open');
    sidebarDrawer.classList.toggle('dh-open');
    
    hamburgerBtn.setAttribute('aria-expanded', !isOpen);
    
    // Prevent body scrolling when menu is active
    if (!isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  };

  hamburgerBtn.addEventListener('click', toggleDrawer);
  sidebarOverlay.addEventListener('click', toggleDrawer);

  // Close drawer when menu links are clicked (useful for anchors on same page)
  const drawerLinks = document.querySelectorAll('.dh-drawer-link');
  drawerLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (sidebarDrawer.classList.contains('dh-open')) {
        toggleDrawer();
      }
    });
  });

  // C. Handle active states smoothly
  const currentPath = window.location.pathname.split('/').pop() || 'index.php';
  const navItems = document.querySelectorAll('.dh-nav-item');
  const drawerItems = document.querySelectorAll('.dh-drawer-item');

  const updateActiveStates = (items, targetAttribute) => {
    items.forEach(item => {
      const link = item.querySelector('a');
      const href = link.getAttribute('href');
      
      if (href === currentPath) {
        item.classList.add('dh-active');
      } else {
        // Only remove if it's linking to another concrete php page
        if (href.endsWith('.php') && href !== currentPath) {
          item.classList.remove('dh-active');
        }
      }
    });
  };

  updateActiveStates(navItems);
  updateActiveStates(drawerItems);
});
</script>
