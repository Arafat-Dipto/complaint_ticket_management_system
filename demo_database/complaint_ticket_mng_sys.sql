-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 03, 2024 at 04:09 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaint_ticket_mng_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Billing', 'billing', 1, NULL, '2024-11-03 09:45:34', '2024-11-03 09:45:34'),
(2, 'Service Issue', 'service-issue', 1, NULL, '2024-11-03 09:45:47', '2024-11-03 09:45:47'),
(3, 'Product Issue', 'product-issue', 1, NULL, '2024-11-03 09:45:58', '2024-11-03 09:45:58'),
(4, 'Customer Support', 'customer-support', 1, NULL, '2024-11-03 09:46:10', '2024-11-03 09:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `complaint_id`, `admin_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'We checking your connection.', '2024-11-03 10:08:00', '2024-11-03 10:08:00'),
(2, 4, 1, 'We have resolved the issue.', '2024-11-03 10:08:17', '2024-11-03 10:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `priority` enum('Low','Medium','High') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medium',
  `status` enum('Open','In Progress','Resolved','Closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `title`, `description`, `category_id`, `priority`, `status`, `attachment`, `submitted_at`, `resolved_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'Incorrect Billing Amount', 'The billed amount is higher than expected. I was charged extra for services not rendered.', 1, 'High', 'Open', NULL, '2024-11-03 10:03:21', NULL, 2, NULL, '2024-11-03 10:03:21', '2024-11-03 10:03:21'),
(3, 2, 'Slow Internet Speed', 'The internet connection speed is much slower than what was promised in my plan.', 2, 'Medium', 'In Progress', NULL, '2024-11-03 10:05:27', NULL, 2, NULL, '2024-11-03 10:05:27', '2024-11-03 10:07:26'),
(4, 3, 'Defective Product Received', 'The product I received has multiple issues, including a malfunctioning display and poor battery life.', 3, 'High', 'Resolved', NULL, '2024-11-03 10:06:23', '2024-11-03 10:07:32', 3, NULL, '2024-11-03 10:06:23', '2024-11-03 10:07:32'),
(5, 3, 'Billing Error in Monthly Statement', 'My monthly bill shows charges for services I did not use. Please review and adjust the charges.', 1, 'Low', 'Open', NULL, '2024-11-03 10:06:51', NULL, 3, NULL, '2024-11-03 10:06:51', '2024-11-03 10:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status_histories`
--

CREATE TABLE `complaint_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaint_status_histories`
--

INSERT INTO `complaint_status_histories` (`id`, `complaint_id`, `status`, `changed_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'In Progress', '2024-11-03 10:07:26', '2024-11-03 10:07:26', '2024-11-03 10:07:26'),
(2, 4, 'Resolved', '2024-11-03 10:07:32', '2024-11-03 10:07:32', '2024-11-03 10:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_10_28_063327_create_roles_table', 1),
(6, '2024_10_28_063444_create_privileges_table', 1),
(7, '2024_10_28_063542_create_user_roles_table', 1),
(8, '2024_10_28_063629_create_role_privileges_table', 1),
(9, '2024_10_28_065129_create_categories_table', 1),
(10, '2024_10_28_065232_create_complaints_table', 1),
(11, '2024_10_28_072525_create_comments_table', 1),
(12, '2024_10_28_073059_create_complaint_status_histories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth-token', '8958aed7ce1a27b6956a0f5e620803225451a9b5ca93fa8aab6b4105f466807b', '[\"Assign_privilege\",\"Average_resolution_time_report\",\"Category\",\"Category_create\",\"Category_delete\",\"Category_edit\",\"Category_show\",\"Comment_create\",\"Complaint\",\"Complaint_create\",\"Complaint_show\",\"Complaint_status_update\",\"Complaints_by_priority_report\",\"Complaints_by_status_report\",\"Complaints_trend_report\",\"Reports\",\"Role\",\"Role_create\",\"Role_delete\",\"Role_update\",\"User\",\"User_create\",\"User_delete\",\"User_update\"]', '2024-11-03 09:50:20', NULL, '2024-11-03 01:13:55', '2024-11-03 09:50:20'),
(2, 'App\\Models\\User', 2, 'auth-token', '3196f66c4723af384527c0ffd5a4f12bbb60aa1d7cb70548f2df72b84a02db5f', '[\"Complaint\",\"Complaint_create\",\"Complaint_show\"]', '2024-11-03 10:05:27', NULL, '2024-11-03 09:50:33', '2024-11-03 10:05:27'),
(3, 'App\\Models\\User', 3, 'auth-token', '4144dd61fa986b0d64d8d5804d39f57e0d65c5b7f4c506879e16e7378f761fd8', '[\"Complaint\",\"Complaint_create\",\"Complaint_show\"]', '2024-11-03 10:06:56', NULL, '2024-11-03 10:05:48', '2024-11-03 10:06:56'),
(4, 'App\\Models\\User', 1, 'auth-token', '69ca0afb346a8ba28f6befb3d46cf765c045a4902fdbfe0a671a216e2ff7060b', '[\"Assign_privilege\",\"Average_resolution_time_report\",\"Category\",\"Category_create\",\"Category_delete\",\"Category_edit\",\"Category_show\",\"Comment_create\",\"Complaint\",\"Complaint_create\",\"Complaint_show\",\"Complaint_status_update\",\"Complaints_by_priority_report\",\"Complaints_by_status_report\",\"Complaints_trend_report\",\"Reports\",\"Role\",\"Role_create\",\"Role_delete\",\"Role_update\",\"User\",\"User_create\",\"User_delete\",\"User_update\"]', '2024-11-03 10:08:17', NULL, '2024-11-03 10:07:07', '2024-11-03 10:08:17'),
(5, 'App\\Models\\User', 3, 'auth-token', 'eb34928f0b788454bf628537273bec45626df4c990631fa0984185288ec49525', '[\"Complaint\",\"Complaint_create\",\"Complaint_show\"]', '2024-11-03 10:08:42', NULL, '2024-11-03 10:08:37', '2024-11-03 10:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `name`, `slug`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'User', 'User', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(2, 'User create', 'User_create', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(3, 'User update', 'User_update', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(4, 'User delete', 'User_delete', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(5, 'Role', 'Role', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(6, 'Role create', 'Role_create', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(7, 'Role update', 'Role_update', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(8, 'Role delete', 'Role_delete', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(9, 'Assign privilege', 'Assign_privilege', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(10, 'Complaint', 'Complaint', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(11, 'Complaint create', 'Complaint_create', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(12, 'Complaint show', 'Complaint_show', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(13, 'Complaint status update', 'Complaint_status_update', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(14, 'Category', 'Category', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(15, 'Category create', 'Category_create', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(16, 'Category show', 'Category_show', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(17, 'Category edit', 'Category_edit', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(18, 'Category delete', 'Category_delete', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(19, 'Comment create', 'Comment_create', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(20, 'Reports', 'Reports', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(21, 'Complaints by status report', 'Complaints_by_status_report', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(22, 'Complaints by priority report', 'Complaints_by_priority_report', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(23, 'Average resolution time report', 'Average_resolution_time_report', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(24, 'Complaints trend report', 'Complaints_trend_report', 1, NULL, '2024-11-03 01:12:45', '2024-11-03 01:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(2, 'User', 'user', '2024-11-03 01:12:45', '2024-11-03 01:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_privileges`
--

CREATE TABLE `role_privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `privilege_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_privileges`
--

INSERT INTO `role_privileges` (`id`, `role_id`, `privilege_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(2, 1, 2, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(3, 1, 3, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(4, 1, 4, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(5, 1, 5, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(6, 1, 6, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(7, 1, 7, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(8, 1, 8, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(9, 1, 9, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(10, 1, 10, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(11, 1, 11, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(12, 1, 12, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(13, 1, 13, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(14, 1, 14, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(15, 1, 15, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(16, 1, 16, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(17, 1, 17, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(18, 1, 18, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(19, 1, 19, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(20, 1, 20, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(21, 1, 21, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(22, 1, 22, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(23, 1, 23, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(24, 1, 24, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(25, 2, 10, NULL, NULL),
(26, 2, 11, NULL, NULL),
(27, 2, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', 'sysadmin@mail.com', '2024-11-03 01:12:44', '$2y$12$qOmXD/43SSAXrcIVmLDF5u2.jzsh05CpJFE8OlkT.WNOr0cgOMfgq', 1, 'E4U4Gkv1NX', '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(2, 'Fahim Hasan', 'fahim@gmail.com', NULL, '$2y$12$FDO6TDWE7Aic1HrgRGpF5OJ2u7vb/PFG/8yAZ3r2Wt9g6LmQiLmf.', 1, NULL, '2024-11-03 09:49:56', '2024-11-03 09:49:56'),
(3, 'Abu Taleb', 'taleb@gmail.com', NULL, '$2y$12$.yLDEA9eZxAVFtxNGUu5UO1v/Ff4ENUzxJ4emOzSXq3yCKXhzwlLm', 1, NULL, '2024-11-03 09:50:20', '2024-11-03 09:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-11-03 01:12:45', '2024-11-03 01:12:45'),
(2, 2, 2, '2024-11-03 09:49:56', '2024-11-03 09:49:56'),
(3, 3, 2, '2024-11-03 09:50:20', '2024-11-03 09:50:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_complaint_id_foreign` (`complaint_id`),
  ADD KEY `comments_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_user_id_foreign` (`user_id`),
  ADD KEY `complaints_category_id_foreign` (`category_id`);

--
-- Indexes for table `complaint_status_histories`
--
ALTER TABLE `complaint_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_status_histories_complaint_id_foreign` (`complaint_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `privileges_slug_unique` (`slug`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_privileges_role_id_foreign` (`role_id`),
  ADD KEY `role_privileges_privilege_id_foreign` (`privilege_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_roles_user_id_foreign` (`user_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `complaint_status_histories`
--
ALTER TABLE `complaint_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_privileges`
--
ALTER TABLE `role_privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_complaint_id_foreign` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaint_status_histories`
--
ALTER TABLE `complaint_status_histories`
  ADD CONSTRAINT `complaint_status_histories_complaint_id_foreign` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`);

--
-- Constraints for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD CONSTRAINT `role_privileges_privilege_id_foreign` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`),
  ADD CONSTRAINT `role_privileges_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
