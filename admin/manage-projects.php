<?php
/**
 * Secure Dholera Admin Portal - Project Management Center
 * Developed by Expert Developer
 */

// 1. Include Secure DB & Commons
require_once __DIR__ . '/../includes/db.php';

// 2. Enforce active administrator authentication gate
enforceAdminAuth();

// 3. Fetch all projects from database
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Query Error: Failed to fetch projects list. Details: " . $e->getMessage());
}

$success_msg = $_SESSION['proj_success'] ?? '';
$error_msg = $_SESSION['proj_error'] ?? '';
unset($_SESSION['proj_success'], $_SESSION['proj_error']);

// Generate CSRF token for delete actions
$csrf_token = generateCSRFToken();

// Include AdminLTE header
include './header.php';
?>

<div class="row">
    <div class="col-12">
        
        <!-- Alerts Block -->
        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check mr-2"></i>
                <span><?php echo htmlspecialchars($success_msg); ?></span>
                <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                <span><?php echo htmlspecialchars($error_msg); ?></span>
                <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
            </div>
        <?php endif; ?>

        <!-- Project Roster Card -->
        <div class="card card-success shadow-sm">
            <div class="card-header bg-success d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold mb-0" style="flex: 1;"><i class="fa-solid fa-compass-drafting mr-2"></i> Dynamic Project Roster</h3>
                <a href="add-project.php" class="btn btn-warning btn-sm font-weight-bold ml-auto" style="box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-plus-circle mr-1"></i> Add New Smart Plot
                </a>
            </div>
            
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;" class="text-center">ID</th>
                            <th style="width: 100px;">Showcase</th>
                            <th>Project Specifications</th>
                            <th>Rates & Sizing</th>
                            <th>RERA Registration</th>
                            <th style="width: 150px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($projects)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fa-solid fa-folder-open display-4 mb-3 d-block text-secondary"></i>
                                    No smart plots are currently registered. Click <strong>Add New Smart Plot</strong> above to seed the inventory!
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($projects as $proj): ?>
                                <?php 
                                $main_img_path = '../' . $proj['main_image'];
                                if (empty($proj['main_image']) || !file_exists(__DIR__ . '/../' . $proj['main_image'])) {
                                    $main_img_path = '../assets/images/hero-bg.png';
                                }
                                ?>
                                <tr>
                                    <td class="text-center font-weight-bold text-secondary"><?php echo $proj['id']; ?></td>
                                    <td>
                                        <img src="<?php echo $main_img_path; ?>" 
                                             alt="Thumbnail" 
                                             class="img-thumbnail elevation-1" 
                                             style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td>
                                        <span class="badge badge-success px-2 py-1 mb-1" style="font-size: 11px;"><?php echo htmlspecialchars($proj['category']); ?></span>
                                        <strong class="d-block text-dark" style="font-size: 14.5px; white-space: normal; max-width: 320px;"><?php echo htmlspecialchars($proj['title']); ?></strong>
                                        <small class="text-muted d-block mt-1"><i class="fa-solid fa-location-dot mr-1 text-danger"></i> <?php echo htmlspecialchars($proj['location']); ?></small>
                                    </td>
                                    <td>
                                        <strong class="text-success d-block"><?php echo htmlspecialchars($proj['price']); ?></strong>
                                        <span class="text-muted d-block" style="font-size: 12px;"><?php echo htmlspecialchars($proj['price_sub']); ?></span>
                                    </td>
                                    <td>
                                        <code class="text-secondary font-weight-bold" style="font-size: 12.5px;"><?php echo htmlspecialchars($proj['rera']); ?></code>
                                        <small class="d-block text-muted mt-1"><i class="fa-solid fa-expand mr-1"></i> Plot Area: <?php echo htmlspecialchars($proj['size']); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit-project.php?id=<?php echo $proj['id']; ?>" class="btn btn-outline-primary btn-sm" title="Edit Project Details">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    title="Remove Project from Database"
                                                    onclick="confirmDelete(<?php echo $proj['id']; ?>, '<?php echo htmlspecialchars(addslashes($proj['title'])); ?>')">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Deletion Submission Mechanics -->
<form id="deleteForm" action="delete-project.php" method="POST" style="display: none;">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <input type="hidden" name="id" id="deleteProjId" value="">
</form>

<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Delete Smart Plot?',
        text: `Are you sure you want to permanently remove "${title}"? This action cannot be reversed!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete plot!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteProjId').value = id;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>

<?php
// Include AdminLTE footer
include './footer.php';
?>
