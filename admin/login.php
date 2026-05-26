<?php
/**
 * Secure Admin Login Endpoint
 * Developed by Expert Security & UI/UX Developer
 */

// 1. Include Secure DB & Commons
require_once __DIR__ . '/../includes/db.php';

// 2. Redirect to profile dashboard if already authenticated
if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header("Location: index.php");
    exit;
}

$error_msg = '';
$success_msg = '';

// 3. Process Login Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CSRF Protection validation
    $submitted_csrf = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($submitted_csrf)) {
        // CSRF validation failed - reject immediately
        $error_msg = 'Cyber-security Alert: Unauthorized form submission token. Session rejected.';
    } else {
        // Sanitize credentials
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error_msg = 'Please enter both your email address and password.';
        } else {
            // Retrieve admin details using PDO prepared statements
            try {
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
                $stmt->execute(['email' => $email]);
                $admin = $stmt->fetch();

                if ($admin && password_verify($password, $admin['password'])) {
                    
                    // Session Fixation Protection: Regenerate session ID securely upon login
                    session_regenerate_id(true);

                    // Set authenticated state in session
                    $_SESSION['admin_logged'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['name'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_mobile'] = $admin['mobile'];
                    $_SESSION['admin_avatar'] = $admin['profile_image'];

                    // Redirect to secure dashboard profile editor
                    header("Location: index.php");
                    exit;
                } else {
                    // Anti-Bruteforce Defense: sleep 1 second to throttle automated directory scanners
                    sleep(1);
                    $error_msg = 'Invalid email address or administrative password.';
                }
            } catch (PDOException $e) {
                $error_msg = 'Database Connection Failure: Query rejected. Please contact administrator.';
            }
        }
    }
}

// 4. Generate unique dynamic CSRF token
$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Secure Dholera Admin Portal Authorization Gate.">
  <title>Administrative Login - Dholera Smart City</title>
  
  <!-- Preconnect and Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Portal Styling Sheets -->
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="adm-body">

  <div class="adm-login-wrapper">
    <div class="adm-login-card">
      
      <!-- Logo Header -->
      <div class="adm-login-header">
        <svg class="adm-login-logo-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 65" width="160" height="52">
          <!-- White silhouette logo graphic -->
          <g>
            <path d="M 12 18 C 22 8, 32 10, 42 20 C 50 28, 56 12, 66 14 C 74 16, 80 22, 86 18" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M 8 23 C 18 12, 28 14, 38 24 C 46 32, 52 16, 62 16 C 70 16, 76 26, 82 23" fill="none" stroke="var(--adm-orange, #ef7d00)" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M 16 14 C 24 6, 34 8, 44 16 C 52 24, 58 10, 68 11 C 76 12, 82 18, 88 15" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2.5" stroke-linecap="round"/>
          </g>
          <text x="6" y="47" font-family="'Montserrat', sans-serif" font-weight="800" font-size="28" fill="#ffffff" letter-spacing="-0.5">Dholera</text>
          <text x="7" y="58" font-family="'Outfit', sans-serif" font-weight="600" font-size="7.2" fill="#94a3b8" letter-spacing="0.1">HUMAN BUILT ON TRUST. ALWAYS.</text>
        </svg>
      </div>

      <!-- Form Body Area -->
      <div class="adm-login-body">
        <h2 class="adm-login-title">Administrative Portal Login</h2>
        
        <!-- Alerts Block -->
        <?php if (!empty($error_msg)): ?>
          <div class="adm-alert adm-alert-error" role="alert">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?php echo $error_msg; ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($success_msg)): ?>
          <div class="adm-alert adm-alert-success" role="alert">
            <i class="fa-solid fa-circle-check"></i>
            <span><?php echo $success_msg; ?></span>
          </div>
        <?php endif; ?>

        <!-- Form Element -->
        <form class="adm-form" action="login.php" method="POST">
          <!-- Dynamic CSRF Token (Secure hidden node) -->
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
          
          <!-- Email Input -->
          <div class="adm-form-group">
            <label class="adm-label" for="login-email">Email Address</label>
            <input class="adm-input" type="email" id="login-email" name="email" placeholder="enter admin email" required autofocus>
          </div>

          <!-- Password Input -->
          <div class="adm-form-group">
            <label class="adm-label" for="login-password">Password</label>
            <input class="adm-input" type="password" id="login-password" name="password" placeholder="enter admin password" required>
          </div>

          <!-- Submit Button -->
          <button class="adm-submit-btn" type="submit" style="width: 100%; margin-top: 15px;">
            Secure Authorize Login <i class="fa-solid fa-arrow-right-to-bracket"></i>
          </button>
        </form>
      </div>

    </div>
  </div>

</body>
</html>
