<?php
class Product {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    // Get products with pagination
    public function getAllProducts($page = 1, $limit = 12, $category = null, $search = null) {
        require_once __DIR__ . '/../config/config.php';
        
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT p.*, c.name as category_name, 
                (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 'active'";
        
        if ($category) {
            $sql .= " AND p.category_id = ?";
        }
        
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT ?, ?";
        
        $stmt = $this->db->prepare($sql);
        
        if ($category && $search) {
            $searchParam = "%$search%";
            $stmt->bind_param("isii", $category, $searchParam, $searchParam, $offset, $limit);
        } elseif ($category) {
            $stmt->bind_param("iii", $category, $offset, $limit);
        } elseif ($search) {
            $searchParam = "%$search%";
            $stmt->bind_param("ssii", $searchParam, $searchParam, $offset, $limit);
        } else {
            $stmt->bind_param("ii", $offset, $limit);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }
    
    // Count total products
    public function countProducts($category = null, $search = null) {
        require_once __DIR__ . '/../config/config.php';
        
        $sql = "SELECT COUNT(*) as total FROM products WHERE status = 'active'";
        
        if ($category) {
            $sql .= " AND category_id = ?";
        }
        
        if ($search) {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($category && $search) {
            $searchParam = "%$search%";
            $stmt->bind_param("iss", $category, $searchParam, $searchParam);
        } elseif ($category) {
            $stmt->bind_param("i", $category);
        } elseif ($search) {
            $searchParam = "%$search%";
            $stmt->bind_param("ss", $searchParam, $searchParam);
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