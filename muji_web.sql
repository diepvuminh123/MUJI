-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th5 05, 2025 lúc 11:10 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS `muji_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `muji_web`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `muji_web`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'c02mb6n8fch2anvlututlhb6jd', '2025-05-04 19:41:39', '2025-05-04 19:41:39'),
(2, NULL, '1j7hf0gj9l7gkcajudjcf2mptc', '2025-05-05 01:15:05', '2025-05-05 01:15:05'),
(3, 1, '1j7hf0gj9l7gkcajudjcf2mptc', '2025-05-05 01:15:21', '2025-05-05 16:03:43'),
(4, 2, '1j7hf0gj9l7gkcajudjcf2mptc', '2025-05-05 02:45:39', '2025-05-05 16:03:04'),
(5, NULL, 'vsv7470mpltd7iqv34bu0bcog7', '2025-05-05 09:40:34', '2025-05-05 14:40:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(14, 5, 1, 1, '2025-05-05 14:40:34', '2025-05-05 14:40:34'),
(15, 5, 3, 1, '2025-05-05 14:40:42', '2025-05-05 14:40:42'),
(16, 4, 1, 2, '2025-05-05 16:03:04', '2025-05-05 16:03:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
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
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `parent_id`, `status`, `created_at`) VALUES
(1, 'Thời trang nam', 'thoi-trang-nam', 'Các sản phẩm thời trang dành cho nam giới', NULL, 1, '2025-05-04 16:49:04'),
(2, 'Thời trang nữ', 'thoi-trang-nu', 'Các sản phẩm thời trang dành cho nữ giới', NULL, 1, '2025-05-04 16:49:04'),
(3, 'Điện tử', 'dien-tu', 'Các sản phẩm điện tử, công nghệ', NULL, 1, '2025-05-04 16:49:04'),
(4, 'Đồ nội thất', 'do-noi-that', 'Các sản phẩm nội thất và trang trí nhà cửa', NULL, 1, '2025-05-04 16:49:04'),
(5, 'Văn phòng phẩm', 'van-phong-pham', 'Các sản phẩm văn phòng phẩm và dụng cụ học tập', NULL, 1, '2025-05-04 16:49:04'),
(6, 'Đồ gia dụng', 'do-gia-dung', 'Các sản phẩm gia dụng và nhà bếp', NULL, 1, '2025-05-04 16:49:04'),
(7, 'Chăm sóc cá nhân', 'cham-soc-ca-nhan', 'Các sản phẩm chăm sóc cá nhân và làm đẹp', NULL, 1, '2025-05-04 16:49:04'),
(8, 'Áo', 'ao', 'Các loại áo dành cho nam giới', 1, 1, '2025-05-04 16:49:04'),
(9, 'Quần', 'quan', 'Các loại quần dành cho nam giới', 1, 1, '2025-05-04 16:49:04'),
(10, 'Phụ kiện nam', 'phu-kien-nam', 'Phụ kiện thời trang nam', 1, 1, '2025-05-04 16:49:04'),
(11, 'Áo nữ', 'ao-nu', 'Các loại áo dành cho nữ giới', 2, 1, '2025-05-04 16:49:04'),
(12, 'Quần & Váy', 'quan-vay', 'Các loại quần và váy dành cho nữ giới', 2, 1, '2025-05-04 16:49:04'),
(13, 'Phụ kiện nữ', 'phu-kien-nu', 'Phụ kiện thời trang nữ', 2, 1, '2025-05-04 16:49:04'),
(14, 'Điện thoại & Máy tính bảng', 'dien-thoai-may-tinh-bang', 'Điện thoại thông minh và máy tính bảng', 3, 1, '2025-05-04 16:49:04'),
(15, 'Laptop & Máy tính', 'laptop-may-tinh', 'Laptop và phụ kiện máy tính', 3, 1, '2025-05-04 16:49:04'),
(16, 'Ghế & Sofa', 'ghe-sofa', 'Ghế, ghế đẩu và sofa', 4, 1, '2025-05-04 16:49:04'),
(17, 'Bàn', 'ban', 'Các loại bàn', 4, 1, '2025-05-04 16:49:04'),
(18, 'Giường & Chăn ga', 'giuong-chan-ga', 'Giường và đồ dùng phòng ngủ', 4, 1, '2025-05-04 16:49:04'),
(19, 'Bút & Viết', 'but-viet', 'Các loại bút và dụng cụ viết', 5, 1, '2025-05-04 16:49:04'),
(20, 'Sổ & Giấy', 'so-giay', 'Sổ tay, giấy và vở', 5, 1, '2025-05-04 16:49:04'),
(21, 'Đồ dùng nhà bếp', 'do-dung-nha-bep', 'Dụng cụ nấu ăn và đồ dùng nhà bếp', 6, 1, '2025-05-04 16:49:04'),
(22, 'Đồ dùng phòng tắm', 'do-dung-phong-tam', 'Các sản phẩm dùng trong phòng tắm', 6, 1, '2025-05-04 16:49:04'),
(23, 'Mỹ phẩm', 'my-pham', 'Các sản phẩm làm đẹp và mỹ phẩm', 7, 1, '2025-05-04 16:49:04'),
(24, 'Chăm sóc da', 'cham-soc-da', 'Sản phẩm chăm sóc da', 7, 1, '2025-05-04 16:49:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_messages`
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
-- Đang đổ dữ liệu cho bảng `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `is_read`, `admin_reply`) VALUES
(69, 'Lê Văn G', 'g@example.com', 'Cần báo giá', 'Gửi giúp mình báo giá chi tiết nhé.', '2025-05-02 18:47:32', 0, NULL),
(70, 'Trần Thị H', 'h@example.com', 'Hủy đơn', 'Mình muốn hủy đơn hàng #12345.', '2025-05-02 18:47:32', 0, NULL),
(71, 'Phạm Văn I', 'i@example.com', 'Thêm chi tiết', 'Cho mình xin thêm ảnh thật sản phẩm.', '2025-05-02 18:47:32', 1, 'jinh'),
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
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('cod','bank_transfer') NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','refunded') NOT NULL DEFAULT 'pending',
  `order_status` enum('pending','processing','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
  `order_notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `subtotal`, `shipping_fee`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `order_notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'ORD20250505030754959', 'Nguyễn Văn A', 'user@example.com', '0987654321', 'Hồ Chí Minh, Việt Nam', 1400000.00, 0.00, 1400000.00, 'cod', 'pending', 'cancelled', '', '2025-05-05 08:07:54', '2025-05-05 08:33:31'),
(2, 1, 'ORD20250505031904421', 'Nguyễn Văn A', 'user@example.com', '0987654321', 'Hồ Chí Minh, Việt Nam', 4750000.00, 0.00, 4750000.00, 'cod', 'pending', 'shipping', '', '2025-05-05 08:19:04', '2025-05-05 08:35:21'),
(3, 1, 'ORD20250505033355992', 'Nguyễn Văn A', 'user@example.com', '0987654321', 'Hồ Chí Minh, Việt Nam', 120000.00, 30000.00, 150000.00, 'cod', 'pending', 'pending', '', '2025-05-05 08:33:55', '2025-05-05 08:33:55'),
(4, 1, 'ORD20250505110356367', 'Nguyễn Văn A', 'user@example.com', '0987654321', 'Hồ Chí Minh, Việt Nam', 240000.00, 30000.00, 270000.00, 'cod', 'pending', 'pending', '', '2025-05-05 16:03:56', '2025-05-05 16:03:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `subtotal`, `created_at`) VALUES
(1, 1, 2, 'Quần jean nam slim fit', 2, 450000.00, 900000.00, '2025-05-05 08:07:54'),
(2, 1, 3, 'Áo sơ mi nữ công sở', 2, 250000.00, 500000.00, '2025-05-05 08:07:54'),
(3, 2, 5, 'Dien thoai Smartphone XYZ', 1, 4500000.00, 4500000.00, '2025-05-05 08:19:04'),
(4, 2, 3, 'Áo sơ mi nữ công sở', 1, 250000.00, 250000.00, '2025-05-05 08:19:04'),
(5, 3, 1, 'Áo thun nam basic', 1, 120000.00, 120000.00, '2025-05-05 08:33:55'),
(6, 4, 1, 'Áo thun nam basic', 2, 120000.00, 240000.00, '2025-05-05 16:03:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
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
-- Cấu trúc bảng cho bảng `products`
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
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `sale_price`, `quantity`, `featured`, `status`, `created_at`) VALUES
(1, 1, 'Áo nu', 'ao-nu', 'Áo thun nam cổ tròn basic, chất liệu cotton 100%, mềm mại, thoáng mát.', 150000.00, 120000.00, 97, 1, 'active', '2025-05-04 16:49:05'),
(2, 1, 'Quần jean nam slim fit', 'quan-jean-nam-slim-fit', 'Quần jean nam dáng slim fit, chất liệu denim cao cấp, co giãn tốt.', 450000.00, NULL, 50, 1, 'active', '2025-05-04 16:49:05'),
(3, 2, 'Áo sơ mi nữ công sở', 'ao-so-mi-nu-cong-so', 'Áo sơ mi nữ dáng suông, phù hợp mặc đi làm, chất liệu lụa mềm mại.', 280000.00, 250000.00, 79, 1, 'active', '2025-05-04 16:49:05'),
(4, 2, 'Quần culottes nữ', 'quan-culottes-nu', 'Quần culottes nữ dáng rộng, chất liệu thoáng mát, phù hợp mùa hè.', 320000.00, NULL, 60, 0, 'active', '2025-05-04 16:49:05'),
(5, 3, 'Dien thoai Smartphone XYZ', 'dien-thoai-smartphone-xyz', 'Điện thoại thông minh với màn hình 6.5 inch, camera 48MP, pin 5000mAh.', 5000000.00, 4500000.00, 29, 1, 'active', '2025-05-04 16:49:05'),
(6, 8, 'Áo polo nam AIRism', 'ao-polo-nam-airism', 'Áo polo nam chất liệu AIRism thoáng mát, thấm hút mồ hôi tốt, phù hợp mặc hàng ngày.', 290000.00, 250000.00, 120, 1, 'active', '2025-05-04 16:49:05'),
(7, 8, 'Áo thun nam cổ tròn cotton supima', 'ao-thun-nam-co-tron-cotton-supima', 'Áo thun nam chất liệu cotton supima cao cấp, mềm mại, bền màu.', 195000.00, NULL, 150, 1, 'active', '2025-05-04 16:49:05'),
(8, 8, 'Áo sơ mi nam oxford dài tay', 'ao-so-mi-nam-oxford-dai-tay', 'Áo sơ mi nam chất liệu oxford, form regular fit, dễ phối đồ.', 450000.00, 390000.00, 80, 0, 'active', '2025-05-04 16:49:05'),
(9, 8, 'Áo khoác nam chống nắng UV protection', 'ao-khoac-nam-chong-nang-uv-protection', 'Áo khoác nhẹ có khả năng chống tia UV, chất liệu mỏng nhẹ và thoáng khí.', 590000.00, NULL, 70, 1, 'active', '2025-05-04 16:49:05'),
(10, 9, 'Quần jeans nam slim-fit stretch', 'quan-jeans-nam-slim-fit-stretch', 'Quần jeans nam dáng slim-fit với chất liệu co giãn, thoải mái khi di chuyển.', 490000.00, 420000.00, 100, 1, 'active', '2025-05-04 16:49:05'),
(11, 9, 'Quần khaki nam regular-fit', 'quan-khaki-nam-regular-fit', 'Quần khaki nam form regular vừa vặn, chất vải cotton bền đẹp.', 390000.00, NULL, 85, 0, 'active', '2025-05-04 16:49:05'),
(12, 9, 'Quần short nam AIRism', 'quan-short-nam-airism', 'Quần short nam chất liệu AIRism thoáng mát, thích hợp mặc mùa hè hoặc tập thể thao.', 250000.00, 220000.00, 120, 1, 'active', '2025-05-04 16:49:05'),
(13, 10, 'Thắt lưng nam da thật', 'that-lung-nam-da-that', 'Thắt lưng nam làm từ da bò thật, khóa kim loại cao cấp, thiết kế thanh lịch.', 350000.00, NULL, 60, 0, 'active', '2025-05-04 16:49:05'),
(14, 10, 'Tất nam cổ ngắn set 3 đôi', 'tat-nam-co-ngan-set-3-doi', 'Bộ 3 đôi tất nam cổ ngắn, chất liệu cotton thấm hút tốt, nhiều màu sắc.', 120000.00, 99000.00, 200, 1, 'active', '2025-05-04 16:49:05'),
(15, 11, 'Áo thun nữ cổ tròn cotton', 'ao-thun-nu-co-tron-cotton', 'Áo thun nữ cổ tròn chất liệu cotton mềm mại, nhiều màu sắc để lựa chọn.', 180000.00, 150000.00, 180, 1, 'active', '2025-05-04 16:49:05'),
(16, 11, 'Áo sơ mi nữ linen dài tay', 'ao-so-mi-nu-linen-dai-tay', 'Áo sơ mi nữ chất liệu linen thoáng mát, dáng suông thanh lịch.', 420000.00, NULL, 90, 1, 'active', '2025-05-04 16:49:05'),
(17, 11, 'Áo len nữ cổ tròn merino', 'ao-len-nu-co-tron-merino', 'Áo len nữ chất liệu len merino mềm mại, không gây ngứa, giữ ấm tốt.', 590000.00, 490000.00, 70, 0, 'active', '2025-05-04 16:49:05'),
(18, 11, 'Áo khoác nữ dáng dài', 'ao-khoac-nu-dang-dai', 'Áo khoác nữ dáng dài, chất liệu polyester cao cấp, có thể chống nước nhẹ.', 850000.00, NULL, 50, 1, 'active', '2025-05-04 16:49:05'),
(19, 12, 'Quần jeans nữ dáng ống đứng', 'quan-jeans-nu-dang-ong-dung', 'Quần jeans nữ ống đứng, chất liệu denim co giãn, tôn dáng người mặc.', 450000.00, 390000.00, 95, 1, 'active', '2025-05-04 16:49:05'),
(20, 12, 'Váy liền thân dáng chữ A', 'vay-lien-than-dang-chu-a', 'Váy liền thân dáng chữ A, chất liệu cotton pha polyester, phù hợp mặc hàng ngày và đi làm.', 520000.00, NULL, 65, 0, 'active', '2025-05-04 16:49:05'),
(21, 12, 'Chân váy midi xếp ly', 'chan-vay-midi-xep-ly', 'Chân váy midi xếp ly thanh lịch, chất liệu polyester cao cấp, phù hợp mặc đi làm.', 450000.00, 380000.00, 60, 1, 'active', '2025-05-04 16:49:05'),
(22, 13, 'Túi xách nữ canvas', 'tui-xach-nu-canvas', 'Túi xách nữ chất liệu canvas bền đẹp, có nhiều ngăn tiện lợi, phù hợp đi làm và đi chơi.', 390000.00, NULL, 45, 1, 'active', '2025-05-04 16:49:05'),
(23, 13, 'Khăn choàng cổ nữ', 'khan-choang-co-nu', 'Khăn choàng cổ nữ chất liệu viscose mềm mại, nhiều họa tiết trang nhã.', 190000.00, 150000.00, 80, 0, 'active', '2025-05-04 16:49:05'),
(24, 14, 'Dien thoai thông minh ABC', 'dien-thoai-thong-minh-abc', 'Điện thoại thông minh với màn hình AMOLED 6.7 inch, camera 64MP, pin 5000mAh, sạc nhanh 67W.', 8500000.00, 7900000.00, 40, 1, 'active', '2025-05-04 16:49:05'),
(25, 14, 'Máy tính bảng Model Z Pro', 'may-tinh-bang-model-z-pro', 'Máy tính bảng màn hình 11 inch, chip xử lý mạnh mẽ, pin trâu, phù hợp làm việc và giải trí.', 9900000.00, NULL, 25, 1, 'active', '2025-05-04 16:49:05'),
(26, 15, 'Laptop ultrabook 14\"', 'laptop-ultrabook-14', 'Laptop mỏng nhẹ, màn hình 14 inch, chip xử lý thế hệ mới, RAM 16GB, SSD 512GB.', 18500000.00, 17000000.00, 20, 1, 'active', '2025-05-04 16:49:05'),
(27, 15, 'Chuột không dây ergonomic', 'chuot-khong-day-ergonomic', 'Chuột không dây thiết kế công thái học, giảm mỏi cổ tay, độ nhạy cao, pin sử dụng lâu.', 650000.00, NULL, 100, 0, 'active', '2025-05-04 16:49:05'),
(28, 16, 'Ghế làm việc lưng cao', 'ghe-lam-viec-lung-cao', 'Ghế làm việc lưng cao với tựa đầu, tay vịn có thể điều chỉnh, chất liệu lưới thoáng khí.', 2500000.00, 2200000.00, 30, 1, 'active', '2025-05-04 16:49:05'),
(29, 16, 'Sofa 2 chỗ ngồi', 'sofa-2-cho-ngoi', 'Sofa 2 chỗ ngồi chất liệu vải canvas cao cấp, khung gỗ tự nhiên, thiết kế tối giản.', 4900000.00, NULL, 15, 1, 'active', '2025-05-04 16:49:05'),
(30, 16, 'Ghế đẩu gỗ oak', 'ghe-dau-go-oak', 'Ghế đẩu làm từ gỗ oak tự nhiên, thiết kế tối giản, phù hợp nhiều không gian.', 850000.00, 750000.00, 40, 0, 'active', '2025-05-04 16:49:05'),
(31, 17, 'Bàn làm việc gỗ tự nhiên', 'ban-lam-viec-go-tu-nhien', 'Bàn làm việc chất liệu gỗ tự nhiên, thiết kế tối giản với ngăn kéo tiện lợi.', 3200000.00, NULL, 25, 1, 'active', '2025-05-04 16:49:05'),
(32, 17, 'Bàn coffee tròn', 'ban-coffee-tron', 'Bàn coffee hình tròn, chân kim loại sơn đen, mặt gỗ công nghiệp phủ melamine.', 1500000.00, 1299000.00, 35, 0, 'active', '2025-05-04 16:49:05'),
(33, 18, 'Giường đôi khung gỗ', 'giuong-doi-khung-go', 'Giường đôi size 1m6 x 2m, khung gỗ tự nhiên chắc chắn, thiết kế tối giản.', 5900000.00, 5200000.00, 10, 1, 'active', '2025-05-04 16:49:05'),
(34, 18, 'Bộ chăn ga gối cotton', 'bo-chan-ga-goi-cotton', 'Bộ chăn ga gối chất liệu cotton 100%, mềm mại, thoáng khí, nhiều họa tiết và màu sắc.', 1200000.00, NULL, 50, 1, 'active', '2025-05-04 16:49:05'),
(35, 19, 'Bút gel 0.38mm set 5 cây', 'but-gel-038mm-set-5-cay', 'Bộ 5 bút gel mực đen, xanh, đỏ, nâu, xanh lá, đầu kim 0.38mm, viết mượt mà.', 95000.00, 80000.00, 150, 1, 'active', '2025-05-04 16:49:05'),
(36, 19, 'Bút chì cơ khí 0.5mm', 'but-chi-co-khi-05mm', 'Bút chì cơ khí thân nhôm, ngòi 0.5mm, có thể thay ruột, thiết kế tối giản.', 120000.00, NULL, 200, 0, 'active', '2025-05-04 16:49:05'),
(37, 20, 'Sổ tay bìa cứng A5', 'so-tay-bia-cung-a5', 'Sổ tay khổ A5 bìa cứng, giấy trắng trơn 100 gsm, 192 trang, có bookmark.', 150000.00, 120000.00, 100, 1, 'active', '2025-05-04 16:49:05'),
(38, 20, 'Giấy note vuông 7.5x7.5cm', 'giay-note-vuong-75x75cm', 'Giấy note vuông 7.5x7.5cm, 100 tờ/tập, giấy màu pastel, có keo dính ở cạnh.', 25000.00, NULL, 300, 0, 'active', '2025-05-04 16:49:05'),
(39, 21, 'Nồi inox 3 đáy 24cm', 'noi-inox-3-day-24cm', 'Nồi inox 304 cao cấp 3 đáy, đường kính 24cm, nắp kính cường lực, tay cầm cách nhiệt.', 750000.00, 650000.00, 40, 1, 'active', '2025-05-04 16:49:05'),
(40, 21, 'Bộ dao nhà bếp 3 món', 'bo-dao-nha-bep-3-mon', 'Bộ 3 dao nhà bếp gồm dao thái, dao gọt, dao thớt, lưỡi thép không gỉ, cán gỗ tự nhiên.', 890000.00, NULL, 30, 1, 'active', '2025-05-04 16:49:05'),
(41, 22, 'Khăn tắm cotton 70x140cm', 'khan-tam-cotton-70x140cm', 'Khăn tắm chất liệu cotton 100%, kích thước 70x140cm, thấm hút tốt, mềm mại.', 190000.00, 150000.00, 80, 0, 'active', '2025-05-04 16:49:05'),
(42, 22, 'Giá đựng đồ phòng tắm 3 tầng', 'gia-dung-do-phong-tam-3-tang', 'Giá đựng đồ phòng tắm 3 tầng, chất liệu thép không gỉ, dễ dàng lắp đặt.', 320000.00, NULL, 45, 1, 'active', '2025-05-04 16:49:05'),
(43, 23, 'Son môi lì dưỡng ẩm', 'son-moi-li-duong-am', 'Son môi lì có chứa thành phần dưỡng ẩm, không gây khô môi, nhiều màu sắc thời trang.', 250000.00, 220000.00, 60, 1, 'active', '2025-05-04 16:49:05'),
(44, 23, 'Phấn phủ kiềm dầu', 'phan-phu-kiem-dau', 'Phấn phủ kiềm dầu, che phủ tốt, không gây bít lỗ chân lông, phù hợp da dầu và hỗn hợp.', 320000.00, NULL, 50, 0, 'active', '2025-05-04 16:49:05'),
(45, 24, 'Sữa rửa mặt dịu nhẹ 150ml', 'sua-rua-mat-diu-nhe-150ml', 'Sữa rửa mặt dịu nhẹ, không chứa sulfate, phù hợp mọi loại da, làm sạch sâu không gây khô.', 180000.00, 150000.00, 100, 1, 'active', '2025-05-04 16:49:05'),
(46, 24, 'Kem dưỡng ẩm chống nắng SPF50+ 50ml', 'kem-duong-am-chong-nang-spf50-50ml', 'Kem dưỡng ẩm tích hợp chống nắng SPF50+, bảo vệ da khỏi tia UV, không gây bít lỗ chân lông.', 390000.00, NULL, 70, 1, 'active', '2025-05-04 16:49:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`) VALUES
(1, 1, 'MUJI/web_project/uploads/products/ao-thun-nam-1.jpg', 0, '2025-05-04 16:49:05'),
(2, 1, 'MUJI/web_project/uploads/products/ao-thun-nam-2.jpg', 1, '2025-05-04 16:49:05'),
(3, 2, 'MUJI/web_project/uploads/products/quan-jean-nam-1.jpg', 1, '2025-05-04 16:49:05'),
(4, 3, 'MUJI/web_project/uploads/products/ao-so-mi-nu-1.jpg', 1, '2025-05-04 16:49:05'),
(5, 4, 'MUJI/web_project/uploads/products/quan-culottes-nu-1.jpg', 1, '2025-05-04 16:49:05'),
(6, 5, 'MUJI/web_project/uploads/products/smartphone-1.jpg', 1, '2025-05-04 16:49:05'),
(7, 6, 'MUJI/web_project/uploads/products/ao-polo-nam-airism-1.jpg', 1, '2025-05-04 16:49:05'),
(8, 6, 'MUJI/web_project/uploads/products/ao-polo-nam-airism-2.jpg', 0, '2025-05-04 16:49:05'),
(9, 7, 'MUJI/web_project/uploads/products/ao-thun-nam-cotton-supima-1.jpg', 1, '2025-05-04 16:49:05'),
(10, 7, 'MUJI/web_project/uploads/products/ao-thun-nam-cotton-supima-2.jpg', 0, '2025-05-04 16:49:05'),
(11, 8, 'MUJI/web_project/uploads/products/ao-so-mi-nam-oxford-1.jpg', 1, '2025-05-04 16:49:05'),
(12, 9, 'MUJI/web_project/uploads/products/ao-khoac-nam-uv-1.jpg', 1, '2025-05-04 16:49:05'),
(13, 9, 'MUJI/web_project/uploads/products/ao-khoac-nam-uv-2.jpg', 0, '2025-05-04 16:49:05'),
(14, 10, 'MUJI/web_project/uploads/products/quan-jeans-nam-slim-fit-1.jpg', 1, '2025-05-04 16:49:05'),
(15, 11, 'MUJI/web_project/uploads/products/quan-khaki-nam-1.jpg', 1, '2025-05-04 16:49:05'),
(16, 12, 'MUJI/web_project/uploads/products/quan-short-nam-airism-1.jpg', 1, '2025-05-04 16:49:05'),
(17, 13, 'MUJI/web_project/uploads/products/that-lung-nam-1.jpg', 1, '2025-05-04 16:49:05'),
(18, 14, 'MUJI/web_project/uploads/products/tat-nam-set-3-1.jpg', 1, '2025-05-04 16:49:05'),
(19, 15, 'MUJI/web_project/uploads/products/ao-thun-nu-cotton-1.jpg', 1, '2025-05-04 16:49:05'),
(20, 15, 'MUJI/web_project/uploads/products/ao-thun-nu-cotton-2.jpg', 0, '2025-05-04 16:49:05'),
(21, 16, 'MUJI/web_project/uploads/products/ao-so-mi-nu-linen-1.jpg', 1, '2025-05-04 16:49:05'),
(22, 17, 'MUJI/web_project/uploads/products/ao-len-nu-merino-1.jpg', 1, '2025-05-04 16:49:05'),
(23, 18, 'MUJI/web_project/uploads/products/ao-khoac-nu-dai-1.jpg', 1, '2025-05-04 16:49:05'),
(24, 19, 'MUJI/web_project/uploads/products/quan-jeans-nu-1.jpg', 1, '2025-05-04 16:49:05'),
(25, 20, 'MUJI/web_project/uploads/products/vay-chu-a-1.jpg', 1, '2025-05-04 16:49:05'),
(26, 21, 'MUJI/web_project/uploads/products/chan-vay-midi-1.jpg', 1, '2025-05-04 16:49:05'),
(27, 22, 'MUJI/web_project/uploads/products/tui-xach-nu-1.jpg', 1, '2025-05-04 16:49:05'),
(28, 23, 'MUJI/web_project/uploads/products/khan-choang-co-1.jpg', 1, '2025-05-04 16:49:05'),
(29, 24, 'MUJI/web_project/uploads/products/dien-thoai-abc-1.jpg', 1, '2025-05-04 16:49:05'),
(30, 24, 'MUJI/web_project/uploads/products/dien-thoai-abc-2.jpg', 0, '2025-05-04 16:49:05'),
(31, 25, 'MUJI/web_project/uploads/products/may-tinh-bang-z-1.jpg', 1, '2025-05-04 16:49:05'),
(32, 26, 'MUJI/web_project/uploads/products/laptop-ultrabook-1.jpg', 1, '2025-05-04 16:49:05'),
(33, 27, 'MUJI/web_project/uploads/products/chuot-ergonomic-1.jpg', 1, '2025-05-04 16:49:05'),
(34, 28, 'MUJI/web_project/uploads/products/ghe-lam-viec-1.jpg', 1, '2025-05-04 16:49:05'),
(35, 29, 'MUJI/web_project/uploads/products/sofa-2-cho-1.jpg', 1, '2025-05-04 16:49:05'),
(36, 30, 'MUJI/web_project/uploads/products/ghe-dau-oak-1.jpg', 1, '2025-05-04 16:49:05'),
(37, 31, 'MUJI/web_project/uploads/products/ban-lam-viec-1.jpg', 1, '2025-05-04 16:49:05'),
(38, 32, 'MUJI/web_project/uploads/products/ban-coffee-1.jpg', 1, '2025-05-04 16:49:05'),
(39, 33, 'MUJI/web_project/uploads/products/giuong-doi-1.jpg', 1, '2025-05-04 16:49:05'),
(40, 34, 'MUJI/web_project/uploads/products/bo-chan-ga-1.jpg', 1, '2025-05-04 16:49:05'),
(41, 35, 'MUJI/web_project/uploads/products/but-gel-set-1.jpg', 1, '2025-05-04 16:49:05'),
(42, 36, 'MUJI/web_project/uploads/products/but-chi-co-khi-1.jpg', 1, '2025-05-04 16:49:05'),
(43, 37, 'MUJI/web_project/uploads/products/so-tay-a5-1.jpg', 1, '2025-05-04 16:49:05'),
(44, 38, 'MUJI/web_project/uploads/products/giay-note-1.jpg', 1, '2025-05-04 16:49:05'),
(45, 39, 'MUJI/web_project/uploads/products/noi-inox-1.jpg', 1, '2025-05-04 16:49:05'),
(46, 40, 'MUJI/web_project/uploads/products/bo-dao-1.jpg', 1, '2025-05-04 16:49:05'),
(47, 41, 'MUJI/web_project/uploads/products/khan-tam-1.jpg', 1, '2025-05-04 16:49:05'),
(48, 42, 'MUJI/web_project/uploads/products/gia-phong-tam-1.jpg', 1, '2025-05-04 16:49:05'),
(49, 43, 'MUJI/web_project/uploads/products/son-moi-1.jpg', 1, '2025-05-04 16:49:05'),
(50, 44, 'MUJI/web_project/uploads/products/phan-phu-1.jpg', 1, '2025-05-04 16:49:05'),
(51, 45, 'MUJI/web_project/uploads/products/sua-rua-mat-1.jpg', 1, '2025-05-04 16:49:05'),
(52, 46, 'MUJI/web_project/uploads/products/kem-chong-nang-1.jpg', 1, '2025-05-04 16:49:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `name`, `email`, `question`, `answer`, `created_at`) VALUES
(1, 'Minh', 'chinhtpc123@gmail.com', 'ddddd', NULL, '2025-05-04 21:07:57'),
(2, 'minh', 'gfggfgfg@gmail.com', 'gfgfg', NULL, '2025-05-05 08:11:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `site_info`
--

CREATE TABLE `site_info` (
  `id` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `site_info`
--

INSERT INTO `site_info` (`id`, `key`, `value`) VALUES
(1, 'hotline', '0915456'),
(2, 'address', 'C6 Lý Thường Kiệt'),
(3, 'Company_name', 'Sakura'),
(4, 'Slogan ', 'いい製品'),
(5, 'email', 'loc.nguyendev04@hcmut.edu.vn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
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
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'user1', '$2y$10$pXWcSHBJLxYEDzCcGBlpe.rCDIKQwwkXol55/0ZrCeV.Ob9CY87Le', 'user@example.com', 'Nguyễn Văn A', '0987654321', 'Hồ Chí Minh, Việt Nam', 'user', 'active', '2025-05-04 23:49:05', '2025-05-04 23:49:05'),
(2, 'admin', '$2y$10$pXWcSHBJLxYEDzCcGBlpe.rCDIKQwwkXol55/0ZrCeV.Ob9CY87Le', 'admin@example.com', 'Admin System', '0123456789', 'Hồ Chí Minh, Việt Nam', 'admin', 'active', '2025-05-04 23:49:05', '2025-05-04 23:49:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `articles`
--

INSERT INTO `articles` (`id`, `title`, `author`, `date`, `category`, `image`, `content`, `views`, `created_at`) VALUES
(10, 'Lối sống tối giản: Xu hướng mới của giới trẻ hiện đại', 'Nguyễn An', '2024-05-01', 'Phong cách sống', 'simple_life.jpg', 'Trong xã hội hiện đại, khi con người ngày càng bị bủa vây bởi thông tin, hàng hóa và các mối lo, lối sống tối giản nổi lên như một phương thức giúp con người lấy lại cân bằng. \r\nViệc lựa chọn đồ dùng đơn giản, tinh tế, hạn chế tối đa sự dư thừa không chỉ giúp tiết kiệm chi phí mà còn tạo ra một không gian sống thanh tịnh, dễ chịu. \r\nNhiều bạn trẻ hiện nay không còn mặn mà với các món đồ màu mè, phức tạp mà thay vào đó là các sản phẩm có thiết kế đơn giản, trung tính nhưng đầy tính thẩm mỹ và công năng.', 42, '2025-05-05 02:21:20'),
(11, 'Tại sao nội thất Nhật Bản được ưa chuộng tại Việt Nam?', 'Trần Minh Huy', '2024-04-28', 'Nội thất', 'japanese_interior.jpg', 'Nội thất Nhật Bản nổi bật bởi sự tối giản trong thiết kế, độ bền cao và đặc biệt là khả năng ứng dụng linh hoạt trong các không gian sống nhỏ hẹp – điều rất phù hợp với những căn hộ tại các thành phố lớn ở Việt Nam. \r\nNgười Việt ngày càng yêu thích các sản phẩm làm từ gỗ tự nhiên, tone màu trầm ấm và cách bố trí không gian mở, thoáng đãng. \r\nSự ưa chuộng này không chỉ nằm ở yếu tố thẩm mỹ mà còn thể hiện một lối sống tinh tế, hiện đại và đề cao sự thư giãn trong chính không gian sống của mình.', 58, '2025-05-05 02:21:20'),
(12, 'Câu chuyện thương hiệu: Từ một cửa hàng nhỏ đến chuỗi bán lẻ toàn quốc', 'Lê Hoàng', '2024-05-03', 'Kinh doanh', 'brand_story.jpg', 'Khởi đầu là một cửa hàng chuyên bán các sản phẩm tiêu dùng cơ bản, thương hiệu này dần phát triển thành một chuỗi bán lẻ với hàng trăm mặt hàng trải dài từ đồ gia dụng, thời trang, văn phòng phẩm cho đến mỹ phẩm. \r\nĐiểm đặc biệt là mọi sản phẩm đều mang chung triết lý thiết kế tối giản, tập trung vào tính năng và giá thành hợp lý. \r\nĐó cũng chính là lý do giúp thương hiệu nhận được sự tin yêu của nhiều gia đình trẻ, sinh viên và dân văn phòng trong nước.', 34, '2025-05-05 02:21:20'),
(13, 'Không gian làm việc tối giản: Tối đa hiệu suất, tối thiểu phiền nhiễu', 'Phạm Thanh Thảo', '2024-05-04', 'Văn phòng', 'workspace.jpg', 'Một không gian làm việc gọn gàng, ngăn nắp sẽ giúp não bộ dễ tập trung hơn, từ đó tăng hiệu suất công việc. \r\nViệc loại bỏ những món đồ không cần thiết, sử dụng bàn làm việc thiết kế gọn nhẹ, đèn chiếu sáng phù hợp và thậm chí là sử dụng các vật dụng tông màu dịu mắt như trắng, be, xám… là những yếu tố giúp môi trường làm việc trở nên dễ chịu hơn. \r\nNhiều công ty trẻ hiện nay cũng lựa chọn thiết kế văn phòng theo hướng \"less is more\".', 61, '2025-05-05 02:21:20'),
(14, 'Đồ gia dụng thân thiện môi trường: Xu hướng hay trách nhiệm xã hội?', 'Ngô Minh Trang', '2024-05-02', 'Môi trường', 'eco_products.jpg', 'Sử dụng các vật liệu tự nhiên như tre, gỗ, thủy tinh thay vì nhựa một lần là bước đi nhỏ nhưng có tác động lớn đến môi trường. \r\nCác thương hiệu tiêu dùng thông minh hiện nay không chỉ chú trọng tới sản phẩm chất lượng, giá tốt mà còn phải quan tâm đến yếu tố bền vững. \r\nRất nhiều người tiêu dùng trẻ ngày nay đặt yếu tố “thân thiện với môi trường” lên hàng đầu khi lựa chọn sản phẩm sử dụng trong gia đình.', 27, '2025-05-05 02:21:20'),
(15, 'Bí quyết chăm sóc da kiểu Nhật: Đơn giản nhưng hiệu quả lâu dài', 'Hà Linh', '2024-05-05', 'Chăm sóc bản thân', 'japanese_skincare.jpg', 'Không phải ngẫu nhiên mà phụ nữ Nhật Bản luôn nổi tiếng với làn da mịn màng, khỏe mạnh. \r\nBí quyết của họ nằm ở việc chăm sóc từ những điều cơ bản nhất: làm sạch đúng cách, dưỡng ẩm đầy đủ và tránh lạm dụng mỹ phẩm. \r\nNgoài ra, họ rất quan tâm tới chế độ ăn uống lành mạnh và thời gian nghỉ ngơi. \r\nTriết lý chăm sóc da kiểu Nhật cũng như mọi thứ khác ở đất nước này – tối giản nhưng hiệu quả.', 37, '2025-05-05 02:21:20'),
(16, 'Tối ưu hóa không gian sống nhỏ với thiết kế thông minh', 'Lâm Thái Sơn', '2024-04-30', 'Thiết kế nhà', 'small_home.jpg', 'Với diện tích sống ngày càng thu hẹp tại các thành phố, việc thiết kế một căn hộ nhỏ trở nên thông minh và tiện nghi là điều rất quan trọng. \r\nTừ việc chọn nội thất đa năng, giường gấp, tủ âm tường đến bố cục ánh sáng tự nhiên – tất cả đều góp phần tạo nên không gian vừa thoáng đãng vừa đầy đủ chức năng. \r\nKhông gian nhỏ không đồng nghĩa với sự bất tiện nếu biết cách khai thác hợp lý.', 48, '2025-05-05 02:21:20'),
(17, 'Sản phẩm tối giản có thật sự nhàm chán?', 'Đoàn Bảo Châu', '2024-05-01', 'Thiết kế', 'minimal_style.jpg', 'Nhiều người cho rằng thiết kế tối giản đồng nghĩa với sự đơn điệu, thiếu cá tính. \r\nTuy nhiên, điều ngược lại mới đúng: sự tối giản đòi hỏi sự tinh tế trong từng đường nét, sự chọn lọc kỹ càng về màu sắc, chất liệu. \r\nKhi mọi thứ được tinh gọn về mặt hình thức, bản chất và công năng của sản phẩm sẽ được tôn lên rõ ràng hơn.', 31, '2025-05-05 02:21:20'),
(18, 'Vì sao khách hàng yêu thích trải nghiệm mua sắm chậm?', 'Đặng Quốc Bảo', '2024-04-29', 'Tiêu dùng', 'slow_shopping.jpg', 'Tại các cửa hàng mang phong cách Nhật Bản, không khí luôn yên tĩnh, ánh sáng dịu, sản phẩm sắp xếp gọn gàng – điều đó khiến khách hàng có cảm giác “được thở”, được thư giãn khi mua sắm. \r\nKhác với việc chen chúc và khuyến mãi ồn ào, xu hướng trải nghiệm mua sắm chậm giúp khách hàng có thời gian cân nhắc kỹ hơn, từ đó hài lòng hơn với lựa chọn của mình.', 38, '2025-05-05 02:21:20'),
(19, 'Ứng dụng màu sắc trung tính trong thiết kế nội thất', 'Tô Mỹ Dung', '2024-04-26', 'Nội thất', 'neutral_colors.jpg', 'Màu trắng, xám nhạt, be hay nâu gỗ nhạt là những gam màu được ưa chuộng trong các không gian nội thất hiện đại. \r\nChúng không chỉ tạo cảm giác rộng rãi, sạch sẽ mà còn rất dễ phối hợp với các chi tiết trang trí khác. \r\nPhong cách phối màu trung tính mang đến sự thanh lịch, không lỗi mốt và đặc biệt phù hợp với mọi độ tuổi.', 24, '2025-05-05 02:21:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sliders`
--

INSERT INTO `sliders` (`id`, `image_path`, `created_at`) VALUES
(9, 'uploads/6817bd7733f0a_hangers-1850082_640.jpg', '2025-05-04 19:18:15'),
(14, 'uploads/68180e1ea8a7f_vn-11134207-7r98o-lsxw40nitfb830.jpg', '2025-05-05 01:02:22'),
(17, 'uploads/68187daac5ab2_tui_luiviton.jpg', '2025-05-05 08:58:18');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Chỉ mục cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `site_info`
--
ALTER TABLE `site_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION;

--
-- Các ràng buộc cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
