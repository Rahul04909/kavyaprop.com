<?php
/**
 * Dholera Smart City Secure Database Connectivity & Security Commons
 * Developed by Expert Security & UI/UX Developer
 */

// 1. Load Dotenv & Autoloader dynamically relative to the current directory
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Exception $e) {
    // Fail-safe default variables if .env fails to load
}

// 2. Establish Secure PDO Connection
$db_host = $_ENV['DB_HOST'] ?? 'localhost';
$db_port = $_ENV['DB_PORT'] ?? '3306';
$db_name = $_ENV['DB_NAME'] ?? 'mineib_i1_kavya_prop';
$db_user = $_ENV['DB_USER'] ?? 'mineib_i1_mineib';
$db_pass = $_ENV['DB_PASS'] ?? 'Rd14072003@./';
$db_charset = 'utf8mb4';

$dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=$db_charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // Defeats SQL injection emulation bypasses
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // In production, log error instead of throwing to prevent database scheme leakage
    die("Database Connection Error: Secure connectivity breach detected. Please verify configuration.");
}

// 3. Start secure session with strict security options
if (session_status() === PHP_SESSION_NONE) {
    if (!headers_sent()) {
        // Prevent session hijacking via JavaScript & enforce secure transport cookies
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        
        // Check if HTTPS is active
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            ini_set('session.cookie_secure', 1);
        }
        
        session_start();
    } else {
        // Fallback session start if headers already sent (quiets warnings)
        @session_start();
    }
}

// 4. Security Helpers

/**
 * Clean & Sanitize user inputs to prevent XSS (Cross Site Scripting) attacks
 */
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a cryptographically secure CSRF Token
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate submitted CSRF Token
 */
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token); // Time-attack resistant validation
}

/**
 * Protect admin dashboard access
 */
function enforceAdminAuth() {
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header("Location: login.php");
        exit;
    }
}
