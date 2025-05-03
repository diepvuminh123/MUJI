-- Simplified database schema for product display
-- DROP DATABASE IF EXISTS muji_web;
-- CREATE DATABASE muji_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS `muji_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `muji_web`;

-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    parent_id INT DEFAULT NULL,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2) DEFAULT NULL,
    quantity INT NOT NULL DEFAULT 0,
    featured TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Product images table
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert main categories
INSERT INTO categories (name, slug, description) VALUES 
('Thời trang nam', 'thoi-trang-nam', 'Các sản phẩm thời trang dành cho nam giới'),
('Thời trang nữ', 'thoi-trang-nu', 'Các sản phẩm thời trang dành cho nữ giới'),
('Điện tử', 'dien-tu', 'Các sản phẩm điện tử, công nghệ'),
('Đồ nội thất', 'do-noi-that', 'Các sản phẩm nội thất và trang trí nhà cửa'),
('Văn phòng phẩm', 'van-phong-pham', 'Các sản phẩm văn phòng phẩm và dụng cụ học tập'),
('Đồ gia dụng', 'do-gia-dung', 'Các sản phẩm gia dụng và nhà bếp'),
('Chăm sóc cá nhân', 'cham-soc-ca-nhan', 'Các sản phẩm chăm sóc cá nhân và làm đẹp');

-- Add subcategories
INSERT INTO categories (name, slug, description, parent_id) VALUES
('Áo', 'ao', 'Các loại áo dành cho nam giới', 1),
('Quần', 'quan', 'Các loại quần dành cho nam giới', 1),
('Phụ kiện nam', 'phu-kien-nam', 'Phụ kiện thời trang nam', 1),
('Áo nữ', 'ao-nu', 'Các loại áo dành cho nữ giới', 2),
('Quần & Váy', 'quan-vay', 'Các loại quần và váy dành cho nữ giới', 2),
('Phụ kiện nữ', 'phu-kien-nu', 'Phụ kiện thời trang nữ', 2),
('Điện thoại & Máy tính bảng', 'dien-thoai-may-tinh-bang', 'Điện thoại thông minh và máy tính bảng', 3),
('Laptop & Máy tính', 'laptop-may-tinh', 'Laptop và phụ kiện máy tính', 3),
('Ghế & Sofa', 'ghe-sofa', 'Ghế, ghế đẩu và sofa', 4),
('Bàn', 'ban', 'Các loại bàn', 4),
('Giường & Chăn ga', 'giuong-chan-ga', 'Giường và đồ dùng phòng ngủ', 4),
('Bút & Viết', 'but-viet', 'Các loại bút và dụng cụ viết', 5),
('Sổ & Giấy', 'so-giay', 'Sổ tay, giấy và vở', 5),
('Đồ dùng nhà bếp', 'do-dung-nha-bep', 'Dụng cụ nấu ăn và đồ dùng nhà bếp', 6),
('Đồ dùng phòng tắm', 'do-dung-phong-tam', 'Các sản phẩm dùng trong phòng tắm', 6),
('Mỹ phẩm', 'my-pham', 'Các sản phẩm làm đẹp và mỹ phẩm', 7),
('Chăm sóc da', 'cham-soc-da', 'Sản phẩm chăm sóc da', 7);

-- Insert original sample products
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES 
(1, 'Áo thun nam basic', 'ao-thun-nam-basic', 'Áo thun nam cổ tròn basic, chất liệu cotton 100%, mềm mại, thoáng mát.', 150000, 120000, 100, 1),
(1, 'Quần jean nam slim fit', 'quan-jean-nam-slim-fit', 'Quần jean nam dáng slim fit, chất liệu denim cao cấp, co giãn tốt.', 450000, NULL, 50, 1),
(2, 'Áo sơ mi nữ công sở', 'ao-so-mi-nu-cong-so', 'Áo sơ mi nữ dáng suông, phù hợp mặc đi làm, chất liệu lụa mềm mại.', 280000, 250000, 80, 1),
(2, 'Quần culottes nữ', 'quan-culottes-nu', 'Quần culottes nữ dáng rộng, chất liệu thoáng mát, phù hợp mùa hè.', 320000, NULL, 60, 0),
(3, 'Điện thoại Smartphone XYZ', 'dien-thoai-smartphone-xyz', 'Điện thoại thông minh với màn hình 6.5 inch, camera 48MP, pin 5000mAh.', 5000000, 4500000, 30, 1);

-- Insert product images for original products
INSERT INTO product_images (product_id, image_path, is_primary) VALUES 
(1, 'MUJI/web_project/uploads/products/ao-thun-nam-1.jpg', 1),
(1, 'MUJI/web_project/uploads/products/ao-thun-nam-2.jpg', 0),
(2, 'MUJI/web_project/uploads/products/quan-jean-nam-1.jpg', 1),
(3, 'MUJI/web_project/uploads/products/ao-so-mi-nu-1.jpg', 1),
(4, 'MUJI/web_project/uploads/products/quan-culottes-nu-1.jpg', 1),
(5, 'MUJI/web_project/uploads/products/smartphone-1.jpg', 1);

-- Add products for Men's clothing subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(8, 'Áo polo nam AIRism', 'ao-polo-nam-airism', 'Áo polo nam chất liệu AIRism thoáng mát, thấm hút mồ hôi tốt, phù hợp mặc hàng ngày.', 290000, 250000, 120, 1),
(8, 'Áo thun nam cổ tròn cotton supima', 'ao-thun-nam-co-tron-cotton-supima', 'Áo thun nam chất liệu cotton supima cao cấp, mềm mại, bền màu.', 195000, NULL, 150, 1),
(8, 'Áo sơ mi nam oxford dài tay', 'ao-so-mi-nam-oxford-dai-tay', 'Áo sơ mi nam chất liệu oxford, form regular fit, dễ phối đồ.', 450000, 390000, 80, 0),
(8, 'Áo khoác nam chống nắng UV protection', 'ao-khoac-nam-chong-nang-uv-protection', 'Áo khoác nhẹ có khả năng chống tia UV, chất liệu mỏng nhẹ và thoáng khí.', 590000, NULL, 70, 1),
(9, 'Quần jeans nam slim-fit stretch', 'quan-jeans-nam-slim-fit-stretch', 'Quần jeans nam dáng slim-fit với chất liệu co giãn, thoải mái khi di chuyển.', 490000, 420000, 100, 1),
(9, 'Quần khaki nam regular-fit', 'quan-khaki-nam-regular-fit', 'Quần khaki nam form regular vừa vặn, chất vải cotton bền đẹp.', 390000, NULL, 85, 0),
(9, 'Quần short nam AIRism', 'quan-short-nam-airism', 'Quần short nam chất liệu AIRism thoáng mát, thích hợp mặc mùa hè hoặc tập thể thao.', 250000, 220000, 120, 1),
(10, 'Thắt lưng nam da thật', 'that-lung-nam-da-that', 'Thắt lưng nam làm từ da bò thật, khóa kim loại cao cấp, thiết kế thanh lịch.', 350000, NULL, 60, 0),
(10, 'Tất nam cổ ngắn set 3 đôi', 'tat-nam-co-ngan-set-3-doi', 'Bộ 3 đôi tất nam cổ ngắn, chất liệu cotton thấm hút tốt, nhiều màu sắc.', 120000, 99000, 200, 1);

-- Add products for Women's clothing subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(11, 'Áo thun nữ cổ tròn cotton', 'ao-thun-nu-co-tron-cotton', 'Áo thun nữ cổ tròn chất liệu cotton mềm mại, nhiều màu sắc để lựa chọn.', 180000, 150000, 180, 1),
(11, 'Áo sơ mi nữ linen dài tay', 'ao-so-mi-nu-linen-dai-tay', 'Áo sơ mi nữ chất liệu linen thoáng mát, dáng suông thanh lịch.', 420000, NULL, 90, 1),
(11, 'Áo len nữ cổ tròn merino', 'ao-len-nu-co-tron-merino', 'Áo len nữ chất liệu len merino mềm mại, không gây ngứa, giữ ấm tốt.', 590000, 490000, 70, 0),
(11, 'Áo khoác nữ dáng dài', 'ao-khoac-nu-dang-dai', 'Áo khoác nữ dáng dài, chất liệu polyester cao cấp, có thể chống nước nhẹ.', 850000, NULL, 50, 1),
(12, 'Quần jeans nữ dáng ống đứng', 'quan-jeans-nu-dang-ong-dung', 'Quần jeans nữ ống đứng, chất liệu denim co giãn, tôn dáng người mặc.', 450000, 390000, 95, 1),
(12, 'Váy liền thân dáng chữ A', 'vay-lien-than-dang-chu-a', 'Váy liền thân dáng chữ A, chất liệu cotton pha polyester, phù hợp mặc hàng ngày và đi làm.', 520000, NULL, 65, 0),
(12, 'Chân váy midi xếp ly', 'chan-vay-midi-xep-ly', 'Chân váy midi xếp ly thanh lịch, chất liệu polyester cao cấp, phù hợp mặc đi làm.', 450000, 380000, 60, 1),
(13, 'Túi xách nữ canvas', 'tui-xach-nu-canvas', 'Túi xách nữ chất liệu canvas bền đẹp, có nhiều ngăn tiện lợi, phù hợp đi làm và đi chơi.', 390000, NULL, 45, 1),
(13, 'Khăn choàng cổ nữ', 'khan-choang-co-nu', 'Khăn choàng cổ nữ chất liệu viscose mềm mại, nhiều họa tiết trang nhã.', 190000, 150000, 80, 0);

-- Add products for Electronics subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(14, 'Điện thoại thông minh ABC', 'dien-thoai-thong-minh-abc', 'Điện thoại thông minh với màn hình AMOLED 6.7 inch, camera 64MP, pin 5000mAh, sạc nhanh 67W.', 8500000, 7900000, 40, 1),
(14, 'Máy tính bảng Model Z Pro', 'may-tinh-bang-model-z-pro', 'Máy tính bảng màn hình 11 inch, chip xử lý mạnh mẽ, pin trâu, phù hợp làm việc và giải trí.', 9900000, NULL, 25, 1),
(15, 'Laptop ultrabook 14"', 'laptop-ultrabook-14', 'Laptop mỏng nhẹ, màn hình 14 inch, chip xử lý thế hệ mới, RAM 16GB, SSD 512GB.', 18500000, 17000000, 20, 1),
(15, 'Chuột không dây ergonomic', 'chuot-khong-day-ergonomic', 'Chuột không dây thiết kế công thái học, giảm mỏi cổ tay, độ nhạy cao, pin sử dụng lâu.', 650000, NULL, 100, 0);

-- Add products for Furniture subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(16, 'Ghế làm việc lưng cao', 'ghe-lam-viec-lung-cao', 'Ghế làm việc lưng cao với tựa đầu, tay vịn có thể điều chỉnh, chất liệu lưới thoáng khí.', 2500000, 2200000, 30, 1),
(16, 'Sofa 2 chỗ ngồi', 'sofa-2-cho-ngoi', 'Sofa 2 chỗ ngồi chất liệu vải canvas cao cấp, khung gỗ tự nhiên, thiết kế tối giản.', 4900000, NULL, 15, 1),
(16, 'Ghế đẩu gỗ oak', 'ghe-dau-go-oak', 'Ghế đẩu làm từ gỗ oak tự nhiên, thiết kế tối giản, phù hợp nhiều không gian.', 850000, 750000, 40, 0),
(17, 'Bàn làm việc gỗ tự nhiên', 'ban-lam-viec-go-tu-nhien', 'Bàn làm việc chất liệu gỗ tự nhiên, thiết kế tối giản với ngăn kéo tiện lợi.', 3200000, NULL, 25, 1),
(17, 'Bàn coffee tròn', 'ban-coffee-tron', 'Bàn coffee hình tròn, chân kim loại sơn đen, mặt gỗ công nghiệp phủ melamine.', 1500000, 1299000, 35, 0),
(18, 'Giường đôi khung gỗ', 'giuong-doi-khung-go', 'Giường đôi size 1m6 x 2m, khung gỗ tự nhiên chắc chắn, thiết kế tối giản.', 5900000, 5200000, 10, 1),
(18, 'Bộ chăn ga gối cotton', 'bo-chan-ga-goi-cotton', 'Bộ chăn ga gối chất liệu cotton 100%, mềm mại, thoáng khí, nhiều họa tiết và màu sắc.', 1200000, NULL, 50, 1);

-- Add products for Stationery subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(19, 'Bút gel 0.38mm set 5 cây', 'but-gel-038mm-set-5-cay', 'Bộ 5 bút gel mực đen, xanh, đỏ, nâu, xanh lá, đầu kim 0.38mm, viết mượt mà.', 95000, 80000, 150, 1),
(19, 'Bút chì cơ khí 0.5mm', 'but-chi-co-khi-05mm', 'Bút chì cơ khí thân nhôm, ngòi 0.5mm, có thể thay ruột, thiết kế tối giản.', 120000, NULL, 200, 0),
(20, 'Sổ tay bìa cứng A5', 'so-tay-bia-cung-a5', 'Sổ tay khổ A5 bìa cứng, giấy trắng trơn 100 gsm, 192 trang, có bookmark.', 150000, 120000, 100, 1),
(20, 'Giấy note vuông 7.5x7.5cm', 'giay-note-vuong-75x75cm', 'Giấy note vuông 7.5x7.5cm, 100 tờ/tập, giấy màu pastel, có keo dính ở cạnh.', 25000, NULL, 300, 0);

-- Add products for Household items subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(21, 'Nồi inox 3 đáy 24cm', 'noi-inox-3-day-24cm', 'Nồi inox 304 cao cấp 3 đáy, đường kính 24cm, nắp kính cường lực, tay cầm cách nhiệt.', 750000, 650000, 40, 1),
(21, 'Bộ dao nhà bếp 3 món', 'bo-dao-nha-bep-3-mon', 'Bộ 3 dao nhà bếp gồm dao thái, dao gọt, dao thớt, lưỡi thép không gỉ, cán gỗ tự nhiên.', 890000, NULL, 30, 1),
(22, 'Khăn tắm cotton 70x140cm', 'khan-tam-cotton-70x140cm', 'Khăn tắm chất liệu cotton 100%, kích thước 70x140cm, thấm hút tốt, mềm mại.', 190000, 150000, 80, 0),
(22, 'Giá đựng đồ phòng tắm 3 tầng', 'gia-dung-do-phong-tam-3-tang', 'Giá đựng đồ phòng tắm 3 tầng, chất liệu thép không gỉ, dễ dàng lắp đặt.', 320000, NULL, 45, 1);

-- Add products for Personal care subcategories
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES
(23, 'Son môi lì dưỡng ẩm', 'son-moi-li-duong-am', 'Son môi lì có chứa thành phần dưỡng ẩm, không gây khô môi, nhiều màu sắc thời trang.', 250000, 220000, 60, 1),
(23, 'Phấn phủ kiềm dầu', 'phan-phu-kiem-dau', 'Phấn phủ kiềm dầu, che phủ tốt, không gây bít lỗ chân lông, phù hợp da dầu và hỗn hợp.', 320000, NULL, 50, 0),
(24, 'Sữa rửa mặt dịu nhẹ 150ml', 'sua-rua-mat-diu-nhe-150ml', 'Sữa rửa mặt dịu nhẹ, không chứa sulfate, phù hợp mọi loại da, làm sạch sâu không gây khô.', 180000, 150000, 100, 1),
(24, 'Kem dưỡng ẩm chống nắng SPF50+ 50ml', 'kem-duong-am-chong-nang-spf50-50ml', 'Kem dưỡng ẩm tích hợp chống nắng SPF50+, bảo vệ da khỏi tia UV, không gây bít lỗ chân lông.', 390000, NULL, 70, 1);

-- Add product images
INSERT INTO product_images (product_id, image_path, is_primary) VALUES
(6, 'MUJI/web_project/uploads/products/ao-polo-nam-airism-1.jpg', 1),
(6, 'MUJI/web_project/uploads/products/ao-polo-nam-airism-2.jpg', 0),
(7, 'MUJI/web_project/uploads/products/ao-thun-nam-cotton-supima-1.jpg', 1),
(7, 'MUJI/web_project/uploads/products/ao-thun-nam-cotton-supima-2.jpg', 0),
(8, 'MUJI/web_project/uploads/products/ao-so-mi-nam-oxford-1.jpg', 1),
(9, 'MUJI/web_project/uploads/products/ao-khoac-nam-uv-1.jpg', 1),
(9, 'MUJI/web_project/uploads/products/ao-khoac-nam-uv-2.jpg', 0),
(10, 'MUJI/web_project/uploads/products/quan-jeans-nam-slim-fit-1.jpg', 1),
(11, 'MUJI/web_project/uploads/products/quan-khaki-nam-1.jpg', 1),
(12, 'MUJI/web_project/uploads/products/quan-short-nam-airism-1.jpg', 1),
(13, 'MUJI/web_project/uploads/products/that-lung-nam-1.jpg', 1),
(14, 'MUJI/web_project/uploads/products/tat-nam-set-3-1.jpg', 1),
(15, 'MUJI/web_project/uploads/products/ao-thun-nu-cotton-1.jpg', 1),
(15, 'MUJI/web_project/uploads/products/ao-thun-nu-cotton-2.jpg', 0),
(16, 'MUJI/web_project/uploads/products/ao-so-mi-nu-linen-1.jpg', 1),
(17, 'MUJI/web_project/uploads/products/ao-len-nu-merino-1.jpg', 1),
(18, 'MUJI/web_project/uploads/products/ao-khoac-nu-dai-1.jpg', 1),
(19, 'MUJI/web_project/uploads/products/quan-jeans-nu-1.jpg', 1),
(20, 'MUJI/web_project/uploads/products/vay-chu-a-1.jpg', 1),
(21, 'MUJI/web_project/uploads/products/chan-vay-midi-1.jpg', 1),
(22, 'MUJI/web_project/uploads/products/tui-xach-nu-1.jpg', 1),
(23, 'MUJI/web_project/uploads/products/khan-choang-co-1.jpg', 1),
(24, 'MUJI/web_project/uploads/products/dien-thoai-abc-1.jpg', 1),
(24, 'MUJI/web_project/uploads/products/dien-thoai-abc-2.jpg', 0),
(25, 'MUJI/web_project/uploads/products/may-tinh-bang-z-1.jpg', 1),
(26, 'MUJI/web_project/uploads/products/laptop-ultrabook-1.jpg', 1),
(27, 'MUJI/web_project/uploads/products/chuot-ergonomic-1.jpg', 1),
(28, 'MUJI/web_project/uploads/products/ghe-lam-viec-1.jpg', 1),
(29, 'MUJI/web_project/uploads/products/sofa-2-cho-1.jpg', 1),
(30, 'MUJI/web_project/uploads/products/ghe-dau-oak-1.jpg', 1),
(31, 'MUJI/web_project/uploads/products/ban-lam-viec-1.jpg', 1),
(32, 'MUJI/web_project/uploads/products/ban-coffee-1.jpg', 1),
(33, 'MUJI/web_project/uploads/products/giuong-doi-1.jpg', 1),
(34, 'MUJI/web_project/uploads/products/bo-chan-ga-1.jpg', 1),
(35, 'MUJI/web_project/uploads/products/but-gel-set-1.jpg', 1),
(36, 'MUJI/web_project/uploads/products/but-chi-co-khi-1.jpg', 1),
(37, 'MUJI/web_project/uploads/products/so-tay-a5-1.jpg', 1),
(38, 'MUJI/web_project/uploads/products/giay-note-1.jpg', 1),
(39, 'MUJI/web_project/uploads/products/noi-inox-1.jpg', 1),
(40, 'MUJI/web_project/uploads/products/bo-dao-1.jpg', 1),
(41, 'MUJI/web_project/uploads/products/khan-tam-1.jpg', 1),
(42, 'MUJI/web_project/uploads/products/gia-phong-tam-1.jpg', 1),
(43, 'MUJI/web_project/uploads/products/son-moi-1.jpg', 1),
(44, 'MUJI/web_project/uploads/products/phan-phu-1.jpg', 1),
(45, 'MUJI/web_project/uploads/products/sua-rua-mat-1.jpg', 1),
(46, 'MUJI/web_project/uploads/products/kem-chong-nang-1.jpg', 1);