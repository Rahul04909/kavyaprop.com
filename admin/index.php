<?php
/**
 * Dholera Admin Dashboard – Live Stats Overview
 */
require_once __DIR__ . '/../includes/db.php';
enforceAdminAuth();

// ── Live Stats ────────────────────────────────────────────────────────
// Projects count
try { $total_projects = (int)$pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn(); }
catch (Exception $e) { $total_projects = 0; }

// Enquiries stats
try {
    $enq_rows       = $pdo->query("SELECT status, COUNT(*) as cnt FROM enquiries GROUP BY status")->fetchAll();
    $enq_stats      = ['new'=>0,'read'=>0,'replied'=>0,'closed'=>0];
    foreach ($enq_rows as $r) { $enq_stats[$r['status']] = $r['cnt']; }
    $total_enquiries = array_sum($enq_stats);
} catch (Exception $e) {
    $enq_stats       = ['new'=>0,'read'=>0,'replied'=>0,'closed'=>0];
    $total_enquiries = 0;
}

// Recent enquiries (last 5)
try {
    $recent_enq = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();
} catch (Exception $e) { $recent_enq = []; }

include './header.php';
?>

<!-- ── TOP STATS ROW ── -->
<div class="row mb-4">

  <!-- Total Projects -->
  <div class="col-lg-3 col-6 mb-3">
    <div class="small-box" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;border-radius:12px;">
      <div class="inner">
        <h3 style="color:#ef7d00;"><?php echo $total_projects; ?></h3>
        <p>Total Projects</p>
      </div>
      <div class="icon"><i class="fas fa-building" style="color:rgba(255,255,255,0.1);"></i></div>
      <a href="manage-projects.php" class="small-box-footer" style="background:rgba(255,255,255,0.08);color:#94a3b8;">
        Manage Projects <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <!-- Total Enquiries -->
  <div class="col-lg-3 col-6 mb-3">
    <div class="small-box" style="background:linear-gradient(135deg,#064e3b,#065f46);color:#fff;border-radius:12px;">
      <div class="inner">
        <h3 style="color:#6ee7b7;"><?php echo $total_enquiries; ?></h3>
        <p>Total Enquiries</p>
      </div>
      <div class="icon"><i class="fas fa-inbox" style="color:rgba(255,255,255,0.1);"></i></div>
      <a href="enquiries/index.php" class="small-box-footer" style="background:rgba(255,255,255,0.08);color:#a7f3d0;">
        View All <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <!-- New Enquiries -->
  <div class="col-lg-3 col-6 mb-3">
    <div class="small-box" style="background:linear-gradient(135deg,#78350f,#92400e);color:#fff;border-radius:12px;">
      <div class="inner">
        <h3 style="color:#fcd34d;"><?php echo $enq_stats['new']; ?></h3>
        <p>Unread Enquiries</p>
      </div>
      <div class="icon"><i class="fas fa-star" style="color:rgba(255,255,255,0.1);"></i></div>
      <a href="enquiries/index.php?status=new" class="small-box-footer" style="background:rgba(255,255,255,0.08);color:#fde68a;">
        View New <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <!-- Replied Enquiries -->
  <div class="col-lg-3 col-6 mb-3">
    <div class="small-box" style="background:linear-gradient(135deg,#1e3a5f,#1d4ed8);color:#fff;border-radius:12px;">
      <div class="inner">
        <h3 style="color:#93c5fd;"><?php echo $enq_stats['replied']; ?></h3>
        <p>Replied Enquiries</p>
      </div>
      <div class="icon"><i class="fas fa-reply-all" style="color:rgba(255,255,255,0.1);"></i></div>
      <a href="enquiries/index.php?status=replied" class="small-box-footer" style="background:rgba(255,255,255,0.08);color:#bfdbfe;">
        View Replied <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

</div>

<!-- ── STATUS BREAKDOWN + RECENT ENQUIRIES ── -->
<div class="row">

  <!-- Enquiry Status Breakdown -->
  <div class="col-lg-4 col-12 mb-4">
    <div class="card shadow-sm h-100">
      <div class="card-header" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;">
        <h5 class="card-title mb-0 font-weight-bold">
          <i class="fa-solid fa-chart-pie mr-2" style="color:#ef7d00;"></i> Enquiry Status Breakdown
        </h5>
      </div>
      <div class="card-body">
        <?php
        $breakdown = [
          'new'     => ['label'=>'New / Unread',  'color'=>'#ef7d00', 'icon'=>'fa-star'],
          'read'    => ['label'=>'Read',           'color'=>'#0ea5e9', 'icon'=>'fa-envelope-open'],
          'replied' => ['label'=>'Replied',        'color'=>'#16a34a', 'icon'=>'fa-reply'],
          'closed'  => ['label'=>'Closed',         'color'=>'#94a3b8', 'icon'=>'fa-lock'],
        ];
        foreach ($breakdown as $key => $cfg):
          $pct = $total_enquiries > 0 ? round($enq_stats[$key] / $total_enquiries * 100) : 0;
        ?>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:13px;font-weight:600;color:#334155;">
              <i class="fa-solid <?php echo $cfg['icon']; ?> mr-1" style="color:<?php echo $cfg['color']; ?>;"></i>
              <?php echo $cfg['label']; ?>
            </span>
            <span style="font-size:13px;font-weight:700;color:<?php echo $cfg['color']; ?>;">
              <?php echo $enq_stats[$key]; ?>
            </span>
          </div>
          <div class="progress" style="height:7px;border-radius:4px;background:#f1f5f9;">
            <div class="progress-bar" role="progressbar"
                 style="width:<?php echo $pct; ?>%;background:<?php echo $cfg['color']; ?>;border-radius:4px;"
                 aria-valuenow="<?php echo $pct; ?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <?php endforeach; ?>
        <div class="mt-3 pt-3" style="border-top:1px solid #e2e8f0;">
          <a href="enquiries/index.php" class="btn btn-sm btn-success w-100 font-weight-bold">
            <i class="fa-solid fa-inbox mr-1"></i> Open Enquiries Panel
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Enquiries Table -->
  <div class="col-lg-8 col-12 mb-4">
    <div class="card shadow-sm h-100">
      <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;">
        <h5 class="card-title mb-0 font-weight-bold">
          <i class="fa-solid fa-clock-rotate-left mr-2" style="color:#ef7d00;"></i> Recent Enquiries
        </h5>
        <a href="enquiries/index.php" class="btn btn-warning btn-sm font-weight-bold">View All</a>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Interest</th>
              <th>Status</th>
              <th>Date</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_enq)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                  No enquiries yet. They'll appear here once visitors submit the contact form.
                </td>
              </tr>
            <?php else: ?>
              <?php
              $status_map = [
                'new'     => ['label'=>'New',     'class'=>'badge-warning text-dark'],
                'read'    => ['label'=>'Read',    'class'=>'badge-info text-white'],
                'replied' => ['label'=>'Replied', 'class'=>'badge-success'],
                'closed'  => ['label'=>'Closed',  'class'=>'badge-secondary'],
              ];
              $interest_labels = [
                'villas'      => '🏡 Villas',
                'industrial'  => '🏭 Industrial',
                'commercial'  => '🏢 Commercial',
                'consultancy' => '💼 Consultancy',
                'general'     => '💬 General',
              ];
              foreach ($recent_enq as $enq):
                $sc = $status_map[$enq['status']] ?? ['label'=>ucfirst($enq['status']),'class'=>'badge-secondary'];
              ?>
              <tr>
                <td>
                  <strong class="d-block" style="font-size:13.5px;"><?php echo htmlspecialchars($enq['name']); ?></strong>
                  <small class="text-muted"><?php echo htmlspecialchars($enq['email']); ?></small>
                </td>
                <td>
                  <span style="font-size:12px;"><?php echo $interest_labels[$enq['interest']] ?? htmlspecialchars($enq['interest']); ?></span>
                </td>
                <td>
                  <span class="badge <?php echo $sc['class']; ?> px-2 py-1"><?php echo $sc['label']; ?></span>
                </td>
                <td class="text-muted small"><?php echo date('d M Y', strtotime($enq['created_at'])); ?></td>
                <td class="text-center">
                  <a href="enquiries/view.php?id=<?php echo $enq['id']; ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-eye"></i>
                  </a>
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

<?php include './footer.php'; ?>