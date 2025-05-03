CREATE DATABASE IF NOT EXISTS `muji_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `muji_web`;

-- 1. Tạo bảng articles (nếu chưa có)
CREATE TABLE IF NOT EXISTS articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  summary TEXT NOT NULL,
  content TEXT NOT NULL,
  thumbnail VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Chèn bài viết mẫu theo chủ đề lifestyle / home decor / tiêu dùng

INSERT INTO articles (id, title, summary, content, thumbnail) VALUES
( '1',
  'Tối giản không gian sống với 5 món đồ nội thất thiết yếu',
  'Khám phá 5 món đồ nội thất giúp bạn tối giản không gian mà vẫn giữ sự tiện nghi trong căn hộ.',
  '<p>Triết lý sống tối giản bắt đầu từ cách chọn nội thất. Bạn chỉ cần một chiếc giường gỗ đơn giản, bàn làm việc gấp gọn, tủ vải thông minh, ghế bệt kiểu Nhật và giá sách treo tường. Vừa tiết kiệm không gian, vừa dễ vệ sinh và tinh tế.</p>',
  'minimal-furniture.jpg'
),
('2',
  'Hướng dẫn chăm sóc đồ gỗ tự nhiên đúng cách',
  'Đồ gỗ mang lại cảm giác ấm cúng và bền bỉ, nhưng bạn đã vệ sinh và bảo quản chúng đúng cách chưa?',
  '<p>Để đồ gỗ bền màu và không bị ẩm mốc, bạn nên dùng khăn mềm lau khô mỗi tuần, tránh ánh nắng trực tiếp hoặc độ ẩm cao. Dùng sáp ong hoặc dầu chuyên dụng đánh bóng mỗi tháng giúp gỗ luôn sáng đẹp như mới.</p>',
  'wood-care.jpg'
),
('3',
  '5 vật dụng đơn giản giúp góc làm việc gọn gàng hơn',
  'Gợi ý những sản phẩm nhỏ gọn giúp bạn cải thiện góc làm việc tại nhà theo phong cách Nhật Bản.',
  '<p>Một góc làm việc ngăn nắp tăng hiệu suất rõ rệt. Bạn có thể dùng khay đựng tài liệu bằng mây tre, đèn LED nhỏ gọn, khung gỗ kẹp ảnh nhắc việc, bảng ghim vải nỉ và giá đỡ laptop đơn giản. Những chi tiết này giúp giảm căng thẳng và tăng tập trung.</p>',
  'desk-organization.jpg'
);
