<?php
/**
 * Admin Enquiries – View Single Enquiry & Update Status
 * d:\wamp\www\dholera-new\admin\enquiries\view.php
 */
require_once __DIR__ . '/../../includes/db.php';
enforceAdminAuth();

$id = (int)($_GET['id'] ?? 0);
if ($id < 1) {
    $_SESSION['enq_admin_error'] = 'Invalid enquiry ID.';
    header('Location: index.php');
    exit;
}

// Fetch enquiry
$stmt = $pdo->prepare("SELECT * FROM enquiries WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$enq = $stmt->fetch();

if (!$enq) {
    $_SESSION['enq_admin_error'] = 'Enquiry not found.';
    header('Location: index.php');
    exit;
}

// Auto-mark as "read" if still "new"
if ($enq['status'] === 'new') {
    $pdo->prepare("UPDATE enquiries SET status = 'read' WHERE id = :id")
        ->execute([':id' => $id]);
    $enq['status'] = 'read';
}

// ── Handle status update POST ─────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $_SESSION['enq_admin_error'] = 'Security token mismatch.';
        header("Location: view.php?id=$id");
        exit;
    }
    $new_status = $_POST['status'] ?? '';
    $allowed    = ['new', 'read', 'replied', 'closed'];
    if (in_array($new_status, $allowed)) {
        $pdo->prepare("UPDATE enquiries SET status = :s WHERE id = :id")
            ->execute([':s' => $new_status, ':id' => $id]);
        $_SESSION['enq_admin_success'] = 'Status updated to "' . ucfirst($new_status) . '".';
        header("Location: view.php?id=$id");
        exit;
    }
}

$csrf_token = generateCSRFToken();
$success_msg = $_SESSION['enq_admin_success'] ?? '';
$error_msg   = $_SESSION['enq_admin_error']   ?? '';
unset($_SESSION['enq_admin_success'], $_SESSION['enq_admin_error']);

// Map for badges
$status_cfg = [
  'new'     => ['label'=>'New',     'color'=>'#ef7d00', 'bs'=>'warning text-dark'],
  'read'    => ['label'=>'Read',    'color'=>'#0ea5e9', 'bs'=>'info text-white'],
  'replied' => ['label'=>'Replied', 'color'=>'#16a34a', 'bs'=>'success'],
  'closed'  => ['label'=>'Closed',  'color'=>'#94a3b8', 'bs'=>'secondary'],
];
$sc = $status_cfg[$enq['status']] ?? ['label'=>ucfirst($enq['status']), 'color'=>'#64748b', 'bs'=>'secondary'];

$interest_labels = [
  'villas'      => '🏡 Residential Villa Plots',
  'industrial'  => '🏭 Industrial Plug-and-Play Plots',
  'commercial'  => '🏢 Commercial Economic Land',
  'consultancy' => '💼 Smart City Consultancy',
  'general'     => '💬 General Enquiry',
];

$_pageTitle  = 'View Enquiry #' . $id;
$_breadcrumb = [
  ['title' => 'Enquiries', 'url' => '#'],
  ['title' => 'View #' . $id, 'url' => '#'],
];
$_adminBase  = '../';   // one level up from admin/enquiries/
include '../header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-9 col-12">

    <?php if ($success_msg): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check mr-2"></i><?php echo htmlspecialchars($success_msg); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i><?php echo htmlspecialchars($error_msg); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <a href="index.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Enquiries
      </a>
      <div class="d-flex gap-2">
        <a href="mailto:<?php echo htmlspecialchars($enq['email']); ?>?subject=Re: Your Dholera Smart City Enquiry"
           class="btn btn-success btn-sm">
          <i class="fa-solid fa-envelope mr-1"></i> Reply via Email
        </a>
        <a href="tel:<?php echo htmlspecialchars($enq['phone']); ?>" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-phone mr-1"></i> Call
        </a>
        <button class="btn btn-danger btn-sm"
                onclick="confirmDeleteEnq(<?php echo $id; ?>, '<?php echo htmlspecialchars(addslashes($enq['name'])); ?>')">
          <i class="fa-solid fa-trash-can mr-1"></i> Delete
        </button>
      </div>
    </div>

    <!-- Enquiry Detail Card -->
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center"
           style="background: linear-gradient(135deg,#0f172a,#1e293b); color:#fff;">
        <div>
          <h4 class="mb-0 font-weight-bold" style="font-size:1.1rem;">
            <i class="fa-solid fa-envelope-open-text mr-2"></i>
            Enquiry from <?php echo htmlspecialchars($enq['name']); ?>
          </h4>
          <small style="color:#94a3b8;">ID #<?php echo $id; ?> &bull; Received <?php echo date('d M Y \a\t h:i A', strtotime($enq['created_at'])); ?></small>
        </div>
        <span class="badge badge-<?php echo $sc['bs']; ?> px-3 py-2" style="font-size:13px;">
          <?php echo $sc['label']; ?>
        </span>
      </div>

      <div class="card-body">

        <!-- Contact Info Grid -->
        <div class="row mb-4">
          <div class="col-sm-4 mb-3">
            <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
              <small class="text-muted d-block mb-1"><i class="fa-solid fa-user mr-1"></i> Full Name</small>
              <strong class="text-dark"><?php echo htmlspecialchars($enq['name']); ?></strong>
            </div>
          </div>
          <div class="col-sm-4 mb-3">
            <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
              <small class="text-muted d-block mb-1"><i class="fa-solid fa-envelope mr-1"></i> Email</small>
              <a href="mailto:<?php echo htmlspecialchars($enq['email']); ?>" class="text-primary font-weight-bold" style="word-break:break-all;">
                <?php echo htmlspecialchars($enq['email']); ?>
              </a>
            </div>
          </div>
          <div class="col-sm-4 mb-3">
            <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
              <small class="text-muted d-block mb-1"><i class="fa-solid fa-phone mr-1"></i> Phone</small>
              <a href="tel:<?php echo htmlspecialchars($enq['phone']); ?>" class="text-success font-weight-bold">
                <?php echo htmlspecialchars($enq['phone']); ?>
              </a>
            </div>
          </div>
          <div class="col-sm-4 mb-3">
            <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
              <small class="text-muted d-block mb-1"><i class="fa-solid fa-tag mr-1"></i> Interest</small>
              <strong><?php echo $interest_labels[$enq['interest']] ?? htmlspecialchars($enq['interest']); ?></strong>
            </div>
          </div>
          <div class="col-sm-4 mb-3">
            <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
              <small class="text-muted d-block mb-1"><i class="fa-solid fa-clock mr-1"></i> Submitted At</small>
              <strong><?php echo date('d M Y, h:i A', strtotime($enq['created_at'])); ?></strong>
            </div>
          </div>
          <div class="col-sm-4 mb-3">
            <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
              <small class="text-muted d-block mb-1"><i class="fa-solid fa-globe mr-1"></i> IP Address</small>
              <code><?php echo htmlspecialchars($enq['ip_address'] ?? 'N/A'); ?></code>
            </div>
          </div>
        </div>

        <!-- Message Box -->
        <div class="mb-4">
          <h6 class="font-weight-bold text-dark mb-2"><i class="fa-solid fa-comment-dots mr-1 text-success"></i> Message</h6>
          <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0; line-height:1.75; white-space:pre-wrap; font-family:'Source Sans Pro',sans-serif; color:#334155;">
            <?php echo nl2br(htmlspecialchars($enq['message'])); ?>
          </div>
        </div>

        <!-- Status Update Form -->
        <div class="p-3 rounded" style="background:#fff8f0; border:1px solid #fdba74;">
          <h6 class="font-weight-bold mb-3" style="color:#c05e00;">
            <i class="fa-solid fa-sliders mr-1"></i> Update Status
          </h6>
          <form method="POST" action="view.php?id=<?php echo $id; ?>" class="d-flex align-items-center gap-3 flex-wrap">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input type="hidden" name="update_status" value="1">
            <select name="status" class="form-control form-control-sm" style="max-width:180px;">
              <?php foreach (['new','read','replied','closed'] as $s): ?>
                <option value="<?php echo $s; ?>" <?php echo ($enq['status'] === $s) ? 'selected' : ''; ?>>
                  <?php echo ucfirst($s); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-warning btn-sm font-weight-bold">
              <i class="fa-solid fa-save mr-1"></i> Save Status
            </button>
          </form>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteEnqForm" action="delete.php" method="POST" style="display:none;">
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
  <input type="hidden" name="id" id="deleteEnqId">
  <input type="hidden" name="redirect" value="index.php">
</form>

<script>
function confirmDeleteEnq(id, name) {
  Swal.fire({
    title: 'Delete Enquiry?',
    html: `Remove enquiry from <strong>${name}</strong>? This cannot be undone.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then(result => {
    if (result.isConfirmed) {
      document.getElementById('deleteEnqId').value = id;
      document.getElementById('deleteEnqForm').submit();
    }
  });
}
</script>

<?php include '../footer.php'; ?>
