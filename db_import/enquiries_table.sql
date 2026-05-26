-- ============================================================
--  Dholera Smart City – Enquiries Table Migration
--  Run this against your `dholera_db` database.
-- ============================================================

CREATE TABLE IF NOT EXISTS `enquiries` (
  `id`          INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(150)     NOT NULL,
  `email`       VARCHAR(255)     NOT NULL,
  `phone`       VARCHAR(30)      NOT NULL,
  `interest`    VARCHAR(100)     NOT NULL DEFAULT 'general',
  `message`     TEXT             NOT NULL,
  `status`      ENUM('new','read','replied','closed')
                                 NOT NULL DEFAULT 'new',
  `ip_address`  VARCHAR(45)      DEFAULT NULL COMMENT 'Submitter IP for spam detection',
  `created_at`  TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status`     (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Contact form enquiries from the public-facing website';
