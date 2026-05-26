<?php
/**
 * Dholera Admin Portal - Edit Existing Smart Plot Project
 * Developed by Expert Developer
 */

// 1. Include Secure DB & Commons
require_once __DIR__ . '/../includes/db.php';

// 2. Enforce active administrator authentication gate
enforceAdminAuth();

$proj_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($proj_id <= 0) {
    $_SESSION['proj_error'] = 'Error: Invalid project selection.';
    header("Location: manage-projects.php");
    exit;
}

// 3. Fetch project details fresh from database
try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $proj_id]);
    $project = $stmt->fetch();
    
    if (!$project) {
        $_SESSION['proj_error'] = 'Error: Project record does not exist.';
        header("Location: manage-projects.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database Connection Error: Failed to fetch record. Details: " . $e->getMessage());
}

$error_msg = '';
$success_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CSRF Protection validation
    $submitted_csrf = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($submitted_csrf)) {
        $error_msg = 'Cyber-security Alert: Unauthorized CSRF submission token. Session rejected.';
    } else {
        
        // Sanitize primary text inputs
        $title = sanitizeInput($_POST['title'] ?? '');
        $category = sanitizeInput($_POST['category'] ?? '');
        $location = sanitizeInput($_POST['location'] ?? '');
        $price = sanitizeInput($_POST['price'] ?? '');
        $price_sub = sanitizeInput($_POST['price_sub'] ?? '');
        $rera = sanitizeInput($_POST['rera'] ?? '');
        $size = sanitizeInput($_POST['size'] ?? '');
        $status = sanitizeInput($_POST['status'] ?? '');
        $road = sanitizeInput($_POST['road'] ?? '');
        $power = sanitizeInput($_POST['power'] ?? '');
        $water = sanitizeInput($_POST['water'] ?? '');
        
        // SEO fields
        $seo_title = sanitizeInput($_POST['seo_title'] ?? '');
        $seo_desc = sanitizeInput($_POST['seo_description'] ?? '');
        $seo_keywords = sanitizeInput($_POST['seo_keywords'] ?? '');
        
        // Rich text description
        $description = trim($_POST['description'] ?? '');
        
        // Decode amenities array to JSON
        $amenities_input = $_POST['amenities'] ?? '';
        $amenities_arr = array_filter(array_map('trim', explode(',', $amenities_input)));
        $amenities_json = json_encode(array_values($amenities_arr));
        
        if (empty($title) || empty($category) || empty($location) || empty($price) || empty($description)) {
            $error_msg = 'Please fill out all mandatory fields marked with an asterisk (*).';
        } else {
            
            // Set up secure file uploads folder
            $upload_dir = __DIR__ . '/../uploads/projects/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // A. Handle primary image update
            $main_image_url = $project['main_image'];
            
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                
                $file_tmp = $_FILES['main_image']['tmp_name'];
                $file_name = $_FILES['main_image']['name'];
                $file_size = $_FILES['main_image']['size'];
                
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
                
                // Mime check
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file_tmp);
                finfo_close($finfo);
                
                $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/x-png', 'image/pjpeg'];
                
                if ($file_size > 3 * 1024 * 1024) {
                    $error_msg = 'Upload Error: Primary image size cannot exceed 3MB.';
                } elseif (!in_array($file_ext, $allowed_exts) || !in_array($mime_type, $allowed_mimes)) {
                    $error_msg = 'Upload Error: Invalid primary image format. Only JPG, JPEG, PNG, or WEBP are permitted.';
                } else {
                    $random_hex = bin2hex(random_bytes(12));
                    $new_main_name = 'main_' . $random_hex . '.' . $file_ext;
                    if (move_uploaded_file($file_tmp, $upload_dir . $new_main_name)) {
                        
                        // Delete old image if uploaded previously
                        $old_main = $project['main_image'];
                        if (!empty($old_main) && !str_starts_with($old_main, 'assets/images/')) {
                            @unlink(__DIR__ . '/../' . $old_main);
                        }
                        
                        $main_image_url = 'uploads/projects/' . $new_main_name;
                    } else {
                        $error_msg = 'System Error: Failed to write primary image to destination.';
                    }
                }
            }
            
            // B. Handle secondary thumbnail uploads
            $thumbs_arr = json_decode($project['thumbs'], true) ?: [$main_image_url];
            
            // If primary image changed and old main image was the first thumbnail, update it
            if ($main_image_url !== $project['main_image'] && isset($thumbs_arr[0]) && $thumbs_arr[0] === $project['main_image']) {
                $thumbs_arr[0] = $main_image_url;
            }
            
            if (empty($error_msg) && isset($_FILES['thumbnails']) && !empty($_FILES['thumbnails']['name'][0])) {
                
                $files_count = count($_FILES['thumbnails']['name']);
                $new_thumbs_uploaded = false;
                $temp_thumbs = [$main_image_url]; // Reset with new main image
                
                for ($i = 0; $i < $files_count; $i++) {
                    if ($_FILES['thumbnails']['error'][$i] === UPLOAD_ERR_OK) {
                        
                        $file_tmp = $_FILES['thumbnails']['tmp_name'][$i];
                        $file_name = $_FILES['thumbnails']['name'][$i];
                        
                        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
                        
                        // Mime check
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime_type = finfo_file($finfo, $file_tmp);
                        finfo_close($finfo);
                        
                        $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/x-png', 'image/pjpeg'];
                        
                        if (in_array($file_ext, $allowed_exts) && in_array($mime_type, $allowed_mimes)) {
                            $random_hex = bin2hex(random_bytes(10));
                            $new_thumb_name = 'thumb_' . $random_hex . '_' . $i . '.' . $file_ext;
                            if (move_uploaded_file($file_tmp, $upload_dir . $new_thumb_name)) {
                                $temp_thumbs[] = 'uploads/projects/' . $new_thumb_name;
                                $new_thumbs_uploaded = true;
                            }
                        }
                    }
                }
                
                if ($new_thumbs_uploaded) {
                    // Purge old custom thumbnails from server
                    $old_thumbs = json_decode($project['thumbs'], true);
                    if (is_array($old_thumbs)) {
                        foreach ($old_thumbs as $old_th) {
                            if (!empty($old_th) && !str_starts_with($old_th, 'assets/images/') && $old_th !== $project['main_image']) {
                                @unlink(__DIR__ . '/../' . $old_th);
                            }
                        }
                    }
                    $thumbs_arr = $temp_thumbs;
                }
            }
            
            $thumbs_json = json_encode($thumbs_arr);
            
            // C. Save into Database using secure PDO transactions
            if (empty($error_msg)) {
                try {
                    $update_sql = "UPDATE projects SET 
                        title = :title, 
                        category = :category, 
                        location = :location, 
                        main_image = :main_image, 
                        thumbs = :thumbs, 
                        price = :price, 
                        price_sub = :price_sub, 
                        rera = :rera, 
                        size = :size, 
                        status = :status, 
                        road = :road, 
                        power = :power, 
                        water = :water, 
                        description = :description, 
                        amenities = :amenities, 
                        seo_title = :seo_title, 
                        seo_description = :seo_desc, 
                        seo_keywords = :seo_keywords 
                        WHERE id = :id";
                    
                    $stmt = $pdo->prepare($update_sql);
                    $stmt->execute([
                        'title' => $title,
                        'category' => $category,
                        'location' => $location,
                        'main_image' => $main_image_url,
                        'thumbs' => $thumbs_json,
                        'price' => $price,
                        'price_sub' => $price_sub,
                        'rera' => $rera,
                        'size' => $size,
                        'status' => $status,
                        'road' => $road,
                        'power' => $power,
                        'water' => $water,
                        'description' => $description,
                        'amenities' => $amenities_json,
                        'seo_title' => empty($seo_title) ? $title : $seo_title,
                        'seo_desc' => empty($seo_desc) ? substr(strip_tags($description), 0, 160) : $seo_desc,
                        'seo_keywords' => $seo_keywords,
                        'id' => $proj_id
                    ]);
                    
                    $_SESSION['proj_success'] = 'Smart plot project "' . $title . '" modifications applied successfully!';
                    header("Location: manage-projects.php");
                    exit;
                } catch (PDOException $e) {
                    $error_msg = 'Database Write Error: Transaction rolled back. Details: ' . $e->getMessage();
                }
            }
        }
    }
}

// Convert amenities json back to comma-separated values for pre-filling
$amenities_arr = json_decode($project['amenities'], true) ?: [];
$amenities_csv = implode(', ', $amenities_arr);

$csrf_token = generateCSRFToken();

// Include AdminLTE header
include './header.php';
?>

<!-- Load Trumbowyg CSS inside the page body/content wrapper -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css">
<style>
    /* Styling Trumbowyg for perfect visual integration inside AdminLTE card fields */
    .trumbowyg-box, .trumbowyg-editor {
        border-color: #ced4da !important;
        border-radius: 4px;
        min-height: 250px !important;
    }
    .trumbowyg-button-pane {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #ced4da !important;
    }
</style>

<div class="row">
    <div class="col-12">
        
        <!-- Alerts Block -->
        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                <span><?php echo $error_msg; ?></span>
                <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
            </div>
        <?php endif; ?>

        <form action="edit-project.php?id=<?php echo $project['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="row">
                <!-- Left Column: Core Fields -->
                <div class="col-lg-8">
                    
                    <!-- Core Specs Card -->
                    <div class="card card-success shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title font-weight-bold mb-0"><i class="fa-solid fa-file-invoice mr-1"></i> Edit Project Details</h3>
                        </div>
                        
                        <div class="card-body">
                            <!-- Project Title -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="proj-title">Project Title *</label>
                                <input class="form-control" type="text" id="proj-title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                            </div>
                            
                            <div class="row">
                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold text-secondary" for="proj-cat">Category *</label>
                                    <select class="form-control" id="proj-cat" name="category" required>
                                        <option value="">Select a Category</option>
                                        <option value="Residential Villa Plots" <?php echo ($project['category'] === 'Residential Villa Plots') ? 'selected' : ''; ?>>Residential Villa Plots</option>
                                        <option value="Premium Residential Land" <?php echo ($project['category'] === 'Premium Residential Land') ? 'selected' : ''; ?>>Premium Residential Land</option>
                                        <option value="Industrial Economic Land" <?php echo ($project['category'] === 'Industrial Economic Land') ? 'selected' : ''; ?>>Industrial Economic Land</option>
                                        <option value="Commercial Infrastructure Space" <?php echo ($project['category'] === 'Commercial Infrastructure Space') ? 'selected' : ''; ?>>Commercial Infrastructure Space</option>
                                        <option value="Logistics & Warehousing Land" <?php echo ($project['category'] === 'Logistics & Warehousing Land') ? 'selected' : ''; ?>>Logistics & Warehousing Land</option>
                                    </select>
                                </div>
                                
                                <!-- Location -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold text-secondary" for="proj-loc">Location Tag *</label>
                                    <input class="form-control" type="text" id="proj-loc" name="location" value="<?php echo htmlspecialchars($project['location']); ?>" required>
                                </div>
                            </div>

                            <!-- Description (Trumbowyg Rich Text Editor) -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary">Detailed Overview & Specifications *</label>
                                <textarea id="project-desc" name="description" class="form-control"><?php echo htmlspecialchars($project['description']); ?></textarea>
                            </div>
                            
                            <!-- Amenities -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="proj-amenities">Amenities Checklist (Comma Separated)</label>
                                <textarea class="form-control" rows="2" id="proj-amenities" name="amenities" placeholder="e.g., Smart Utility Grids, 24/7 CCTV & Security"><?php echo htmlspecialchars($amenities_csv); ?></textarea>
                                <small class="text-muted"><i class="fa-solid fa-info-circle mr-1"></i> Add multiple parameters separated by commas.</small>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Optimization Config Card -->
                    <div class="card card-dark shadow-sm mb-4">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title font-weight-bold mb-0"><i class="fa-solid fa-gauge-high mr-1"></i> High-End SEO Optimization</h3>
                        </div>
                        <div class="card-body">
                            <!-- SEO Title -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="seo-title">Google Custom Title Tag</label>
                                <input class="form-control" type="text" id="seo-title" name="seo_title" value="<?php echo htmlspecialchars($project['seo_title']); ?>" placeholder="If left blank, default title will be used for indexing">
                            </div>
                            
                            <!-- SEO Description -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="seo-desc">Google Custom Meta Description</label>
                                <textarea class="form-control" id="seo-desc" name="seo_description" rows="3" placeholder="Optimized text shown in search result snippets (Max 160 chars)"><?php echo htmlspecialchars($project['seo_description']); ?></textarea>
                            </div>
                            
                            <!-- SEO Keywords -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="seo-keys">Meta Keywords Tag</label>
                                <input class="form-control" type="text" id="seo-keys" name="seo_keywords" value="<?php echo htmlspecialchars($project['seo_keywords']); ?>" placeholder="e.g., dholera plots, smart city projects, greenfield investment">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Media, Utilities & Rates -->
                <div class="col-lg-4">
                    
                    <!-- Media Showcase Uploads -->
                    <div class="card card-success shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title font-weight-bold mb-0"><i class="fa-solid fa-images mr-1"></i> Visual Media Assets</h3>
                        </div>
                        <div class="card-body">
                            <!-- Main Image -->
                            <div class="mb-4">
                                <label class="form-label font-weight-bold text-secondary">Primary Banner Showcase</label>
                                <div class="mb-2">
                                    <img src="../<?php echo $project['main_image']; ?>" class="img-thumbnail" style="max-height: 120px; object-fit: cover; width: 100%;">
                                    <small class="text-muted d-block mt-1">Active primary banner showcase.</small>
                                </div>
                                <input class="form-control" type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp">
                                <small class="text-muted d-block mt-1">Upload new image only if you wish to overwrite existing.</small>
                            </div>
                            
                            <!-- Gallery Thumbnails -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary">Additional Gallery Thumbnails</label>
                                <?php 
                                $thumbs = json_decode($project['thumbs'], true) ?: [];
                                if (!empty($thumbs)): ?>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        <?php foreach ($thumbs as $th): ?>
                                            <img src="../<?php echo $th; ?>" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <input class="form-control" type="file" name="thumbnails[]" accept=".jpg,.jpeg,.png,.webp" multiple>
                                <small class="text-muted d-block mt-1">Upload multiple photos to overwrite existing details gallery.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Parameter Specs -->
                    <div class="card card-success shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title font-weight-bold mb-0"><i class="fa-solid fa-sliders mr-1"></i> Specifications & Rates</h3>
                        </div>
                        <div class="card-body">
                            <!-- Price Main -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="price-main">Price Rate Tag *</label>
                                <input class="form-control" type="text" id="price-main" name="price" value="<?php echo htmlspecialchars($project['price']); ?>" required>
                            </div>
                            
                            <!-- Price Sub -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="price-sub">Price Subtitle *</label>
                                <input class="form-control" type="text" id="price-sub" name="price_sub" value="<?php echo htmlspecialchars($project['price_sub']); ?>" required>
                            </div>

                            <!-- RERA -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="rera-num">RERA ID Code</label>
                                <input class="form-control" type="text" id="rera-num" name="rera" value="<?php echo htmlspecialchars($project['rera']); ?>">
                            </div>

                            <!-- Plot Sizing -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="plot-size">Plot Sizing Parameters</label>
                                <input class="form-control" type="text" id="plot-size" name="size" value="<?php echo htmlspecialchars($project['size']); ?>">
                            </div>

                            <!-- Possession Status -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="pos-status">Possession Status</label>
                                <input class="form-control" type="text" id="pos-status" name="status" value="<?php echo htmlspecialchars($project['status']); ?>">
                            </div>

                            <!-- Roads -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="road-spec">Internal Road Width</label>
                                <input class="form-control" type="text" id="road-spec" name="road" value="<?php echo htmlspecialchars($project['road']); ?>">
                            </div>

                            <!-- Power -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="power-spec">Power Utilities</label>
                                <input class="form-control" type="text" id="power-spec" name="power" value="<?php echo htmlspecialchars($project['power']); ?>">
                            </div>

                            <!-- Water -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-secondary" for="water-spec">Water Network</label>
                                <input class="form-control" type="text" id="water-spec" name="water" value="<?php echo htmlspecialchars($project['water']); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Action Submit -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success btn-block btn-lg font-weight-bold">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Modifications
                            </button>
                            <a href="manage-projects.php" class="btn btn-outline-secondary btn-block mt-2 font-weight-bold">
                                Cancel & Return
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

<!-- Load Trumbowyg JS CDN and initialize -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
<script>
$(document).ready(function() {
    // Elegant Trumbowyg Rich Text Editor setup
    $('#project-desc').trumbowyg({
        autogrow: true,
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ]
    });
});
</script>

<?php
// Include AdminLTE footer
include './footer.php';
?>
