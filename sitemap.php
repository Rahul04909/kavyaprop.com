<?php
/**
 * Kavya Prop - Sitemap Router Page
 * Developed by Expert Developer
 */

// 1. Include Secure Database Connection
require_once __DIR__ . '/includes/db.php';

// 2. Include Sitemap Compiler Engine
require_once __DIR__ . '/includes/sitemap-generator.php';

// 3. Rebuild sitemaps (both xml and html static files)
generateSitemaps($pdo);

// 4. Redirect to the compiled visual sitemap
header("Location: sitemap.html", true, 302);
exit;
