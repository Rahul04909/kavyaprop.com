<?php
/**
 * Dholera Smart City – Professional About Us Page
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
  <meta name="description" content="Learn about Dholera Smart City – India's first Greenfield Smart City, our vision, values, milestones, and the trusted team behind the nation's most ambitious infrastructure project.">
  <title>About Us – Our Vision & Story | Dholera Smart City</title>

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
    <h1>Building Tomorrow's<br>India – Today</h1>
    <p>Dholera Special Investment Region is India's first Greenfield Smart City, conceived under the DMIC Corridor. We help investors become part of one of the world's most ambitious infrastructure transformations.</p>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 2 · VISION & STORY
  ══════════════════════════════════════════════════ -->
  <section class="dh-aboutpage-story">
    <div class="dh-aboutpage-story-container">

      <!-- Text Side -->
      <div class="dh-story-text-side">
        <span class="dh-aboutpage-subtitle">Who We Are</span>
        <h2 class="dh-aboutpage-title">A Trusted Partner in India's Smart City Revolution</h2>
        <p class="dh-aboutpage-text">
          Established as a specialised real estate consultancy with an exclusive focus on the Dholera Special Investment Region (SIR), we have guided thousands of investors in securing high-potential plots in India's fastest developing smart-city corridor.
        </p>
        <p class="dh-aboutpage-text">
          Our team combines deep local knowledge, RERA compliance expertise, and transparent advisory practices to ensure every client makes an informed, profitable investment decision – with zero hidden surprises.
        </p>

        <!-- Quick Highlights List -->
        <ul class="dh-story-highlights">
          <li><i class="fa-solid fa-circle-check"></i> 100% RERA registered & govt. approved projects</li>
          <li><i class="fa-solid fa-circle-check"></i> 5,000+ satisfied investor families across India</li>
          <li><i class="fa-solid fa-circle-check"></i> Free site visits & transparent documentation</li>
          <li><i class="fa-solid fa-circle-check"></i> Pan-India presence with Ahmedabad HQ</li>
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
          alt="Dholera Smart City aerial development view"
          class="dh-aboutpage-graphic"
          loading="lazy"
        >
        <!-- Overlay Badge -->
        <div class="dh-about-img-badge">
          <span class="dh-badge-year">Est. 2011</span>
          <span class="dh-badge-label">India's First<br>Greenfield Smart City</span>
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
        <p>We operate with full RERA compliance and zero-hidden-fee policies. Every document, clause, and transaction is disclosed upfront so clients invest with complete confidence.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-chart-line"></i></div>
        <h3>High-Growth Investment Focus</h3>
        <p>Dholera SIR is projected to become a 100-billion-dollar economy. We identify the highest-ROI plots, sectors, and timelines to maximise your portfolio returns.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-users"></i></div>
        <h3>Client-First Advisory</h3>
        <p>From the first consultation to property registration, our dedicated relationship managers guide you through every step. No outsourcing, no call centres – just direct expert support.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-leaf"></i></div>
        <h3>Sustainable Smart Living</h3>
        <p>Dholera is designed as a zero-carbon, self-sustaining city. We champion investments that align with Gujarat's 2047 green-energy vision and ESG principles.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-building-columns"></i></div>
        <h3>Government-Backed Security</h3>
        <p>Investments in Dholera SIR carry the assurance of state and central government backing, strategic inclusion in the National Infrastructure Pipeline, and DMIC funding.</p>
      </div>

      <div class="dh-pillar-card">
        <div class="dh-pillar-icon"><i class="fa-solid fa-handshake"></i></div>
        <h3>Long-Term Partnerships</h3>
        <p>We build relationships, not just transactions. Our investor community receives regular updates, site reports, and early access to new project launches well ahead of public listings.</p>
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
          <span class="dh-stat-label">Satisfied Investors</span>
        </div>

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="920">0</span>
          <span class="dh-stat-suffix">km²</span>
          <span class="dh-stat-label">Smart City Area</span>
        </div>

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="100">0</span>
          <span class="dh-stat-suffix">%</span>
          <span class="dh-stat-label">RERA Compliant Projects</span>
        </div>

        <div class="dh-about-stat-item">
          <span class="dh-stat-number" data-target="14">0</span>
          <span class="dh-stat-suffix">+</span>
          <span class="dh-stat-label">Years of Expertise</span>
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
      <h2 class="dh-aboutpage-title">Key Milestones of Dholera SIR</h2>
    </div>

    <div class="dh-timeline-container">

      <div class="dh-timeline-item dh-tl-left">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2011</span>
          <h4>Dholera SIR Act Passed</h4>
          <p>Gujarat government enacts the Dholera SIR Act, formally designating the 920 km² region as India's first Special Investment Region under the DMIC project.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-right">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2014</span>
          <h4>National Infrastructure Priority</h4>
          <p>Dholera SIR receives priority status under PM Modi's Digital India & Smart Cities Mission. Massive central government funding earmarked for trunk infrastructure.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-left">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2017</span>
          <h4>Activation Area Development Begins</h4>
          <p>Roads, drainage, water supply and power infrastructure works commence in the 22.5 km² Activation Area (Phase 1), making the first plots investor-ready.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-right">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2020</span>
          <h4>Semiconductor & Data Centre Investments</h4>
          <p>International semiconductor manufacturers and data centre operators announce anchor investments, cementing Dholera as India's electronics manufacturing hub.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-left">
        <div class="dh-timeline-content">
          <span class="dh-tl-year">2023</span>
          <h4>Airport & Metro Rail Clearances</h4>
          <p>Dholera International Airport Phase 1 construction approved. Metro rail connectivity from Ahmedabad finalised, linking investors' assets to a global transit network.</p>
        </div>
      </div>

      <div class="dh-timeline-item dh-tl-right">
        <div class="dh-timeline-content dh-tl-active">
          <span class="dh-tl-year">2025+</span>
          <h4>Rapid Appreciation Phase</h4>
          <p>With airport operations commencing, land values are projected to appreciate 3–5× as Dholera transforms into a fully operational smart-city ecosystem.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
       SECTION 6 · CALL TO ACTION BANNER
  ══════════════════════════════════════════════════ -->
  <section class="dh-about-cta-section">
    <div class="dh-about-cta-inner">
      <h2>Ready to Invest in India's Future?</h2>
      <p>Join 5,000+ investors who trusted Dholera Smart City to grow their wealth. Schedule a free consultation call with our senior advisors today.</p>
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
