<?php
/**
 * Dholera Responsive Hero Slider Component (Flipkart Style)
 * Developed by Expert UI/UX Designer & Developer
 */
?>
<!-- Load Hero Component Stylesheet -->
<link rel="stylesheet" href="assets/css/hero.css">

<section class="dh-hero-slider-container" id="dhHeroSlider" aria-roledescription="carousel" aria-label="Dholera Smart City Showcases">
  <!-- Slides Wrapper -->
  <div class="dh-hero-slider-wrapper" id="dhSliderWrapper">
    
    <!-- Slide 1: Welcome / Gateways -->
    <a href="#about-us" class="dh-hero-slide dh-active-slide" role="group" aria-roledescription="slide" aria-label="1 of 3">
      <img src="assets/images/hero-1.png" alt="Dholera Smart City Future Visualization" class="dh-hero-slide-img" loading="eager">
      <div class="dh-hero-slide-overlay">
        <div class="dh-hero-slide-content">
          <span class="dh-hero-slide-tag">India's First Smart Greenfield City</span>
          <h2 class="dh-hero-slide-title">Gateway of Investment <span> At Dholera</span></h2>
          <p class="dh-hero-slide-desc">Explore highly-coveted residential, commercial, and industrial plots inside the Special Investment Region, equipped with global plug-and-play utilities.</p>
          <span class="dh-hero-slide-btn">Learn More <i class="fa-solid fa-arrow-right"></i></span>
        </div>
      </div>
    </a>

    <!-- Slide 2: Residential plots -->
    <a href="#projects" class="dh-hero-slide" role="group" aria-roledescription="slide" aria-label="2 of 3">
      <img src="assets/images/banner-1.png" alt="Dholera Premium Residential Villa Plots" class="dh-hero-slide-img" loading="lazy">
      <div class="dh-hero-slide-overlay">
        <div class="dh-hero-slide-content">
          <span class="dh-hero-slide-tag">RERA Approved Plots</span>
          <h2 class="dh-hero-slide-title">Build Your Dream Villa on <span>Smart Ring Road</span></h2>
          <p class="dh-hero-slide-desc">Premium registry-ready residential plots featuring smart security, automated water recycling, solar grids, and immediate possession rights.</p>
          <span class="dh-hero-slide-btn">Explore Plots <i class="fa-solid fa-arrow-right"></i></span>
        </div>
      </div>
    </a>

    <!-- Slide 3: Industrial Economic Zone -->
    <a href="#dholera-sir" class="dh-hero-slide" role="group" aria-roledescription="slide" aria-label="3 of 3">
      <img src="assets/images/banner-2.png" alt="Dholera Greenfield Industrial Zone" class="dh-hero-slide-img" loading="lazy">
      <div class="dh-hero-slide-overlay">
        <div class="dh-hero-slide-content">
          <span class="dh-hero-slide-tag">Economic Industrial Zone</span>
          <h2 class="dh-hero-slide-title">Plug & Play Ecosystem in <span>Industrial Corridor</span></h2>
          <p class="dh-hero-slide-desc">Optimized logistics grids with direct access to high-speed cargo rail, single-window licensing, and adjacent international cargo airport links.</p>
          <span class="dh-hero-slide-btn">Invest in SIR <i class="fa-solid fa-arrow-right"></i></span>
        </div>
      </div>
    </a>

  </div>

  <!-- Left & Right Arrow Navigation (Flipkart Style) -->
  <button class="dh-hero-arrow dh-hero-arrow-left" id="dhHeroArrowLeft" aria-label="Previous Slide">
    <i class="fa-solid fa-chevron-left"></i>
  </button>
  <button class="dh-hero-arrow dh-hero-arrow-right" id="dhHeroArrowRight" aria-label="Next Slide">
    <i class="fa-solid fa-chevron-right"></i>
  </button>

  <!-- Dynamic Dot Indicators Container (Flipkart style) -->
  <div class="dh-hero-dots" id="dhHeroDots"></div>

</section>

<!-- Slider Logic Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('dhHeroSlider');
  const wrapper = document.getElementById('dhSliderWrapper');
  const slides = document.querySelectorAll('.dh-hero-slide');
  const prevBtn = document.getElementById('dhHeroArrowLeft');
  const nextBtn = document.getElementById('dhHeroArrowRight');
  const dotsContainer = document.getElementById('dhHeroDots');

  let currentIdx = 0;
  let autoplayTimer = null;
  const autoplayDelay = 5000; // 5 seconds autoplay

  // Create dot elements dynamically for each slide
  slides.forEach((_, idx) => {
    const dot = document.createElement('div');
    dot.classList.add('dh-hero-dot');
    if (idx === 0) dot.classList.add('dh-active');
    dot.setAttribute('role', 'button');
    dot.setAttribute('aria-label', `Navigate to slide ${idx + 1}`);
    dot.addEventListener('click', () => {
      goToSlide(idx);
      restartAutoplay();
    });
    dotsContainer.appendChild(dot);
  });

  const dots = document.querySelectorAll('.dh-hero-dot');

  // A. Move to Slide
  const goToSlide = (index) => {
    // Index clamping bounds
    if (index < 0) {
      currentIdx = slides.length - 1;
    } else if (index >= slides.length) {
      currentIdx = 0;
    } else {
      currentIdx = index;
    }

    // Horizontal translation
    wrapper.style.transform = `translateX(-${currentIdx * 100}%)`;

    // Toggle active class for overlay animation
    slides.forEach((slide, idx) => {
      if (idx === currentIdx) {
        slide.classList.add('dh-active-slide');
      } else {
        slide.classList.remove('dh-active-slide');
      }
    });

    // Update dot indicator state
    dots.forEach((dot, idx) => {
      if (idx === currentIdx) {
        dot.classList.add('dh-active');
      } else {
        dot.classList.remove('dh-active');
      }
    });
  };

  // B. Event Listeners for Nav controls
  const handleNext = () => {
    goToSlide(currentIdx + 1);
  };

  const handlePrev = () => {
    goToSlide(currentIdx - 1);
  };

  nextBtn.addEventListener('click', () => {
    handleNext();
    restartAutoplay();
  });

  prevBtn.addEventListener('click', () => {
    handlePrev();
    restartAutoplay();
  });

  // C. Autoplay Loop with Pause-On-Hover (Flipkart feature)
  const startAutoplay = () => {
    if (autoplayTimer === null) {
      autoplayTimer = setInterval(handleNext, autoplayDelay);
    }
  };

  const stopAutoplay = () => {
    if (autoplayTimer !== null) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  };

  const restartAutoplay = () => {
    stopAutoplay();
    startAutoplay();
  };

  container.addEventListener('mouseenter', stopAutoplay);
  container.addEventListener('mouseleave', startAutoplay);
  
  // Start Autoplay immediately
  startAutoplay();

  // D. Responsive Touch Swipe Gesture Mechanics (Mobile swipe experience)
  let touchStartX = 0;
  let touchEndX = 0;

  wrapper.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    stopAutoplay();
  }, { passive: true });

  wrapper.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipeGesture();
    startAutoplay();
  }, { passive: true });

  const handleSwipeGesture = () => {
    const minSwipeDistance = 50; // minimum swipe in px
    const swipeDelta = touchEndX - touchStartX;

    if (Math.abs(swipeDelta) > minSwipeDistance) {
      if (swipeDelta < 0) {
        // Swiped Left -> Next Slide
        handleNext();
      } else {
        // Swiped Right -> Previous Slide
        handlePrev();
      }
    }
  };
});
</script>
