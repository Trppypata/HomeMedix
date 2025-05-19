-- SQL Script to create the practitioner_notifications table
-- Run this script to add notification functionality for practitioners

CREATE TABLE IF NOT EXISTS `practitioner_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `practitioner_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `practitioner_id` (`practitioner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add foreign key if practitioners table exists and you want referential integrity
-- ALTER TABLE `practitioner_notifications` 
-- ADD CONSTRAINT `practitioner_notifications_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `practitioners` (`user_id`) ON DELETE CASCADE; 