<?php
/**
 * Admin Enquiries – List / Dashboard
 * d:\wamp\www\dholera-new\admin\enquiries\index.php
 */
require_once __DIR__ . '/../../includes/db.php';
enforceAdminAuth();

// ── Filters ───────────────────────────────────────────────────────────
$filter_status  = $_GET['status']  ?? 'all';
$filter_search  = trim($_GET['search'] ?? '');
$page           = max(1, (int)($_GET['page'] ?? 1));
$per_page       = 15;
$offset         = ($page - 1) * $per_page;

$where  = [];
$params = [];

if ($filter_status !== 'all') {
    $where[]              = 'status = :status';
    $params[':status']    = $filter_status;
}
if ($filter_search !== '') {
    $where[]              = '(name LIKE :s OR email LIKE :s OR phone LIKE :s)';
    $params[':s']         = '%' . $filter_search . '%';
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// ── Count total ───────────────────────────────────────────────────────
$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM enquiries $where_sql");
$count_stmt->execute($params);
$total       = (int)$count_stmt->fetchColumn();
$total_pages = max(1, ceil($total / $per_page));

// ── Fetch page rows ───────────────────────────────────────────────────
$stmt = $pdo->prepare("SELECT * FROM enquiries $where_sql ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(':limit',  $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,   PDO::PARAM_INT);
$stmt->execute();
$enquiries = $stmt->fetchAll();

// ── Stats badges ──────────────────────────────────────────────────────
$stats_stmt = $pdo->query("SELECT status, COUNT(*) as cnt FROM enquiries GROUP BY status");
$stats_raw  = $stats_stmt->fetchAll();
$stats      = ['new' => 0, 'read' => 0, 'replied' => 0, 'closed' => 0];
foreach ($stats_raw as $r) { $stats[$r['status']] = $r['cnt']; }
$total_all  = array_sum($stats);

// ── Flash messages ────────────────────────────────────────────────────
$success_msg = $_SESSION['enq_admin_success'] ?? '';
$error_msg   = $_SESSION['enq_admin_error']   ?? '';
unset($_SESSION['enq_admin_success'], $_SESSION['enq_admin_error']);

$csrf_token = generateCSRFToken();

// ── Page meta for admin header ────────────────────────────────────────
$_pageTitle      = 'Enquiries Management';
$_breadcrumb     = [['title' => 'Enquiries', 'url' => '#']];
$_adminBase      = '../';   // one level up from admin/enquiries/

include '../header.php';
?>

<div class="row">
  <div class="col-12">

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

    <!-- ── Stats Row ── -->
    <div class="row mb-4">
      <?php
      $badge_cfg = [
        'all'     => ['label'=>'Total Enquiries', 'color'=>'#0f172a', 'icon'=>'fa-inbox',           'val' => $total_all],
        'new'     => ['label'=>'New',             'color'=>'#ef7d00', 'icon'=>'fa-star',             'val' => $stats['new']],
        'read'    => ['label'=>'Read',            'color'=>'#0ea5e9', 'icon'=>'fa-envelope-open',    'val' => $stats['read']],
        'replied' => ['label'=>'Replied',         'color'=>'#16a34a', 'icon'=>'fa-reply',            'val' => $stats['replied']],
        'closed'  => ['label'=>'Closed',          'color'=>'#94a3b8', 'icon'=>'fa-lock',             'val' => $stats['closed']],
      ];
      foreach ($badge_cfg as $key => $cfg):
        $is_active = ($filter_status === $key) ? 'box-shadow:0 0 0 3px ' . $cfg['color'] . '55;' : '';
        $url_params = http_build_query(array_merge($_GET, ['status' => $key, 'page' => 1]));
      ?>
      <div class="col-6 col-sm-4 col-lg-2-4 mb-3" style="flex: 0 0 20%; max-width: 20%;">
        <a href="index.php?<?php echo $url_params; ?>" class="text-decoration-none">
          <div class="info-box mb-0" style="border-left: 4px solid <?php echo $cfg['color']; ?>; <?php echo $is_active; ?>">
            <span class="info-box-icon" style="background:<?php echo $cfg['color']; ?>15; color:<?php echo $cfg['color']; ?>; font-size:1.4rem; min-width:60px;">
              <i class="fa-solid <?php echo $cfg['icon']; ?>"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text" style="color:#64748b; font-size:11px;"><?php echo $cfg['label']; ?></span>
              <span class="info-box-number" style="color:<?php echo $cfg['color']; ?>; font-weight:800; font-size:1.6rem;"><?php echo $cfg['val']; ?></span>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- ── Main Card ── -->
    <div class="card card-success shadow-sm">
      <div class="card-header bg-success d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="card-title font-weight-bold mb-0">
          <i class="fa-solid fa-inbox mr-2"></i>Enquiries
          <?php if ($filter_status !== 'all'): ?>
            <span class="badge badge-light ml-2" style="font-size:12px;"><?php echo ucfirst($filter_status); ?></span>
          <?php endif; ?>
        </h3>
        <!-- Search Form -->
        <form method="GET" action="index.php" class="d-flex align-items-center gap-2 ml-auto" style="gap:8px;">
          <input type="hidden" name="status" value="<?php echo htmlspecialchars($filter_status); ?>">
          <input type="text" name="search" class="form-control form-control-sm"
                 placeholder="Search name / email / phone…"
                 value="<?php echo htmlspecialchars($filter_search); ?>"
                 style="min-width:200px;">
          <button type="submit" class="btn btn-warning btn-sm">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
          <?php if ($filter_search): ?>
            <a href="index.php?status=<?php echo urlencode($filter_status); ?>" class="btn btn-outline-light btn-sm">
              <i class="fa-solid fa-xmark"></i>
            </a>
          <?php endif; ?>
        </form>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="text-center" style="width:50px;">#</th>
              <th>Contact Details</th>
              <th>Interest</th>
              <th style="max-width:260px;">Message</th>
              <th style="width:100px;">Status</th>
              <th style="width:120px;">Received</th>
              <th class="text-center" style="width:130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($enquiries)): ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-5">
                  <i class="fa-solid fa-inbox fa-3x mb-3 d-block text-secondary"></i>
                  No enquiries found<?php if ($filter_search): ?> for &ldquo;<strong><?php echo htmlspecialchars($filter_search); ?></strong>&rdquo;<?php endif; ?>.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($enquiries as $enq): ?>
              <?php
                $status_cfg = [
                  'new'     => ['label'=>'New',     'class'=>'badge-warning text-dark'],
                  'read'    => ['label'=>'Read',    'class'=>'badge-info text-white'],
                  'replied' => ['label'=>'Replied', 'class'=>'badge-success'],
                  'closed'  => ['label'=>'Closed',  'class'=>'badge-secondary'],
                ];
                $sc = $status_cfg[$enq['status']] ?? ['label'=>ucfirst($enq['status']), 'class'=>'badge-secondary'];
              ?>
              <tr>
                <td class="text-center text-muted small font-weight-bold"><?php echo $enq['id']; ?></td>
                <td>
                  <strong class="d-block text-dark" style="font-size:14px;"><?php echo htmlspecialchars($enq['name']); ?></strong>
                  <a href="mailto:<?php echo htmlspecialchars($enq['email']); ?>" class="text-primary d-block small">
                    <i class="fa-solid fa-envelope mr-1"></i><?php echo htmlspecialchars($enq['email']); ?>
                  </a>
                  <a href="tel:<?php echo htmlspecialchars($enq['phone']); ?>" class="text-success d-block small">
                    <i class="fa-solid fa-phone mr-1"></i><?php echo htmlspecialchars($enq['phone']); ?>
                  </a>
                </td>
                <td>
                  <span class="badge badge-light border" style="font-size:11px;">
                    <?php
                    $interest_labels = [
                      'villas'      => '🏡 Villa Plots',
                      'industrial'  => '🏭 Industrial',
                      'commercial'  => '🏢 Commercial',
                      'consultancy' => '💼 Consultancy',
                      'general'     => '💬 General',
                    ];
                    echo $interest_labels[$enq['interest']] ?? htmlspecialchars($enq['interest']);
                    ?>
                  </span>
                </td>
                <td>
                  <span class="text-muted small" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <?php echo htmlspecialchars($enq['message']); ?>
                  </span>
                </td>
                <td>
                  <span class="badge <?php echo $sc['class']; ?> px-2 py-1"><?php echo $sc['label']; ?></span>
                </td>
                <td class="text-muted small">
                  <?php echo date('d M Y', strtotime($enq['created_at'])); ?>
                  <span class="d-block" style="font-size:10px;"><?php echo date('h:i A', strtotime($enq['created_at'])); ?></span>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="view.php?id=<?php echo $enq['id']; ?>" class="btn btn-outline-primary btn-sm" title="View Details">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm" title="Delete"
                            onclick="confirmDeleteEnq(<?php echo $enq['id']; ?>, '<?php echo htmlspecialchars(addslashes($enq['name'])); ?>')">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if ($total_pages > 1): ?>
      <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">
          Showing <?php echo min($offset + 1, $total); ?>–<?php echo min($offset + $per_page, $total); ?>
          of <?php echo $total; ?> enquiries
        </small>
        <ul class="pagination pagination-sm mb-0">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
              <a class="page-link"
                 href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                <?php echo $i; ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteEnqForm" action="delete.php" method="POST" style="display:none;">
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
  <input type="hidden" name="id" id="deleteEnqId">
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
