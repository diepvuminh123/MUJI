
-- @block: Tạo database muji_web
CREATE DATABASE IF NOT EXISTS muji_web
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci; --COLLATE utf8mb4_unicode_ci là chuẩn mã hóa cho tiếng Việt

-- @block: Sử dụng database muji_web
USE muji_web;

-- @block: Tạo bảng site_info (thông tin cơ bản: logo, địa chỉ, email...)
CREATE TABLE IF NOT EXISTS site_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) UNIQUE NOT NULL,
    `value` TEXT NOT NULL
);

-- @block: Tạo bảng banners (slider/trình chiếu ở trang chủ)
CREATE TABLE IF NOT EXISTS banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image_path VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1
);

-- @block: Tạo bảng promotion_banners (ảnh khuyến mãi lớn dạng grid)
CREATE TABLE IF NOT EXISTS promotion_banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- @block: Tạo bảng contacts (form liên hệ khách hàng gửi)
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    status ENUM('unread', 'read', 'responded') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
