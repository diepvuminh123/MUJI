<?php
class Product {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    // Trong file Product.php
    public function getAllProducts($page = 1, $limit = 12, $category = null, $search = null, $sort = null, $sale = null, $price_min = null, $price_max = null) {
        require_once __DIR__ . '/../config/config.php';
        
        $offset = ($page - 1) * $limit;
        
        // Sử dụng subquery để xác định giá hiển thị (sale_price hoặc price)
        $sql = "SELECT p.*, c.name as category_name, 
                (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image,
                IF(p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price, p.sale_price, p.price) as display_price
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 'active'";
        
        $params = [];
        $types = "";
        
        // Xử lý các tham số lọc
        if ($category) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
            $types .= "i";
        }
        
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "ss";
        }
        
        if ($sale == '1') {
            $sql .= " AND p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price";
        }
        
        // Thêm lọc theo khoảng giá
        if ($price_min !== null && is_numeric($price_min)) {
            $sql .= " AND IF(p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price, p.sale_price, p.price) >= ?";
            $params[] = $price_min;
            $types .= "d";
        }
        
        if ($price_max !== null && is_numeric($price_max)) {
            $sql .= " AND IF(p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price, p.sale_price, p.price) <= ?";
            $params[] = $price_max;
            $types .= "d";
        }
        
        // Xử lý sắp xếp
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY display_price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY display_price DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY p.name ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY p.name DESC";
                break;
            case 'newest':
                $sql .= " ORDER BY p.created_at DESC";
                break;
            default:
                $sql .= " ORDER BY p.created_at DESC";
        }
        
        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }
    
    public function countProducts($category = null, $search = null, $sale = null, $price_min = null, $price_max = null) {
        require_once __DIR__ . '/../config/config.php';
        
        $sql = "SELECT COUNT(*) as total FROM products p WHERE p.status = 'active'";
        
        $params = [];
        $types = "";
        
        if ($category) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
            $types .= "i";
        }
        
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "ss";
        }
        
        if ($sale == '1') {
            $sql .= " AND p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price";
        }
        
        // Thêm lọc theo khoảng giá
        if ($price_min !== null && is_numeric($price_min)) {
            $sql .= " AND IF(p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price, p.sale_price, p.price) >= ?";
            $params[] = $price_min;
            $types .= "d";
        }
        
        if ($price_max !== null && is_numeric($price_max)) {
            $sql .= " AND IF(p.sale_price IS NOT NULL AND p.sale_price > 0 AND p.sale_price < p.price, p.sale_price, p.price) <= ?";
            $params[] = $price_max;
            $types .= "d";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    // Get product by slug
    public function getProductBySlug($slug) {
        require_once __DIR__ . '/../config/config.php';
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = ? AND p.status = 'active'";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    // Get product images
    public function getProductImages($productId) {
        require_once __DIR__ . '/../config/config.php';
        
        $sql = "SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        
        return $images;
    }
    
    // Get related products
    public function getRelatedProducts($productId, $categoryId, $limit = 4) {
        require_once __DIR__ . '/../config/config.php';
        
        $sql = "SELECT p.*, 
                (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image 
                FROM products p 
                WHERE p.category_id = ? AND p.id != ? AND p.status = 'active' 
                ORDER BY RAND() 
                LIMIT ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $categoryId, $productId, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }
        // Sản phẩm nổi bật
    public function getFeaturedProducts($limit = 8) {
        $sql = "SELECT p.*, 
            (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) AS primary_image
            FROM products p
            WHERE p.featured = 1 AND p.status = 'active'
            ORDER BY p.created_at DESC
            LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Sản phẩm mới
    public function getNewProducts($limit = 8) {
        $sql = "SELECT p.*, 
            (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) AS primary_image
            FROM products p
            WHERE p.status = 'active'
            ORDER BY p.created_at DESC
            LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Sản phẩm bán chạy (giả sử nhiều hàng tồn là bán chạy)
    public function getBestsellerProducts($limit = 8) {
        $sql = "SELECT p.*, 
            (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) AS primary_image
            FROM products p
            WHERE p.status = 'active'
            ORDER BY quantity DESC
            LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
?>