-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 11:07 AM
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
-- Database: `gittrophyhouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `long_description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `description`, `long_description`, `image`, `created_at`, `updated_at`) VALUES
(11, 'Craftsmanship That Lasts', 'Our trophies are made with premium materials and meticulous attention to detail for durability and timeless appeal.', 'At Trophy House, craftsmanship is more than skill — it’s tradition. We pour precision, passion, and perfection into every design. Each trophy is carefully assembled to ensure lasting strength and beauty. Whether it\'s metal, crystal, or wood, we use materials that stand the test of time so your achievement is always remembered in its finest form.', '1750576727.png', '2025-06-21 23:42:54', '2025-06-22 02:25:35'),
(12, 'Fully Custom, Fully You', 'Celebrate your uniqueness with trophies that reflect your identity, values, and vision — no compromises.', 'We believe that no two achievements are alike, so why should your trophies be? Our custom trophy design services give you full creative control. Choose your shape, size, engraving, and finishes — or let us collaborate with you on a completely new concept. We craft each piece as a one-of-a-kind symbol, tailored entirely to your story.', '1750576735.png', '2025-06-21 23:45:48', '2025-06-22 02:25:55'),
(13, 'Delivered With Confidence', 'Reliable delivery, careful packaging, and on-time service — because your moments deserve stress-free celebration.', 'From production to packaging, we prioritize safety and punctuality. Every order goes through strict quality checks and is packed with precision to avoid any damage in transit. Whether you need a single piece or a bulk order, our logistics network ensures your trophies arrive in pristine condition — right when you need them.', '1750576744.png', '2025-06-21 23:46:08', '2025-06-22 02:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `delivery_instructions` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `email`, `pincode`, `address`, `city`, `state`, `country`, `delivery_instructions`, `is_default`, `created_at`, `updated_at`) VALUES
(6, 20, 'Jeanette Long', '+1 (482) 221-5466', 'mihato@mailinator.com', '123456', 'Quidem consequatur c', 'Doloribus sunt labor', 'Sit mollitia qui co', 'Quas ullamco quia ad', 'Nulla veniam recusa', 1, '2025-07-24 08:52:18', '2025-07-24 08:52:18'),
(7, 53, 'junaid shaikh', '93073 33450', 'shaikhjunaid7548@gmail.com', '1234567', 'nashik', 'nashik', 'Dolor nostrud sunt d', 'Placeat quaerat sol', 'Consectetur proident', 0, '2025-07-31 07:03:01', '2025-07-31 07:17:44'),
(8, 53, 'Blythe Cash', '+1 (858) 349-7141', 'rufow@mailinator.com', '12464616', 'Duis laboriosam vol', 'Ad natus nesciunt e', 'Quam dolorem aliquid', 'Debitis odio dolores', 'Irure ipsa quis dol', 1, '2025-07-31 07:17:39', '2025-07-31 07:17:44'),
(10, 75, 'Mayur Jawale', '9096879903', 'mayur@gmail.com', '422008', 'abc, abc street,', 'abc', 'abc', 'abc', 'abc', 1, '2025-08-02 04:23:16', '2025-08-12 23:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(109, 3, 107, 145, 7, '2025-07-31 04:04:29', '2025-07-31 04:55:10'),
(111, 53, 107, 145, 22, '2025-07-31 06:40:21', '2025-07-31 08:50:17'),
(115, 53, 105, 139, 2, '2025-07-31 09:41:42', '2025-07-31 09:41:49'),
(116, 53, 83, 98, 1, '2025-07-31 09:45:53', '2025-07-31 09:45:53'),
(127, 20, 108, 146, 3, '2025-08-07 02:07:10', '2025-08-07 02:12:03'),
(128, 20, 109, 147, 1, '2025-08-07 02:11:09', '2025-08-07 02:12:24'),
(133, 6, 104, 136, 1, '2025-08-08 03:03:19', '2025-08-08 03:03:19'),
(134, 6, 107, 145, 1, '2025-08-08 04:37:56', '2025-08-08 04:37:56'),
(136, 52, 83, 98, 1, '2025-08-08 08:03:37', '2025-08-08 08:03:37'),
(137, 52, 104, 136, 1, '2025-08-08 08:36:06', '2025-08-08 08:36:06'),
(143, 88, 105, 139, 1, '2025-08-12 03:12:50', '2025-08-12 03:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(19, 'Trophy & Memento', NULL, '1750417960.png', '2025-06-12 22:15:52', '2025-08-02 04:46:52'),
(20, 'Medals/Pins', 'test image', '1750418047.png', '2025-06-12 23:14:59', '2025-07-21 04:19:56'),
(21, 'Corporate Gifts', NULL, '1750418060.png', '2025-06-12 23:15:13', '2025-06-20 05:44:20'),
(22, 'Samman', NULL, '1750418075.png', '2025-06-12 23:15:27', '2025-06-20 05:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(6, NULL, NULL, '1750576095.png', '2025-06-22 01:38:15', '2025-06-22 01:38:15'),
(7, NULL, NULL, '1750576102.png', '2025-06-22 01:38:22', '2025-06-22 01:38:22'),
(8, NULL, NULL, '1750576117.png', '2025-06-22 01:38:37', '2025-06-22 01:38:37'),
(9, NULL, NULL, '1750576127.png', '2025-06-22 01:38:47', '2025-06-22 01:38:47'),
(10, NULL, NULL, '1750576137.png', '2025-06-22 01:38:57', '2025-06-22 01:38:57'),
(11, NULL, NULL, '1750576145.png', '2025-06-22 01:39:05', '2025-06-22 01:39:05'),
(12, NULL, NULL, '1750576152.png', '2025-06-22 01:39:12', '2025-06-22 01:39:12'),
(13, NULL, NULL, '1750576159.png', '2025-06-22 01:39:19', '2025-06-22 01:39:19'),
(14, NULL, NULL, '1750576166.png', '2025-06-22 01:39:26', '2025-06-22 01:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(4, 'mj', 'mayurjawale999@gmail.com', '9172593159', 'enquiry', 'test enquirt', '2025-06-30 23:43:46', '2025-06-30 23:43:46'),
(5, 'mj', 'mayur@gmail.com', '9172593150', 'support', 'support description', '2025-06-30 23:47:48', '2025-06-30 23:47:48'),
(6, 'mj', 'mj@gmail.com', NULL, NULL, 'test message', '2025-06-30 23:53:52', '2025-06-30 23:53:52'),
(7, 'mj', 'm@g.c', NULL, NULL, 'mm', '2025-06-30 23:55:52', '2025-06-30 23:55:52'),
(8, 'mj', 'm@g.c', '6578787878', 'support', 'mm', '2025-06-30 23:56:29', '2025-06-30 23:56:29'),
(9, 'AnthonyLex', 'aintsaword@yahoo.com', NULL, NULL, 'Rapid Riches: Withdraw Your $200,235.43 – Act Fast! http://realcarboncredits.com/bikinihaul/link.php?link=https%3A%2F%2Ftelegra.ph%2Fnfs-06-11%3F0467', '2025-07-08 23:06:52', '2025-07-08 23:06:52'),
(10, 'AnthonyLex', 'usmankonosuba@gmail.com', NULL, NULL, 'Ready, Withdraw, Go! Claim Your $200,985.90 Now! https://script.google.com/macros/s/AKfycbz06mwyeZTPcGglkWldNr41V5SZ5XLt6n-xdH2Srhf6VKZhAVVCWMv_nFKcnm0rCLxqvQ/exec/5v7h8l5e/4e9t/g/v3/4e5k9d3y/7y9t/8/1w/3v0b9k5t/3w6s/t/29', '2025-07-10 15:47:01', '2025-07-10 15:47:01'),
(11, 'AnthonyLex', 'richardwillett@btinternet.com', NULL, NULL, 'IMPORTANT! DID YOU CHECK? $200,435.52 IS YOURS! https://auto.today/go-to-url/1333/event/1333?slug=telegra.ph%2Fnfs-06-11%3F6558%2F', '2025-07-13 00:41:41', '2025-07-13 00:41:41'),
(12, 'Chassidy Razo', 'chassidy.razo81@gmail.com', NULL, NULL, 'We have a promotional offer for your website trophyhouse.shop.\r\n\r\nUnlimited Evergreen Traffic: Submit up to 30 posts every month, for life, and enjoy a never-ending stream of targeted traffic to your affiliate offers.\r\nLevel the Playing Field: Whether you\'re a newbie or a seasoned marketer, our platform gives you the edge you need to succeed.\r\nBuild Your Empire: Effortlessly grow your email list, promote unlimited affiliate products, and drive sales through the roof.\r\nPromote ANYTHING: Review affiliate products, promote your own products, local businesses, social media – the possibilities are endless!\r\nUnleash Powerful Features: Enjoy robust profile features, easy post editing/removal, seamless social sharing, and everything you need to dominate.\r\nThe Ultimate Traffic Weapon: Tap into our unique, high-quality traffic generation engine that works 24/7 on complete autopilot.\r\n\r\nSee it in action: https://goldsolutions.pro/FreePostZone\r\n\r\nYou are receiving this message because we believe our offer may be relevant to you. \r\nIf you do not wish to receive further communications from us, please click here to UNSUBSCRIBE:\r\nhttps://goldsolutions.pro/unsubscribe?domain=trophyhouse.shop\r\nAddress: 209 West Street Comstock Park, MI 49321\r\nLooking out for you, Ethan Parker', '2025-08-01 08:39:47', '2025-08-01 08:39:47'),
(13, 'Karl Abreu', 'karl.abreu3@gmail.com', NULL, NULL, 'Hello,\r\n\r\nWe have a promotional offer for your website trophyhouse.shop.\r\n\r\nIf You Want FREE, Targeted Traffic \r\nFrom The TOP 3 Free Traffic Sources, \r\nThen Pay Close Attention...\r\nSee it in action: https://goldsolutions.pro/TrafficSniper\r\n\r\nYou are receiving this message because we believe our offer may be relevant to you. \r\nIf you do not wish to receive further communications from us, please click here to UNSUBSCRIBE:\r\nhttps://goldsolutions.pro/unsubscribe?domain=trophyhouse.shop\r\nAddress: 209 West Street Comstock Park, MI 49321\r\nLooking out for you, Ethan Parker', '2025-08-07 14:06:38', '2025-08-07 14:06:38'),
(14, 'Reginald Oakley', 'oakley.reginald@yahoo.com', '1150464387', 'support', 'Hello,\r\n\r\nWe have a promotional offer for your website trophyhouse.shop.\r\n\r\nHere’s the Breakthrough Changing How Affiliates Make Money!\r\nThe Revolutionary AI Tool & Complete Business System That Builds, Writes & Ranks Websites...\r\n\r\nYES - Writes the Content For You\r\nYES - Structures it for SEO rankings\r\nYES - Publishes it directly to your site\r\nYES - Brings in organic traffic on autopilot\r\nYES - Helps generate commissions\r\n\r\nSee it in action: https://www.novaai.expert/AIContentSniper\r\n\r\nYou are receiving this message because we believe our offer may be relevant to you. \r\nIf you do not wish to receive further communications from us, please click here to UNSUBSCRIBE:\r\nhttps://www.novaai.expert/unsubscribe?domain=trophyhouse.shop\r\nAddress: 209 West Street Comstock Park, MI 49321\r\nLooking out for you, Ethan Parker', '2025-08-09 15:44:20', '2025-08-09 15:44:20');

-- --------------------------------------------------------

--
-- Table structure for table `customization_images`
--

CREATE TABLE `customization_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customization_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customization_images`
--

INSERT INTO `customization_images` (`id`, `user_id`, `customization_request_id`, `image`, `created_at`, `updated_at`) VALUES
(49, 52, 57, '1754647607478.jpg', '2025-08-08 08:06:47', '2025-08-08 08:06:47'),
(50, 52, 58, '1754649545592.png', '2025-08-08 08:39:05', '2025-08-08 08:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `customization_messages`
--

CREATE TABLE `customization_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customization_request_id` bigint(20) UNSIGNED NOT NULL,
  `cart_item_id` bigint(20) DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customization_messages`
--

INSERT INTO `customization_messages` (`id`, `customization_request_id`, `cart_item_id`, `sender_id`, `receiver_id`, `message`, `attachment`, `sent_at`, `created_at`, `updated_at`) VALUES
(114, 57, 136, 83, 52, 'gfg', NULL, '2025-08-08 08:53:22', '2025-08-08 08:53:22', '2025-08-08 08:53:22'),
(115, 57, 136, 83, 52, 'gfg', NULL, '2025-08-08 08:53:23', '2025-08-08 08:53:23', '2025-08-08 08:53:23'),
(116, 57, 136, 83, 52, NULL, '1754650669.png', '2025-08-08 08:57:49', '2025-08-08 08:57:49', '2025-08-08 08:57:49'),
(117, 58, 137, 52, 83, 'hie', NULL, '2025-08-08 11:24:36', '2025-08-08 09:24:36', '2025-08-08 09:24:36'),
(118, 57, 136, 83, 52, 'ello', NULL, '2025-08-08 09:25:27', '2025-08-08 09:25:27', '2025-08-08 09:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `customization_requests`
--

CREATE TABLE `customization_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cart_item_id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transferred_from` bigint(20) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `final_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','completed','approved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customization_requests`
--

INSERT INTO `customization_requests` (`id`, `user_id`, `cart_item_id`, `designer_id`, `transferred_from`, `description`, `image`, `final_image`, `status`, `created_at`, `updated_at`) VALUES
(57, 52, 136, 83, NULL, 'test work for second trophy', NULL, NULL, 'accepted', '2025-08-08 08:06:47', '2025-08-08 08:53:15'),
(58, 52, 137, 83, NULL, 'test', NULL, NULL, 'accepted', '2025-08-08 08:39:05', '2025-08-08 08:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(4, NULL, NULL, '1751353567.jpg', '2025-07-01 01:36:07', '2025-07-01 01:36:07'),
(5, NULL, NULL, '1751353587.jpg', '2025-07-01 01:36:27', '2025-07-01 01:36:27'),
(6, NULL, NULL, '1751353598.jpg', '2025-07-01 01:36:38', '2025-07-01 01:36:38'),
(7, NULL, NULL, '1751353607.jpg', '2025-07-01 01:36:47', '2025-07-01 01:36:47'),
(8, NULL, NULL, '1751353618.jpg', '2025-07-01 01:36:58', '2025-07-01 01:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"77f31eed-9028-458c-b84b-e42811cea4fa\",\"displayName\":\"App\\\\Mail\\\\ContactFormSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\ContactFormSubmitted\\\":3:{s:7:\\\"contact\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Contact\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"mayurjawale999@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1751346061,\"delay\":null}', 0, NULL, 1751346061, 1751346061),
(2, 'default', '{\"uuid\":\"575e2eb3-87aa-42ae-8222-0def7e7a79ec\",\"displayName\":\"App\\\\Mail\\\\ContactFormSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\ContactFormSubmitted\\\":3:{s:7:\\\"contact\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Contact\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"mayurjawale999@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1751346391,\"delay\":null}', 0, NULL, 1751346391, 1751346391),
(3, 'default', '{\"uuid\":\"f72098be-4107-4e07-bce3-3f8ee244a746\",\"displayName\":\"App\\\\Mail\\\\ContactFormSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\ContactFormSubmitted\\\":3:{s:7:\\\"contact\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Contact\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"mayurjawale999@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1751346473,\"delay\":null}', 0, NULL, 1751346473, 1751346473);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_21_112635_create_category_table', 2),
(7, '2025_05_22_100150_create_abouts_table', 4),
(8, '2025_05_23_035933_create_teams_table', 5),
(11, '2025_05_23_083225_create_testimonials_table', 7),
(12, '2025_05_23_064145_create_pages_table', 8),
(13, '2025_06_10_062014_create_sub_categories_table', 9),
(14, '2025_05_21_112949_create_products_table', 10),
(15, '2025_06_11_104634_create_cart_items_table', 11),
(17, '2025_06_13_063131_create_orders_table', 12),
(18, '2025_06_13_110006_create_order_items_table', 13),
(19, '2025_06_20_093127_create_wishlist_items_table', 14),
(20, '2025_06_21_045244_create_product_variants_table', 15),
(21, '2025_06_22_055427_create_clients_table', 16),
(22, '2025_06_23_154348_create_galleries_table', 17),
(23, '2025_06_24_091330_create_addresses_table', 18),
(24, '2025_07_01_045501_create_contacts_table', 19),
(25, '2025_07_02_084354_create_personal_access_tokens_table', 20),
(26, '2025_07_04_101736_create_occasions_table', 21),
(27, '2025_07_04_111152_create_occasion_products_table', 22),
(28, '2025_07_05_090548_create_product_images_table', 23),
(29, '2025_08_13_044152_create_payments_table', 24),
(30, '2025_08_13_050506_add_cf_order_id_to_payments_table', 25),
(31, '2025_08_13_065104_create_payment_items_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `occasional_products`
--

CREATE TABLE `occasional_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `occasion_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `occasions`
--

CREATE TABLE `occasions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `occasions`
--

INSERT INTO `occasions` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(4, 'Rakshabandhan', '<p>Special Trophy for Your Special Sister, Best Sister Trophy</p>', '1751974123.png', '2025-07-08 09:28:43', '2025-07-08 09:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `occasion_products`
--

CREATE TABLE `occasion_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `final_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(11, 'Disclaimer', '<div style=\"text-align: justify; \"><p dir=\"ltr\" data-pm-slice=\"1 1 []\">Trophy House specializes in crafting custom-designed trophies and awards for corporate achievements, academic excellence, sports recognition, and personal milestones. Our products are intended solely for <b>commemorative and decorative purposes</b>, and are <b>not meant to serve as legal certification</b>, <b>monetary instruments, or resale items with official authority</b>. We take immense pride in the quality of our work, combining time-honored craftsmanship with modern techniques to deliver premium, lasting creations. Due to the handcrafted nature of many of our products, <b>slight variations in color, texture, or finish may occur,</b> which are considered part of their uniqueness and character—not defects. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">By placing an order with Trophy House, you acknowledge and accept that: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Product images and descriptions provided on our website are for illustrative purposes only, and the actual product may vary slightly. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Trophy House is not liable for any misuse or misrepresentation of our products by individuals or organizations. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• All content on our website including logos, product photos, and descriptions — is the intellectual property of Trophy House and may not be reproduced, copied, or distributed without prior written consent. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">By using our services, you agree to these terms and understand that our trophies are designed to honor achievements — not to validate, certify, or guarantee them.</p></div>', '2025-06-26 04:35:00', '2025-07-30 08:44:12'),
(12, 'Privacy Policy', '<p dir=\"auto\" style=\"text-align: justify; white-space-collapse: preserve;\"></p><div style=\"text-align: justify;\"></div><p></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">At Trophy House, we value your privacy and are committed to protecting the personal information you share with us. This Privacy Policy explains how we collect, use, store, and protect your information when you visit our website or place an order with us.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><br></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b> 1. Information We Collect </b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">We may collect the following information when you interact with our website or services: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>• Personal Details: </b>Name, email address, phone number, shipping/billing address. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>• Order Information: </b>Product preferences, payment details (via secure third-party gateway), and transaction history.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b> • Technical Data: </b>IP address, browser type, device information, and browsing behavior through cookies and analytics tools. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>2. How We Use Your Information </b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">We use the collected data for purposes such as: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Processing and delivering your orders. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Responding to inquiries or customer support requests.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"> • Sending order updates, confirmations, and delivery status.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"> • Improving our website functionality and user experience. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>3. Information Sharing </b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">We <b>do not sell or rent</b> your personal data to any third party. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">We may share limited information with: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>• Trusted service providers </b>(like courier services or payment gateways) for order fulfillment. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Government authorities, only if legally required.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b> 4. Data Protection </b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">We implement appropriate security measures to protect your information from unauthorized access, misuse, or alteration. However, no online platform can guarantee 100% security, so we encourage you to safeguard your login credentials. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>5. Cookies</b> </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">Our website uses cookies to enhance your browsing experience. You may choose to disable cookies through your browser settings, though this may affect some website functionality. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>6. Your Rights</b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"> You have the right to: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Access the personal information we hold about you. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Request corrections or updates to your information. </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">• Opt-out of receiving promotional communications at any time.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"> To exercise any of these rights, please contact us at: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>contact email</b> -&nbsp;<span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">trophyhousensk1@gmail.com</span></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>Phone number </b>-&nbsp;<span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">9423962242, 9423962042, 9404076742</span></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>7. Policy Updates </b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\">We may update this Privacy Policy occasionally to reflect changes in our practices or legal requirements. Any updates will be posted on this page with a revised effective date.</p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b> 8. Contact Us</b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"> If you have any questions or concerns about this Privacy Policy or how your data is handled, please reach out to us at: </p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>Trophy House </b></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><b>Business address-&nbsp;</b><span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">Space cosmos, old Mumbai Agra Road, Beside Canara Bank, opp. Meher Bus Stop, Ashok Stambh, Nashik 422002</span></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><span style=\"font-weight: bolder;\">contact email</span>&nbsp;-&nbsp;<span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">trophyhousensk1@gmail.com</span></p><p dir=\"ltr\" data-pm-slice=\"1 1 []\"><span style=\"font-weight: bolder;\">contact number&nbsp;</span>-&nbsp;<span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">9423962242, 9423962042, 9404076742</span></p>', '2025-06-26 04:35:24', '2025-07-30 08:58:04'),
(13, 'Refund & return  Policy', '<p dir=\"auto\" style=\"\"><span style=\"white-space-collapse: preserve;\"></span></p><div style=\"text-align: justify; margin: 0; padding: 0;\">\r\n    <p><strong>At Trophy House</strong>, customer satisfaction is important to us. As most of our products are customized, we have specific guidelines for returns and refunds. Please read the policy carefully before placing an order.</p>\r\n\r\n    <p><strong>1. Eligibility for Return</strong><br>\r\n    You may request a return or replacement only if:<br>\r\n    • The product was received damaged or defective<br>\r\n    • You received the wrong item (wrong design, name, or model)<br>\r\n    • The issue is reported within 48 hours of delivery<br>\r\n    Note: Personalized or custom-made trophies are non-returnable unless they fall under the above conditions.</p>\r\n\r\n    <p><strong>2. Non-Returnable Items</strong><br>\r\n    We do not accept returns for:<br>\r\n    • Products with errors caused by incorrect information provided by the customer (e.g., spelling mistakes in engraving)<br>\r\n    • Products that have been used, altered, or damaged after delivery<br>\r\n    • Orders canceled after production has started</p>\r\n\r\n    <p><strong>3. Return Process</strong><br>\r\n    To request a return:<br>\r\n    1. Email us at&nbsp;<a href=\"mailto:Trophyhouse@gmail.com\" class=\"text-black text-decoration-none\" source=\"\" sans=\"\" 3\",=\"\" sans-serif;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0)=\"\" !important;=\"\" text-decoration:=\"\" none=\"\" !important;\"=\"\" style=\"background-color: rgb(255, 255, 255); font-family: sans-serif; font-weight: 400; font-size: 1rem; text-align: start; margin: 0px; padding: 0px; transition: 0.3s ease-out; display: inline-block;\">trophyhousensk1@gmail.com</a>&nbsp;or WhatsApp us at&nbsp;<span style=\"text-align: start; font-size: 1rem; font-weight: initial;\">9423962242, 9423962042, 9404076742</span><span style=\"font-size: 0.9375rem; font-weight: initial;\">&nbsp;within 48 hours of delivery.</span></p><p>\r\n    2. Include:<br>\r\n       • Your order number<br>\r\n       • A clear description of the issue<br>\r\n       • Photos or videos of the damaged/incorrect item<br>\r\n    3. Our support team will review your request and respond within 2–3 business days.</p>\r\n\r\n    <p><strong>4. Refund Policy</strong><br>\r\n    • Approved refunds will be processed within 5–6 business days to your original payment method.<br>\r\n    • For prepaid orders, refund times may vary depending on your bank or payment provider.<br>\r\n    • Cash-on-Delivery orders (if applicable) will be refunded via bank transfer.</p>\r\n\r\n    <p><strong>5. Replacements</strong><br>\r\n    • If eligible, we will send a free replacement of the damaged or incorrect product.<br>\r\n    • Replacement shipping costs will be borne by Trophy House.</p>\r\n\r\n    <p><strong>6. Cancellation Policy</strong><br>\r\n    • Orders can only be canceled within 12 hours of placement if production hasn’t started.<br>\r\n    • Once customization or production begins, the order cannot be canceled or refunded.</p>\r\n\r\n    <p><strong>7. Contact Us</strong><br>\r\n    For any questions or refund/return assistance, please contact:<br></p><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\">Trophy House</span></span></div><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\"><br></span></span></div><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\">Email: </span></span><a href=\"mailto:Trophyhouse@gmail.com\" class=\"text-black text-decoration-none\" source=\"\" sans=\"\" 3\",=\"\" sans-serif;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0)=\"\" !important;=\"\" text-decoration:=\"\" none=\"\" !important;\"=\"\" style=\"font-weight: 400; font-size: 1rem; margin: 0px; padding: 0px; transition: 0.3s ease-out; display: inline-block;\">trophyhousensk1@gmail.com</a></div><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\"><br></span></span></div><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\">Phone: </span></span><span source=\"\" sans=\"\" 3\",=\"\" sans-serif;=\"\" font-size:=\"\" 1rem;=\"\" font-weight:=\"\" initial;\"=\"\">9423962242, 9423962042, 9404076742</span></div><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\"><br></span></span></div><div style=\"text-align: start;\"><span style=\"white-space-collapse: preserve;\"><span style=\"font-weight: bolder;\">Address: </span></span><span source=\"\" sans=\"\" 3\",=\"\" sans-serif;=\"\" font-size:=\"\" 1rem;=\"\" font-weight:=\"\" initial;\"=\"\">Space cosmos, old Mumbai Agra Road, Beside Canara Bank, opp. Meher Bus Stop, Ashok Stambh, Nashik 422002</span></div>\r\n</div><p></p>', '2025-06-26 04:35:41', '2025-08-08 07:06:35'),
(14, 'Terms & Conditions', '<div><span style=\"white-space-collapse: preserve;\">Welcome to <b>Trophy House</b>. These Terms &amp; Conditions (\"Terms\") govern your use of our website and the purchase of our products. By accessing or using our website, you agree to comply with and be bound by these Terms. Please read them carefully before placing any orders.</span></div><div><span style=\"white-space-collapse: preserve;\"><b><br></b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>1. Eligibility</b></span></div><div><span style=\"white-space-collapse: preserve;\">To use our services, you must:</span></div><div><span style=\"white-space-collapse: preserve;\">• Be a resident of India with a valid delivery address and contact number.</span></div><div><span style=\"white-space-collapse: preserve;\">• Use the website in accordance with all applicable local, state, and national laws.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>2. Products &amp; Orders</b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>2.1 Product Information</b></span></div><div><span style=\"white-space-collapse: preserve;\">All products listed on our website are displayed with as much accuracy as possible. However, slight variations in color, finish, or texture may occur due to the handcrafted nature of our products.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>2.2 Customization</b></span></div><div><span style=\"white-space-collapse: preserve;\">For personalized items, customers are responsible for providing accurate information such as names, dates, and design preferences. <b>Trophy House will not be held responsible for errors submitted by the customer.</b></span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>2.3 Order Confirmation</b></span></div><div><span style=\"white-space-collapse: preserve;\">All orders are subject to acceptance and availability. You will receive an order confirmation via email or message once your order is placed successfully.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>3. Pricing &amp; Payment</b></span></div><div><span style=\"white-space-collapse: preserve;\">• All prices are listed in Indian Rupees (INR) and include applicable taxes unless stated otherwise.</span></div><div><span style=\"white-space-collapse: preserve;\">• Prices are subject to change without prior notice.</span></div><div><span style=\"white-space-collapse: preserve;\">• Payments must be completed in full before order processing begins.</span></div><div><span style=\"white-space-collapse: preserve;\">• We use secure third-party payment gateways for transactions. We do not store your payment details.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>4. Shipping &amp; Delivery</b></span></div><div><span style=\"white-space-collapse: preserve;\">• We aim to dispatch orders within the estimated delivery time, but delays may occur due to unforeseen circumstances.</span></div><div><span style=\"white-space-collapse: preserve;\">• Trophy House is <b>not liable</b> for any delays caused by courier services, incorrect shipping addresses, or uncontrollable events.</span></div><div><span style=\"white-space-collapse: preserve;\">• Customers will receive tracking details once the order has been shipped.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>5. Returns &amp; Refunds</b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>• Customized products are non-returnable</b> unless damaged or defective on arrival.</span></div><div><span style=\"white-space-collapse: preserve;\">• In case of a damaged product, customers must notify us within <b>48 hours</b> of delivery, along with photo or video evidence.</span></div><div><span style=\"white-space-collapse: preserve;\">• Once the return is approved, refunds or replacements will be processed within <b>7–10 business days.</b></span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>6. Intellectual Property</b></span></div><div><span style=\"white-space-collapse: preserve;\">All content on this website — including but not limited to logos, images, designs, product names, and descriptions — is the <b>intellectual property of Trophy House</b> and is protected by copyright and trademark laws.</span></div><div><span style=\"white-space-collapse: preserve;\">You may not reproduce, reuse, or redistribute any content without our written consent.</span></div><div><span style=\"white-space-collapse: preserve;\"><b><br></b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>7. Limitation of Liability</b></span></div><div><span style=\"white-space-collapse: preserve;\">Trophy House shall not be held liable for:</span></div><div><span style=\"white-space-collapse: preserve;\">• Any indirect, incidental, or consequential damages.</span></div><div><span style=\"white-space-collapse: preserve;\">• Losses resulting from misuse or unauthorized use of our products.</span></div><div><span style=\"white-space-collapse: preserve;\">• Inaccuracies in customer-provided content or order details.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>8. Modifications to Terms</b></span></div><div><span style=\"white-space-collapse: preserve;\">We reserve the right to modify or update these Terms at any time. Any changes will be posted on this page with a revised effective date. Continued use of the website after updates means you agree to the revised Terms.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>9. Governing Law</b></span></div><div><span style=\"white-space-collapse: preserve;\">These Terms &amp; Conditions are governed by the laws of India. Any disputes arising from the use of our website or products will be subject to the jurisdiction of the courts in Nashik, Maharashtra.</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>10. Contact Us</b></span></div><div><span style=\"white-space-collapse: preserve;\">If you have any questions about these Terms &amp; Conditions, please contact us at:</span></div><div><span style=\"white-space-collapse: preserve;\"><br></span></div><div><span style=\"white-space-collapse: preserve;\"><b>Trophy House</b></span></div><div><span style=\"white-space-collapse: preserve;\"><b><br></b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>Email: </b></span><a href=\"mailto:Trophyhouse@gmail.com\" class=\"text-black text-decoration-none\" style=\"font-size: 1rem; font-weight: 400; margin: 0px; padding: 0px; transition: 0.3s ease-out; display: inline-block; font-family: &quot;Source Sans 3&quot;, sans-serif; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0) !important; text-decoration: none !important;\">trophyhousensk1@gmail.com</a></div><div><span style=\"white-space-collapse: preserve;\"><b><br></b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>Phone: </b></span><span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">9423962242, 9423962042, 9404076742</span></div><div><span style=\"white-space-collapse: preserve;\"><b><br></b></span></div><div><span style=\"white-space-collapse: preserve;\"><b>Address: </b></span><span style=\"font-family: &quot;Source Sans 3&quot;, sans-serif; font-size: 1rem; font-weight: initial;\">Space cosmos, old Mumbai Agra Road, Beside Canara Bank, opp. Meher Bus Stop, Ashok Stambh, Nashik 422002</span></div><div><span style=\"white-space-collapse: preserve;\"><b><br></b></span></div>', '2025-06-26 04:36:17', '2025-07-30 09:10:03'),
(15, 'Shipping & Delivery Policy', '<p dir=\"auto\" style=\"text-align: justify;\"><span style=\"white-space-collapse: preserve;\">At Trophy House, we are committed to delivering your custom-designed trophies and awards safely and on time. This Shipping &amp; Delivery Policy outlines our process, timelines, and responsibilities.\r\n\r\n<b>1. Order Processing Time</b>\r\n• Standard Processing Time: Orders are typically processed within 5 – 6 business days from the date of confirmation, depending on customization requirements.\r\n• Orders with complex personalization may take additional time, which will be communicated at the time of order placement.\r\n• Orders placed on weekends or public holidays will be processed on the next working day.\r\n\r\n<b>2. Shipping Methods &amp; Partners</b>\r\n• We partner with trusted courier and logistics companies to ensure secure and timely delivery.\r\n• Delivery is available across most pin codes in India. In case your location is non-serviceable, our team will inform you promptly.\r\n\r\n<b>3. Estimated Delivery Time</b>\r\n• Standard Delivery: 5 – 6 business days after dispatch (varies by location).\r\n• You will receive tracking information via SMS or email once your order is shipped.\r\n• Please note: Delivery timelines are estimates and may vary due to courier delays, weather conditions, or regional restrictions.\r\n\r\n<b>4. Shipping Charges</b>\r\n• Shipping charges (if applicable) are calculated at checkout based on delivery location and order size.\r\n• For bulk orders or special delivery arrangements, charges will be shared in advance during the order confirmation process.\r\n<b>\r\n5. Delivery Delays</b>\r\nTrophy House is not liable for delays caused by:\r\n• Courier/logistics partner issues.\r\n• Natural disasters, strikes, or unforeseen events.\r\n• Incorrect or incomplete shipping addresses provided by the customer.\r\n\r\n<b>6. Failed Delivery Attempts</b>\r\n• If the delivery partner is unable to deliver the package due to unavailability, incorrect address, or customer refusal, the shipment may be returned to us.\r\n• Re-shipping charges will be applicable for re-delivery attempts in such cases.\r\n\r\n<b>7. Damaged or Lost Packages</b>\r\n• If your order arrives damaged, please report it within 48 hours of delivery with supporting photos/videos.\r\n• In case of lost shipments, we will work with the courier service to investigate and resolve the issue.\r\n\r\n<b>8. Contact for Shipping Queries</b>\r\nFor any shipping-related questions or delivery assistance, contact us at:</span></p><p dir=\"auto\" style=\"text-align: justify;\"><span style=\"white-space-collapse: preserve;\">\r\n<b>contact email - </b></span><a href=\"mailto:Trophyhouse@gmail.com\" class=\"text-black text-decoration-none\" style=\"margin: 0px; padding: 0px; color: inherit; text-decoration: none; transition: 0.3s ease-out; display: inline-block; --bs-link-color-rgb: 10,88,202; font-family: \" source=\"\" sans=\"\" 3\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-weight:=\"\" 400;=\"\" text-align:=\"\" left;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">trophyhousensk1@gmail.com</a><span style=\"white-space-collapse: preserve;\"><b><br></b></span></p><p dir=\"auto\" style=\"text-align: justify;\"><span style=\"white-space-collapse: preserve;\"><b>\r\nPhone number - </b></span><span style=\"font-family: \" source=\"\" sans=\"\" 3\",=\"\" sans-serif;=\"\" font-size:=\"\" 1rem;=\"\" font-weight:=\"\" initial;=\"\" text-align:=\"\" start;\"=\"\">9423962242, 9423962042, 9404076742</span></p>', '2025-06-26 04:37:18', '2025-08-08 07:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `cf_order_id` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'INR',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_mode` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `cf_order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `amount`, `currency`, `status`, `payment_mode`, `transaction_id`, `created_at`, `updated_at`) VALUES
(18, 'TH_1755067595_75', '2195825700', '75', 'mayur', 'mayur@gmail.com', '9999999999', 88.50, 'INR', 'paid', 'upi', '5114919884534', '2025-08-13 01:16:36', '2025-08-13 01:17:13'),
(19, 'TH_1755068144_75', '2195826025', '75', 'mayur', 'mayur@gmail.com', '9999999999', 206.50, 'INR', 'paid', 'upi', '5114919884786', '2025-08-13 01:25:44', '2025-08-13 01:26:59'),
(20, 'TH_1755068277_75', '2195826103', '75', 'mayur', 'mayur@gmail.com', '9999999999', 88.50, 'INR', 'failed', NULL, NULL, '2025-08-13 01:27:58', '2025-08-13 01:28:31'),
(21, 'TH_1755068440_75', '2195826209', '75', 'mayur', 'mayur@gmail.com', '9999999999', 218.30, 'INR', 'paid', 'upi', '5114919884897', '2025-08-13 01:30:40', '2025-08-13 01:31:15'),
(22, 'TH_1755074173_75', '2195829022', '75', 'mayur', 'mayur@gmail.com', '9999999999', 206.50, 'INR', 'paid', 'upi', '5114919886598', '2025-08-13 03:06:18', '2025-08-13 03:06:56'),
(23, 'TH_1755074366_75', '2195829132', '75', 'mayur', 'mayur@gmail.com', '9999999999', 206.50, 'INR', 'paid', 'upi', '5114919886699', '2025-08-13 03:09:26', '2025-08-13 03:09:58'),
(24, 'TH_1755074461_75', '2195829520', '75', 'mayur', 'mayur@gmail.com', '9999999999', 430.70, 'INR', 'paid', 'upi', '5114919887026', '2025-08-13 03:11:01', '2025-08-13 03:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `payment_items`
--

CREATE TABLE `payment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_order_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_items`
--

INSERT INTO `payment_items` (`id`, `payment_order_id`, `user_id`, `product_id`, `variant_id`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`) VALUES
(6, 'TH_1755074366_75', 75, 103, 133, 1, 175.00, 175.00, '2025-08-13 03:09:58', '2025-08-13 03:09:58'),
(7, 'TH_1755074461_75', 75, 104, 136, 1, 175.00, 175.00, '2025-08-13 03:11:32', '2025-08-13 03:11:32'),
(8, 'TH_1755074461_75', 75, 106, 142, 1, 190.00, 190.00, '2025-08-13 03:11:32', '2025-08-13 03:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6, 'App\\Models\\User', 12, 'API Token', '8078cb5b9ce1913212adc439b6d358e5205f4711dfce213ca2fc5034318aa798', '[\"*\"]', NULL, NULL, '2025-07-24 08:22:11', '2025-07-24 08:22:11'),
(7, 'App\\Models\\User', 29, 'API Token', '203d4a6c3ee19db65544aba34f59dfb090ca93334aaeced6a030d83ac8f4ee57', '[\"*\"]', NULL, NULL, '2025-07-24 09:13:45', '2025-07-24 09:13:45'),
(21, 'App\\Models\\User', 36, 'API Token', '9a7b940e87a6dd2a149b64cc3c654cabd163e54098bc30ddb33cb4957b0ceb1e', '[\"*\"]', NULL, NULL, '2025-07-27 08:01:50', '2025-07-27 08:01:50'),
(22, 'App\\Models\\User', 32, 'API Token', '2d6e9f9b99c1a2fbbfaf78dce27d8ac246e198b5e5f6fa3c903061b58cf09271', '[\"*\"]', NULL, NULL, '2025-07-27 16:07:59', '2025-07-27 16:07:59'),
(26, 'App\\Models\\User', 45, 'API Token', '8881fe2e2d2a93e0423811804256c5f16e4ec84217000bf2d65e12557191fa6e', '[\"*\"]', NULL, NULL, '2025-07-28 03:01:00', '2025-07-28 03:01:00'),
(27, 'App\\Models\\User', 44, 'API Token', 'dff60b229bbdcf662ad6183d96192d62a3b7fff1f128228d27fb307f118b21ab', '[\"*\"]', NULL, NULL, '2025-07-28 03:29:15', '2025-07-28 03:29:15'),
(36, 'App\\Models\\User', 10, 'API Token', 'b8e8789dc69d24e8a7d0dc4d0d598ae31bf9ec0752edce8cb12020fe6f63cfa2', '[\"*\"]', NULL, NULL, '2025-07-28 06:37:54', '2025-07-28 06:37:54'),
(46, 'App\\Models\\User', 3, 'API Token', 'f9d3252c5a3e210542e7f03fbc9c72b8af9e75a4e80ef6f56d75198787dc49e8', '[\"*\"]', NULL, NULL, '2025-07-28 07:23:55', '2025-07-28 07:23:55'),
(47, 'App\\Models\\User', 50, 'API Token', '8423241232e41c52bed36d5f444b2778c4a12b43860f70b5e2b270406154b9b6', '[\"*\"]', NULL, NULL, '2025-07-28 07:29:10', '2025-07-28 07:29:10'),
(51, 'App\\Models\\User', 1, 'API Token', '3946bb85efd05ea07c85de960e2f5ef4a4d415276e23479d9b7f54d642ac98f3', '[\"*\"]', NULL, NULL, '2025-07-31 08:32:26', '2025-07-31 08:32:26'),
(53, 'App\\Models\\User', 57, 'API Token', 'f4110899529aec002833d56764b99f47d03184bf2830d9be310c508966db60b4', '[\"*\"]', NULL, NULL, '2025-07-31 08:44:25', '2025-07-31 08:44:25'),
(54, 'App\\Models\\User', 58, 'API Token', '1610bae2daa825bd70362d032cdc8f3fcceabb3b65ef31d14bba3bc215b8f7fa', '[\"*\"]', NULL, NULL, '2025-07-31 09:24:47', '2025-07-31 09:24:47'),
(68, 'App\\Models\\User', 73, 'API Token', 'cdf10263eef2430eb8b94d1f7ae242660f6a0505ff389f1c1e45901390ec2745', '[\"*\"]', NULL, NULL, '2025-08-01 07:51:11', '2025-08-01 07:51:11'),
(71, 'App\\Models\\User', 37, 'API Token', '86aa0bb16a8ccd14199247cda9e4cbfa5a6b73b9f9d6bd6ac83557396570dc1e', '[\"*\"]', NULL, NULL, '2025-08-01 08:23:16', '2025-08-01 08:23:16'),
(73, 'App\\Models\\User', 74, 'API Token', 'a814173ac1770f85035af1fcb7e8a46b3643ead5988dde84502e75e97867da9f', '[\"*\"]', NULL, NULL, '2025-08-01 08:28:35', '2025-08-01 08:28:35'),
(92, 'App\\Models\\User', 48, 'API Token', 'f150db3c445ae49fb5d0b942175677024e52f08d658b4e44ac0754bba8d33e95', '[\"*\"]', NULL, NULL, '2025-08-02 07:46:12', '2025-08-02 07:46:12'),
(220, 'App\\Models\\User', 81, 'API Token', 'ae5c199228980254382a84edd6fa49a06293055bf9b714621c2fd3d2bce2ebe5', '[\"*\"]', NULL, NULL, '2025-08-08 04:54:31', '2025-08-08 04:54:31'),
(238, 'App\\Models\\User', 85, 'API Token', '4434d55ca813bd690813902a3817cdf966b065fd7472e702a19cb8053016f995', '[\"*\"]', NULL, NULL, '2025-08-08 09:59:26', '2025-08-08 09:59:26'),
(248, 'App\\Models\\User', 75, 'API Token', 'f455f9c1856efafee7b146e8cc758aa61c9eeb496dee42964f5a5667038e01ea', '[\"*\"]', NULL, NULL, '2025-08-11 03:18:54', '2025-08-11 03:18:54'),
(253, 'App\\Models\\User', 82, 'API Token', 'd66d80816a82e0ca42efbb1b578ae8e550b20771261a2514b8b9925aa757b823', '[\"*\"]', NULL, NULL, '2025-08-11 15:07:10', '2025-08-11 15:07:10'),
(258, 'App\\Models\\User', 86, 'API Token', 'e829cf48dcab6038dae1861bc7411499b64d3cc35109d05a9217499d3459c039', '[\"*\"]', NULL, NULL, '2025-08-12 02:47:49', '2025-08-12 02:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `cdr_file` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_top_pick` tinyint(1) NOT NULL DEFAULT 0,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_new_arrival` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `sub_category_id`, `title`, `description`, `rating`, `cdr_file`, `image`, `is_top_pick`, `is_best_seller`, `is_new_arrival`, `created_at`, `updated_at`) VALUES
(83, 19, 23, 'NTB 2013', '<p>Fiber Trophy</p>', 5, NULL, '1752049103.png', 0, 0, 0, '2025-07-09 06:18:23', '2025-07-30 07:45:04'),
(103, 19, 15, 'NMO 2316', '<p>Best Quality Wooden Trophies with Mirror Finish, Top- Wooden, Base-Fiber<br>Brown colour with Golden Foil</p>', 5, NULL, '1753189363.png', 0, 0, 0, '2025-07-22 11:02:43', '2025-07-22 11:02:43'),
(104, 19, 15, 'NMO 2314', '<p><span style=\"color: rgb(94, 98, 111); font-family: \"DM Sans\", sans-serif; font-size: 16px;\">Best Quality Wooden Trophies with Mirror Finish, Top- Wooden, Base-Fiber</span><br style=\"margin: 0px; padding: 0px; color: rgb(94, 98, 111); font-family: \"DM Sans\", sans-serif; font-size: 16px;\"><span style=\"color: rgb(94, 98, 111); font-family: \"DM Sans\", sans-serif; font-size: 16px;\">Brown colour with Golden Foil<br></span>Best for Felicitation, Educational Awards, Mementoe, </p>', 5, NULL, '1753189575.jpg', 0, 0, 0, '2025-07-22 11:06:15', '2025-07-22 11:07:57'),
(105, 19, 15, 'NMO 2303', '<p><span style=\"color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\">Best Quality Wooden Trophies with Mirror Finish, Top- Wooden, Base-Fiber</span><br style=\"margin: 0px; padding: 0px; color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\"><span style=\"color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\">Brown colour with Golden Foil, Star Trophy<br></span>Best for Corporate awards, Felicitation, Educational Awards, Best mother, Best Father,Best Sister Trophy</p>', 5, NULL, '1753189814.jpg', 0, 0, 0, '2025-07-22 11:10:14', '2025-07-22 11:10:14'),
(106, 19, 15, 'NMO 2321', '<p><span style=\"color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\">Best Quality Wooden Trophies with Mirror Finish, Top- Wooden, Base-Fiber</span><br style=\"margin: 0px; padding: 0px; color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\"><span style=\"color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\">Brown colour with Golden Foil</span><br></p><p><span style=\"color: rgb(94, 98, 111); font-family: &quot;DM Sans&quot;, sans-serif; font-size: 16px;\">With eagle wing design,with star</span></p>', 5, NULL, '1753190118.jpg', 0, 0, 0, '2025-07-22 11:15:18', '2025-07-22 11:15:18'),
(107, 19, 20, 'NBL 710 Cut', 'Crystal Cube', NULL, NULL, '1753202559.jpg', 1, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:42:39'),
(108, 19, 20, 'NBL 710', 'Crystal Cube', NULL, NULL, '1753202576.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:42:56'),
(109, 19, 20, 'NBL 716', 'Crystal Cube', NULL, NULL, '1753202589.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:43:09'),
(110, 19, 20, 'NBl 720', 'Crystal Cube', NULL, NULL, '1753202605.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:43:25'),
(111, 19, 20, 'NCG 101', 'Crystal Trophy', NULL, NULL, '1753202630.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:43:50'),
(112, 19, 20, 'NCG 104', 'Crystal Trophy', NULL, NULL, '1753202644.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:44:04'),
(113, 19, 20, 'NCG 105', 'Crystal Trophy', NULL, NULL, '1753202697.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:44:57'),
(114, 19, 20, 'NCG 109', 'Crystal Trophy', NULL, NULL, '1753202708.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:45:08'),
(115, 19, 20, 'NCG 113', 'Crystal Trophy', NULL, NULL, '1753202719.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:45:19'),
(116, 19, 20, 'NCG 117', 'Crystal Trophy', NULL, NULL, '1753202753.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:45:53'),
(117, 19, 20, 'NCG 134', 'Crystal Trophy', NULL, NULL, '1753202738.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:45:38'),
(118, 19, 20, 'NCG 136', 'Crystal Trophy', NULL, NULL, '1753202792.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:46:32'),
(119, 19, 20, 'NCG 140', 'Crystal Trophy', NULL, NULL, '1753202804.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:46:44'),
(120, 19, 20, 'NCG 150', 'Crystal Trophy', NULL, NULL, '1753202823.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:47:03'),
(121, 19, 20, 'NCG 151', 'Crystal Trophy', NULL, NULL, '1753202854.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:47:34'),
(122, 19, 20, 'NCG 176', 'Crystal Trophy', NULL, NULL, '1753247310.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:08:30'),
(123, 19, 20, 'NCG 204', 'Crystal Trophy', NULL, NULL, '1753202954.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:49:14'),
(124, 19, 20, 'NCG 210', 'Crystal Trophy', NULL, NULL, '1753247267.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:07:47'),
(125, 19, 20, 'NCG 146', 'Crystal Trophy', NULL, NULL, 'NCG 146.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(126, 19, 20, 'NCG 211', 'Crystal Trophy', NULL, NULL, '1753247363.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:09:23'),
(127, 19, 20, 'NCG 223', 'Crystal Trophy', NULL, NULL, '1753247336.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:08:56'),
(128, 19, 20, 'NCG 233', 'Crystal Trophy', NULL, NULL, '1753247102.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:05:02'),
(129, 19, 20, 'NCG 234', 'Crystal Trophy', NULL, NULL, '1753247387.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:09:47'),
(130, 19, 20, 'NCG 238', 'Crystal Trophy', NULL, NULL, '1753247427.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:10:27'),
(131, 19, 20, 'NCG 239', 'Crystal Trophy', NULL, NULL, '1753247443.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:10:43'),
(132, 19, 20, 'NCG 246', 'Crystal Trophy', NULL, NULL, '1753247485.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:11:25'),
(133, 19, 20, 'NCG 249', 'Crystal Trophy', NULL, NULL, '1753247515.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:11:55'),
(134, 19, 20, 'NCG 329', 'Crystal Trophy', NULL, NULL, '1753247551.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:12:31'),
(135, 19, 20, 'NCG 359', 'Crystal Trophy', NULL, NULL, '1753247070.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:04:30'),
(136, 19, 20, 'NCG 370', 'Crystal Trophy', NULL, NULL, '1753247055.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:04:15'),
(137, 19, 20, 'NCG 408', 'Crystal Trophy', NULL, NULL, '1753247568.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:12:48'),
(138, 19, 20, 'NCG 409', 'Crystal Trophy', NULL, NULL, '1753247605.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:13:25'),
(139, 19, 20, 'NCG 419', 'Crystal Trophy', NULL, NULL, '1753247635.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:13:55'),
(140, 19, 20, 'NCG 425', 'Crystal Trophy', NULL, NULL, '1753247681.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:14:41'),
(141, 19, 20, 'NCG 453', 'Crystal Trophy', NULL, NULL, '1753247216.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:06:56'),
(142, 19, 20, 'NCG 470', 'Crystal Trophy', NULL, NULL, '1753247151.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:05:51'),
(143, 19, 20, 'NCG 473', 'Crystal Trophy', NULL, NULL, '1753247195.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:06:35'),
(144, 19, 20, 'NCG 481', 'Crystal Trophy', NULL, NULL, '1753203788.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 15:03:08'),
(145, 19, 20, 'NCG 484', 'Crystal Trophy', NULL, NULL, '1753203761.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 15:02:41'),
(146, 19, 20, 'NCG 538', 'Crystal Trophy', NULL, NULL, 'NCG 538.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(147, 19, 20, 'NCG 536', 'Crystal Trophy', NULL, NULL, 'NCG 536.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(148, 19, 20, 'NCG 535', 'Crystal Trophy', NULL, NULL, 'NCG 535.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(149, 19, 20, 'NCL 09', 'Elegant Crystal Glass Trophy in Blue Colour', NULL, NULL, '1753247724.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:15:24'),
(150, 19, 20, 'NCL 11', 'Crystal Glass Trophy', NULL, NULL, '1753203725.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 15:02:05'),
(151, 19, 20, 'NCL 13', 'Round Crystal Glass Trophy', NULL, NULL, '1753247747.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:15:47'),
(152, 19, 20, 'NCL 16', 'Crystal Glass Trophy', NULL, NULL, '1753247757.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-23 03:15:57'),
(153, 19, 20, 'NCL 01', 'Crystal Glass Trophy', NULL, NULL, 'NCL 01.jpg', 0, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(164, 20, 34, 'BD 821', '<p>Metal Pin with Magnet</p>', 5, NULL, '1753285206.jpg', 0, 0, 0, '2025-07-23 13:38:57', '2025-07-23 13:40:06'),
(165, 20, 34, 'BD 822', '<p>Metal Pin With Magnet (Small Size)</p>', 5, NULL, '1753285357.jpg', 0, 0, 0, '2025-07-23 13:42:37', '2025-07-23 13:42:37'),
(166, 20, 34, 'BD 823', '<p>Metal Pin with Pin</p>', 5, NULL, '1753285422.jpg', 0, 0, 0, '2025-07-23 13:43:42', '2025-07-23 13:43:42'),
(167, 20, 34, 'BD 824', '<p>Metal pin With Pin (Small SIze)</p>', 5, NULL, '1753285500.jpg', 0, 0, 0, '2025-07-23 13:45:00', '2025-07-23 13:45:00'),
(168, 20, 34, 'BD 825', '<p>Round Metal pin With Magnet</p>', 5, NULL, '1753285570.jpg', 0, 0, 0, '2025-07-23 13:46:10', '2025-07-23 13:46:10'),
(169, 20, 34, 'BD 826', '<p>Round Metal Abdge with Pin</p>', 5, NULL, '1753285680.jpg', 0, 0, 0, '2025-07-23 13:48:00', '2025-07-23 13:48:00'),
(170, 20, 34, 'BD 827', '<p>Fiber Badge with PIn</p>', 5, NULL, '1753285798.jpg', 0, 0, 0, '2025-07-23 13:49:58', '2025-07-23 13:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occasion_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `occasion_product_id`, `image`, `created_at`, `updated_at`) VALUES
(8, 168, NULL, '1753285570809.jpg', '2025-07-23 13:46:10', '2025-07-23 13:46:10'),
(9, 169, NULL, '1753285680108.jpg', '2025-07-23 13:48:00', '2025-07-23 13:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occasion_product_id` int(11) DEFAULT NULL,
  `size` varchar(255) NOT NULL,
  `color` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`color`)),
  `price` decimal(10,2) NOT NULL,
  `discount_percentage` float NOT NULL DEFAULT 0,
  `discounted_price` float NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `occasion_product_id`, `size`, `color`, `price`, `discount_percentage`, `discounted_price`, `created_at`, `updated_at`) VALUES
(62, NULL, 47, '7 inch', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 800.00, 6, 752, '2025-07-05 01:39:27', '2025-07-05 01:39:27'),
(63, NULL, 48, '7 inch', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 9, 728, '2025-07-05 01:41:00', '2025-07-05 01:41:00'),
(65, NULL, 49, 'Quis perspiciatis v', '\"[\\\"Aliqua Sed Nam quos\\\"]\"', 769.00, 99, 7.69, '2025-07-05 05:03:29', '2025-07-05 05:03:29'),
(66, NULL, 50, 'Autem aliquip except', '\"[\\\"Ab nulla aliqua Vol\\\"]\"', 372.00, 14, 319.92, '2025-07-05 05:11:30', '2025-07-05 05:11:30'),
(67, NULL, 51, 'Autem aliquip except', '\"[\\\"Ab nulla aliqua Vol\\\"]\"', 372.00, 14, 319.92, '2025-07-05 05:12:05', '2025-07-05 05:12:05'),
(68, NULL, 52, 'Quis non quis esse', '\"[\\\"Inventore laudantium\\\"]\"', 532.00, 77, 122.36, '2025-07-05 05:26:59', '2025-07-05 05:26:59'),
(69, NULL, 53, 'Omnis aut qui mollit', '\"[\\\"Qui dolores odit nos\\\"]\"', 505.00, 26, 373.7, '2025-07-05 05:29:55', '2025-07-05 05:29:55'),
(70, NULL, 54, 'Omnis tempor corrupt', '\"[\\\"Asperiores ad sed de\\\"]\"', 18.00, 98, 0.36, '2025-07-05 05:31:02', '2025-07-05 05:31:02'),
(92, NULL, 56, '7 inch', '\"[\\\"red\\\",\\\"yellow\\\"]\"', 400.00, 9, 364, '2025-07-08 09:58:40', '2025-07-08 09:58:40'),
(93, NULL, 56, '8 inch', '\"[\\\"red\\\",\\\"yellow\\\"]\"', 500.00, 8, 460, '2025-07-08 09:58:40', '2025-07-08 09:58:40'),
(94, NULL, 56, '10 inch', '\"[\\\"red\\\",\\\"yellow\\\"]\"', 1020.00, 9, 928.2, '2025-07-08 09:58:40', '2025-07-08 09:58:40'),
(98, 83, NULL, '16.5\"', '\"[\\\"Golden\\\"]\"', 1050.00, 0, 1050, '2025-07-09 06:18:23', '2025-07-09 06:18:23'),
(105, NULL, 3, '7 inch', '\"[\\\"dilver\\\"]\"', 900.00, 9, 819, '2025-07-18 10:28:15', '2025-07-18 10:28:15'),
(106, NULL, 11, '7inch', '\"[\\\"red\\\"]\"', 899.00, 9, 818.09, '2025-07-19 05:12:44', '2025-07-19 05:12:44'),
(119, NULL, 19, '7 inch', '\"[\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-21 07:56:43', '2025-07-21 07:56:43'),
(133, 103, NULL, '9.5', '\"[\\\"Brown\\\"]\"', 175.00, 0, 175, '2025-07-22 11:02:43', '2025-07-22 11:02:43'),
(134, 103, NULL, '10.5', '\"[\\\"Brown\\\"]\"', 200.00, 0, 200, '2025-07-22 11:02:43', '2025-07-22 11:02:43'),
(135, 103, NULL, '12', '\"[\\\"Brown\\\"]\"', 225.00, 0, 225, '2025-07-22 11:02:43', '2025-07-22 11:02:43'),
(136, 104, NULL, '10', '\"[\\\"Brown\\\"]\"', 175.00, 0, 175, '2025-07-22 11:06:15', '2025-07-22 11:06:15'),
(137, 104, NULL, '11', '\"[\\\"Brown\\\"]\"', 200.00, 0, 200, '2025-07-22 11:06:15', '2025-07-22 11:07:57'),
(138, 104, NULL, '12', '\"[\\\"Brown\\\"]\"', 225.00, 0, 225, '2025-07-22 11:06:15', '2025-07-22 11:07:57'),
(139, 105, NULL, '5', '\"[null]\"', 75.00, 0, 75, '2025-07-22 11:10:14', '2025-07-22 11:10:14'),
(140, 105, NULL, '6', '\"[null]\"', 90.00, 0, 90, '2025-07-22 11:10:14', '2025-07-22 11:10:14'),
(141, 105, NULL, '7', '\"[null]\"', 110.00, 0, 110, '2025-07-22 11:10:14', '2025-07-22 11:10:14'),
(142, 106, NULL, '10', '\"[null]\"', 190.00, 0, 190, '2025-07-22 11:15:18', '2025-07-22 11:15:18'),
(143, 106, NULL, '10.5', '\"[null]\"', 210.00, 0, 210, '2025-07-22 11:15:18', '2025-07-22 11:15:18'),
(144, 106, NULL, '11', '\"[null]\"', 240.00, 0, 240, '2025-07-22 11:15:18', '2025-07-22 11:15:18'),
(145, 107, NULL, '2', '\"[\\\"Transperent\\\"]\"', 440.00, 7, 409.2, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(146, 108, NULL, '2', '\"[\\\"Transperent\\\"]\"', 375.00, 0, 375, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(147, 109, NULL, '2.37', '\"[\\\"Transperent\\\"]\"', 855.00, 0, 855, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(148, 110, NULL, '3.95', '\"[\\\"Transperent\\\"]\"', 5000.00, 0, 5000, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(149, 110, NULL, '3.95', '\"[\\\"Transperent\\\"]\"', 8500.00, 0, 8500, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(150, 111, NULL, '6', '\"[\\\"Transperent\\\"]\"', 480.00, 0, 480, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(151, 111, NULL, '7.75', '\"[\\\"Transperent\\\"]\"', 665.00, 0, 665, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(152, 111, NULL, '9', '\"[\\\"Transperent\\\"]\"', 745.00, 0, 745, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(153, 111, NULL, '10', '\"[\\\"Transperent\\\"]\"', 900.00, 0, 900, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(154, 111, NULL, '11', '\"[\\\"Transperent\\\"]\"', 1160.00, 0, 1160, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(155, 112, NULL, '3', '\"[\\\"Transperent\\\"]\"', 315.00, 0, 315, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(156, 112, NULL, '4', '\"[\\\"Transperent\\\"]\"', 355.00, 0, 355, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(157, 112, NULL, '5', '\"[\\\"Transperent\\\"]\"', 465.00, 0, 465, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(158, 112, NULL, '6', '\"[\\\"Transperent\\\"]\"', 600.00, 0, 600, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(159, 112, NULL, '7', '\"[\\\"Transperent\\\"]\"', 930.00, 0, 930, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(160, 112, NULL, '8', '\"[\\\"Transperent\\\"]\"', 950.00, 0, 950, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(161, 112, NULL, '9', '\"[\\\"Transperent\\\"]\"', 1585.00, 0, 1585, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(162, 113, NULL, '4', '\"[\\\"Transperent\\\"]\"', 590.00, 0, 590, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(163, 113, NULL, '5', '\"[\\\"Transperent\\\"]\"', 850.00, 0, 850, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(164, 113, NULL, '6.5', '\"[\\\"Transperent\\\"]\"', 1480.00, 0, 1480, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(165, 114, NULL, '10', '\"[\\\"Transperent\\\"]\"', 785.00, 0, 785, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(166, 115, NULL, '6', '\"[\\\"Transperent\\\"]\"', 725.00, 0, 725, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(167, 115, NULL, '7.75', '\"[\\\"Transperent\\\"]\"', 1010.00, 0, 1010, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(168, 115, NULL, '9', '\"[\\\"Transperent\\\"]\"', 1125.00, 0, 1125, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(169, 115, NULL, '10', '\"[\\\"Transperent\\\"]\"', 1365.00, 0, 1365, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(170, 115, NULL, '12', '\"[\\\"Transperent\\\"]\"', 1590.00, 0, 1590, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(171, 116, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 1890.00, 0, 1890, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(172, 117, NULL, '6.25', '\"[\\\"Transperent\\\"]\"', 1050.00, 0, 1050, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(173, 117, NULL, '8.5', '\"[\\\"Transperent\\\"]\"', 1175.00, 0, 1175, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(174, 117, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 1680.00, 0, 1680, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(175, 118, NULL, '8', '\"[\\\"Transperent\\\"]\"', 1275.00, 0, 1275, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(176, 118, NULL, '11.5', '\"[\\\"Transperent\\\"]\"', 1480.00, 0, 1480, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(177, 118, NULL, '13', '\"[\\\"Transperent\\\"]\"', 2020.00, 0, 2020, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(178, 119, NULL, '6.75', '\"[\\\"Transperent\\\"]\"', 1265.00, 0, 1265, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(179, 119, NULL, '7.75', '\"[\\\"Transperent\\\"]\"', 1510.00, 0, 1510, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(180, 119, NULL, '9.75', '\"[\\\"Transperent\\\"]\"', 1590.00, 0, 1590, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(181, 119, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 1870.00, 0, 1870, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(182, 120, NULL, '8', '\"[\\\"Transperent\\\"]\"', 1005.00, 0, 1005, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(183, 120, NULL, '9', '\"[\\\"Transperent\\\"]\"', 1080.00, 0, 1080, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(184, 120, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 1170.00, 0, 1170, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(185, 122, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 1425.00, 0, 1425, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(186, 124, NULL, '6', '\"[\\\"Transperent\\\"]\"', 390.00, 0, 390, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(187, 124, NULL, '7', '\"[\\\"Transperent\\\"]\"', 560.00, 0, 560, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(188, 124, NULL, '7.75', '\"[\\\"Transperent\\\"]\"', 725.00, 0, 725, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(189, 124, NULL, '8.5', '\"[\\\"Transperent\\\"]\"', 780.00, 0, 780, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(190, 124, NULL, '10', '\"[\\\"Transperent\\\"]\"', 835.00, 0, 835, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(191, 126, NULL, '13', '\"[\\\"Transperent\\\"]\"', 3150.00, 0, 3150, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(192, 126, NULL, '15', '\"[\\\"Transperent\\\"]\"', 3985.00, 0, 3985, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(193, 126, NULL, '16.5', '\"[\\\"Transperent\\\"]\"', 5480.00, 0, 5480, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(194, 127, NULL, '7.75', '\"[\\\"Transperent\\\"]\"', 1035.00, 0, 1035, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(195, 127, NULL, '8.75', '\"[\\\"Transperent\\\"]\"', 1215.00, 0, 1215, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(196, 127, NULL, '0', '\"[\\\"Transperent\\\"]\"', 0.00, 0, 0, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(197, 129, NULL, '3.5', '\"[\\\"Transperent\\\"]\"', 720.00, 0, 720, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(198, 130, NULL, '8.5', '\"[\\\"Transperent\\\"]\"', 1300.00, 0, 1300, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(199, 131, NULL, '9', '\"[\\\"Transperent\\\"]\"', 1315.00, 0, 1315, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(200, 132, NULL, '3.5', '\"[\\\"Transperent\\\"]\"', 635.00, 0, 635, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(201, 132, NULL, '4.5', '\"[\\\"Transperent\\\"]\"', 790.00, 0, 790, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(202, 132, NULL, '5.5', '\"[\\\"Transperent\\\"]\"', 1000.00, 0, 1000, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(203, 133, NULL, '7', '\"[\\\"Transperent\\\"]\"', 3685.00, 0, 3685, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(204, 135, NULL, '9.5', '\"[\\\"Transperent\\\"]\"', 2625.00, 0, 2625, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(205, 135, NULL, '10.75', '\"[\\\"Transperent\\\"]\"', 3335.00, 0, 3335, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(206, 136, NULL, '8.75', '\"[\\\"Transperent\\\"]\"', 1545.00, 0, 1545, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(207, 136, NULL, '9.75', '\"[\\\"Transperent\\\"]\"', 2140.00, 0, 2140, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(208, 137, NULL, '11.5', '\"[\\\"Transperent\\\"]\"', 1605.00, 0, 1605, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(209, 138, NULL, '10.25', '\"[\\\"Transperent\\\"]\"', 1770.00, 0, 1770, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(210, 139, NULL, '6.5', '\"[\\\"Transperent\\\"]\"', 2315.00, 0, 2315, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(211, 142, NULL, '5', '\"[\\\"Transperent\\\"]\"', 805.00, 0, 805, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(212, 142, NULL, '5.75', '\"[\\\"Transperent\\\"]\"', 1045.00, 0, 1045, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(213, 142, NULL, '7', '\"[\\\"Transperent\\\"]\"', 1295.00, 0, 1295, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(214, 143, NULL, '6.75', '\"[\\\"Transperent\\\"]\"', 980.00, 0, 980, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(215, 143, NULL, '8', '\"[\\\"Transperent\\\"]\"', 1135.00, 0, 1135, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(216, 145, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 2860.00, 0, 2860, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(217, 146, NULL, '8.5', '\"[\\\"Transperent\\\"]\"', 1885.00, 0, 1885, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(218, 146, NULL, '9.5', '\"[\\\"Transperent\\\"]\"', 2110.00, 0, 2110, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(219, 146, NULL, '10.5', '\"[\\\"Transperent\\\"]\"', 2285.00, 0, 2285, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(220, 147, NULL, '7', '\"[\\\"Transperent\\\"]\"', 950.00, 0, 950, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(221, 148, NULL, '7.25', '\"[\\\"Transperent\\\"]\"', 1045.00, 0, 1045, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(222, 149, NULL, '12', '\"[\\\"Blue\\\"]\"', 4500.00, 0, 4500, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(223, 151, NULL, '8.5', '\"[\\\"Transperent\\\"]\"', 3000.00, 0, 3000, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(224, 152, NULL, '9.75', '\"[\\\"Transperent\\\"]\"', 3200.00, 0, 3200, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(225, 153, NULL, '5.75', '\"[\\\"Black\\\"]\"', 700.00, 0, 700, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(226, 153, NULL, '7.5', '\"[\\\"Black\\\"]\"', 900.00, 0, 900, '2025-07-22 14:41:31', '2025-07-22 14:41:31'),
(227, NULL, 20, '223', '\"[\\\"white\\\"]\"', 22.00, 22, 17.16, '2025-07-23 08:30:51', '2025-07-23 08:30:51'),
(228, NULL, 68, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 09:58:47', '2025-07-23 09:58:47'),
(229, NULL, 70, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:01:38', '2025-07-23 10:01:38'),
(230, NULL, 71, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:02:09', '2025-07-23 10:02:09'),
(231, NULL, 72, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:02:39', '2025-07-23 10:02:39'),
(232, NULL, 73, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:03:37', '2025-07-23 10:03:37'),
(233, NULL, 74, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:04:05', '2025-07-23 10:04:05'),
(234, NULL, 75, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:04:45', '2025-07-23 10:04:45'),
(235, NULL, 76, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:05:38', '2025-07-23 10:05:38'),
(236, NULL, 77, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:06:24', '2025-07-23 10:06:24'),
(237, NULL, 78, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:07:45', '2025-07-23 10:07:45'),
(238, NULL, 79, '78', '\"[\\\"ss\\\"]\"', 78.00, 8, 71.76, '2025-07-23 10:09:27', '2025-07-23 10:09:27'),
(239, NULL, 80, '7878', '\"[\\\"s\\\"]\"', 78888.00, 7, 73365.8, '2025-07-23 10:10:21', '2025-07-23 10:10:21'),
(240, NULL, 81, '7878', '\"[\\\"s\\\"]\"', 78888.00, 7, 73365.8, '2025-07-23 10:11:01', '2025-07-23 10:11:01'),
(241, NULL, 82, '7878', '\"[\\\"s\\\"]\"', 78888.00, 7, 73365.8, '2025-07-23 10:11:20', '2025-07-23 10:11:20'),
(242, NULL, 83, '7878', '\"[\\\"s\\\"]\"', 78888.00, 7, 73365.8, '2025-07-23 10:11:58', '2025-07-23 10:11:58'),
(243, NULL, 84, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:12:54', '2025-07-23 10:12:54'),
(244, NULL, 85, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:13:33', '2025-07-23 10:13:33'),
(245, NULL, 86, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:13:58', '2025-07-23 10:13:58'),
(246, NULL, 87, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:16:57', '2025-07-23 10:16:57'),
(247, NULL, 88, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:17:23', '2025-07-23 10:17:23'),
(248, NULL, 89, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:17:41', '2025-07-23 10:17:41'),
(249, NULL, 90, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:17:53', '2025-07-23 10:17:53'),
(250, NULL, 91, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:19:46', '2025-07-23 10:19:46'),
(251, NULL, 92, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:20:23', '2025-07-23 10:20:23'),
(252, NULL, 93, '7', '\"[\\\"ss\\\"]\"', 78.00, 7, 72.54, '2025-07-23 10:20:51', '2025-07-23 10:20:51'),
(253, NULL, 94, '89', '\"[\\\"ss\\\"]\"', 8989.00, 8, 8269.88, '2025-07-23 10:26:37', '2025-07-23 10:26:37'),
(254, NULL, 95, '89', '\"[\\\"ss\\\"]\"', 8989.00, 8, 8269.88, '2025-07-23 10:27:14', '2025-07-23 10:27:14'),
(255, NULL, 96, '89', '\"[\\\"ss\\\"]\"', 8989.00, 8, 8269.88, '2025-07-23 10:28:50', '2025-07-23 10:28:50'),
(265, 164, NULL, '3', '\"[null]\"', 90.00, 0, 90, '2025-07-23 13:38:57', '2025-07-23 13:38:57'),
(266, 165, NULL, '2.5', '\"[\\\"Golden\\\"]\"', 78.00, 0, 78, '2025-07-23 13:42:37', '2025-07-23 13:42:37'),
(267, 166, NULL, '3', '\"[\\\"Golden\\\"]\"', 60.00, 0, 60, '2025-07-23 13:43:42', '2025-07-23 13:43:42'),
(268, 167, NULL, '2.5', '\"[\\\"Golden\\\"]\"', 48.00, 0, 48, '2025-07-23 13:45:00', '2025-07-23 13:45:00'),
(269, 168, NULL, '1.25', '\"[null]\"', 78.00, 0, 78, '2025-07-23 13:46:10', '2025-07-23 13:46:10'),
(270, 169, NULL, '1.5', '\"[\\\"Golden\\\"]\"', 58.00, 0, 58, '2025-07-23 13:48:00', '2025-07-23 13:48:00'),
(271, 170, NULL, '3', '\"[\\\"Golden\\\"]\"', 40.00, 0, 40, '2025-07-23 13:49:58', '2025-07-23 13:49:58'),
(272, NULL, 102, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-07-24 02:01:41', '2025-07-24 02:01:41'),
(273, NULL, 102, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-07-24 02:01:41', '2025-07-24 02:01:41'),
(274, NULL, 103, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-24 02:01:41', '2025-07-24 02:01:41'),
(275, NULL, 103, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-07-24 02:01:41', '2025-07-24 02:01:41'),
(276, NULL, 104, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-07-24 02:01:41', '2025-07-24 02:01:41'),
(277, NULL, 104, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-07-24 02:01:41', '2025-07-24 02:01:41'),
(278, NULL, 105, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-07-24 02:03:02', '2025-07-24 02:03:02'),
(279, NULL, 105, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-07-24 02:03:02', '2025-07-24 02:03:02'),
(280, NULL, 106, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-24 02:03:02', '2025-07-24 02:03:02'),
(281, NULL, 106, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-07-24 02:03:02', '2025-07-24 02:03:02'),
(282, NULL, 107, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-07-24 02:03:02', '2025-07-24 02:03:02'),
(283, NULL, 107, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-07-24 02:03:02', '2025-07-24 02:03:02'),
(284, NULL, 108, '77', '\"[\\\"golden\\\"]\"', 889.00, 8, 817.88, '2025-07-24 02:12:17', '2025-07-24 02:12:17'),
(285, NULL, 109, '77', '\"[\\\"golden\\\"]\"', 889.00, 8, 817.88, '2025-07-24 02:14:46', '2025-07-24 02:14:46'),
(286, NULL, 110, '5', '\"[\\\"white\\\"]\"', 585.00, 5, 555.75, '2025-07-24 02:14:52', '2025-07-24 02:14:52'),
(287, NULL, 111, '77', '\"[\\\"golden\\\"]\"', 888.00, 7, 825.84, '2025-07-24 02:15:45', '2025-07-24 02:15:45'),
(288, NULL, 112, '77', '\"[\\\"golden\\\"]\"', 888.00, 7, 825.84, '2025-07-24 02:16:17', '2025-07-24 02:16:17'),
(289, NULL, 113, '5', '\"[\\\"white\\\"]\"', 585.00, 5, 555.75, '2025-07-24 02:17:02', '2025-07-24 02:17:02'),
(290, NULL, 114, '77', '\"[\\\"golden\\\"]\"', 888.00, 7, 825.84, '2025-07-24 02:17:11', '2025-07-24 02:17:11'),
(291, NULL, 115, '5', '\"[\\\"red\\\"]\"', 456.00, 4, 437.76, '2025-07-24 02:18:31', '2025-07-24 02:18:31'),
(292, NULL, 116, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-07-24 02:18:59', '2025-07-24 02:18:59'),
(293, NULL, 116, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-07-24 02:18:59', '2025-07-24 02:18:59'),
(294, NULL, 117, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-24 02:18:59', '2025-07-24 02:18:59'),
(295, NULL, 117, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-07-24 02:18:59', '2025-07-24 02:18:59'),
(296, NULL, 118, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-07-24 02:18:59', '2025-07-24 02:18:59'),
(297, NULL, 118, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-07-24 02:18:59', '2025-07-24 02:18:59'),
(298, NULL, 119, '4', '\"[\\\"red\\\"]\"', 5655.00, 45, 3110.25, '2025-07-24 02:19:40', '2025-07-24 02:19:40'),
(299, NULL, 120, '78', '\"[\\\"silver\\\"]\"', 787.00, 7, 731.91, '2025-07-24 02:28:31', '2025-07-24 02:28:31'),
(311, NULL, 121, '77', '\"[\\\"q\\\"]\"', 787.00, 7, 731.91, '2025-07-24 04:52:08', '2025-07-24 04:52:08'),
(312, NULL, 122, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-07-24 05:10:16', '2025-07-24 05:10:16'),
(313, NULL, 122, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-07-24 05:10:16', '2025-07-24 05:10:16'),
(314, NULL, 123, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-24 05:10:16', '2025-07-24 05:10:16'),
(315, NULL, 123, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-07-24 05:10:16', '2025-07-24 05:10:16'),
(318, NULL, 124, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-07-24 05:10:58', '2025-07-24 05:10:58'),
(319, NULL, 124, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-07-24 05:10:58', '2025-07-24 05:10:58'),
(328, NULL, 125, '45', '\"[null]\"', 566.00, 8, 520.72, '2025-07-24 05:58:34', '2025-07-24 05:58:34'),
(329, NULL, 126, '45.6', '\"[\\\"golden\\\"]\"', 4567.00, 3, 4429.99, '2025-07-24 05:59:41', '2025-07-24 05:59:41'),
(330, NULL, 127, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-07-24 06:01:03', '2025-07-24 06:01:03'),
(331, NULL, 127, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-07-24 06:01:03', '2025-07-24 06:01:03'),
(332, NULL, 128, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-24 06:01:03', '2025-07-24 06:01:03'),
(333, NULL, 128, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-07-24 06:01:03', '2025-07-24 06:01:03'),
(334, NULL, 129, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-07-24 06:01:04', '2025-07-24 06:01:04'),
(335, NULL, 129, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-07-24 06:01:04', '2025-07-24 06:01:04'),
(342, NULL, 130, '1.69', '\"[\\\"yellow\\\"]\"', 8.00, 0.1, 7.992, '2025-07-30 08:42:17', '2025-07-30 08:42:17'),
(353, NULL, 131, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-07-31 10:09:09', '2025-07-31 10:09:09'),
(354, NULL, 131, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-07-31 10:09:09', '2025-07-31 10:09:09'),
(355, NULL, 132, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-07-31 10:09:09', '2025-07-31 10:09:09'),
(356, NULL, 132, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-07-31 10:09:09', '2025-07-31 10:09:09'),
(357, NULL, 133, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-07-31 10:09:09', '2025-07-31 10:09:09'),
(358, NULL, 133, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-07-31 10:09:09', '2025-07-31 10:09:09'),
(360, NULL, 134, '7.9', '\"[\\\"test\\\"]\"', 999.00, 9, 909.09, '2025-08-02 02:43:56', '2025-08-02 02:43:56'),
(361, NULL, 135, '67.7', '\"[\\\"golden test\\\"]\"', 789.00, 9, 717.99, '2025-08-02 02:46:11', '2025-08-02 02:46:11'),
(362, NULL, 136, '7', '\"[\\\"test\\\"]\"', 7.00, 7, 6.51, '2025-08-02 02:59:43', '2025-08-02 02:59:43'),
(363, NULL, 137, '7', '\"[\\\"silver\\\"]\"', 7.00, 7, 6.51, '2025-08-02 03:08:57', '2025-08-02 03:08:57'),
(364, NULL, 138, '6', '\"[\\\"s\\\"]\"', 6.00, 6, 5.64, '2025-08-02 03:32:41', '2025-08-02 03:32:41'),
(365, NULL, 139, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-08-02 03:34:30', '2025-08-02 03:34:30'),
(366, NULL, 139, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-08-02 03:34:30', '2025-08-02 03:34:30'),
(367, NULL, 140, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-08-02 03:34:30', '2025-08-02 03:34:30'),
(368, NULL, 140, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-08-02 03:34:30', '2025-08-02 03:34:30'),
(369, NULL, 141, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-08-02 03:34:30', '2025-08-02 03:34:30'),
(370, NULL, 141, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-08-02 03:34:30', '2025-08-02 03:34:30'),
(371, NULL, 142, '7', '\"[\\\"color\\\"]\"', 7.00, 7, 6.51, '2025-08-02 03:40:48', '2025-08-02 03:40:48'),
(372, NULL, 143, '7', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 700.00, 7, 651, '2025-08-02 04:08:02', '2025-08-02 04:08:02'),
(373, NULL, 143, '8', '\"[\\\"silver\\\",\\\"golden\\\"]\"', 800.00, 8, 736, '2025-08-02 04:08:02', '2025-08-02 04:08:02'),
(374, NULL, 144, '7', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 900.00, 9, 819, '2025-08-02 04:08:02', '2025-08-02 04:08:02'),
(375, NULL, 144, '10', '\"[\\\"golden\\\",\\\"silver\\\"]\"', 879.00, 23, 676.83, '2025-08-02 04:08:02', '2025-08-02 04:08:02'),
(376, NULL, 145, '7', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 999.00, 0, 999, '2025-08-02 04:08:02', '2025-08-02 04:08:02'),
(377, NULL, 145, '10', '\"[\\\"gold\\\",\\\"silver\\\"]\"', 888.00, 22, 692.64, '2025-08-02 04:08:02', '2025-08-02 04:08:02'),
(378, NULL, 146, '88', '\"[\\\"golden\\\"]\"', 888.00, 8, 816.96, '2025-08-02 04:09:24', '2025-08-02 04:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('p7eSW6U9dJpIcoHzq1Nhz7vGneI1QDYFIYdFPYOg', 75, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiN0FDMDlZR1YxR0k4Mm1YT1hJZVRmeGZsbG5ONGFtWWVOc1F1MWMwVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teS1vcmRlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZWRpdC1wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NzU7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU1MDc0MTMwO319', 1755074957),
('pfRWt9MSTdeEGZljZZMDDZN6npTdmQB0UXWe19pE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic1JxRHhOZ2tzUTVwZEIyNldtN3JqaUVCTHNiR0JrdElGRFdLNm1jeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wYXltZW50cy9USF8xNzU1MDY3NTk1Xzc1L2RldGFpbHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1NTA2ODU0OTt9fQ==', 1755069762);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `title`, `description`, `image`, `category_id`, `created_at`, `updated_at`) VALUES
(15, 'Wooden', NULL, '1751284910.png', 19, '2025-06-13 00:20:49', '2025-07-24 03:49:40'),
(19, 'Metal', NULL, '1751284997.png', 19, '2025-06-22 00:00:39', '2025-07-24 03:49:58'),
(20, 'Crystal', NULL, '1751973877.png', 19, '2025-06-22 00:02:17', '2025-07-08 09:24:37'),
(21, 'Acrylic', NULL, '1751285130.png', 19, '2025-06-22 00:02:31', '2025-07-24 03:50:08'),
(22, 'Resin', NULL, '1751285149.png', 19, '2025-06-22 00:02:55', '2025-07-24 03:50:40'),
(23, 'Fiber', NULL, '1751285161.png', 19, '2025-06-22 00:03:09', '2025-07-24 03:51:00'),
(24, 'Marble', NULL, '1751285171.png', 19, '2025-06-22 00:03:24', '2025-07-24 03:51:44'),
(25, 'Plaques', NULL, '1751285191.png', 19, '2025-06-22 00:03:40', '2025-07-24 03:51:53'),
(27, 'Key Chain', NULL, '1751285379.png', 21, '2025-06-22 00:06:10', '2025-07-24 03:53:36'),
(28, 'Pen & Diary', NULL, '1751285391.png', 21, '2025-06-22 00:06:33', '2025-07-24 03:52:08'),
(29, 'Mobile Stand', NULL, '1751285427.png', 21, '2025-06-22 00:06:46', '2025-07-24 03:52:19'),
(30, 'Pen Stand', NULL, '1751285438.png', 21, '2025-06-22 00:07:02', '2025-07-24 03:52:36'),
(31, 'Bottles & Mugs', NULL, '1751285457.png', 21, '2025-06-22 00:07:23', '2025-06-30 06:40:57'),
(32, 'Coffee Mugs', NULL, '1751285466.png', 21, '2025-06-22 00:07:42', '2025-07-24 03:52:52'),
(34, 'Pin', NULL, '1753285037.jpg', 20, '2025-07-23 13:37:17', '2025-07-23 13:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `role` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `author`, `role`, `image`, `testimonial`, `created_at`, `updated_at`) VALUES
(10, 'Author 1', 'tests', '1750502413.png', 'bst services', '2025-06-21 05:10:13', '2025-06-21 05:10:13'),
(11, 'author2', 'test2', '1750502435.png', 'best products', '2025-06-21 05:10:35', '2025-06-21 05:10:35'),
(12, 'author 3', 'test4', '1750502467.png', 'nice people', '2025-06-21 05:11:07', '2025-06-21 05:11:07'),
(13, 'author 4', 'test5', '1750502511.png', 'good atmosphere', '2025-06-21 05:11:51', '2025-06-21 05:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `google_id` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `profile_img` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `birthday`, `designation`, `email_verified_at`, `password`, `role`, `google_id`, `status`, `profile_img`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test admin', 'admin@gmail.com', NULL, NULL, NULL, '2025-05-21 03:25:09', '$2y$12$/g06o1sge.yFsGNoPM0EA..m25vDhWSqlV.CwxAWFo1MD5wwti/TS', 1, NULL, 0, NULL, '3Q1YkeKmq5guXFj1BiPLJKqrsm7nq0DQohDhO6oRbl5VlmZySA2sd5fk0h5j', '2025-05-21 03:25:10', '2025-05-21 03:25:10'),
(2, 'user', 'user@gmail.com', NULL, NULL, NULL, '2025-05-21 09:18:30', 'scakj342k@#KBK$H#b', 0, NULL, 0, NULL, NULL, NULL, NULL),
(4, 'Yadnesh', 'yadnesh@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$sX6WceiKI1/9ta44FQcLgu8TnFQbo/5FRTr90CGn3rIipT785hFvi', 0, NULL, 0, NULL, NULL, '2025-06-19 23:57:42', '2025-06-19 23:57:42'),
(5, 'Chetan shelake', 'chetanshelake147@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, '106191124320301942138', 0, NULL, NULL, '2025-06-23 03:55:40', '2025-06-23 03:55:40'),
(6, 'Mayur Jawale', 'mayurjawale999@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, '116389741486347225528', 0, '175462612215.jpg', NULL, '2025-06-24 01:20:14', '2025-08-08 02:08:42'),
(8, 'mannat', 'mann@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$waot5GjgrpxaWJnbOIy88eYucOEpSaJQL3d.fIafnY9RVwuEZaxlK', 0, NULL, 0, NULL, NULL, '2025-07-02 06:20:22', '2025-07-02 06:20:22'),
(9, 'Priyanka Kakulate', 'priyankakakulate111@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, '112075610103887002776', 0, NULL, NULL, '2025-07-08 10:10:18', '2025-07-08 10:10:18'),
(10, 'mayur jawale', 'mj@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$8XBcl4X6UtPxPgmK790BYuWA9lLC7rYNqdDwW410tJ3V608pb8HTi', 0, NULL, 0, NULL, NULL, '2025-07-21 03:55:27', '2025-07-21 03:55:27'),
(11, 'mayur jawale', 'mjfdfd@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$GbsXth3XRKkoXYgcaRESZuAUdnn5bS.GlDm3LNXZfM.O/CDwQmwJ2', 0, NULL, 0, NULL, NULL, '2025-07-24 08:13:18', '2025-07-24 08:13:18'),
(12, 'abc', 'abc@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$JqDEm5PXHEDRdNOydm5j.Ol/88IK.v8PlvO5oPRpjXuLoMjmrhfSC', 0, NULL, 0, NULL, NULL, '2025-07-24 08:20:21', '2025-07-24 08:20:21'),
(13, 'prathamesh', 'rathodprathamesh23@gamil.com', NULL, NULL, NULL, NULL, '$2y$12$FlCTNUba4nMDEqjRt.A7H.Wiv6LJxjLdetKf51fz9TPkGgCJt9mzS', 0, NULL, 0, NULL, NULL, '2025-07-24 08:38:16', '2025-07-24 08:38:16'),
(20, 'Bairagi Sonali', 'bairagisonali2019@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, '107975398823289643507', 0, NULL, NULL, '2025-07-24 08:49:51', '2025-07-24 08:49:51'),
(29, 'abcddcsvgbbe', 'abfdvc@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$nARoc5NJmgEoaMgfYNexWOOvNnvCCKIwjfESEaO1vhWFwedbSVApq', 0, NULL, 0, NULL, NULL, '2025-07-24 08:59:53', '2025-07-24 08:59:53'),
(32, 'santosh', 'santosh@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$LvXlOtUiCFiBx9IEMHneT.L.0vjEttROioZaBmOk4lWPr4ubgAgcK', 0, NULL, 0, NULL, NULL, '2025-07-25 07:12:58', '2025-07-25 07:12:58'),
(36, 'santosh', 'santoshi@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$01868EpW8fRXnG/AJgjEduThIQKYyheSMZetqyOyCRUsvQ1gH9.Ei', 0, NULL, 0, NULL, NULL, '2025-07-25 10:11:38', '2025-07-25 10:11:38'),
(37, 'prathamesh', 'rathodprathamesh23@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$wVOGTjtI0uQF897UEiUuNOOZw4RGdA/qXTyUsHB5kGN301qY05OVe', 0, NULL, 0, NULL, NULL, '2025-07-27 10:49:13', '2025-07-27 10:49:13'),
(40, 'prathameshh', 'rathodprathameshh23@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$JZ/zXsy0TPwqS2lW5YJLjud8/X2vCvr1z1rRKesdztkoT2ov4kO8y', 0, NULL, 0, NULL, NULL, '2025-07-27 14:39:28', '2025-07-27 14:39:28'),
(41, 'pratham', 'rathodpratham23@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$6uiuOmWkZimBhhTloYzHC.Z15c5APLKSkmP7OidMidOgJcM2OZKVm', 0, NULL, 0, NULL, NULL, '2025-07-27 14:44:12', '2025-07-27 14:44:12'),
(42, 'samiksha', 'samikshapatil@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$pwu1JcPiEBpXv3CFFQfCduY6H9vSlb7D0cqZ7kM51hfp5pBf5r18S', 0, NULL, 0, NULL, NULL, '2025-07-27 15:49:40', '2025-07-27 15:49:40'),
(44, 'prathamee', 'rathodprathamee23@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$4.mBrAUsXuznVvEUvqpY8uGyE4LwytkV3LfUjj/ZoDfD3zVWUsLbK', 0, NULL, 0, NULL, NULL, '2025-07-27 16:06:24', '2025-07-27 16:06:24'),
(45, 'pratik', 'pratik@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$FaZjV7RWEH1.6yqkfivpI.QrkKrXfQ.dFy7NBpCZgyETN1sXaq2a2', 0, NULL, 0, NULL, NULL, '2025-07-28 02:59:03', '2025-07-28 02:59:03'),
(48, 'mayur', 'mayurgg@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$vGCYwIaj2Q7E8Nwh8M20zOgelyO0ksWA9jvtxlCDefN7DYSy.c9h2', 0, NULL, 0, NULL, NULL, '2025-07-28 03:03:07', '2025-07-28 03:03:07'),
(49, 'maauuuu', 'mmmmmmmmm@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$/CACkGbXqQtQX8ppVkiCdeaRy/gOVjjGuM3PeoW2orEJZ4BI7FKSq', 0, NULL, 0, NULL, NULL, '2025-07-28 03:58:16', '2025-07-28 03:58:16'),
(50, 'maya jawale', 'mu@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$UIPW5tve.Tf5GFHHPoRSmuahupxiulzDGUtEwVJxph2HBMtnyymva', 0, NULL, 0, NULL, NULL, '2025-07-28 07:28:51', '2025-07-28 07:28:51'),
(52, 'shaam', 'shaam@gmail.com', '0000000000', NULL, NULL, NULL, '$2y$12$rKqOLQyUAbEzZ.bXx.eX3ehE2jDjt1I10SclmX8xIt.1OOvAuE0JO', 0, NULL, 0, NULL, NULL, '2025-07-31 05:30:34', '2025-07-31 05:30:34'),
(53, 'junaid shaikh', 'shaikhjunaid7548@gmail.com', '9307333450', NULL, NULL, NULL, '$2y$12$LqhwrKQHQkzAYq8FsLvIkeqmC0s2tdXO7vvh6XkIdu/Jgnx4NwTgC', 0, NULL, 0, NULL, NULL, '2025-07-31 06:27:51', '2025-07-31 06:27:51'),
(56, 'MJ JAWALE', 'mj3489894@gmail.com', '9172593150', NULL, NULL, NULL, '$2y$12$wJHlUlvvHzcGoHSp/baL.urZ9z.NZEwMsfkCC0Kq2v5bLAyokxKmi', 0, NULL, 0, NULL, NULL, '2025-07-31 07:44:01', '2025-07-31 07:44:01'),
(57, 'maauuuu', 'mjmayur@gmail.com', '9012454224', NULL, NULL, NULL, '$2y$12$QD/xBQ.moK4tednRuMB6hOta/L980szvn9yuQQJLp2.eaQEcqIlGG', 0, NULL, 0, NULL, NULL, '2025-07-31 08:31:49', '2025-07-31 08:31:49'),
(58, 'pritesh', 'pawarr@gmail.in', '7546213522', NULL, NULL, NULL, '$2y$12$KLj9uJb9aCVvgkbq58hH1elmYGw5yASKufkUVRtTR6hHbvSTk2Jci', 0, NULL, 0, NULL, NULL, '2025-07-31 09:23:37', '2025-07-31 09:23:37'),
(59, 'vivekk', 'vivekk@gmail.com', '9898989897', NULL, NULL, NULL, '$2y$12$7otjIU1SmUexgZuFSSxr/eZXUCmu3B.yvMKXA/yj47upwzu5jwAZ6', 0, NULL, 0, '1754551300.png', NULL, '2025-07-31 09:26:09', '2025-08-08 04:33:45'),
(60, 'vishal', 'vishal@gmail.com', '9898989898', NULL, NULL, NULL, '$2y$12$vi6NnZT6AqGDSmM6tvBnSOtwgsG6yx5AKg9VA0DO.f0FGIH8D7DZ6', 0, NULL, 0, NULL, NULL, '2025-07-31 09:40:36', '2025-07-31 09:40:36'),
(61, 'nikhil', 'nikhil@gmail.com', '9898989898', NULL, NULL, NULL, '$2y$12$RF.H42jRy.UiPV/Ibo2j6eFWxzEBonisoSnBEAOpsclvM55MGfd/i', 0, NULL, 0, NULL, NULL, '2025-07-31 09:43:10', '2025-07-31 09:43:10'),
(62, 'shekhar', 'shekhar@gmail.com', '9898989898', NULL, NULL, NULL, '$2y$12$tUwREM96U5x8eJZL.0YaOuFFHuKZzFynky2w.O9hiX4ywCb4EtNja', 0, NULL, 0, NULL, NULL, '2025-07-31 09:44:09', '2025-07-31 09:44:09'),
(63, 'nikhil', 'aamin@gmail.com', '9898989898', NULL, NULL, NULL, '$2y$12$.teTIvdiR28DaEtUd1Ufn.JyiiTJ3bdCtksdrljqDQ3BmxzlGWSAa', 0, NULL, 0, NULL, NULL, '2025-07-31 09:46:12', '2025-07-31 09:46:12'),
(64, 'MJ JAWALE', 'jawale@gmail.com', '9172593150', NULL, NULL, NULL, '$2y$12$ax74F6B9Rr2TaEKwqQtdkuxxjNCHkfFOyyWtUK2k0awLdL9Vbe.he', 0, NULL, 0, NULL, NULL, '2025-07-31 09:47:10', '2025-07-31 09:47:10'),
(65, 'MJ JAWALE', 'jawalemayur@gmail.com', '9172593150', NULL, NULL, NULL, '$2y$12$KEoc4XiX6dZbhgTJCOUip.PCjzxaZksi/VbhIb6wKXrxVWrmKM9k2', 0, NULL, 0, NULL, NULL, '2025-07-31 09:47:32', '2025-07-31 09:47:32'),
(66, 'MJ JAWALE', 'junaidbhai@gmail.com', '9172593150', NULL, NULL, NULL, '$2y$12$ECyvkHRRhgqmcNgGTUCPTuYLaiNk98ue9YQ0LZ1MhtTVoYh2qmcd.', 0, NULL, 0, NULL, NULL, '2025-07-31 09:49:49', '2025-07-31 09:49:49'),
(67, 'MJ JAWALE', 'junaidbhaiyaaaaa@gmail.com', '9172593150', NULL, NULL, NULL, '$2y$12$E6fmyLXIjAfcR5AhZJgHguQVGihzQmVA4C6C7KzYQAfWZ9rTP/2VW', 0, NULL, 0, NULL, NULL, '2025-07-31 09:59:32', '2025-07-31 09:59:32'),
(68, 'saaaii', 'saii@gmail.com', '8888888888', NULL, NULL, NULL, '$2y$12$fdeYQX7E.Z9juYiy2xN5auB77sMFcO51tcunH/.m1ZhVz.AI0zkcG', 0, NULL, 0, NULL, NULL, '2025-07-31 10:03:44', '2025-07-31 10:03:44'),
(69, 'akash', 'akash@gmail.com', '8888888232', NULL, NULL, NULL, '$2y$12$A95UJhKbw.9d0y9ZVNXdQ.zkspoQykcpy1RhEcFoVZThSP1.emOXO', 0, NULL, 0, NULL, NULL, '2025-07-31 10:06:03', '2025-07-31 10:06:03'),
(70, 'ganesh', 'ganesh@gmail.com', '8888888887', NULL, NULL, NULL, '$2y$12$dTiEz9kDzZ6MGMbqVMFsKuT7fZu1pJnx59H09dMM23p3kIHmVWa6S', 0, NULL, 0, NULL, NULL, '2025-08-01 02:47:51', '2025-08-01 02:47:51'),
(71, 'chetan', 'chetan@gmail.com', '8585858585', NULL, NULL, NULL, '$2y$12$SLUziLuPk0MfRtZahFA5puC6PNQRtvVop7lvEEP2gd26lZzj8HZUi', 0, NULL, 0, NULL, NULL, '2025-08-01 03:08:22', '2025-08-01 03:08:22'),
(72, 'rtiioh', 'rathodprathamesh2@gmail.com', '7474747474', NULL, NULL, NULL, '$2y$12$TpoOqql/brTaMTNQaT8f0OELE74Gxbg5FohMrZdU0K7F24QzNIdoe', 0, NULL, 0, NULL, NULL, '2025-08-01 03:40:39', '2025-08-01 03:40:39'),
(73, 'pratham', 'rathodpratham@gmail.com', '7757872455', NULL, NULL, NULL, '$2y$12$q6Xv67WEzlPOFYrMQmqRneoqrNkkiXx5x.NtQUhmr.ULQmCN/rCkK', 0, NULL, 0, NULL, NULL, '2025-08-01 07:48:35', '2025-08-01 07:48:35'),
(74, 'samiksha', 'samiksha@gmail.com', '7757872474', NULL, NULL, NULL, '$2y$12$pgdjJqt7x70JI9Lf6Jsrw.q6DVUVK9wVTi3t6L7Om7QCSMPr2gQa.', 0, NULL, 0, NULL, NULL, '2025-08-01 08:26:48', '2025-08-01 08:26:48'),
(75, 'mayur', 'mayur@gmail.com', '9096879903', NULL, NULL, NULL, '$2y$12$ma.b44RssQ0sfmIjv1S8tOkXwE29EtgQo5ri14YtTabWTChtZej72', 0, NULL, 0, '1754125833210.jpg', NULL, '2025-08-02 03:26:32', '2025-08-13 01:01:14'),
(81, 'pratham', 'pratham@gmail.com', '7777777777', NULL, NULL, NULL, '$2y$12$w/GZ2lQX6R47LYxOJ24H5O3tn8s6H8NZCrkpE1kStu9Yyi5Vb3G0W', 0, NULL, 0, '1754641348.jpg', NULL, '2025-08-08 02:47:07', '2025-08-08 06:22:28'),
(82, 'vivek', 'vivek@gmail.com', '8888888877', NULL, NULL, NULL, '$2y$12$FLhPzVfaCsH/6lqFk/QM4.6NQbd8JuaxqTW50C1mNXe7A7nS/j6om', 0, NULL, 0, NULL, NULL, '2025-08-08 07:05:28', '2025-08-08 07:05:28'),
(83, 'new designer', 'design@gmail.com', '78675764', '2025-08-15', NULL, NULL, '$2y$12$XUN/zLCY/xSpKf0lHUlvMu4Hh1y5PqBaGb/c7yvLggMEfy2U1eOPm', 2, NULL, 0, NULL, NULL, '2025-08-08 07:50:22', '2025-08-08 07:50:22'),
(84, 'desiner 2', 'des2@gmail.com', '3454565656', '2025-08-29', NULL, NULL, '$2y$12$ZMTtdG.T3oSR9Js9v.dS7OfR69O686y/pj4PQxftrIx..imjYvKDe', 2, NULL, 0, NULL, NULL, '2025-08-08 07:56:07', '2025-08-08 07:56:07'),
(85, 'nilesh', 'nilesh@gmail.com', '9960523475', NULL, NULL, NULL, '$2y$12$zlnpKJAB7Q4GgEqXcc8J6.fhZMq2JNh.2WqGYv91zv4iC/bAB9h82', 0, NULL, 0, NULL, NULL, '2025-08-08 09:33:16', '2025-08-08 09:33:16'),
(86, 'nilesh', 'pathaknilesh1998@gmail.com', '9834705267', NULL, NULL, NULL, '$2y$12$SUBUyH0GX8sdL/BXY1Y3f.1mYOGOJz4tdwikFxR4tXWBtJjrZ6veK', 0, NULL, 0, NULL, NULL, '2025-08-11 03:47:07', '2025-08-11 03:47:07'),
(87, 'shubham', 'shubhamjain@gmail.com', '124563856', NULL, NULL, NULL, '$2y$12$Pr2sfdoanV47hF1fhxVgCOFpVpEIAS2njEoLoTkvqOCIW8gJe/oS2', 0, NULL, 0, NULL, NULL, '2025-08-11 04:00:37', '2025-08-11 04:00:37'),
(88, 'sneha', 'sneha@gmail.com', '265974388', NULL, NULL, NULL, '$2y$12$dE8pKknr2Hj4lm8nzI126OfP7wghMO2rgv6/HcSDA7P6JHLrbr6Ci', 0, NULL, 0, NULL, NULL, '2025-08-12 03:09:16', '2025-08-12 03:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist_items`
--

INSERT INTO `wishlist_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(95, 1, 104, 1, '2025-07-23 03:53:38', '2025-07-23 03:53:38'),
(111, 20, 108, 1, '2025-08-07 02:07:01', '2025-08-07 02:07:01'),
(112, 20, 109, 1, '2025-08-07 02:11:21', '2025-08-07 02:11:21'),
(120, 20, 83, 1, '2025-08-12 03:01:44', '2025-08-12 03:01:44'),
(121, 88, 105, 1, '2025-08-12 03:12:55', '2025-08-12 03:12:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name_unique` (`name`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customization_images`
--
ALTER TABLE `customization_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customization_images_user_id_foreign` (`user_id`),
  ADD KEY `customization_images_customization_request_id_foreign` (`customization_request_id`);

--
-- Indexes for table `customization_messages`
--
ALTER TABLE `customization_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customization_messages_customization_request_id_foreign` (`customization_request_id`),
  ADD KEY `customization_messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `customization_requests`
--
ALTER TABLE `customization_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customization_requests_user_id_foreign` (`user_id`),
  ADD KEY `customization_requests_cart_item_id_foreign` (`cart_item_id`),
  ADD KEY `customization_requests_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `occasional_products`
--
ALTER TABLE `occasional_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `occasional_products_category_id_foreign` (`category_id`),
  ADD KEY `occasional_products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `occasional_products_occasion_id_foreign` (`occasion_id`);

--
-- Indexes for table `occasions`
--
ALTER TABLE `occasions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `occasion_products`
--
ALTER TABLE `occasion_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `occasion_products_category_id_foreign` (`category_id`),
  ADD KEY `occasion_products_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_order_id_unique` (`order_id`);

--
-- Indexes for table `payment_items`
--
ALTER TABLE `payment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_items_user_id_foreign` (`user_id`),
  ADD KEY `payment_items_product_id_foreign` (`product_id`),
  ADD KEY `payment_items_payment_order_id_index` (`payment_order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`),
  ADD KEY `product_images_occasion_product_id_foreign` (`occasion_product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlist_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlist_items_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customization_images`
--
ALTER TABLE `customization_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `customization_messages`
--
ALTER TABLE `customization_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `customization_requests`
--
ALTER TABLE `customization_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `occasional_products`
--
ALTER TABLE `occasional_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `occasions`
--
ALTER TABLE `occasions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `occasion_products`
--
ALTER TABLE `occasion_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment_items`
--
ALTER TABLE `payment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=396;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customization_images`
--
ALTER TABLE `customization_images`
  ADD CONSTRAINT `customization_images_customization_request_id_foreign` FOREIGN KEY (`customization_request_id`) REFERENCES `customization_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customization_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customization_messages`
--
ALTER TABLE `customization_messages`
  ADD CONSTRAINT `customization_messages_customization_request_id_foreign` FOREIGN KEY (`customization_request_id`) REFERENCES `customization_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customization_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customization_requests`
--
ALTER TABLE `customization_requests`
  ADD CONSTRAINT `customization_requests_cart_item_id_foreign` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customization_requests_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customization_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `occasional_products`
--
ALTER TABLE `occasional_products`
  ADD CONSTRAINT `occasional_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `occasional_products_occasion_id_foreign` FOREIGN KEY (`occasion_id`) REFERENCES `occasions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `occasional_products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `occasion_products`
--
ALTER TABLE `occasion_products`
  ADD CONSTRAINT `occasion_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `occasion_products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_items`
--
ALTER TABLE `payment_items`
  ADD CONSTRAINT `payment_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_occasion_product_id_foreign` FOREIGN KEY (`occasion_product_id`) REFERENCES `occasional_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
