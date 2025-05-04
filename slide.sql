-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 04, 2025 at 08:01 AM
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
-- Database: `muji_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'nka6ic7htatpedef54eslrq35g', '2025-05-03 20:15:40', '2025-05-03 20:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `parent_id`, `status`, `created_at`) VALUES
(1, 'Thời trang nam', 'thoi-trang-nam', 'Các sản phẩm thời trang dành cho nam giới', NULL, 1, '2025-05-03 17:50:01'),
(2, 'Thời trang nữ', 'thoi-trang-nu', 'Các sản phẩm thời trang dành cho nữ giới', NULL, 1, '2025-05-03 17:50:01'),
(3, 'Điện tử', 'dien-tu', 'Các sản phẩm điện tử, công nghệ', NULL, 1, '2025-05-03 17:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `admin_reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `is_read`, `admin_reply`) VALUES
(68, 'Nguyễn Thị F', 'f@example.com', 'Thắc mắc bảo hành', 'Bảo hành sản phẩm như thế nào?', '2025-05-02 18:47:32', 1, 'hhhhhh'),
(69, 'Lê Văn G', 'g@example.com', 'Cần báo giá', 'Gửi giúp mình báo giá chi tiết nhé.', '2025-05-02 18:47:32', 0, NULL),
(70, 'Trần Thị H', 'h@example.com', 'Hủy đơn', 'Mình muốn hủy đơn hàng #12345.', '2025-05-02 18:47:32', 0, NULL),
(71, 'Phạm Văn I', 'i@example.com', 'Thêm chi tiết', 'Cho mình xin thêm ảnh thật sản phẩm.', '2025-05-02 18:47:32', 0, NULL),
(72, 'Hoàng Thị J', 'j@example.com', 'Tư vấn nhanh', 'Gọi mình sớm nhé: 0123456789', '2025-05-02 18:47:32', 1, 'kok'),
(73, 'Nguyễn Văn K', 'k@example.com', 'Có hàng không?', 'Mẫu này còn size M không bạn?', '2025-05-02 18:47:32', 0, NULL),
(74, 'Trần Văn L', 'l@example.com', 'Góp ý web', 'Website hơi chậm, cần tối ưu.', '2025-05-02 18:47:32', 0, NULL),
(75, 'Lê Thị M', 'm@example.com', 'Ship COD?', 'Có hỗ trợ ship COD không?', '2025-05-02 18:47:32', 0, NULL),
(76, 'Phạm Văn N', 'n@example.com', 'Tư vấn thời trang', 'Combo phối đồ nam có sẵn không?', '2025-05-02 18:47:32', 0, NULL),
(77, 'Hoàng Thị O', 'o@example.com', 'Hẹn lịch', 'Mình muốn đặt lịch tư vấn offline.', '2025-05-02 18:47:32', 0, NULL),
(78, 'Nguyễn Văn P', 'p@example.com', 'Tài khoản lỗi', 'Không đăng nhập được tài khoản.', '2025-05-02 18:47:32', 0, NULL),
(79, 'Trần Thị Q', 'q@example.com', 'Hướng dẫn mua', 'Mua nhiều có giảm không?', '2025-05-02 18:47:32', 0, NULL),
(80, 'Lê Văn R', 'r@example.com', 'Cần đổi size', 'Size M chật quá, đổi size L được không?', '2025-05-02 18:47:32', 0, NULL),
(81, 'Phạm Thị S', 's@example.com', 'Thắc mắc thanh toán', 'Có hỗ trợ trả góp không?', '2025-05-02 18:47:32', 0, NULL),
(82, 'Hoàng Văn T', 't@example.com', 'Review sản phẩm', 'Rất hài lòng với chất lượng.', '2025-05-02 18:47:32', 0, NULL),
(83, 'Nguyễn Thị U', 'u@example.com', 'Gửi hóa đơn', 'Hóa đơn điện tử gửi qua email nhé.', '2025-05-02 18:47:32', 0, NULL),
(84, 'Trần Văn V', 'v@example.com', 'Tư vấn gấp', 'Gọi mình trước 5h chiều nhé.', '2025-05-02 18:47:32', 0, NULL),
(85, 'Lê Thị W', 'w@example.com', 'Mua lại', 'Mình muốn mua lại đơn cũ.', '2025-05-02 18:47:32', 0, NULL),
(86, 'Phạm Văn X', 'x@example.com', 'Thêm chi tiết', 'Sản phẩm có xuất xứ từ đâu?', '2025-05-02 18:47:32', 0, NULL),
(87, 'Hoàng Thị Y', 'y@example.com', 'Góp ý nhân viên', 'Nhân viên hỗ trợ rất tốt.', '2025-05-02 18:47:32', 0, NULL),
(88, 'Nguyễn Văn Z', 'z@example.com', 'Thắc mắc thêm', 'Mình muốn thêm thông tin sản phẩm.', '2025-05-02 18:47:32', 0, NULL),
(89, 'User AA', 'aa@example.com', 'Tư vấn đặt hàng', 'Hướng dẫn mình đặt combo.', '2025-05-02 18:47:32', 0, NULL),
(90, 'User BB', 'bb@example.com', 'Thanh toán lỗi', 'Thẻ mình bị từ chối, giúp mình với.', '2025-05-02 18:47:32', 0, NULL),
(91, 'User CC', 'cc@example.com', 'Mã giảm giá', 'Còn mã giảm nào đang chạy không?', '2025-05-02 18:47:32', 0, NULL),
(92, 'User DD', 'dd@example.com', 'Thắc mắc vận chuyển', 'Mất bao lâu để giao hàng đến HCM?', '2025-05-02 18:47:32', 0, NULL),
(93, 'Vu Minh', 'chinhtpc123@gmail.com', 'Bảo lưu kết quả học tập', 'Tôi muốn bảo lưu ạ', '2025-05-03 17:48:00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `sale_price`, `quantity`, `featured`, `status`, `created_at`) VALUES
(1, 1, 'Áo thun nam basic', 'ao-thun-nam-basic', 'Áo thun nam cổ tròn basic, chất liệu cotton 100%, mềm mại, thoáng mát.', 150000.00, 120000.00, 100, 1, 'active', '2025-05-03 17:50:01'),
(2, 1, 'Quần jean nam slim fit', 'quan-jean-nam-slim-fit', 'Quần jean nam dáng slim fit, chất liệu denim cao cấp, co giãn tốt.', 450000.00, NULL, 50, 1, 'active', '2025-05-03 17:50:01'),
(3, 2, 'Áo sơ mi nữ công sở', 'ao-so-mi-nu-cong-so', 'Áo sơ mi nữ dáng suông, phù hợp mặc đi làm, chất liệu lụa mềm mại.', 280000.00, 250000.00, 80, 1, 'active', '2025-05-03 17:50:01'),
(4, 2, 'Quần culottes nữ', 'quan-culottes-nu', 'Quần culottes nữ dáng rộng, chất liệu thoáng mát, phù hợp mùa hè.', 320000.00, NULL, 60, 0, 'active', '2025-05-03 17:50:01'),
(5, 3, 'Điện thoại Smartphone XYZ', 'dien-thoai-smartphone-xyz', 'Điện thoại thông minh với màn hình 6.5 inch, camera 48MP, pin 5000mAh.', 5000000.00, 4500000.00, 30, 1, 'active', '2025-05-03 17:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`) VALUES
(1, 1, 'MUJI/web_project/uploads/products/ao-thun-nam-1.jpg', 1, '2025-05-03 17:50:01'),
(2, 1, 'MUJI/web_project/uploads/products/ao-thun-nam-2.jpg', 0, '2025-05-03 17:50:01'),
(3, 2, 'MUJI/web_project/uploads/products/quan-jean-nam-1.jpg', 1, '2025-05-03 17:50:01'),
(4, 3, 'MUJI/web_project/uploads/products/ao-so-mi-nu-1.jpg', 1, '2025-05-03 17:50:01'),
(5, 4, 'MUJI/web_project/uploads/products/quan-culottes-nu-1.jpg', 1, '2025-05-03 17:50:01'),
(6, 5, 'MUJI/web_project/uploads/products/smartphone-1.jpg', 1, '2025-05-03 17:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE `site_info` (
  `id` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`id`, `key`, `value`) VALUES
(1, 'hotline', '0915728661'),
(2, 'address', '152 Điện Biên Phủ '),
(3, 'Company_name', 'Sakura'),
(4, 'Slogan ', 'いい製品');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'user1', '$2y$10$hGsaG4uZg5YEgSsuJz3MAOhyXlJIb4rXOk9o/hE0KWjHiUZjR6Vgy', 'user@example.com', 'Nguyễn Văn A', '0987654321', 'Hồ Chí Minh, Việt Nam', 'user', 'active', '2025-05-04 00:51:10', '2025-05-04 00:51:10'),
(2, 'admin', '$2y$10$jSKc1xWt7Tm3Hg5LzB5zOuPUW.H3FJ0tXO9HT0e.QDcYI26XUDvJW', 'admin@example.com', 'Admin System', '0123456789', 'Hồ Chí Minh, Việt Nam', 'admin', 'active', '2025-05-04 00:51:10', '2025-05-04 00:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
