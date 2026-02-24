-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 08:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health_safety_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `changes_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes_json`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `table_name`, `record_id`, `changes_json`, `ip_address`, `user_agent`, `timestamp`) VALUES
(1, 1, 'Manual Certificate Issuance', 'certificates', 4, '{\"certificate_number\":\"123123123\",\"type\":\"Sanitary Clearance\",\"action\":\"Manual Issue\"}', NULL, NULL, '2026-02-04 19:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `inspection_id` int(11) DEFAULT NULL,
  `certificate_number` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `status` enum('Valid','Expired','Revoked') DEFAULT 'Valid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `establishment_id`, `inspection_id`, `certificate_number`, `type`, `issue_date`, `expiry_date`, `status`, `created_at`) VALUES
(2, 12, NULL, 'CERT-2026-2140', 'Health Certificate', '2026-02-04', '2027-02-04', 'Valid', '2026-02-04 19:00:32'),
(4, 3, NULL, '123123123', 'Sanitary Clearance', '2026-02-28', '2027-02-26', 'Valid', '2026-02-04 19:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_templates`
--

CREATE TABLE `checklist_templates` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `items_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items_json`)),
  `passing_score` int(11) DEFAULT 70,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checklist_templates`
--

INSERT INTO `checklist_templates` (`id`, `category`, `items_json`, `passing_score`, `created_at`, `updated_at`) VALUES
(1, 'Food Safety', '[{\"id\":\"food_01\",\"text\":\"Proper food storage temperature\",\"weight\":10},{\"id\":\"food_02\",\"text\":\"Cleanliness of food preparation area\",\"weight\":10},{\"id\":\"food_03\",\"text\":\"Valid health certificates for staff\",\"weight\":5},{\"id\":\"food_04\",\"text\":\"Pest control measures in place\",\"weight\":10}]', 80, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(2, 'Fire Safety', '[{\"id\":\"fire_01\",\"text\":\"Working fire extinguishers available\",\"weight\":10},{\"id\":\"fire_02\",\"text\":\"Clear emergency exits\",\"weight\":10},{\"id\":\"fire_03\",\"text\":\"Functional fire alarm system\",\"weight\":10},{\"id\":\"fire_04\",\"text\":\"Smoke detectors installed and tested\",\"weight\":5}]', 90, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(3, 'Building Safety', '[{\"id\":\"bld_01\",\"text\":\"Structural integrity inspection\",\"weight\":20},{\"id\":\"bld_02\",\"text\":\"Electrical wiring safety\",\"weight\":10},{\"id\":\"bld_03\",\"text\":\"Plumbing and sanitation functional\",\"weight\":5}]', 75, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(4, 'Sanitation & Health', '[{\"id\":\"san_01\",\"text\":\"Proper waste disposal system\",\"weight\":10},{\"id\":\"san_02\",\"text\":\"Clean restroom facilities\",\"weight\":5},{\"id\":\"san_03\",\"text\":\"Water supply safety\",\"weight\":10}]', 70, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(5, 'Food Safety', '[{\"id\":\"food_01\",\"text\":\"Proper food storage temperature\",\"weight\":10},{\"id\":\"food_02\",\"text\":\"Cleanliness of food preparation area\",\"weight\":10},{\"id\":\"food_03\",\"text\":\"Valid health certificates for staff\",\"weight\":5},{\"id\":\"food_04\",\"text\":\"Pest control measures in place\",\"weight\":10}]', 80, '2026-02-04 18:41:19', '2026-02-04 18:41:19'),
(6, 'Fire Safety', '[{\"id\":\"fire_01\",\"text\":\"Working fire extinguishers available\",\"weight\":10},{\"id\":\"fire_02\",\"text\":\"Clear emergency exits\",\"weight\":10},{\"id\":\"fire_03\",\"text\":\"Functional fire alarm system\",\"weight\":10},{\"id\":\"fire_04\",\"text\":\"Smoke detectors installed and tested\",\"weight\":5}]', 90, '2026-02-04 18:41:19', '2026-02-04 18:41:19'),
(7, 'Building Safety', '[{\"id\":\"bld_01\",\"text\":\"Structural integrity inspection\",\"weight\":20},{\"id\":\"bld_02\",\"text\":\"Electrical wiring safety\",\"weight\":10},{\"id\":\"bld_03\",\"text\":\"Plumbing and sanitation functional\",\"weight\":5}]', 75, '2026-02-04 18:41:19', '2026-02-04 18:41:19'),
(8, 'Sanitation & Health', '[{\"id\":\"san_01\",\"text\":\"Proper waste disposal system\",\"weight\":10},{\"id\":\"san_02\",\"text\":\"Clean restroom facilities\",\"weight\":5},{\"id\":\"san_03\",\"text\":\"Water supply safety\",\"weight\":10}]', 70, '2026-02-04 18:41:19', '2026-02-04 18:41:19'),
(9, 'Food Safety', '[{\"id\":\"food_01\",\"text\":\"Proper food storage temperature\",\"weight\":10},{\"id\":\"food_02\",\"text\":\"Cleanliness of food preparation area\",\"weight\":10},{\"id\":\"food_03\",\"text\":\"Valid health certificates for staff\",\"weight\":5},{\"id\":\"food_04\",\"text\":\"Pest control measures in place\",\"weight\":10}]', 80, '2026-02-04 18:41:29', '2026-02-04 18:41:29'),
(10, 'Fire Safety', '[{\"id\":\"fire_01\",\"text\":\"Working fire extinguishers available\",\"weight\":10},{\"id\":\"fire_02\",\"text\":\"Clear emergency exits\",\"weight\":10},{\"id\":\"fire_03\",\"text\":\"Functional fire alarm system\",\"weight\":10},{\"id\":\"fire_04\",\"text\":\"Smoke detectors installed and tested\",\"weight\":5}]', 90, '2026-02-04 18:41:29', '2026-02-04 18:41:29'),
(11, 'Building Safety', '[{\"id\":\"bld_01\",\"text\":\"Structural integrity inspection\",\"weight\":20},{\"id\":\"bld_02\",\"text\":\"Electrical wiring safety\",\"weight\":10},{\"id\":\"bld_03\",\"text\":\"Plumbing and sanitation functional\",\"weight\":5}]', 75, '2026-02-04 18:41:29', '2026-02-04 18:41:29'),
(12, 'Sanitation & Health', '[{\"id\":\"san_01\",\"text\":\"Proper waste disposal system\",\"weight\":10},{\"id\":\"san_02\",\"text\":\"Clean restroom facilities\",\"weight\":5},{\"id\":\"san_03\",\"text\":\"Water supply safety\",\"weight\":10}]', 70, '2026-02-04 18:41:29', '2026-02-04 18:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `citations`
--

CREATE TABLE `citations` (
  `id` int(11) NOT NULL,
  `violation_id` int(11) NOT NULL,
  `citation_hash` varchar(64) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `issued_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishments`
--

CREATE TABLE `establishments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `gps_coordinates` point NOT NULL,
  `status` enum('Active','Suspended','Reinstated') DEFAULT 'Active',
  `contact_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contact_json`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `establishments`
--

INSERT INTO `establishments` (`id`, `name`, `type`, `location`, `gps_coordinates`, `status`, `contact_json`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'City Grand Hotel', 'Accommodation', '123 Main St, Central District', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"0917-123-4567\",\"email\":\"info@citygrand.com\"}', '2026-02-04 17:38:21', '2026-02-04 17:54:15', '2026-02-04 17:54:15'),
(2, 'The Daily Grind Coffee', 'Restaurant/Cafe', '45 South Ave, Business Park', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"0918-765-4321\",\"email\":\"hello@dailygrind.ph\"}', '2026-02-04 17:38:21', '2026-02-04 17:38:21', NULL),
(3, 'Evergreen Shopping Mall', 'Commercial', '88 North Blvd, Green Valley', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"02-888-9999\",\"email\":\"admin@evergreen.com\"}', '2026-02-04 17:38:21', '2026-02-04 17:38:21', NULL),
(4, 'Industrial Storage Solutions', 'Warehouse', 'Industrial Zone, Tower 3', 0x0000000001010000000000000000405e400000000000002c40, 'Suspended', '{\"phone\":\"0999-111-2222\",\"email\":\"contact@iss.com\"}', '2026-02-04 17:38:21', '2026-02-04 17:38:21', NULL),
(5, 'asdasd', 'Accommodation', 'asdasd', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"asd\",\"email\":\"asdasd@gmail.com\",\"owner\":\"asdasd\"}', '2026-02-04 17:41:16', '2026-02-04 17:41:16', NULL),
(6, 'asdasd', 'Industrial', '123123', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"asd\",\"email\":\"adasd223@gmail.com\",\"owner\":\"asd123\"}', '2026-02-04 17:51:29', '2026-02-04 17:51:29', NULL),
(7, 'asdasd', 'Accommodation', '213123', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"asdasd\",\"email\":\"asdasd@gmail.com\",\"owner\":\"asdasd\"}', '2026-02-04 18:06:39', '2026-02-04 18:06:39', NULL),
(8, 'City Grand Hotel', 'Accommodation', '123 Main St, Central District', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"0917-123-4567\",\"email\":\"info@citygrand.com\"}', '2026-02-04 18:41:19', '2026-02-04 18:41:19', NULL),
(9, 'The Daily Grind Coffee', 'Restaurant/Cafe', '45 South Ave, Business Park', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"0918-765-4321\",\"email\":\"hello@dailygrind.ph\"}', '2026-02-04 18:41:19', '2026-02-04 18:41:19', NULL),
(10, 'Evergreen Shopping Mall', 'Commercial', '88 North Blvd, Green Valley', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"02-888-9999\",\"email\":\"admin@evergreen.com\"}', '2026-02-04 18:41:19', '2026-02-04 18:41:19', NULL),
(11, 'Industrial Storage Solutions', 'Warehouse', 'Industrial Zone, Tower 3', 0x0000000001010000000000000000405e400000000000002c40, 'Suspended', '{\"phone\":\"0999-111-2222\",\"email\":\"contact@iss.com\"}', '2026-02-04 18:41:19', '2026-02-04 18:41:19', NULL),
(12, 'City Grand Hotel', 'Accommodation', '123 Main St, Central District', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"0917-123-4567\",\"email\":\"info@citygrand.com\"}', '2026-02-04 18:41:29', '2026-02-04 18:41:29', NULL),
(13, 'The Daily Grind Coffee', 'Restaurant/Cafe', '45 South Ave, Business Park', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"0918-765-4321\",\"email\":\"hello@dailygrind.ph\"}', '2026-02-04 18:41:29', '2026-02-04 18:41:29', NULL),
(14, 'Evergreen Shopping Mall', 'Commercial', '88 North Blvd, Green Valley', 0x0000000001010000000000000000405e400000000000002c40, 'Active', '{\"phone\":\"02-888-9999\",\"email\":\"admin@evergreen.com\"}', '2026-02-04 18:41:29', '2026-02-04 18:41:29', NULL),
(15, 'Industrial Storage Solutions', 'Warehouse', 'Industrial Zone, Tower 3', 0x0000000001010000000000000000405e400000000000002c40, 'Suspended', '{\"phone\":\"0999-111-2222\",\"email\":\"contact@iss.com\"}', '2026-02-04 18:41:29', '2026-02-04 18:41:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inspections`
--

CREATE TABLE `inspections` (
  `id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `inspector_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `scheduled_date` date NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `status` enum('Scheduled','In Progress','Completed','Cancelled') DEFAULT 'Scheduled',
  `priority` enum('Low','Medium','High','Urgent') DEFAULT 'Medium',
  `score` decimal(5,2) DEFAULT 0.00,
  `rating` enum('Excellent','Good','Fair','Poor','Failing') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inspections`
--

INSERT INTO `inspections` (`id`, `establishment_id`, `inspector_id`, `template_id`, `scheduled_date`, `completed_at`, `status`, `priority`, `score`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2026-02-05', NULL, 'Scheduled', 'Urgent', 0.00, NULL, '2026-02-04 17:50:32', '2026-02-04 17:50:32'),
(2, 1, 2, 3, '2026-02-05', '2026-02-04 18:07:18', 'Completed', 'Low', 66.67, '', '2026-02-04 17:54:05', '2026-02-04 18:07:18'),
(3, 6, 2, 2, '2026-02-05', NULL, 'Scheduled', 'Urgent', 0.00, NULL, '2026-02-04 18:07:13', '2026-02-04 18:07:13'),
(4, 1, 2, 1, '2026-02-02', NULL, 'Completed', 'Medium', 92.50, 'Excellent', '2026-02-04 18:41:19', '2026-02-04 18:41:19'),
(5, 2, 2, 2, '2026-02-04', NULL, 'Scheduled', 'Medium', 0.00, NULL, '2026-02-04 18:41:19', '2026-02-04 18:41:19'),
(6, 1, 2, 1, '2026-02-02', NULL, 'Completed', 'Medium', 92.50, 'Excellent', '2026-02-04 18:41:29', '2026-02-04 18:41:29'),
(7, 2, 2, 2, '2026-02-04', NULL, 'Scheduled', 'Medium', 0.00, NULL, '2026-02-04 18:41:29', '2026-02-04 18:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_items`
--

CREATE TABLE `inspection_items` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `checklist_item_id` varchar(50) NOT NULL,
  `status` enum('Pass','Fail','N/A') DEFAULT 'N/A',
  `notes` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `gps_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inspection_items`
--

INSERT INTO `inspection_items` (`id`, `inspection_id`, `checklist_item_id`, `status`, `notes`, `photo_path`, `gps_timestamp`) VALUES
(1, 2, 'bld_01', 'Pass', NULL, NULL, NULL),
(2, 2, 'bld_02', 'Pass', NULL, NULL, NULL),
(3, 2, 'bld_03', 'Fail', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `created_at`) VALUES
(1, '01_CreateRolesTable.php', '2026-02-04 17:38:21'),
(2, '02_CreateUsersTable.php', '2026-02-04 17:38:21'),
(3, '03_CreateEstablishmentsTable.php', '2026-02-04 17:38:21'),
(4, '04_CreateChecklistTemplatesTable.php', '2026-02-04 17:38:21'),
(5, '05_CreateInspectionsTable.php', '2026-02-04 17:38:21'),
(6, '06_CreateInspectionItemsTable.php', '2026-02-04 17:38:21'),
(7, '07_CreateViolationsTable.php', '2026-02-04 17:38:21'),
(8, '08_CreateCitationsTable.php', '2026-02-04 17:38:21'),
(9, '09_CreateCertificatesTable.php', '2026-02-04 17:38:21'),
(10, '10_CreateAuditLogsTable.php', '2026-02-04 17:38:21'),
(11, '11_AddDueDateToViolationsTable.php', '2026-02-04 18:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions_json`)),
  `hierarchy_level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions_json`, `hierarchy_level`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '{\"all\":true}', 10, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(2, 'Inspector', '{\"inspect\":true,\"view_establishments\":true}', 5, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(3, 'Clerk', '{\"view_reports\":true,\"manage_establishments\":true}', 3, '2026-02-04 17:38:21', '2026-02-04 17:38:21'),
(4, 'Owner', '{\"view_own_compliance\":true}', 1, '2026-02-04 17:38:21', '2026-02-04 17:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
('lgu_name', 'MUNICIPALITY OF SAMPLE', '2026-02-05 02:03:54'),
('office_name', 'HEALTH AND SAFETY OFFICE', '2026-02-05 02:03:54'),
('penalty_amount', '2500.00', '2026-02-05 02:03:54'),
('permit_validity_years', '1', '2026-02-05 02:03:54'),
('system_title', 'H&S COMPLIANCE SYSTEM', '2026-02-05 02:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `role_id`, `full_name`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@lgu.gov.ph', '$2y$10$MhctLQkW7HFJc.w.njr0Iust16Uq8dYrf4QXUrr.OFpAAoWfyOc06', 1, 'System Administrator', '2026-02-04 17:38:21', '2026-02-04 17:38:21', '2026-02-04 17:38:21', NULL),
(2, '213asda@gmail.com', '$2y$10$5blQqze.p8hkJK.LVHV.EemeKb8seZr74Q8CNMFr6bfgQ7kycAKjG', 2, '213123', NULL, '2026-02-04 17:50:19', '2026-02-04 17:50:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `fine_amount` decimal(10,2) DEFAULT 0.00,
  `due_date` date DEFAULT NULL,
  `status` enum('Pending','Paid','Resolved','In Progress') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`id`, `inspection_id`, `description`, `fine_amount`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Inspection result: Needs Improvement (66.7%). Failure to meet minimum health and safety standards.', 5000.00, NULL, 'Resolved', '2026-02-04 18:07:18', '2026-02-04 18:35:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `table_name` (`table_name`),
  ADD KEY `record_id` (`record_id`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `establishment_id` (`establishment_id`),
  ADD KEY `inspection_id` (`inspection_id`),
  ADD KEY `expiry_date` (`expiry_date`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `checklist_templates`
--
ALTER TABLE `checklist_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `citations`
--
ALTER TABLE `citations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `citation_hash` (`citation_hash`),
  ADD KEY `violation_id` (`violation_id`),
  ADD KEY `citation_hash_2` (`citation_hash`);

--
-- Indexes for table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `status` (`status`),
  ADD KEY `type` (`type`),
  ADD SPATIAL KEY `gps_coordinates` (`gps_coordinates`);

--
-- Indexes for table `inspections`
--
ALTER TABLE `inspections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`),
  ADD KEY `establishment_id` (`establishment_id`),
  ADD KEY `inspector_id` (`inspector_id`),
  ADD KEY `scheduled_date` (`scheduled_date`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `inspection_items`
--
ALTER TABLE `inspection_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inspection_id` (`inspection_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inspection_id` (`inspection_id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checklist_templates`
--
ALTER TABLE `checklist_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `citations`
--
ALTER TABLE `citations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inspections`
--
ALTER TABLE `inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inspection_items`
--
ALTER TABLE `inspection_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`);

--
-- Constraints for table `citations`
--
ALTER TABLE `citations`
  ADD CONSTRAINT `citations_ibfk_1` FOREIGN KEY (`violation_id`) REFERENCES `violations` (`id`);

--
-- Constraints for table `inspections`
--
ALTER TABLE `inspections`
  ADD CONSTRAINT `inspections_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`),
  ADD CONSTRAINT `inspections_ibfk_2` FOREIGN KEY (`inspector_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inspections_ibfk_3` FOREIGN KEY (`template_id`) REFERENCES `checklist_templates` (`id`);

--
-- Constraints for table `inspection_items`
--
ALTER TABLE `inspection_items`
  ADD CONSTRAINT `inspection_items_ibfk_1` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `violations_ibfk_1` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
