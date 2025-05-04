CREATE DATABASE IF NOT EXISTS `muji_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `muji_web`;
CREATE TABLE sliders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO sliders (image_url, title, description) 
VALUES 
    ('https://example.com/images/slider1.jpg', 'Khuyến mãi mùa hè', 'Giảm giá 50% cho tất cả các sản phẩm mùa hè!'),
    ('https://example.com/images/slider2.jpg', 'Mua 1 tặng 1', 'Mua 1 sản phẩm tặng 1 sản phẩm miễn phí!'),
    ('https://example.com/images/slider3.jpg', 'Giảm giá lớn', 'Giảm giá lên tới 70% cho các mặt hàng chọn lọc!');
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
