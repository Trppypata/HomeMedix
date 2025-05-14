-- Table structure for services
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `details` text,
  `duration` varchar(128),
  `price_range` varchar(128),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for illnesses
CREATE TABLE `illnesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `symptoms` text,
  `treatment` text,
  `prevention` text,
  `related_services` text,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert comprehensive services data
INSERT INTO `services` (`name`, `description`, `details`, `duration`, `price_range`) VALUES
('Physical Therapy', 'Expert physical therapists provide personalized care for mobility and recovery.', 
'Our physical therapy services include: 
- Post-surgery rehabilitation
- Sports injury recovery
- Chronic pain management
- Balance and coordination training
- Strength and flexibility exercises', 
'45-60 minutes per session', 
'PHP 1,500 - 2,500 per session'),

('Caregiving Services', 'Professional caregivers offering 8/12/24-hour shifts for in-home care.', 
'Our caregiving services include:
- Personal care assistance
- Medication reminders
- Meal preparation
- Light housekeeping
- Companionship
- Mobility assistance', 
'8/12/24-hour shifts available', 
'PHP 15,000 - 45,000 per month'),

('Nursing Home', '24/7 professional nursing care in a comfortable facility.', 
'Our nursing home services include:
- 24/7 medical supervision
- Regular health monitoring
- Medication management
- Physical therapy
- Recreational activities
- Nutritious meals', 
'Long-term stay', 
'PHP 30,000 - 50,000 per month');

-- Insert comprehensive illnesses data
INSERT INTO `illnesses` (`name`, `description`, `symptoms`, `treatment`, `prevention`, `related_services`) VALUES
('Back Pain', 'Common condition affecting the lower back, often caused by poor posture or injury.', 
'Common symptoms include:
- Dull aching pain
- Sharp, shooting pain
- Muscle stiffness
- Limited range of motion', 
'Treatment options:
- Physical therapy exercises
- Posture correction
- Pain management techniques
- Core strengthening', 
'Prevention tips:
- Maintain good posture
- Regular exercise
- Proper lifting techniques
- Ergonomic workspace setup', 
'Physical Therapy, Caregiving Services'),

('Stroke Recovery', 'Rehabilitation after stroke to regain mobility and function.', 
'Common symptoms:
- Weakness or paralysis
- Speech difficulties
- Balance problems
- Memory issues', 
'Treatment includes:
- Physical therapy
- Occupational therapy
- Speech therapy
- Cognitive rehabilitation', 
'Prevention:
- Regular health check-ups
- Blood pressure control
- Healthy lifestyle
- Regular exercise', 
'Physical Therapy, Nursing Home'),

('Arthritis', 'Joint inflammation causing pain and stiffness.', 
'Common symptoms:
- Joint pain
- Stiffness
- Swelling
- Reduced range of motion', 
'Treatment options:
- Physical therapy
- Pain management
- Joint protection techniques
- Exercise programs', 
'Prevention:
- Regular exercise
- Healthy weight maintenance
- Joint protection
- Proper nutrition', 
'Physical Therapy, Caregiving Services'); 