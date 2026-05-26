<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dholera Smart City">
  <title>Dholera Smart City</title>
  
  <style>
    body {
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body>

  <!-- Include the Interactive Responsive Header Component -->
  <?php include 'includes/header.php'; ?>

  <!-- Include the Responsive Hero Slider Component (Flipkart Style) -->
  <?php include 'components/hero.php'; ?>

  <!-- Include the Front About Us Component -->
  <?php include 'components/about.php'; ?>

  <!-- Include the Premium Projects Component (Udemy/Card Style) -->
  <?php include 'components/projects.php'; ?>

  <!-- Include the Front Contact Component -->
  <?php include 'components/contact.php'; ?>

  <!-- Include the Responsive Footer Component -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
