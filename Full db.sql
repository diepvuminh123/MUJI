-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 05, 2025 at 04:26 AM
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
(1, 11, '7a4ojn9apjralnv0nbsrl92hnt', '2025-05-04 20:24:37', '2025-05-05 02:03:37'),
(2, NULL, '5sflhmnblug5gc36p49crosc6b', '2025-05-05 01:51:21', '2025-05-05 07:15:47');

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
(1, 'Thời trang nam', 'thoi-trang-nam', 'Các sản phẩm thời trang dành cho nam giới', NULL, 1, '2025-05-04 18:08:53'),
(2, 'Thời trang nữ', 'thoi-trang-nu', 'Các sản phẩm thời trang dành cho nữ giới', NULL, 1, '2025-05-04 18:08:53'),
(3, 'Điện tử', 'dien-tu', 'Các sản phẩm điện tử, công nghệ', NULL, 1, '2025-05-04 18:08:53'),
(4, 'Đồ nội thất', 'do-noi-that', 'Các sản phẩm nội thất và trang trí nhà cửa', NULL, 1, '2025-05-04 18:08:53'),
(5, 'Văn phòng phẩm', 'van-phong-pham', 'Các sản phẩm văn phòng phẩm và dụng cụ học tập', NULL, 1, '2025-05-04 18:08:53'),
(6, 'Đồ gia dụng', 'do-gia-dung', 'Các sản phẩm gia dụng và nhà bếp', NULL, 1, '2025-05-04 18:08:53'),
(7, 'Chăm sóc cá nhân', 'cham-soc-ca-nhan', 'Các sản phẩm chăm sóc cá nhân và làm đẹp', NULL, 1, '2025-05-04 18:08:53'),
(8, 'Áo', 'ao', 'Các loại áo dành cho nam giới', 1, 1, '2025-05-04 18:08:53'),
(9, 'Quần', 'quan', 'Các loại quần dành cho nam giới', 1, 1, '2025-05-04 18:08:53'),
(10, 'Phụ kiện nam', 'phu-kien-nam', 'Phụ kiện thời trang nam', 1, 1, '2025-05-04 18:08:53'),
(11, 'Áo nữ', 'ao-nu', 'Các loại áo dành cho nữ giới', 2, 1, '2025-05-04 18:08:53'),
(12, 'Quần & Váy', 'quan-vay', 'Các loại quần và váy dành cho nữ giới', 2, 1, '2025-05-04 18:08:53'),
(13, 'Phụ kiện nữ', 'phu-kien-nu', 'Phụ kiện thời trang nữ', 2, 1, '2025-05-04 18:08:53'),
(14, 'Điện thoại & Máy tính bảng', 'dien-thoai-may-tinh-bang', 'Điện thoại thông minh và máy tính bảng', 3, 1, '2025-05-04 18:08:53'),
(15, 'Laptop & Máy tính', 'laptop-may-tinh', 'Laptop và phụ kiện máy tính', 3, 1, '2025-05-04 18:08:53'),
(16, 'Ghế & Sofa', 'ghe-sofa', 'Ghế, ghế đẩu và sofa', 4, 1, '2025-05-04 18:08:53'),
(17, 'Bàn', 'ban', 'Các loại bàn', 4, 1, '2025-05-04 18:08:53'),
(18, 'Giường & Chăn ga', 'giuong-chan-ga', 'Giường và đồ dùng phòng ngủ', 4, 1, '2025-05-04 18:08:53'),
(19, 'Bút & Viết', 'but-viet', 'Các loại bút và dụng cụ viết', 5, 1, '2025-05-04 18:08:53'),
(20, 'Sổ & Giấy', 'so-giay', 'Sổ tay, giấy và vở', 5, 1, '2025-05-04 18:08:53'),
(21, 'Đồ dùng nhà bếp', 'do-dung-nha-bep', 'Dụng cụ nấu ăn và đồ dùng nhà bếp', 6, 1, '2025-05-04 18:08:53'),
(22, 'Đồ dùng phòng tắm', 'do-dung-phong-tam', 'Các sản phẩm dùng trong phòng tắm', 6, 1, '2025-05-04 18:08:53'),
(23, 'Mỹ phẩm', 'my-pham', 'Các sản phẩm làm đẹp và mỹ phẩm', 7, 1, '2025-05-04 18:08:53'),
(24, 'Chăm sóc da', 'cham-soc-da', 'Sản phẩm chăm sóc da', 7, 1, '2025-05-04 18:08:53');

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
(70, 'Trần Thị H', 'h@example.com', 'Hủy đơn', 'Mình muốn hủy đơn hàng #12345.', '2025-05-02 18:47:32', 0, NULL),
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
(92, 'User DD', 'dd@example.com', 'Thắc mắc vận chuyển', 'Mất bao lâu để giao hàng đến HCM?', '2025-05-02 18:47:32', 0, NULL),
(95, 'fffffff', 'chinhtpc123@gmail.com', 'Hubn', 'em yêu', '2025-05-05 02:07:26', 0, NULL);

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
(1, 1, 'Áo thun nam basic', 'ao-thun-nam-basic', 'Áo thun nam cổ tròn basic, chất liệu cotton 100%, mềm mại, thoáng mát.', 150000.00, 120000.00, 100, 1, 'active', '2025-05-04 18:08:53'),
(2, 1, 'Quần jean nam slim fit', 'quan-jean-nam-slim-fit', 'Quần jean nam dáng slim fit, chất liệu denim cao cấp, co giãn tốt.', 450000.00, NULL, 50, 1, 'active', '2025-05-04 18:08:53'),
(3, 2, 'Áo sơ mi nữ công sở', 'ao-so-mi-nu-cong-so', 'Áo sơ mi nữ dáng suông, phù hợp mặc đi làm, chất liệu lụa mềm mại.', 280000.00, 250000.00, 80, 1, 'active', '2025-05-04 18:08:53'),
(4, 2, 'Quần culottes nữ', 'quan-culottes-nu', 'Quần culottes nữ dáng rộng, chất liệu thoáng mát, phù hợp mùa hè.', 320000.00, NULL, 60, 0, 'active', '2025-05-04 18:08:53'),
(5, 3, 'Điện thoại Smartphone XYZ', 'dien-thoai-smartphone-xyz', 'Điện thoại thông minh với màn hình 6.5 inch, camera 48MP, pin 5000mAh.', 5000000.00, 4500000.00, 30, 1, 'active', '2025-05-04 18:08:53'),
(6, 8, 'Áo polo nam AIRism', 'ao-polo-nam-airism', 'Áo polo nam chất liệu AIRism thoáng mát, thấm hút mồ hôi tốt, phù hợp mặc hàng ngày.', 290000.00, 250000.00, 120, 1, 'active', '2025-05-04 18:08:53'),
(7, 8, 'Áo thun nam cổ tròn cotton supima', 'ao-thun-nam-co-tron-cotton-supima', 'Áo thun nam chất liệu cotton supima cao cấp, mềm mại, bền màu.', 195000.00, NULL, 150, 1, 'active', '2025-05-04 18:08:53'),
(8, 8, 'Áo sơ mi nam oxford dài tay', 'ao-so-mi-nam-oxford-dai-tay', 'Áo sơ mi nam chất liệu oxford, form regular fit, dễ phối đồ.', 450000.00, 390000.00, 80, 0, 'active', '2025-05-04 18:08:53'),
(9, 8, 'Áo khoác nam chống nắng UV protection', 'ao-khoac-nam-chong-nang-uv-protection', 'Áo khoác nhẹ có khả năng chống tia UV, chất liệu mỏng nhẹ và thoáng khí.', 590000.00, NULL, 70, 1, 'active', '2025-05-04 18:08:53'),
(10, 9, 'Quần jeans nam slim-fit stretch', 'quan-jeans-nam-slim-fit-stretch', 'Quần jeans nam dáng slim-fit với chất liệu co giãn, thoải mái khi di chuyển.', 490000.00, 420000.00, 100, 1, 'active', '2025-05-04 18:08:53'),
(11, 9, 'Quần khaki nam regular-fit', 'quan-khaki-nam-regular-fit', 'Quần khaki nam form regular vừa vặn, chất vải cotton bền đẹp.', 390000.00, NULL, 85, 0, 'active', '2025-05-04 18:08:53'),
(12, 9, 'Quần short nam AIRism', 'quan-short-nam-airism', 'Quần short nam chất liệu AIRism thoáng mát, thích hợp mặc mùa hè hoặc tập thể thao.', 250000.00, 220000.00, 120, 1, 'active', '2025-05-04 18:08:53'),
(13, 10, 'Thắt lưng nam da thật', 'that-lung-nam-da-that', 'Thắt lưng nam làm từ da bò thật, khóa kim loại cao cấp, thiết kế thanh lịch.', 350000.00, NULL, 60, 0, 'active', '2025-05-04 18:08:53'),
(14, 10, 'Tất nam cổ ngắn set 3 đôi', 'tat-nam-co-ngan-set-3-doi', 'Bộ 3 đôi tất nam cổ ngắn, chất liệu cotton thấm hút tốt, nhiều màu sắc.', 120000.00, 99000.00, 200, 1, 'active', '2025-05-04 18:08:53'),
(15, 11, 'Áo thun nữ cổ tròn cotton', 'ao-thun-nu-co-tron-cotton', 'Áo thun nữ cổ tròn chất liệu cotton mềm mại, nhiều màu sắc để lựa chọn.', 180000.00, 150000.00, 180, 1, 'active', '2025-05-04 18:08:53'),
(16, 11, 'Áo sơ mi nữ linen dài tay', 'ao-so-mi-nu-linen-dai-tay', 'Áo sơ mi nữ chất liệu linen thoáng mát, dáng suông thanh lịch.', 420000.00, NULL, 90, 1, 'active', '2025-05-04 18:08:53'),
(17, 11, 'Áo len nữ cổ tròn merino', 'ao-len-nu-co-tron-merino', 'Áo len nữ chất liệu len merino mềm mại, không gây ngứa, giữ ấm tốt.', 590000.00, 490000.00, 70, 0, 'active', '2025-05-04 18:08:53'),
(18, 11, 'Áo khoác nữ dáng dài', 'ao-khoac-nu-dang-dai', 'Áo khoác nữ dáng dài, chất liệu polyester cao cấp, có thể chống nước nhẹ.', 850000.00, NULL, 50, 1, 'active', '2025-05-04 18:08:53'),
(19, 12, 'Quần jeans nữ dáng ống đứng', 'quan-jeans-nu-dang-ong-dung', 'Quần jeans nữ ống đứng, chất liệu denim co giãn, tôn dáng người mặc.', 450000.00, 390000.00, 95, 1, 'active', '2025-05-04 18:08:53'),
(20, 12, 'Váy liền thân dáng chữ A', 'vay-lien-than-dang-chu-a', 'Váy liền thân dáng chữ A, chất liệu cotton pha polyester, phù hợp mặc hàng ngày và đi làm.', 520000.00, NULL, 65, 0, 'active', '2025-05-04 18:08:53'),
(21, 12, 'Chân váy midi xếp ly', 'chan-vay-midi-xep-ly', 'Chân váy midi xếp ly thanh lịch, chất liệu polyester cao cấp, phù hợp mặc đi làm.', 450000.00, 380000.00, 60, 1, 'active', '2025-05-04 18:08:53'),
(22, 13, 'Túi xách nữ canvas', 'tui-xach-nu-canvas', 'Túi xách nữ chất liệu canvas bền đẹp, có nhiều ngăn tiện lợi, phù hợp đi làm và đi chơi.', 390000.00, NULL, 45, 1, 'active', '2025-05-04 18:08:53'),
(23, 13, 'Khăn choàng cổ nữ', 'khan-choang-co-nu', 'Khăn choàng cổ nữ chất liệu viscose mềm mại, nhiều họa tiết trang nhã.', 190000.00, 150000.00, 80, 0, 'active', '2025-05-04 18:08:53'),
(24, 14, 'Điện thoại thông minh ABC', 'dien-thoai-thong-minh-abc', 'Điện thoại thông minh với màn hình AMOLED 6.7 inch, camera 64MP, pin 5000mAh, sạc nhanh 67W.', 8500000.00, 7900000.00, 40, 1, 'active', '2025-05-04 18:08:53'),
(25, 14, 'Máy tính bảng Model Z Pro', 'may-tinh-bang-model-z-pro', 'Máy tính bảng màn hình 11 inch, chip xử lý mạnh mẽ, pin trâu, phù hợp làm việc và giải trí.', 9900000.00, NULL, 25, 1, 'active', '2025-05-04 18:08:53'),
(26, 15, 'Laptop ultrabook 14\"', 'laptop-ultrabook-14', 'Laptop mỏng nhẹ, màn hình 14 inch, chip xử lý thế hệ mới, RAM 16GB, SSD 512GB.', 18500000.00, 17000000.00, 20, 1, 'active', '2025-05-04 18:08:53'),
(27, 15, 'Chuột không dây ergonomic', 'chuot-khong-day-ergonomic', 'Chuột không dây thiết kế công thái học, giảm mỏi cổ tay, độ nhạy cao, pin sử dụng lâu.', 650000.00, NULL, 100, 0, 'active', '2025-05-04 18:08:53'),
(28, 16, 'Ghế làm việc lưng cao', 'ghe-lam-viec-lung-cao', 'Ghế làm việc lưng cao với tựa đầu, tay vịn có thể điều chỉnh, chất liệu lưới thoáng khí.', 2500000.00, 2200000.00, 30, 1, 'active', '2025-05-04 18:08:53'),
(29, 16, 'Sofa 2 chỗ ngồi', 'sofa-2-cho-ngoi', 'Sofa 2 chỗ ngồi chất liệu vải canvas cao cấp, khung gỗ tự nhiên, thiết kế tối giản.', 4900000.00, NULL, 15, 1, 'active', '2025-05-04 18:08:53'),
(30, 16, 'Ghế đẩu gỗ oak', 'ghe-dau-go-oak', 'Ghế đẩu làm từ gỗ oak tự nhiên, thiết kế tối giản, phù hợp nhiều không gian.', 850000.00, 750000.00, 40, 0, 'active', '2025-05-04 18:08:53'),
(31, 17, 'Bàn làm việc gỗ tự nhiên', 'ban-lam-viec-go-tu-nhien', 'Bàn làm việc chất liệu gỗ tự nhiên, thiết kế tối giản với ngăn kéo tiện lợi.', 3200000.00, NULL, 25, 1, 'active', '2025-05-04 18:08:53'),
(32, 17, 'Bàn coffee tròn', 'ban-coffee-tron', 'Bàn coffee hình tròn, chân kim loại sơn đen, mặt gỗ công nghiệp phủ melamine.', 1500000.00, 1299000.00, 35, 0, 'active', '2025-05-04 18:08:53'),
(33, 18, 'Giường đôi khung gỗ', 'giuong-doi-khung-go', 'Giường đôi size 1m6 x 2m, khung gỗ tự nhiên chắc chắn, thiết kế tối giản.', 5900000.00, 5200000.00, 10, 1, 'active', '2025-05-04 18:08:53'),
(34, 18, 'Bộ chăn ga gối cotton', 'bo-chan-ga-goi-cotton', 'Bộ chăn ga gối chất liệu cotton 100%, mềm mại, thoáng khí, nhiều họa tiết và màu sắc.', 1200000.00, NULL, 50, 1, 'active', '2025-05-04 18:08:53'),
(35, 19, 'Bút gel 0.38mm set 5 cây', 'but-gel-038mm-set-5-cay', 'Bộ 5 bút gel mực đen, xanh, đỏ, nâu, xanh lá, đầu kim 0.38mm, viết mượt mà.', 95000.00, 80000.00, 150, 1, 'active', '2025-05-04 18:08:53'),
(36, 19, 'Bút chì cơ khí 0.5mm', 'but-chi-co-khi-05mm', 'Bút chì cơ khí thân nhôm, ngòi 0.5mm, có thể thay ruột, thiết kế tối giản.', 120000.00, NULL, 200, 0, 'active', '2025-05-04 18:08:53'),
(37, 20, 'Sổ tay bìa cứng A5', 'so-tay-bia-cung-a5', 'Sổ tay khổ A5 bìa cứng, giấy trắng trơn 100 gsm, 192 trang, có bookmark.', 150000.00, 120000.00, 100, 1, 'active', '2025-05-04 18:08:53'),
(38, 20, 'Giấy note vuông 7.5x7.5cm', 'giay-note-vuong-75x75cm', 'Giấy note vuông 7.5x7.5cm, 100 tờ/tập, giấy màu pastel, có keo dính ở cạnh.', 25000.00, NULL, 300, 0, 'active', '2025-05-04 18:08:53'),
(39, 21, 'Nồi inox 3 đáy 24cm', 'noi-inox-3-day-24cm', 'Nồi inox 304 cao cấp 3 đáy, đường kính 24cm, nắp kính cường lực, tay cầm cách nhiệt.', 750000.00, 650000.00, 40, 1, 'active', '2025-05-04 18:08:53'),
(40, 21, 'Bộ dao nhà bếp 3 món', 'bo-dao-nha-bep-3-mon', 'Bộ 3 dao nhà bếp gồm dao thái, dao gọt, dao thớt, lưỡi thép không gỉ, cán gỗ tự nhiên.', 890000.00, NULL, 30, 1, 'active', '2025-05-04 18:08:53'),
(41, 22, 'Khăn tắm cotton 70x140cm', 'khan-tam-cotton-70x140cm', 'Khăn tắm chất liệu cotton 100%, kích thước 70x140cm, thấm hút tốt, mềm mại.', 190000.00, 150000.00, 80, 0, 'active', '2025-05-04 18:08:53'),
(42, 22, 'Giá đựng đồ phòng tắm 3 tầng', 'gia-dung-do-phong-tam-3-tang', 'Giá đựng đồ phòng tắm 3 tầng, chất liệu thép không gỉ, dễ dàng lắp đặt.', 320000.00, NULL, 45, 1, 'active', '2025-05-04 18:08:53'),
(43, 23, 'Son môi lì dưỡng ẩm', 'son-moi-li-duong-am', 'Son môi lì có chứa thành phần dưỡng ẩm, không gây khô môi, nhiều màu sắc thời trang.', 250000.00, 220000.00, 60, 1, 'active', '2025-05-04 18:08:53'),
(44, 23, 'Phấn phủ kiềm dầu', 'phan-phu-kiem-dau', 'Phấn phủ kiềm dầu, che phủ tốt, không gây bít lỗ chân lông, phù hợp da dầu và hỗn hợp.', 320000.00, NULL, 50, 0, 'active', '2025-05-04 18:08:53'),
(45, 24, 'Sữa rửa mặt dịu nhẹ 150ml', 'sua-rua-mat-diu-nhe-150ml', 'Sữa rửa mặt dịu nhẹ, không chứa sulfate, phù hợp mọi loại da, làm sạch sâu không gây khô.', 180000.00, 150000.00, 100, 1, 'active', '2025-05-04 18:08:53'),
(46, 24, 'Kem dưỡng ẩm chống nắng SPF50+ 50ml', 'kem-duong-am-chong-nang-spf50-50ml', 'Kem dưỡng ẩm tích hợp chống nắng SPF50+, bảo vệ da khỏi tia UV, không gây bít lỗ chân lông.', 390000.00, NULL, 70, 1, 'active', '2025-05-04 18:08:53');

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
(1, 1, 'MUJI/web_project/uploads/products/ao-thun-nam-1.jpg', 1, '2025-05-04 18:08:53'),
(2, 1, 'MUJI/web_project/uploads/products/ao-thun-nam-2.jpg', 0, '2025-05-04 18:08:53'),
(3, 2, 'MUJI/web_project/uploads/products/quan-jean-nam-1.jpg', 1, '2025-05-04 18:08:53'),
(4, 3, 'MUJI/web_project/uploads/products/ao-so-mi-nu-1.jpg', 1, '2025-05-04 18:08:53'),
(5, 4, 'MUJI/web_project/uploads/products/quan-culottes-nu-1.jpg', 1, '2025-05-04 18:08:53'),
(6, 5, 'MUJI/web_project/uploads/products/smartphone-1.jpg', 1, '2025-05-04 18:08:53'),
(7, 6, 'MUJI/web_project/uploads/products/ao-polo-nam-airism-1.jpg', 1, '2025-05-04 18:08:53'),
(8, 6, 'MUJI/web_project/uploads/products/ao-polo-nam-airism-2.jpg', 0, '2025-05-04 18:08:53'),
(9, 7, 'MUJI/web_project/uploads/products/ao-thun-nam-cotton-supima-1.jpg', 1, '2025-05-04 18:08:53'),
(10, 7, 'MUJI/web_project/uploads/products/ao-thun-nam-cotton-supima-2.jpg', 0, '2025-05-04 18:08:53'),
(11, 8, 'MUJI/web_project/uploads/products/ao-so-mi-nam-oxford-1.jpg', 1, '2025-05-04 18:08:53'),
(12, 9, 'MUJI/web_project/uploads/products/ao-khoac-nam-uv-1.jpg', 1, '2025-05-04 18:08:53'),
(13, 9, 'MUJI/web_project/uploads/products/ao-khoac-nam-uv-2.jpg', 0, '2025-05-04 18:08:53'),
(14, 10, 'MUJI/web_project/uploads/products/quan-jeans-nam-slim-fit-1.jpg', 1, '2025-05-04 18:08:53'),
(15, 11, 'MUJI/web_project/uploads/products/quan-khaki-nam-1.jpg', 1, '2025-05-04 18:08:53'),
(16, 12, 'MUJI/web_project/uploads/products/quan-short-nam-airism-1.jpg', 1, '2025-05-04 18:08:53'),
(17, 13, 'MUJI/web_project/uploads/products/that-lung-nam-1.jpg', 1, '2025-05-04 18:08:53'),
(18, 14, 'MUJI/web_project/uploads/products/tat-nam-set-3-1.jpg', 1, '2025-05-04 18:08:53'),
(19, 15, 'MUJI/web_project/uploads/products/ao-thun-nu-cotton-1.jpg', 1, '2025-05-04 18:08:53'),
(20, 15, 'MUJI/web_project/uploads/products/ao-thun-nu-cotton-2.jpg', 0, '2025-05-04 18:08:53'),
(21, 16, 'MUJI/web_project/uploads/products/ao-so-mi-nu-linen-1.jpg', 1, '2025-05-04 18:08:53'),
(22, 17, 'MUJI/web_project/uploads/products/ao-len-nu-merino-1.jpg', 1, '2025-05-04 18:08:53'),
(23, 18, 'MUJI/web_project/uploads/products/ao-khoac-nu-dai-1.jpg', 1, '2025-05-04 18:08:53'),
(24, 19, 'MUJI/web_project/uploads/products/quan-jeans-nu-1.jpg', 1, '2025-05-04 18:08:53'),
(25, 20, 'MUJI/web_project/uploads/products/vay-chu-a-1.jpg', 1, '2025-05-04 18:08:53'),
(26, 21, 'MUJI/web_project/uploads/products/chan-vay-midi-1.jpg', 1, '2025-05-04 18:08:53'),
(27, 22, 'MUJI/web_project/uploads/products/tui-xach-nu-1.jpg', 1, '2025-05-04 18:08:53'),
(28, 23, 'MUJI/web_project/uploads/products/khan-choang-co-1.jpg', 1, '2025-05-04 18:08:53'),
(29, 24, 'MUJI/web_project/uploads/products/dien-thoai-abc-1.jpg', 1, '2025-05-04 18:08:53'),
(30, 24, 'MUJI/web_project/uploads/products/dien-thoai-abc-2.jpg', 0, '2025-05-04 18:08:53'),
(31, 25, 'MUJI/web_project/uploads/products/may-tinh-bang-z-1.jpg', 1, '2025-05-04 18:08:53'),
(32, 26, 'MUJI/web_project/uploads/products/laptop-ultrabook-1.jpg', 1, '2025-05-04 18:08:53'),
(33, 27, 'MUJI/web_project/uploads/products/chuot-ergonomic-1.jpg', 1, '2025-05-04 18:08:53'),
(34, 28, 'MUJI/web_project/uploads/products/ghe-lam-viec-1.jpg', 1, '2025-05-04 18:08:53'),
(35, 29, 'MUJI/web_project/uploads/products/sofa-2-cho-1.jpg', 1, '2025-05-04 18:08:53'),
(36, 30, 'MUJI/web_project/uploads/products/ghe-dau-oak-1.jpg', 1, '2025-05-04 18:08:53'),
(37, 31, 'MUJI/web_project/uploads/products/ban-lam-viec-1.jpg', 1, '2025-05-04 18:08:53'),
(38, 32, 'MUJI/web_project/uploads/products/ban-coffee-1.jpg', 1, '2025-05-04 18:08:53'),
(39, 33, 'MUJI/web_project/uploads/products/giuong-doi-1.jpg', 1, '2025-05-04 18:08:53'),
(40, 34, 'MUJI/web_project/uploads/products/bo-chan-ga-1.jpg', 1, '2025-05-04 18:08:53'),
(41, 35, 'MUJI/web_project/uploads/products/but-gel-set-1.jpg', 1, '2025-05-04 18:08:53'),
(42, 36, 'MUJI/web_project/uploads/products/but-chi-co-khi-1.jpg', 1, '2025-05-04 18:08:53'),
(43, 37, 'MUJI/web_project/uploads/products/so-tay-a5-1.jpg', 1, '2025-05-04 18:08:53'),
(44, 38, 'MUJI/web_project/uploads/products/giay-note-1.jpg', 1, '2025-05-04 18:08:53'),
(45, 39, 'MUJI/web_project/uploads/products/noi-inox-1.jpg', 1, '2025-05-04 18:08:53'),
(46, 40, 'MUJI/web_project/uploads/products/bo-dao-1.jpg', 1, '2025-05-04 18:08:53'),
(47, 41, 'MUJI/web_project/uploads/products/khan-tam-1.jpg', 1, '2025-05-04 18:08:53'),
(48, 42, 'MUJI/web_project/uploads/products/gia-phong-tam-1.jpg', 1, '2025-05-04 18:08:53'),
(49, 43, 'MUJI/web_project/uploads/products/son-moi-1.jpg', 1, '2025-05-04 18:08:53'),
(50, 44, 'MUJI/web_project/uploads/products/phan-phu-1.jpg', 1, '2025-05-04 18:08:53'),
(51, 45, 'MUJI/web_project/uploads/products/sua-rua-mat-1.jpg', 1, '2025-05-04 18:08:53'),
(52, 46, 'MUJI/web_project/uploads/products/kem-chong-nang-1.jpg', 1, '2025-05-04 18:08:53');

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
(1, 'user1', '$2y$10$pXWcSHBJLxYEDzCcGBlpe.rCDIKQwwkXol55/0ZrCeV.Ob9CY87Le', 'user@example.com', 'Nguyễn Văn A', '0987654321', 'Hồ Chí Minh, Việt Nam', 'user', 'active', '2025-05-05 01:08:53', '2025-05-05 01:08:53'),
(2, 'admin', '$2y$10$pXWcSHBJLxYEDzCcGBlpe.rCDIKQwwkXol55/0ZrCeV.Ob9CY87Le', 'admin@example.com', 'Admin System', '0123456789', 'Hồ Chí Minh, Việt Nam', 'admin', 'active', '2025-05-05 01:08:53', '2025-05-05 01:08:53');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
