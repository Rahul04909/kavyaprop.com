<?php
/**
 * Admin Enquiries – Secure Delete Handler
 * d:\wamp\www\dholera-new\admin\enquiries\delete.php
 */
require_once __DIR__ . '/../../includes/db.php';
enforceAdminAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// CSRF check
if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
    $_SESSION['enq_admin_error'] = 'Security token mismatch. Action rejected.';
    header('Location: index.php');
    exit;
}

$id       = (int)($_POST['id'] ?? 0);
$redirect = in_array($_POST['redirect'] ?? '', ['index.php']) ? 'index.php' : 'index.php';

if ($id < 1) {
    $_SESSION['enq_admin_error'] = 'Invalid enquiry ID.';
    header("Location: $redirect");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['enq_admin_success'] = "Enquiry #$id has been permanently deleted.";
    } else {
        $_SESSION['enq_admin_error'] = "Enquiry #$id was not found.";
    }
} catch (PDOException $e) {
    $_SESSION['enq_admin_error'] = 'Database error: could not delete enquiry.';
}

header("Location: $redirect");
exit;
