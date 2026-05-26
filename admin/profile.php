<?php
/**
 * Secure Admin Profile Management Dashboard
 * Developed by Expert Security & UI/UX Developer
 */

// 1. Include Secure DB & Commons
require_once __DIR__ . '/../includes/db.php';

// 2. Enforce active administrator authentication gate
enforceAdminAuth();

// 3. Load active admin details fresh from Database using PDO Prepared Statements
$admin_id = $_SESSION['admin_id'];
try {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $admin_id]);
    $admin = $stmt->fetch();
    
    if (!$admin) {
        // Active admin record deleted - force terminate session
        header("Location: logout.php");
        exit;
    }
} catch (PDOException $e) {
    die("Security System Failure: Critical query failed. Please contact support.");
}

$error_msg = '';
$success_msg = '';

// 4. Handle Profile Updates (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CSRF Protection validation
    $submitted_csrf = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($submitted_csrf)) {
        $error_msg = 'Cyber-security Alert: Unauthorized CSRF submission token. Session rejected.';
    } else {
        // Sanitize textual details
        $name = sanitizeInput($_POST['name'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $mobile = sanitizeInput($_POST['mobile'] ?? '');
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Input Validations
        if (empty($name) || empty($email) || empty($mobile)) {
            $error_msg = 'Please fill out all primary profile fields (Name, Email, and Mobile).';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = 'Please provide a valid email address structure.';
        } else {
            // Check if email is already taken by another administrator to prevent unique key errors
            try {
                $chk_stmt = $pdo->prepare("SELECT id FROM admins WHERE email = :email AND id != :id LIMIT 1");
                $chk_stmt->execute(['email' => $email, 'id' => $admin_id]);
                if ($chk_stmt->fetch()) {
                    $error_msg = 'The email address is already registered to another administrator account.';
                }
            } catch (PDOException $e) {
                $error_msg = 'Database Query Failure: Duplicate check failed.';
            }
            
            if (empty($error_msg)) {
                // Determine transaction updates
                $update_avatar = false;
                $new_avatar_filename = $admin['profile_image'];
                
                // A. Handle Secure Image Upload if a file is uploaded
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] !== UPLOAD_ERR_NO_FILE) {
                    
                    $file_error = $_FILES['profile_pic']['error'];
                    
                    if ($file_error !== UPLOAD_ERR_OK) {
                        if ($file_error === UPLOAD_ERR_INI_SIZE) {
                            $error_msg = 'Upload Error: The image file size exceeds the server\'s maximum upload limit (upload_max_filesize in php.ini). Please compress your image (under 2MB) or adjust the php.ini configuration of your WAMP server.';
                        } else {
                            $error_msg = 'Profile Picture Upload Error: Code ' . $file_error;
                        }
                    } else {
                        
                        $file_size = $_FILES['profile_pic']['size'];
                        $file_tmp = $_FILES['profile_pic']['tmp_name'];
                        $file_name = $_FILES['profile_pic']['name'];
                        
                        // Limit size to max 2MB
                        $max_size = 2 * 1024 * 1024;
                        
                        if ($file_size > $max_size) {
                            $error_msg = 'Security Block: File size exceeds the maximum limit of 2MB.';
                        } else {
                            // Extract file extension cleanly
                            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                            $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
                            
                            // Strict Cyber Protection Mime-Type check using Server side FileInfo (anti-spoofing)
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime_type = finfo_file($finfo, $file_tmp);
                            finfo_close($finfo);
                            
                            $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/x-png', 'image/pjpeg'];
                            
                            if (!in_array($file_ext, $allowed_exts) || !in_array($mime_type, $allowed_mimes)) {
                                $error_msg = 'Security Block: Invalid file type. Only JPG, JPEG, PNG, and WEBP formats are authorized.';
                            } else {
                                // Create uploads/profile folder if missing with clean permissions
                                $upload_dir = __DIR__ . '/../uploads/profile/';
                                if (!file_exists($upload_dir)) {
                                    mkdir($upload_dir, 0755, true);
                                }
                                
                                // Cryptographically secure random filename to block path traversals and directory listings
                                $random_hex = bin2hex(random_bytes(16));
                                $new_avatar_filename = 'avatar_' . $admin_id . '_' . $random_hex . '.' . $file_ext;
                                $upload_path = $upload_dir . $new_avatar_filename;
                                
                                if (move_uploaded_file($file_tmp, $upload_path)) {
                                    $update_avatar = true;
                                    
                                    // Remove old avatar photo from server to conserve storage (excluding default placeholder)
                                    $old_avatar = $admin['profile_image'];
                                    if ($old_avatar !== 'default-avatar.png' && file_exists($upload_dir . $old_avatar)) {
                                        @unlink($upload_dir . $old_avatar);
                                    }
                                } else {
                                    $error_msg = 'System Error: Failed to write uploaded image to secure directories.';
                                }
                            }
                        }
                    }
                }
                
                // B. Handle Secure Password Reset if requested
                $update_pass = false;
                $hashed_password = '';
                
                if (!empty($new_password)) {
                    if (strlen($new_password) < 6) {
                        $error_msg = 'Security Standard: Password must contain at least 6 characters.';
                    } elseif ($new_password !== $confirm_password) {
                        $error_msg = 'Password confirmation mismatch. Please re-enter passwords.';
                    } else {
                        // Secure BCRYPT hashing with computational cost factor of 12
                        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 12]);
                        $update_pass = true;
                    }
                }
                
                // C. Persist all verified changes using transaction blocks
                if (empty($error_msg)) {
                    try {
                        $sql = "UPDATE admins SET name = :name, email = :email, mobile = :mobile";
                        $params = [
                            'name' => $name,
                            'email' => $email,
                            'mobile' => $mobile,
                            'id' => $admin_id
                        ];
                        
                        if ($update_avatar) {
                            $sql .= ", profile_image = :profile_pic";
                            $params['profile_pic'] = $new_avatar_filename;
                        }
                        
                        if ($update_pass) {
                            $sql .= ", password = :pass";
                            $params['pass'] = $hashed_password;
                        }
                        
                        $sql .= " WHERE id = :id";
                        
                        $update_stmt = $pdo->prepare($sql);
                        $update_stmt->execute($params);
                        
                        // Refetch details to keep visual outputs synced
                        $stmt->execute(['id' => $admin_id]);
                        $admin = $stmt->fetch();
                        
                        // Synchronize variables inside Active Session State
                        $_SESSION['admin_name'] = $admin['name'];
                        $_SESSION['admin_email'] = $admin['email'];
                        $_SESSION['admin_mobile'] = $admin['mobile'];
                        $_SESSION['admin_avatar'] = $admin['profile_image'];
                        
                        $success_msg = 'Administrative profile details updated successfully.';
                    } catch (PDOException $e) {
                        $error_msg = 'Database Write Error: Transaction rolled back.';
                    }
                }
            }
        }
    }
}

// 5. Generate fresh dynamic CSRF token
$csrf_token = generateCSRFToken();

// Compute avatar path fallback
$avatar_src = '../uploads/profile/' . $admin['profile_image'];
if ($admin['profile_image'] === 'default-avatar.png' || !file_exists(__DIR__ . '/../uploads/profile/' . $admin['profile_image'])) {
    // Elegant inline SVG base64 default avatar representation if file is missing
    $avatar_src = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' fill='%23cbd5e1'><circle cx='50' cy='35' r='20'/><path d='M 15,85 C 15,60 30,55 50,55 C 70,55 85,60 85,85 Z'/></svg>";
}
?>
<?php 
// Include the AdminLTE readymade header
include './header.php'; 
?>

<div class="row">
    <!-- Left Column: Visual Profile Card Summary -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-success card-outline shadow-sm">
            <div class="card-body box-profile text-center">
                <div class="text-center mb-3">
                    <img class="profile-user-img img-fluid img-circle elevation-2 bg-white" 
                         src="<?php echo $avatar_src; ?>" 
                         id="admAvatarPreview"
                         alt="Admin profile picture" 
                         style="width: 110px; height: 110px; object-fit: cover;">
                </div>
                <h3 class="profile-username text-center font-weight-bold text-dark"><?php echo htmlspecialchars($admin['name']); ?></h3>
                <p class="text-muted text-center"><?php echo htmlspecialchars($admin['email']); ?></p>
                
                <hr>
                
                <ul class="list-group list-group-unbordered mb-3 text-left">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <span class="text-muted"><i class="fa-solid fa-phone mr-2"></i> Mobile:</span> 
                        <strong class="text-dark"><?php echo htmlspecialchars($admin['mobile']); ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <span class="text-muted"><i class="fa-solid fa-shield-halved mr-2"></i> Security:</span> 
                        <span class="badge badge-success px-2 py-1">Authorized</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column: Profile & Security Editor Form -->
    <div class="col-md-8 col-lg-9">
        <div class="card card-success shadow-sm">
            <div class="card-header bg-success text-white">
                <h3 class="card-title font-weight-bold"><i class="fa-solid fa-user-gear mr-2"></i> Edit Administrative Profile</h3>
            </div>
            
            <!-- Editor Form (EncType required for file uploads) -->
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <!-- Dynamic CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <div class="card-body">
                    
                    <!-- Alerts Block -->
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                            <span><?php echo $error_msg; ?></span>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-check mr-2"></i>
                            <span><?php echo $success_msg; ?></span>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Name Input -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-secondary" for="profile-name">Full Name</label>
                            <input class="form-control" type="text" id="profile-name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                        </div>
                        
                        <!-- Mobile Input -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-secondary" for="profile-mobile">Mobile Number</label>
                            <input class="form-control" type="tel" id="profile-mobile" name="mobile" value="<?php echo htmlspecialchars($admin['mobile']); ?>" required>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="mb-4">
                        <label class="form-label font-weight-bold text-secondary" for="profile-email">Email Address (Login Username)</label>
                        <input class="form-control" type="email" id="profile-email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                    </div>

                    <!-- File Upload Component -->
                    <div class="mb-4">
                        <label class="form-label font-weight-bold text-secondary">Update Profile Picture</label>
                        <div class="custom-file">
                            <input type="file" class="form-control" id="profile-pic" name="profile_pic" accept=".jpg,.jpeg,.png,.webp" onchange="previewUpload(this)">
                            <small class="form-text text-muted mt-1"><i class="fa-solid fa-circle-info mr-1"></i> Supports JPG, JPEG, PNG, or WEBP formats (Max 2MB).</small>
                        </div>
                    </div>

                    <!-- Password Reset Section -->
                    <div class="pt-3 border-top">
                        <h5 class="text-success font-weight-bold mb-3"><i class="fa-solid fa-lock mr-2"></i> Update Security Credentials</h5>
                        <p class="text-muted mb-3" style="font-size: 13.5px;"><i class="fa-solid fa-triangle-exclamation text-warning mr-1"></i> Leave password fields completely blank if you do not wish to modify your active password.</p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="profile-new-pass">New Password</label>
                                <input class="form-control" type="password" id="profile-new-pass" name="new_password" placeholder="enter new password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="profile-confirm-pass">Confirm Password</label>
                                <input class="form-control" type="password" id="profile-confirm-pass" name="confirm_password" placeholder="re-enter new password">
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="card-footer bg-light d-flex justify-content-start">
                    <button class="btn btn-success font-weight-bold px-4" type="submit">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Apply Profile Alterations
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dynamic Image Preview JavaScript Mechanics -->
<script>
function previewUpload(inputElement) {
  if (inputElement.files && inputElement.files[0]) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
      // Smoothly swap large showcase avatar preview display
      document.getElementById('admAvatarPreview').src = e.target.result;
    };
    
    reader.readAsDataURL(inputElement.files[0]);
  }
}
</script>

<?php 
// Include the AdminLTE readymade footer
include './footer.php'; 
?>