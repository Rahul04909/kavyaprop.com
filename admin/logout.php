<?php
/**
 * Secure Admin Logout Endpoint
 * Developed by Expert Security & UI/UX Developer
 */

// 1. Include DB Commons & Session Start
require_once __DIR__ . '/../includes/db.php';

// 2. Clear all active Session variables
$_SESSION = [];

// 3. Clear session cookie parameters completely
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Terminate active session process
session_destroy();

// 5. Redirect securely back to Login Portal Gate
header("Location: login.php");
exit;
