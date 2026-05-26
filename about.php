<?php
/**
 * Kavya Prop – Professional About Us Page
 * Simple Core PHP | Mobile Responsive | SEO Optimised
 * Developed by Expert UI/UX Designer & Developer
 */
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Learn about Kavya Prop – Your trusted real estate advisory and consultancy partner offering premium, government-approved, and high-ROI smart plot investments.">
  <title>About Us – Our Vision & Story | Kavya Prop</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/about-page.css">
</head>
<body>

  <!-- ── Sticky Navigation Header ── -->
  <?php include 'includes/header.php'; ?>

  <!-- ══════════════════════════════════════════════════
       SECTION 1 · HERO BANNER
  ══════════════════════════════════════════════════ -->
  <section class="dh-aboutpage-hero">
    <span class="dh-aboutpage-subtitle">Our Story</span>
    <h1>Building Wealth Through<br>Strategic Real Estate</h1>
    <p>Kavya Prop (kavyaprop.com) is a leading real estate advisory firm specializing in high-growth investment zones. We empower smart property choices for retail, institutional, and corporate investors across India.</p>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 2 · VISION & STORY
  ══════════════════════════════════════════════════ -->
  <section class="dh-aboutpage-story">
    <div class="dh-aboutpage-story-container">

      <!-- Text Side -->
      <div class="dh-story-text-side">
        <span class="dh-aboutpage-subtitle">Who We Are</span>
        <h2 class="dh-aboutpage-title">A Trusted Partner in Your Real Estate Journey</h2>
        <p class="dh-aboutpage-text">
          Established as a specialized real estate advisory with our head office at Shubham Tower in NIT Faridabad, <strong>Kavya Prop</strong> has guided thousands of investors in securing high-potential residential, commercial, and industrial plots in the country's most rapid growth zones, including the prestigious Dholera Special Investment Region (SIR).
        </p>
        <p class="dh-aboutpage-text">
          Our team combines absolute transparency, dynamic local insights, complete RERA compliance, and streamlined end-to-end guidance so that your property purchase is legally verified, stress-free, and positioned for high ROI.
        </p>

        <!-- Quick Highlights List -->
        <ul class="dh-story-highlights">
          <li><i class="fa-solid fa-circle-check"></i> 100% Verified & government-approved assets</li>
          <li><i class="fa-solid fa-circle-check"></i> 5,000+ satisfied clients across India</li>
          <li><i class="fa-solid fa-circle-check"></i> Complete end-to-end documentation & registry support</li>
          <li><i class="fa-solid fa-circle-check"></i> Offices in Faridabad (NCR) & Ahmedabad (Gujarat)</li>
        </ul>

        <a href="contact.php" class="dh-about-cta-btn">
          Talk to an Expert <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>

      <!-- Image/Graphic Side -->
      <div class="dh-aboutpage-graphic-container">
        <img
          src="assets/images/about-story.jpg"
          onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80';"
          alt="Kavya Prop real estate showcase"
          class="dh-aboutpage-graphic"
          loading="lazy"
        >
        <!-- Overlay Badge -->
        <div class="dh-about-img-badge">
          <span class="dh-badge-year">Est. 2018</span>
          <span class="dh-badge-label">Faridabad NCR HQ<br>& Pan-India Advisory</span>
        </div>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 3 · CORE PILLARS
  ══════════════════════════════════════════════════ -->
  <section class="dh-aboutpage-pillars">
    <div style="max-width:1200px; margin:0 auto; text-align:center;">
      <span class="dh-aboutpage-subtitle">What Drives Us</span>
      <h2 class="dh-aboutpage-title" style="max-width:600px; margin:0 auto 0 auto;">Our Core Pillars of Excellence</h2>
    </div>

    <div class="dh-pillars-grid">

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <h3>Integrity & Transparency</h3>
        <p>We work exclusively with developer inventories that are fully RERA approved and government certified. Every cost, policy, and paper is explained clearly upfront with zero hidden clauses.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-chart-line"></i></div>
        <h3>High-ROI Focus</h3>
        <p>We focus on high-potential investment zones like Dholera Special Investment Region (SIR) where major connectivity and infrastructure are set to drive 3x to 5x value appreciation.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-users"></i></div>
        <h3>End-to-End Assistance</h3>
        <p>From organizing site visits and performing due diligence to drafting agreements and registering deeds, our dedicated managers take care of everything, guaranteeing zero hassle.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-leaf"></i></div>
        <h3>Sustainable Investments</h3>
        <p>We advocate for smart-infrastructure investments that feature modern eco-friendly amenities, digital utilities, green corridors, and efficient resource systems.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-building-columns"></i></div>
        <h3>Government-Backed Trust</h3>
        <p>Our catalog highlights premium properties located close to key state and national infrastructure priorities (like international airports, major expressways, and logistical hubs).</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-handshake"></i></div>
        <h3>Long-Term Partnership</h3>
        <p>For Kavya Prop, a transaction is just the beginning of a lifelong relationship. We continuously update our investors with quarterly site status reports and new exclusive pre-launch options.</p>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 4 · KEY STATISTICS COUNTERS
  ══════════════════════════════════════════════════ -->
  <section class="dh-aboutpage-stats">
    <div class="dh-stats-grid-wrapper">
      <div style="text-align:center; margin-bottom:40px;">
        <span class="dh-aboutpage-subtitle">Our Impact in Numbers</span>
        <h2 class="dh-aboutpage-title">Milestones That Define Us</h2>
      </div>

      <div class="dh-about-stats-grid">

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="5000">0</span>
          <span class="dh-stat-suffix">+</span>
          <span class="dh-stat-label">Satisfied Clients</span>
        </div>

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="2500">0</span>
          <span class="dh-stat-suffix">+</span>
          <span class="dh-stat-label">Acres Handled</span>
        </div>

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="100">0</span>
          <span class="dh-stat-suffix">%</span>
          <span class="dh-stat-label">RERA Compliant Assets</span>
        </div>

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="8">0</span>
          <span class="dh-stat-suffix">+</span>
          <span class="dh-stat-label">Years of Excellence</span>
        </div>

      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 5 · TIMELINE / MILESTONES
  ══════════════════════════════════════════════════ -->
  <section class="dh-aboutpage-timeline">
    <div style="max-width:1200px; margin:0 auto; text-align:center; margin-bottom:50px;">
      <span class="dh-aboutpage-subtitle">Our Journey</span>
      <h2 class="dh-aboutpage-title">Key Milestones of Kavya Prop</h2>
    </div>

    <div class="dh-timeline-container">

      <div class="dh-timeline-item dh-tl-left">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2018</span>
          <h4>Foundation of Kavya Prop</h4>
          <p>Started real estate advisory services at Shubham Tower in NIT Faridabad, catering to strategic Delhi-NCR residential and commercial expansion corridors.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-right">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2020</span>
          <h4>Expansion to Dholera SIR</h4>
          <p>Identified the immense wealth potential of India's first greenfield smart city. Set up key strategic tie-ups and representative support in Gujarat.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-left">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2022</span>
          <h4>100% RERA compliance Pledge</h4>
          <p>Established strict quality filters, committing to exclusively showcase RERA-registered and government-approved projects to guarantee client security.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-right">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2024</span>
          <h4>5,000+ Happy Investors</h4>
          <p>Successfully crossed the milestone of serving over 5,000 retail and corporate clients with high-appreciating, legally sound investments.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-left">
        <div class="dh-timeline-content dh-tl-active">
          <span class="dh-tl-year">2026+</span>
          <h4>Futuristic Asset Portfolios</h4>
          <p>Continuing to pioneer access to prime smart plots and multi-modal logistical corridors to deliver unparalleled financial growth for our investors.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 6 · CALL TO ACTION BANNER
  ══════════════════════════════════════════════════ -->
  <section class="dh-about-cta-section">
    <div class="dh-about-cta-inner">
      <h2>Ready to Invest in Your Future?</h2>
      <p>Join 5,000+ investors who trusted Kavya Prop to grow their wealth. Schedule a free consultation call with our senior advisors today.</p>
      <div class="dh-about-cta-actions">
        <a href="contact.php" class="dh-about-cta-primary">
          <i class="fa-solid fa-calendar-check"></i> Book Free Consultation
        </a>
        <a href="projects.php" class="dh-about-cta-secondary">
          <i class="fa-solid fa-building"></i> Browse Projects
        </a>
      </div>
    </div>
  </section>

  <!-- ── Footer ── -->
  <?php include 'includes/footer.php'; ?>

  <!-- ══════════════════════════════════════════════════
       JAVASCRIPT – Animated Counter on Scroll
  ══════════════════════════════════════════════════ -->
  <script>
  (function () {
    'use strict';

    const counters = document.querySelectorAll('.dh-stat-number[data-target]');
    let animated = false;

    function animateCounters() {
      if (animated) return;
      counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'), 10);
        const duration = 2000;
        const stepTime = 20;
        const steps = duration / stepTime;
        const increment = target / steps;
        let current = 0;

        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            current = target;
            clearInterval(timer);
          }
          counter.textContent = Math.floor(current).toLocaleString('en-IN');
        }, stepTime);
      });
      animated = true;
    }

    // IntersectionObserver to trigger on scroll
    const statsSection = document.querySelector('.dh-aboutpage-stats');
    if (statsSection && 'IntersectionObserver' in window) {
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateCounters();
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.3 });
      observer.observe(statsSection);
    } else if (statsSection) {
      animateCounters();
    }
  })();
  </script>

</body>
</html>
