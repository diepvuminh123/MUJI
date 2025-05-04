-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 04, 2025 at 06:39 PM
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
(68, 'Quốc Lộc ', 'f@example.com', 'Thắc mắc bảo hành', 'Bảo hành sản phẩm như thế nào?', '2025-05-02 18:47:32', 0, 'hhhhhh'),
(69, 'Lê Văn G', 'g@example.com', 'Cần báo giá', 'Gửi giúp mình báo giá chi tiết nhé.', '2025-05-02 18:47:32', 0, NULL),
(70, 'Trần Thị H', 'h@example.com', 'Hủy đơn', 'Mình muốn hủy đơn hàng #12345.', '2025-05-02 18:47:32', 0, NULL),
(71, 'Phạm Văn I', 'i@example.com', 'Thêm chi tiết', 'Cho mình xin thêm ảnh thật sản phẩm.', '2025-05-02 18:47:32', 0, NULL),
(72, 'Hoàng Thị J', 'j@example.com', 'Tư vấn nhanh', 'Gọi mình sớm nhé: 0123456789', '2025-05-02 18:47:32', 0, 'kok'),
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
(92, 'User DD', 'dd@example.com', 'Thắc mắc vận chuyển', 'Mất bao lâu để giao hàng đến HCM?', '2025-05-02 18:47:32', 0, NULL);

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
(1, 'hotline', '0915728662'),
(2, 'address', '152 Điện Biên Phủ '),
(3, 'Company_name', 'Sakura'),
(4, 'Slogan ', 'いい製品');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
