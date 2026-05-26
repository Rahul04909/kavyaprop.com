<?php
/**
 * Dholera Professional Contact Us Page
 * Seamless integration of dynamic header, original contact forms, map locator, and footer.
 * Developed by Expert Developer & UI/UX Designer.
 */
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Connect with Dholera Smart City investment coordinators. Schedule office visits, request pricing sheets, or consult with our property experts online.">
  <title>Connect With Our Experts | Dholera Contact Desk</title>
  
  <!-- Fonts & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Global Base Styles & Custom Page Styles -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/contact-page.css">
</head>
<body>

  <!-- Include Sticky Navigation Header -->
  <?php include 'includes/header.php'; ?>

  <!-- 🔷 Page Hero Banner Section -->
  <section class="dh-contactpage-hero">
    <h1>Connect With Our Experts</h1>
    <p>24/7 Corporate Help Desk. Get in touch with our investment advisors or schedule a priority site-visit today.</p>
  </section>

  <!-- 🔷 Include Original Contact Form Component (Refactored to look professional) -->
  <?php include 'components/contact.php'; ?>

  <!-- 🔷 Google Maps Styled Office Location Wrapper -->
  <section class="dh-contact-map-section" style="padding: 0 5% 80px 5%; background-color: #f8fafc;">
    <div style="max-width: 1200px; margin: 0 auto;">
      
      <!-- Section Mini Title -->
      <div style="text-align: center; margin-bottom: 35px;">
        <span style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 13px; color: var(--dh-orange, #ef7d00); text-transform: uppercase; letter-spacing: 2px;">Find Us on the Map</span>
        <h2 style="font-family: 'Montserrat', sans-serif; font-size: 24px; font-weight: 800; color: #1c1d1f; margin: 8px 0 0 0;">Dholera SIR Corporate Hub</h2>
      </div>

      <!-- Map Frame -->
      <div style="background-color: #ffffff; border: 2px solid #e2e8f0; border-radius: 20px; padding: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); overflow: hidden; position: relative;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d118228.43734612448!2d72.11585868205244!3d22.2537754406144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395fa33e59530467%3A0xe54dcfcd77732c53!2sDholera%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1716723223000!5m2!1sen!2sin" 
                width="100%" 
                height="450" 
                style="border:0; border-radius: 12px; display: block;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
      
    </div>
  </section>

  <!-- Include Responsive Footer Component -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
