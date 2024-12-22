-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 12, 2024 lúc 03:16 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `pickleballshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Joola', 'joola', 1, '2024-12-08 12:04:32', '2024-12-08 12:04:32'),
(2, 'Passion', 'passion', 1, '2024-12-08 12:04:42', '2024-12-08 12:04:42'),
(3, 'GEN 3S', 'gen-3s', 1, '2024-12-08 12:04:53', '2024-12-08 12:04:53'),
(4, 'Six Zero', 'six-zero', 1, '2024-12-08 12:05:02', '2024-12-08 12:05:02'),
(5, 'Wilson', 'wilson', 1, '2024-12-08 12:05:12', '2024-12-08 12:05:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'NULL',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `showHome` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `showHome`, `created_at`, `updated_at`) VALUES
(1, 'Vợt PickleBall', 'vot-pickleball', '1.png', '1', 'Yes', '2024-12-08 12:03:46', '2024-12-08 12:03:46'),
(2, 'Bóng PickleBall', 'bong-pickleball', '2.png', '1', 'Yes', '2024-12-08 12:03:58', '2024-12-08 12:03:58'),
(3, 'Phụ kiện PickleBall', 'phu-kien-pickleball', '3.png', '1', 'Yes', '2024-12-08 12:04:10', '2024-12-08 12:04:10'),
(4, 'Quần áo PickleBall', 'quan-ao-pickleball', '4.png', '1', 'Yes', '2024-12-08 12:04:20', '2024-12-08 12:04:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_coupons`
--

CREATE TABLE `discount_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `max_uses` int(11) DEFAULT NULL,
  `max_uses_user` int(11) DEFAULT NULL,
  `type` enum('percent','fixed') NOT NULL DEFAULT 'fixed',
  `discount_amount` double(10,2) NOT NULL,
  `min_amount` double(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `start_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_18_184823_alter_users_table', 1),
(6, '2024_06_20_191448_add_avatar_to_users_table', 1),
(7, '2024_06_20_194603_create_categories_table', 1),
(8, '2024_06_25_001733_create_temp_images_table', 1),
(9, '2024_06_29_152426_create_sub_categories_table', 1),
(10, '2024_07_01_145315_create_brands_table', 1),
(11, '2024_07_02_102348_create_products_table', 1),
(12, '2024_07_02_102544_create_product_images_table', 1),
(13, '2024_07_08_171918_alter_categories_table', 1),
(14, '2024_07_08_174828_alter_products_table', 1),
(15, '2024_07_08_181427_alter_sub_categories_table', 1),
(16, '2024_07_11_183405_alter_products_table', 1),
(17, '2024_07_14_041753_alter_users_table', 1),
(18, '2024_07_15_180330_create_countries_table', 1),
(19, '2024_07_16_181853_create_orders_table', 1),
(20, '2024_07_16_182421_create_order_items_table', 1),
(21, '2024_07_16_182514_create_customer_addresses_table', 1),
(22, '2024_07_18_182946_create_shipping_charges_table', 1),
(23, '2024_07_24_165300_create_discount_coupons_table', 1),
(24, '2024_07_24_195901_alter_discount_coupons_table', 1),
(25, '2024_07_26_030507_alter_orders_table', 1),
(26, '2024_08_04_181745_alter_orders_table', 1),
(27, '2024_08_25_001717_create_wishlists_table', 1),
(28, '2024_08_28_115454_alter_users_table', 1),
(29, '2024_08_28_161217_create_pages_table', 1),
(30, '2024_08_29_194600_create_product_ratings_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` double(10,2) NOT NULL,
  `shipping` double(10,2) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_code_id` varchar(255) NOT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `grand_total` double(10,2) NOT NULL,
  `payment_status` enum('paid','not paid') NOT NULL DEFAULT 'not paid',
  `status` enum('pending','shipped','delivered') NOT NULL DEFAULT 'pending',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `order_note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `shipping_returns` text DEFAULT NULL,
  `related_product` text DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `compare_price` double(10,2) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` enum('Yes','No') NOT NULL DEFAULT 'No',
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `track_qty` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `qty` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `short_description`, `shipping_returns`, `related_product`, `price`, `compare_price`, `category_id`, `sub_category_id`, `brand_id`, `is_featured`, `sku`, `barcode`, `track_qty`, `qty`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Joola Ben Johns Hyperion 3 14mm', 'joola-ben-johns-hyperion-3-14mm', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Vợt Pickleball Joola Ben Johns Hyperion 3 14mm chính hãng giá tốt, toàn quốc</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><a href=\"https://pickleball.vn/vot-pickleball/joola-ben-johns-hyperion-3-14mm.html\" title=\"Vợt pickleball JOOLA Ben Johns Hyperion 3\" style=\"color: rgb(0, 102, 255);\"><span style=\"font-weight: 700 !important;\">Vợt pickleball JOOLA Ben Johns Hyperion 3</span></a>&nbsp;kết hợp công nghệ vợt mang tính cách mạng của&nbsp;<a href=\"https://pickleball.vn/vot-joola.html\" title=\"JOOLA\" style=\"color: rgb(0, 102, 255);\">JOOLA</a>&nbsp;với thiết kế hình cong Aero mang tính biểu tượng. Hiện&nbsp;<a href=\"https://pickleball.vn/vot-pickleball\" title=\"vợt pickleball\" style=\"color: rgb(0, 102, 255);\">vợt pickleball</a>&nbsp;này được trang bị công nghệ Propulsion Core của JOOLA, vợt này cung cấp sức mạnh bùng nổ phù hợp với cảm giác tinh tế khi đặt lại và dinks.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Được tăng cường hơn nữa nhờ độ bền của bề mặt Carbon tích điện mang lại khả năng chơi ổn định trong suốt vòng đời của vợt. Mỗi vợt&nbsp;<span style=\"font-weight: 700 !important;\">Ben Johns Hyperion 3</span>&nbsp;đi kèm với một chip NFC nhúng giúp mở khóa bảo hành kéo dài 12 tháng thông qua quy trình đăng ký dễ dàng điều hướng. Như một phần thưởng, bạn sẽ nhận được một tháng truy cập miễn phí vào nội dung độc quyền trên Ứng dụng JOola Connect.<br></p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Thông tin kỹ thuật của Ben Johns Hyperion 3 14mm</span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Bề mặt: Bề mặt carbon tích điện</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Cốt lõi: Lõi đẩy</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Lõi (mm): 14</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Kiểm soát: 96</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Sức mạnh : 98</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Quay : 98</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Được USAPA phê duyệt : Có</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Trọng lượng trung bình : 7,8oz</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chiều dài vợt : 16,5in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chiều rộng vợt : 7,5in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Loại tay cầm : Tay cầm màu xám Feel-Tec Pure</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chiều dài tay cầm : 5,5in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chu vi tay cầm* : 4.125in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><a rel=\"nofollow noopener\" href=\"https://pickleball.vn/uploads/attachment/2/joola-ben-johns-hyperion-3.pdf\" title=\"Catalog Joola Ben Johns Hyperion 3 14mm\" target=\"_blank\" style=\"color: rgb(0, 102, 255); text-decoration-line: underline; outline: 0px;\">Catalog Joola Ben Johns Hyperion 3 14mm</a></p>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Vợt Pickleball Joola Ben Johns Hyperion 3 14mm chính hãng giá tốt, toàn quốc</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><a href=\"https://pickleball.vn/vot-pickleball/joola-ben-johns-hyperion-3-14mm.html\" title=\"Vợt pickleball JOOLA Ben Johns Hyperion 3\" style=\"color: rgb(0, 102, 255);\"><span style=\"font-weight: 700 !important;\">Vợt pickleball JOOLA Ben Johns Hyperion 3</span></a>&nbsp;kết hợp công nghệ vợt mang tính cách mạng của&nbsp;<a href=\"https://pickleball.vn/vot-joola.html\" title=\"JOOLA\" style=\"color: rgb(0, 102, 255);\">JOOLA</a>&nbsp;với thiết kế hình cong Aero mang tính biểu tượng. Hiện&nbsp;<a href=\"https://pickleball.vn/vot-pickleball\" title=\"vợt pickleball\" style=\"color: rgb(0, 102, 255);\">vợt pickleball</a>&nbsp;này được trang bị công nghệ Propulsion Core của JOOLA, vợt này cung cấp sức mạnh bùng nổ phù hợp với cảm giác tinh tế khi đặt lại và dinks.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Được tăng cường hơn nữa nhờ độ bền của bề mặt Carbon tích điện mang lại khả năng chơi ổn định trong suốt vòng đời của vợt. Mỗi vợt&nbsp;<span style=\"font-weight: 700 !important;\">Ben Johns Hyperion 3</span>&nbsp;đi kèm với một chip NFC nhúng giúp mở khóa bảo hành kéo dài 12 tháng thông qua quy trình đăng ký dễ dàng điều hướng. Như một phần thưởng, bạn sẽ nhận được một tháng truy cập miễn phí vào nội dung độc quyền trên Ứng dụng JOola Connect.</p>', NULL, '', 120.00, 123.00, 1, NULL, 1, 'Yes', 'Hyperion-341', '1353', 'Yes', 2, 1, '2024-12-08 12:09:53', '2024-12-08 12:09:53'),
(2, 'Joola Tyson McGuffin Magnus 3 14mm', 'joola-tyson-mcguffin-magnus-3-14mm', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Vợt Pickleball Joola Tyson McGuffin Magnus 3 14mm chính hãng</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Được Barstool Sports mệnh danh là “Người đàn ông điện khí nhất trong thể thao”,&nbsp;<span style=\"font-weight: 700 !important;\">Tyson McGuffin</span>&nbsp;hiện có vợt đặc trưng JOOLA của riêng mình.&nbsp;<a href=\"https://pickleball.vn/vot-pickleball/joola-tyson-mcguffin-magnus-3-14mm.html\" title=\"Vợt Joola Tyson McGuffin Magnus 3\" style=\"color: rgb(0, 102, 255);\"><span style=\"font-weight: 700 !important;\">Vợt Joola Tyson McGuffin Magnus 3</span></a>&nbsp;14mm mở ra một kỷ nguyên mới trong sự nghiệp của Tyson và một cuộc cách mạng trong công nghệ vợt. Được thiết kế với màu hồng đậm để truyền tải nguồn năng lượng đỉnh cao mà Tyson mang đến cho sân đấu.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Hình dạng của Magnus 3 được lấy cảm hứng từ nền tảng quần vợt của Tyson và tạo ra tốc độ bóng đáng kinh ngạc đồng thời “chơi như thể có dây”. Người chơi Crossover Tennis sẽ thích thú với hình dạng vợt thon dài giúp mở rộng tầm với và tạo ra bề mặt đánh cực lớn.&nbsp;<span style=\"font-weight: 700 !important;\">Joola Tyson McGuffin Magnus 3 14mm</span>&nbsp;có công nghệ Propulsion Core đang chờ cấp bằng sáng chế cho phép tạo ra sức mạnh bùng nổ trên các ổ đĩa, bộ đếm và tăng tốc, nhưng với cảm giác và khả năng kiểm soát tinh tế khi đặt lại, giảm và giả</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Thông tin về Joola Tyson McGuffin Magnus 3 14mm</span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Bề mặt: Bề mặt carbon tích điện</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Cốt lõi: Lõi đẩy</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Lõi (mm): 16</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Kiểm soát: 96</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Sức mạnh : 98</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Quay : 98</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Được USAPA phê duyệt : Có</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Trọng lượng trung bình : 7,9oz</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chiều dài vợt : 16,5in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chiều rộng vợt : 7,5in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Loại tay cầm : Tay cầm màu xám Feel-Tec Pure</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Chiều dài tay cầm : 5in</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-size: 1rem;\">Chu vi tay cầm* : 4.1875in</span>m tốc.<br><br></p>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Vợt Pickleball Joola Tyson McGuffin Magnus 3 14mm chính hãng</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Được Barstool Sports mệnh danh là “Người đàn ông điện khí nhất trong thể thao”,&nbsp;<span style=\"font-weight: 700 !important;\">Tyson McGuffin</span>&nbsp;hiện có vợt đặc trưng JOOLA của riêng mình.&nbsp;<a href=\"https://pickleball.vn/vot-pickleball/joola-tyson-mcguffin-magnus-3-14mm.html\" title=\"Vợt Joola Tyson McGuffin Magnus 3\" style=\"color: rgb(0, 102, 255);\"><span style=\"font-weight: 700 !important;\">Vợt Joola Tyson McGuffin Magnus 3</span></a>&nbsp;14mm mở ra một kỷ nguyên mới trong sự nghiệp của Tyson và một cuộc cách mạng trong công nghệ vợt. Được thiết kế với màu hồng đậm để truyền tải nguồn năng lượng đỉnh cao mà Tyson mang đến cho sân đấu.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Hình dạng của Magnus 3 được lấy cảm hứng từ nền tảng quần vợt của Tyson và tạo ra tốc độ bóng đáng kinh ngạc đồng thời “chơi như thể có dây”. Người chơi Crossover Tennis sẽ thích thú với hình dạng vợt thon dài giúp mở rộng tầm với và tạo ra bề mặt đánh cực lớn.&nbsp;<span style=\"font-weight: 700 !important;\">Joola Tyson McGuffin Magnus 3 14mm</span>&nbsp;có công nghệ Propulsion Core đang chờ cấp bằng sáng chế cho phép tạo ra sức mạnh bùng nổ trên các ổ đĩa, bộ đếm và tăng tốc, nhưng với cảm giác và khả năng kiểm soát tinh tế khi đặt lại, giảm và giảm tốc.<br><br></p>', NULL, '', 234.00, 250.00, 1, NULL, 1, 'Yes', 'Magnus-314', '2326526', 'Yes', 3, 1, '2024-12-08 12:11:53', '2024-12-08 12:11:53'),
(3, 'Bóng Pickleball Joola Primo 4 quả', 'bong-pickleball-joola-primo-4-qua', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Pickleball Joola Primo 4 quả</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Pickleball Joola Primo</span>&nbsp;là sự lựa chọn lý tưởng cho các giải đấu và giải trí. Những quả&nbsp;<span style=\"font-weight: 700 !important;\">bóng Pickleball</span>&nbsp;ngoài trời chính thức này có đường kính 74 mm và nặng 26 gram.&nbsp;<span style=\"font-weight: 700 !important;\">Bóng pickleball</span>&nbsp;cân bằng tốt giảm thiểu hiệu ứng lắc lư và cho phép sử dụng tốt hơn với máy ném bóng.</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Thông tin của bóng Pickleball Joola Primo</span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Khối lượng tịnh (g): 26<br>Trọng lượng (tính bằng kg): 0,104</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Các lựa chọn mua bóng Primo 3 Star</span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Primo 3 Star - 4 Pack = 305.000đ<br>Primo 3 Star - 20 Pack = 1.3000.000đ<br>Primo 3 Star - 100 Pack = 5.200.000đ</p>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Pickleball Joola Primo 4 quả</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Pickleball Joola Primo</span>&nbsp;là sự lựa chọn lý tưởng cho các giải đấu và giải trí. Những quả&nbsp;<span style=\"font-weight: 700 !important;\">bóng Pickleball</span>&nbsp;ngoài trời chính thức này có đường kính 74 mm và nặng 26 gram.&nbsp;<span style=\"font-weight: 700 !important;\">Bóng pickleball</span>&nbsp;cân bằng tốt giảm thiểu hiệu ứng lắc lư và cho phép sử dụng tốt hơn với máy ném bóng.</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Thông tin của bóng Pickleball Joola Primo</span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Khối lượng tịnh (g): 26<br>Trọng lượng (tính bằng kg): 0,104</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Các lựa chọn mua bóng Primo 3 Star</span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Primo 3 Star - 4 Pack = 305.000đ<br>Primo 3 Star - 20 Pack = 1.3000.000đ<br>Primo 3 Star - 100 Pack = 5.200.000đ</p>', NULL, '', 13.00, 14.00, 2, NULL, 1, 'No', 'bong-4', '321651', 'Yes', 10, 1, '2024-12-08 12:13:21', '2024-12-08 12:13:21'),
(4, 'Bóng Pickleball Passion 4 quả', 'bong-pickleball-passion-4-qua', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion chính hãng</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng pickleball</span>&nbsp;hãng Passion chất lượng được sử dụng trong các trận đấu Pickleball đỉnh cao với khả năng chơi tuyệt vời. Sản phẩm chính hãng&nbsp;<span style=\"font-weight: 700 !important;\">Passion USA</span>&nbsp;được phân phối bởi Pickleball Việt Nam</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Passion</span>&nbsp;được thiết kế đặc biệt để mang lại chất lượng phù hợp và hiệu suất tối ưu trên bề mặt sân</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng pickleball Passion</span>&nbsp;được thiết kế với 26 lỗ chính xác cho cân bằng và độ xoáy chặt chẽ, đáng tin cậy phù hợp</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Những&nbsp;<span style=\"font-weight: 700 !important;\">quả bóng pickleball Passion</span>&nbsp;kích thước và trọng lượng chính thức này được chấp thuận cho giải đấu tại Việt Nam</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Passion</span>&nbsp;được thiết kế với thiết kế hai mảnh để mang lại hiệu suất cao, lâu dài</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Các lựa chọn mua bóng Passion:</span></h3><ul style=\"margin-bottom: 10px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><li><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion USA</span>&nbsp;4 quả = 200.000đ</li><li><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion USA</span>&nbsp;20 quả = 1.000.000đ</li><li><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion USA</span>&nbsp;50 quả = 2.500.000đ</li><li><span style=\"font-weight: 700 !important;\">Bóng Passion USA</span>&nbsp;100 quả = 5.000.000đ</li></ul>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion chính hãng</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng pickleball</span>&nbsp;hãng Passion chất lượng được sử dụng trong các trận đấu Pickleball đỉnh cao với khả năng chơi tuyệt vời. Sản phẩm chính hãng&nbsp;<span style=\"font-weight: 700 !important;\">Passion USA</span>&nbsp;được phân phối bởi Pickleball Việt Nam</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Passion</span>&nbsp;được thiết kế đặc biệt để mang lại chất lượng phù hợp và hiệu suất tối ưu trên bề mặt sân</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng pickleball Passion</span>&nbsp;được thiết kế với 26 lỗ chính xác cho cân bằng và độ xoáy chặt chẽ, đáng tin cậy phù hợp</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Những&nbsp;<span style=\"font-weight: 700 !important;\">quả bóng pickleball Passion</span>&nbsp;kích thước và trọng lượng chính thức này được chấp thuận cho giải đấu tại Việt Nam</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Bóng Passion</span>&nbsp;được thiết kế với thiết kế hai mảnh để mang lại hiệu suất cao, lâu dài</p><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Các lựa chọn mua bóng Passion:</span></h3><ul style=\"margin-bottom: 10px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><li><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion USA</span>&nbsp;4 quả = 200.000đ</li><li><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion USA</span>&nbsp;20 quả = 1.000.000đ</li><li><span style=\"font-weight: 700 !important;\">Bóng Pickleball Passion USA</span>&nbsp;50 quả = 2.500.000đ</li><li><span style=\"font-weight: 700 !important;\">Bóng Passion USA</span>&nbsp;100 quả = 5.000.000đ</li></ul>', NULL, '', 10.00, 10.50, 2, NULL, 2, 'No', 'bong-4-passion', '2318651', 'Yes', 3, 1, '2024-12-08 12:14:39', '2024-12-08 12:14:39'),
(5, 'Balo Joola Tour Elite Pro Bags Navy & Yellow', 'balo-joola-tour-elite-pro-bags-navy-yellow', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Tour Elite Pro Bags Navy &amp; Yellow Balo Joola chính hãng</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Tour Elite Pro Bags Navy &amp; Yellow Balo Joola chính hãng, phong cách đang được đông đảo người chơi Pickleball yêu thích. Tour Elite Pro Bags Navy &amp; Yellow có kích thước 16 x 24 x 11 inch, được thiết kế tối ưu hóa với không gian rộng rãi bao gồm 8 ngăn khóa. Trong đó, ngăn chính được dùng để chứa đồ đạc, quần áo...2 ngăn đựng vợt 2 bên, mỗi ngăn có thể chứa được 2 cây vợt pickleball. Xung quanh Balo là 4 ngăn đựng phụ kiện và 1 ngăn để giày riêng biệt.<br></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Tour Elite Pro Bags Navy &amp; Yellow Balo Joola có thể gọi là túi và cũng có thể nói là Vali, bởi nó được thiết kế một cách linh hoạt với các dây đeo, tay xách để bạn có thể linh hoạt sử dụng. Tour Elite Pro Bags Navy &amp; Yellow khác với bản bình thường ở điểm, nó không có nhiều họa tiết bên ngoài mà thay vào đó là sự đơn giản với Logo của hãng.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Tour Elite Pro Bags Navy &amp; Yellow Balo Joola chính hãng cũng được làm từ chất liệu cao cấp, các ngăn đựng vợt được thiết kế với lớp lót cách nhiệt, đảm bảo cho vợt ổn định hơn trước sự thay đổi nhiệt của môi trường bên ngoài.</p>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Tour Elite Pro Bags Navy &amp; Yellow Balo Joola chính hãng</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Tour Elite Pro Bags Navy &amp; Yellow Balo Joola chính hãng, phong cách đang được đông đảo người chơi Pickleball yêu thích. Tour Elite Pro Bags Navy &amp; Yellow có kích thước 16 x 24 x 11 inch, được thiết kế tối ưu hóa với không gian rộng rãi bao gồm 8 ngăn khóa. Trong đó, ngăn chính được dùng để chứa đồ đạc, quần áo...2 ngăn đựng vợt 2 bên, mỗi ngăn có thể chứa được 2 cây vợt pickleball. Xung quanh Balo là 4 ngăn đựng phụ kiện và 1 ngăn để giày riêng biệt.</p>', NULL, '', 37.00, 39.00, 3, NULL, 1, 'Yes', 'balo-joola-yl', '54564', 'Yes', 2, 1, '2024-12-08 12:16:34', '2024-12-08 12:16:34'),
(6, 'Joola Vision II Deluxe Backpack (Pink)', 'joola-vision-ii-deluxe-backpack-pink', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Joola Vision II Deluxe Backpack (Pink)</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><a href=\"https://pickleball.vn/phu-kien-pickleball/joola-vision-ii-deluxe-backpack-pink.html\" title=\"Joola Vision II Deluxe\" style=\"color: rgb(0, 102, 255);\"><span style=\"font-weight: 700 !important;\">Joola Vision II Deluxe</span></a>&nbsp;với 10 ngăn và một ngăn chính rộng rãi, chiếc túi này có đủ không gian bạn cần để đóng gói tất cả các vật dụng cần thiết và hơn thế nữa. Chiếc&nbsp;<a href=\"https://pickleball.vn/tui-balo-pickleball.html\" title=\"Balo Pickleball Joola\" style=\"color: rgb(0, 102, 255);\">Balo Pickleball Joola</a>&nbsp;này có thể chứa tối đa 4 Vợt Pickleball yêu thích của bạn và nhiều hơn nữa trong ngăn chính. Một ngăn đựng máy tính xách tay có đệm khép kín có thể chứa máy tính xách tay 17\" để giúp bạn đi làm, đi học hoặc bất cứ nơi nào khác mà đi thẳng đến sân pickleball.&nbsp;<span style=\"font-weight: 700 !important;\">Joola Vision II Deluxe Backpack</span>&nbsp;có túi bên ngoài hoàn hảo để đựng các phụ kiện nhỏ hơn và các túi lưới bên hông là nơi hoàn hảo để bạn cất giữ chai thể thao. Để hoàn thiện hơn, một ngăn đựng giày ngăn cách giày dép của bạn với các trang bị còn lại để giữ mọi thứ được sắp xếp gọn gàng.<br></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><em>Một số sản phẩm khác dòng Joola Vision bạn có thể tham khảo thêm như:</em></p><blockquote style=\"margin: 15px 0px; padding-left: 15px; font-size: 15px; border-left-width: 5px; border-left-color: rgb(38, 34, 96); color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><p style=\"margin-right: 0px; margin-left: 0px;\"><em><a href=\"https://pickleball.vn/phu-kien-pickleball/joola-vision-ii-deluxe-backpack-blue.html\" title=\"Vision II Deluxe Backpack Blue\" style=\"color: rgb(0, 102, 255);\">Vision II Deluxe Backpack Blue</a>,&nbsp;<a href=\"https://pickleball.vn/phu-kien-pickleball/tui-joola-vision-duo.html\" title=\"Túi Joola&nbsp;Vision Duo\" style=\"color: rgb(0, 102, 255);\">Túi Joola Vision Duo</a>&nbsp;,&nbsp;<a href=\"https://pickleball.vn/phu-kien-pickleball/balo-joola-tour-elite-black-yellow.html\" title=\"Joola Tour Elite Black &amp; Yellow\" style=\"color: rgb(0, 102, 255);\">Joola Tour Elite Black &amp; Yellow</a>&nbsp;,&nbsp;<a href=\"https://pickleball.vn/phu-kien-pickleball/balo-joola-tour-elite-turquoise-teal.html\" title=\"Joola Tour Elite Turquoise &amp; Teal\" style=\"color: rgb(0, 102, 255);\">Joola Tour Elite Turquoise &amp; Teal</a></em></p></blockquote><h3 style=\"line-height: 20px; color: rgb(0, 0, 0); margin: 10px 0px; font-size: 16px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Chi tiết Joola Vision II Deluxe Backpack (Pink)</span></h3><ul style=\"margin-bottom: 10px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><li>Số vợt Pickleball : 4</li><li>Kích thước : 12\"L x 8\"W x 20\"H</li><li>Chất liệu : Polyester</li><li>Ngăn đựng giày : Có</li><li>Màu sắc : Hồng</li></ul><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Balo Joola Vision II Deluxe Backpack (Pink)</span>&nbsp;có sức chứa tới 4 vợt Pickleball chắc hẳn sẽ là một sự lựa chọn tuyệt vời dành cho bạn. Hãy liên hệ với chúng tôi Pickleball Việt Nam 0.87654321.9 để được tư vấn, hỗ trợ chi tiết nhất các thông tin về sản phẩm.</p>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Joola Vision II Deluxe Backpack (Pink)</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\"><a href=\"https://pickleball.vn/phu-kien-pickleball/joola-vision-ii-deluxe-backpack-pink.html\" title=\"Joola Vision II Deluxe\" style=\"color: rgb(0, 102, 255);\"><span style=\"font-weight: 700 !important;\">Joola Vision II Deluxe</span></a>&nbsp;với 10 ngăn và một ngăn chính rộng rãi, chiếc túi này có đủ không gian bạn cần để đóng gói tất cả các vật dụng cần thiết và hơn thế nữa. Chiếc&nbsp;<a href=\"https://pickleball.vn/tui-balo-pickleball.html\" title=\"Balo Pickleball Joola\" style=\"color: rgb(0, 102, 255);\">Balo Pickleball Joola</a>&nbsp;này có thể chứa tối đa 4 Vợt Pickleball yêu thích của bạn và nhiều hơn nữa trong ngăn chính. Một ngăn đựng máy tính xách tay có đệm khép kín có thể chứa máy tính xách tay 17\" để giúp bạn đi làm, đi học hoặc bất cứ nơi nào khác mà đi thẳng đến sân pickleball.&nbsp;<span style=\"font-weight: 700 !important;\">Joola Vision II Deluxe Backpack</span>&nbsp;có túi bên ngoài hoàn hảo để đựng các phụ kiện nhỏ hơn và các túi lưới bên hông là nơi hoàn hảo để bạn cất giữ chai thể thao. Để hoàn thiện hơn, một ngăn đựng giày ngăn cách giày dép của bạn với các trang bị còn lại để giữ mọi thứ được sắp xếp gọn gàng.</p>', NULL, '', 55.00, 57.00, 3, NULL, 1, 'Yes', 'Joola-Vision-II', '3244', 'Yes', 1, 1, '2024-12-08 13:37:07', '2024-12-08 13:37:07'),
(7, 'Giày Gel-Dedicate 8 Pickleball cho nam', 'giay-gel-dedicate-8-pickleball-cho-nam', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Giày Pickleball Gel Dedicate 8 dành cho nam</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Giày Gel Dedicate 8 Pickleball dành cho nam, sở hữu thiết kế độc đáo, mang kiểu dáng khỏe khoắn, gam màu mạnh mẻ, nổi bật và tôn nên vóc dáng sức mạnh khi di chuyển. Giày Gel Dedicate 8 Pickleball của ASICS sử dụng những chất liệu cao cấp, phần trên của giày này được làm bằng lớp phủ da tổng hợp để cải thiện khả năng hỗ trợ. Chúng giữ chân bạn cố định khi bạn chuyển hướng và đuổi theo những cú đánh đầy thách thức.<br>Giày Gel Dedicate 8 Pickleball được trang bị nhiều công nghệ hiện đại, trong đó bộ phận hỗ trợ TRUSSTIC và đế ngoài bọc giúp cải thiện độ ổn định đồng thời cho phép chân bạn di chuyển tự do. Điều này cho phép bạn thay đổi hướng đi một cách tự tin hơn, đặc biệt nếu bạn đang di chuyển song song.<br>Pickleball Việt Nam hiện đang là đơn vị phân phối các sản phẩm giày Gel Dedicate 8 Pickleball chính hãng dành cho nam. Hãy liên hệ với chúng tôi 0.87654321.9 để được tư vấn, hỗ trợ chi tiết các thông tin về sản phẩm.</p>', '<h2 style=\"line-height: 22px; color: rgb(0, 0, 0); margin: 5px 0px 10px; font-size: 18px; font-family: &quot;Baloo 2&quot;, arial, cursive;\"><span style=\"font-weight: 700 !important;\">Giày Pickleball Gel Dedicate 8 dành cho nam</span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(0, 0, 0); font-family: &quot;Baloo 2&quot;, arial, cursive;\">Giày Gel Dedicate 8 Pickleball dành cho nam, sở hữu thiết kế độc đáo, mang kiểu dáng khỏe khoắn, gam màu mạnh mẻ, nổi bật và tôn nên vóc dáng sức mạnh khi di chuyển. Giày Gel Dedicate 8 Pickleball của ASICS sử dụng những chất liệu cao cấp, phần trên của giày này được làm bằng lớp phủ da tổng hợp để cải thiện khả năng hỗ trợ. Chúng giữ chân bạn cố định khi bạn chuyển hướng và đuổi theo những cú đánh đầy thách thức.</p>', NULL, '', 31.00, 36.00, 4, NULL, 3, 'Yes', 'giay-gel', '234123', 'Yes', 2, 1, '2024-12-08 13:38:43', '2024-12-08 13:38:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, '1-1-1733659793.png', NULL, '2024-12-08 12:09:53', '2024-12-08 12:09:53'),
(2, 1, '1-2-1733659794.png', NULL, '2024-12-08 12:09:54', '2024-12-08 12:09:54'),
(3, 1, '1-3-1733659794.png', NULL, '2024-12-08 12:09:54', '2024-12-08 12:09:54'),
(4, 2, '2-4-1733659913.png', NULL, '2024-12-08 12:11:53', '2024-12-08 12:11:53'),
(5, 2, '2-5-1733659913.png', NULL, '2024-12-08 12:11:53', '2024-12-08 12:11:53'),
(6, 2, '2-6-1733659914.png', NULL, '2024-12-08 12:11:54', '2024-12-08 12:11:54'),
(7, 2, '2-7-1733659914.png', NULL, '2024-12-08 12:11:54', '2024-12-08 12:11:54'),
(8, 3, '3-8-1733660001.png', NULL, '2024-12-08 12:13:21', '2024-12-08 12:13:21'),
(9, 3, '3-9-1733660001.png', NULL, '2024-12-08 12:13:21', '2024-12-08 12:13:21'),
(10, 4, '4-10-1733660079.png', NULL, '2024-12-08 12:14:39', '2024-12-08 12:14:39'),
(11, 4, '4-11-1733660079.png', NULL, '2024-12-08 12:14:39', '2024-12-08 12:14:39'),
(12, 5, '5-12-1733660194.png', NULL, '2024-12-08 12:16:34', '2024-12-08 12:16:34'),
(13, 5, '5-13-1733660195.png', NULL, '2024-12-08 12:16:35', '2024-12-08 12:16:35'),
(14, 5, '5-14-1733660196.png', NULL, '2024-12-08 12:16:36', '2024-12-08 12:16:36'),
(15, 6, '6-15-1733665027.png', NULL, '2024-12-08 13:37:07', '2024-12-08 13:37:07'),
(16, 6, '6-16-1733665027.png', NULL, '2024-12-08 13:37:07', '2024-12-08 13:37:07'),
(17, 6, '6-17-1733665028.png', NULL, '2024-12-08 13:37:08', '2024-12-08 13:37:08'),
(18, 6, '6-18-1733665028.png', NULL, '2024-12-08 13:37:08', '2024-12-08 13:37:08'),
(19, 7, '7-19-1733665161.png', NULL, '2024-12-08 13:39:21', '2024-12-08 13:39:21'),
(20, 7, '7-20-1733665161.png', NULL, '2024-12-08 13:39:21', '2024-12-08 13:39:21'),
(21, 7, '7-21-1733665162.png', NULL, '2024-12-08 13:39:22', '2024-12-08 13:39:22'),
(22, 7, '7-22-1733665163.png', NULL, '2024-12-08 13:39:23', '2024-12-08 13:39:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping_charges`
--

CREATE TABLE `shipping_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `showHome` enum('Yes','No') NOT NULL DEFAULT 'No',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '1733659424_693e7961-fee5-4ef0-b6ac-18bd44745a5f.png', '2024-12-08 12:03:44', '2024-12-08 12:03:44'),
(2, '1733659437_e7669ac7-e59e-493a-9944-b781fdff7d2e.png', '2024-12-08 12:03:57', '2024-12-08 12:03:57'),
(3, '1733659449_fdddda3a-fb61-49fe-9eff-a2dda21f0071.png', '2024-12-08 12:04:09', '2024-12-08 12:04:09'),
(4, '1733659458_daac3d65-a877-4a1a-b220-8b18f50c024c.png', '2024-12-08 12:04:18', '2024-12-08 12:04:18'),
(5, '1733659727_eb9d0896-604d-4f96-98cb-4c16ff974e27.png', '2024-12-08 12:08:47', '2024-12-08 12:08:47'),
(6, '1733659728_348fe439-7ec2-4de4-bca9-c2ca6bc3fd7c.png', '2024-12-08 12:08:48', '2024-12-08 12:08:48'),
(7, '1733659728_821b6257-8a14-46a0-a1e1-736ba7eeee48.png', '2024-12-08 12:08:48', '2024-12-08 12:08:48'),
(8, '1733659881_b1e03481-2faa-4885-90f9-c6a2b3f7e3bc.png', '2024-12-08 12:11:21', '2024-12-08 12:11:21'),
(9, '1733659881_ad798d29-c676-4737-9e1d-2cfc080105e6.png', '2024-12-08 12:11:21', '2024-12-08 12:11:21'),
(10, '1733659882_7a9c4d5c-2dda-416c-9b9a-afd148808788.png', '2024-12-08 12:11:22', '2024-12-08 12:11:22'),
(11, '1733659882_22577e95-4eb8-46b8-92d0-5a931d466993.png', '2024-12-08 12:11:22', '2024-12-08 12:11:22'),
(12, '1733659974_2e720c74-6e98-43f9-9414-d8da21324ea6.png', '2024-12-08 12:12:54', '2024-12-08 12:12:54'),
(13, '1733659974_988b4a73-54a2-44ee-8485-b13ce4c89a32.png', '2024-12-08 12:12:54', '2024-12-08 12:12:54'),
(14, '1733660050_6aa8ccfc-d088-4b90-9a63-4fe02e2f6be1.png', '2024-12-08 12:14:10', '2024-12-08 12:14:10'),
(15, '1733660050_1ea0f424-a7ae-4079-8f57-dfc9ab403167.png', '2024-12-08 12:14:10', '2024-12-08 12:14:10'),
(16, '1733660172_8631a7cd-296f-459f-a691-a9ab2ba357d4.png', '2024-12-08 12:16:12', '2024-12-08 12:16:12'),
(17, '1733660172_3b02bbdc-fed4-447b-94a7-8ba33db25e31.png', '2024-12-08 12:16:12', '2024-12-08 12:16:12'),
(18, '1733660173_0fb922a7-83d7-45fe-95cc-66c1a36923ac.png', '2024-12-08 12:16:13', '2024-12-08 12:16:13'),
(19, '1733664997_10b42de4-9044-429c-8e8d-60a6ecdc35ea.png', '2024-12-08 13:36:37', '2024-12-08 13:36:37'),
(20, '1733664997_442fdf0a-99f4-4986-85ef-ad5e4ef25bbd.png', '2024-12-08 13:36:37', '2024-12-08 13:36:37'),
(21, '1733664998_c18a30b5-f0c5-4811-b876-25da41c50e88.png', '2024-12-08 13:36:38', '2024-12-08 13:36:38'),
(22, '1733664998_3695b928-590b-4de3-802c-445725fa880e.png', '2024-12-08 13:36:38', '2024-12-08 13:36:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `avatar`, `role`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', NULL, NULL, 1, 1, '2024-12-08 12:01:17', '$2y$10$shNFUaq4.BVeWe2awnO6Qesudm.4fPtPI718a.gQuUv3Y6pn4WXh2', 'ObC9L2oVRw', '2024-12-08 12:01:17', '2024-12-08 12:01:17'),
(2, 'Nguyễn Huy Hoàng Phúc', 'phucnguyen03@gmail.com', '123345544', 'avatar-2.png', 1, 1, NULL, '$2y$10$NLploctroHSddsfrpp9vuuV7MmHP3PDBgcAE/HdVZRyqfeyoGkOue', NULL, '2024-12-08 12:21:54', '2024-12-08 12:21:54'),
(3, 'Nguyễn Huy Hoàng Phúc', 'phucnguyen@gmail.com', '123412341234', 'avatar-3.png', 1, 1, NULL, '$2y$10$wcDvmer5Kpk0JgSz6WntJukr643kLlK9kCxb3yYnQ3axs1VyiQpt6', NULL, '2024-12-08 12:22:51', '2024-12-08 12:22:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(3, 3, 7, '2024-12-09 15:12:36', '2024-12-09 15:12:36');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_addresses_user_id_foreign` (`user_id`),
  ADD KEY `customer_addresses_country_id_foreign` (`country_id`);

--
-- Chỉ mục cho bảng `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_country_id_foreign` (`country_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ratings_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
