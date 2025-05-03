-- Simplified database schema for product display
-- DROP DATABASE IF EXISTS muji_web;
-- CREATE DATABASE muji_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- USE simple_shop;
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

-- Insert sample categories
INSERT INTO categories (name, slug, description) VALUES 
('Thời trang nam', 'thoi-trang-nam', 'Các sản phẩm thời trang dành cho nam giới'),
('Thời trang nữ', 'thoi-trang-nu', 'Các sản phẩm thời trang dành cho nữ giới'),
('Điện tử', 'dien-tu', 'Các sản phẩm điện tử, công nghệ');

-- Insert sample products
INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured) VALUES 
(1, 'Áo thun nam basic', 'ao-thun-nam-basic', 'Áo thun nam cổ tròn basic, chất liệu cotton 100%, mềm mại, thoáng mát.', 150000, 120000, 100, 1),
(1, 'Quần jean nam slim fit', 'quan-jean-nam-slim-fit', 'Quần jean nam dáng slim fit, chất liệu denim cao cấp, co giãn tốt.', 450000, NULL, 50, 1),
(2, 'Áo sơ mi nữ công sở', 'ao-so-mi-nu-cong-so', 'Áo sơ mi nữ dáng suông, phù hợp mặc đi làm, chất liệu lụa mềm mại.', 280000, 250000, 80, 1),
(2, 'Quần culottes nữ', 'quan-culottes-nu', 'Quần culottes nữ dáng rộng, chất liệu thoáng mát, phù hợp mùa hè.', 320000, NULL, 60, 0),
(3, 'Điện thoại Smartphone XYZ', 'dien-thoai-smartphone-xyz', 'Điện thoại thông minh với màn hình 6.5 inch, camera 48MP, pin 5000mAh.', 5000000, 4500000, 30, 1);

-- Insert product images
INSERT INTO product_images (product_id, image_path, is_primary) VALUES 
(1, 'MUJI/web_project/uploads/products/ao-thun-nam-1.jpg', 1),
(1, 'MUJI/web_project/uploads/products/ao-thun-nam-2.jpg', 0),
(2, 'MUJI/web_project/uploads/products/quan-jean-nam-1.jpg', 1),
(3, 'MUJI/web_project/uploads/products/ao-so-mi-nu-1.jpg', 1),
(4, 'MUJI/web_project/uploads/products/quan-culottes-nu-1.jpg', 1),
(5, 'MUJI/web_project/uploads/products/smartphone-1.jpg', 1);