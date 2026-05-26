-- Dholera Smart City Database Setup Script
-- Developed by Expert Database Administrator & Security Engineer

-- 1. Create Admins Table Schema
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `mobile` VARCHAR(15) NOT NULL,
  `profile_image` VARCHAR(255) DEFAULT 'default-avatar.png',
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Seed Default Administrator Record
-- Default Credentials:
-- Email: admin@dholera.com
-- Password: admin123 (BCRYPT encrypted: $2y$12$d4nmvv8V3q4dckEpK8Bj7uNwXRLbe6tCiKtCYqkM7xoKF1biyonYa)
INSERT INTO `admins` (`name`, `email`, `mobile`, `profile_image`, `password`) 
VALUES (
  'Dholera Admin', 
  'admin@dholera.com', 
  '+919220551771', 
  'default-avatar.png', 
  '$2y$12$d4nmvv8V3q4dckEpK8Bj7uNwXRLbe6tCiKtCYqkM7xoKF1biyonYa'
)
ON DUPLICATE KEY UPDATE `email` = `email`;
