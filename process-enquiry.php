<?php
/**
 * Dholera Smart City – Enquiry Form Backend Processor
 * Handles POST from components/contact.php
 * Stores data in `enquiries` table with full validation & CSRF protection.
 */
require_once __DIR__ . '/includes/db.php';

// ── Only accept POST ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// ── CSRF Validation ───────────────────────────────────────────────────
$submitted_token = $_POST['csrf_token'] ?? '';
if (!validateCSRFToken($submitted_token)) {
    $_SESSION['enq_error'] = 'Security token mismatch. Please refresh and try again.';
    header('Location: contact.php');
    exit;
}

// ── Collect & Sanitize Inputs ─────────────────────────────────────────
$name     = sanitizeInput($_POST['name']     ?? '');
$email    = sanitizeInput($_POST['email']    ?? '');
$phone    = sanitizeInput($_POST['phone']    ?? '');
$interest = sanitizeInput($_POST['interest'] ?? 'general');
$message  = sanitizeInput($_POST['message']  ?? '');

// ── Server-Side Validation ────────────────────────────────────────────
$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please enter your full name (min 2 characters).';
}
if (empty($email) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (empty($phone) || !preg_match('/^[+\d\s\-()]{7,20}$/', $_POST['phone'])) {
    $errors[] = 'Please enter a valid phone number.';
}
if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Please enter a message (min 10 characters).';
}

$allowed_interests = ['villas', 'industrial', 'commercial', 'consultancy', 'general'];
if (!in_array($interest, $allowed_interests)) {
    $interest = 'general';
}

if (!empty($errors)) {
    $_SESSION['enq_error']  = implode(' ', $errors);
    $_SESSION['enq_old']    = ['name' => $name, 'email' => $email, 'phone' => $phone, 'interest' => $interest, 'message' => $message];
    $project_id_err = (int)($_POST['project_id'] ?? 0);
    if ($project_id_err > 0) {
        header('Location: project-details.php?id=' . $project_id_err);
    } else {
        header('Location: contact.php');
    }
    exit;
}

// ── Capture IP ────────────────────────────────────────────────────────
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? null;
$ip = $ip ? substr($ip, 0, 45) : null;

// ── Insert into DB ────────────────────────────────────────────────────
try {
    $stmt = $pdo->prepare("
        INSERT INTO enquiries (name, email, phone, interest, message, ip_address)
        VALUES (:name, :email, :phone, :interest, :message, :ip)
    ");
    $stmt->execute([
        ':name'     => $name,
        ':email'    => $email,
        ':phone'    => $phone,
        ':interest' => $interest,
        ':message'  => $message,
        ':ip'       => $ip,
    ]);

    // ── Regenerate CSRF after successful submit ────────────────────────
    unset($_SESSION['csrf_token']);
    generateCSRFToken();

    $_SESSION['enq_success'] = 'Thank you, ' . htmlspecialchars($name) . '! Your enquiry has been received. Our team will contact you within 24 hours.';

    // Redirect back to the originating page
    $project_id = (int)($_POST['project_id'] ?? 0);
    if ($project_id > 0) {
        header('Location: project-details.php?id=' . $project_id);
    } else {
        header('Location: contact.php');
    }
    exit;

} catch (PDOException $e) {
    $_SESSION['enq_error'] = 'We could not process your request right now. Please try again shortly.';
    header('Location: contact.php');
    exit;
}
