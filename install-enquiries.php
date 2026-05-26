<?php
/**
 * Dholera Smart City – DB Installer
 * Visit: http://localhost/dholera-new/install-enquiries.php
 * DELETE this file after running once.
 */
require_once 'includes/db.php';

$sql = "
CREATE TABLE IF NOT EXISTS `enquiries` (
  `id`          INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(150)     NOT NULL,
  `email`       VARCHAR(255)     NOT NULL,
  `phone`       VARCHAR(30)      NOT NULL,
  `interest`    VARCHAR(100)     NOT NULL DEFAULT 'general',
  `message`     TEXT             NOT NULL,
  `status`      ENUM('new','read','replied','closed') NOT NULL DEFAULT 'new',
  `ip_address`  VARCHAR(45)      DEFAULT NULL,
  `created_at`  TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status`     (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

try {
    $pdo->exec($sql);
    echo '<p style="color:green;font-family:sans-serif;font-size:18px;">✅ <strong>enquiries</strong> table created successfully! You may now delete this file.</p>';
} catch (PDOException $e) {
    echo '<p style="color:red;font-family:sans-serif;">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>
