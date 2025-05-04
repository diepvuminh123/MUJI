<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class AdminProductController {
    private $db;
    private $productModel;
    private $categoryModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
        
        // Check if user is logged in and is admin
        $this->checkAdminAuth();
    }
    
    /**
     * Display product list in admin
     */
    public function index() {
        // Get query parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        
        // Validate page number
        if ($page < 1) $page = 1;
        
        // Get products with pagination
        $limit = 10; // Products per page
        $products = $this->productModel->getAllProducts($page, $limit, null, $search);
        $totalProducts = $this->productModel->countProducts(null, $search);
        
        // Calculate total pages
        $totalPages = ceil($totalProducts / $limit);
        
        // Pass data to view
        $data = [
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'search' => $search
        ];
        
        // Load view
        $pageTitle = 'Quản lý sản phẩm';
        require_once __DIR__ . '/../views/admin/products/index.php';
    }
    
    /**
     * Create new product form
     */
    public function create() {
        // Get all categories for the form
        $categories = $this->categoryModel->getAllCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            $errors = $this->validateProductForm($_POST);
            
            if (empty($errors)) {
                // Process product creation
                $product = [
                    'name' => $_POST['name'],
                    'slug' => $this->createSlug($_POST['name']),
                    'category_id' => $_POST['category_id'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'sale_price' => !empty($_POST['sale_price']) ? $_POST['sale_price'] : null,
                    'quantity' => $_POST['quantity'],
                    'featured' => isset($_POST['featured']) ? 1 : 0,
                    'status' => $_POST['status']
                ];
                
                // Insert product
                $sql = "INSERT INTO products (category_id, name, slug, description, price, sale_price, quantity, featured, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param(
                    "isssddiis", 
                    $product['category_id'], 
                    $product['name'], 
                    $product['slug'], 
                    $product['description'], 
                    $product['price'], 
                    $product['sale_price'], 
                    $product['quantity'], 
                    $product['featured'], 
                    $product['status']
                );
                
                if ($stmt->execute()) {
                    $productId = $this->db->insert_id;
                    
                    // Handle image uploads
                    if (isset($_FILES['images']) && $_FILES['images']['error'][0] != UPLOAD_ERR_NO_FILE) {
                        $this->handleImageUploads($productId, $_FILES['images']);
                    }
                    
                    // Set success message and redirect
                    $_SESSION['success_message'] = 'Sản phẩm đã được tạo thành công!';
                    header('Location: admin.php?action=adminProducts');
                    exit;
                } else {
                    $errors[] = 'Có lỗi xảy ra khi tạo sản phẩm: ' . $this->db->error;
                }
            }
            
            // If there were errors, pass them to the view
            $data = [
                'categories' => $categories,
                'errors' => $errors,
                'formData' => $_POST
            ];
        } else {
            // Initial form load
            $data = [
                'categories' => $categories,
                'errors' => [],
                'formData' => []
            ];
        }
        
        // Load view
        $pageTitle = 'Thêm sản phẩm mới';
        require_once __DIR__ . '/../views/admin/products/create.php';
    }
    
    /**
     * Edit product
     */
    public function edit($id = null) {
        if ($id === null) {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        }
        
        // Get product by ID
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if (!$product) {
            // Product not found
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại.';
            header('Location: admin.php?action=adminProducts');
            exit;
        }
        
        // Get product images
        $sql = "SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        
        // Get all categories for the form
        $categories = $this->categoryModel->getAllCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            $errors = $this->validateProductForm($_POST);
            
            if (empty($errors)) {
                // Process product update
                $product = [
                    'id' => $id,
                    'name' => $_POST['name'],
                    'slug' => $this->createSlug($_POST['name'], $id),
                    'category_id' => $_POST['category_id'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'sale_price' => !empty($_POST['sale_price']) ? $_POST['sale_price'] : null,
                    'quantity' => $_POST['quantity'],
                    'featured' => isset($_POST['featured']) ? 1 : 0,
                    'status' => $_POST['status']
                ];
                
                // Update product
                $sql = "UPDATE products SET 
                        category_id = ?, 
                        name = ?, 
                        slug = ?, 
                        description = ?, 
                        price = ?, 
                        sale_price = ?, 
                        quantity = ?, 
                        featured = ?, 
                        status = ? 
                        WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param(
                    "isssddiisi", 
                    $product['category_id'], 
                    $product['name'], 
                    $product['slug'], 
                    $product['description'], 
                    $product['price'], 
                    $product['sale_price'], 
                    $product['quantity'], 
                    $product['featured'], 
                    $product['status'],
                    $product['id']
                );
                
                if ($stmt->execute()) {
                    // Handle image uploads
                    if (isset($_FILES['images']) && $_FILES['images']['error'][0] != UPLOAD_ERR_NO_FILE) {
                        $this->handleImageUploads($id, $_FILES['images']);
                    }
                    
                    // Set primary image if selected
                    if (isset($_POST['primary_image'])) {
                        $this->setPrimaryImage($_POST['primary_image']);
                    }
                    
                    // Set success message and redirect
                    $_SESSION['success_message'] = 'Sản phẩm đã được cập nhật thành công!';
                    header('Location: admin.php?action=adminProducts');
                    exit;
                } else {
                    $errors[] = 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $this->db->error;
                }
            }
            
            // If there were errors, get updated product data
            $sql = "SELECT * FROM products WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            
            // Pass data to view
            $data = [
                'product' => $product,
                'images' => $images,
                'categories' => $categories,
                'errors' => $errors,
                'formData' => $_POST
            ];
        } else {
            // Initial form load
            $data = [
                'product' => $product,
                'images' => $images,
                'categories' => $categories,
                'errors' => [],
                'formData' => $product
            ];
        }
        
        // Load view
        $pageTitle = 'Sửa sản phẩm';
        require_once __DIR__ . '/../views/admin/products/edit.php';
    }
    
    /**
     * Delete product
     */
    public function delete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Check if product exists
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if (!$product) {
            // Product not found
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại.';
            header('Location: admin.php?action=adminProducts');
            exit;
        }
        
        // Get product images for deletion
        $sql = "SELECT image_path FROM product_images WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['image_path'];
        }
        
        // Delete product from database
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Delete image files from server
            foreach ($images as $imagePath) {
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            
            $_SESSION['success_message'] = 'Sản phẩm đã được xóa thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa sản phẩm: ' . $this->db->error;
        }
        
        header('Location: admin.php?action=adminProducts');
        exit;
    }
    
    /**
     * Delete product image
     */
    public function deleteImage() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Get image info
        $sql = "SELECT * FROM product_images WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();
        
        if (!$image) {
            $_SESSION['error_message'] = 'Hình ảnh không tồn tại.';
            header('Location: admin.php?action=adminProducts');
            exit;
        }
        
        // Delete image from database
        $sql = "DELETE FROM product_images WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Delete image file from server
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . $image['image_path'];
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            
            // If this was the primary image, set another image as primary
            if ($image['is_primary']) {
                $sql = "UPDATE product_images SET is_primary = 1 WHERE product_id = ? LIMIT 1";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $image['product_id']);
                $stmt->execute();
            }
            
            $_SESSION['success_message'] = 'Hình ảnh đã được xóa thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa hình ảnh: ' . $this->db->error;
        }
        
        // Redirect back to edit product page
        header('Location: admin.php?action=editProduct&id=' . $image['product_id']);
        exit;
    }
    
    /**
     * Set image as primary
     */
    public function setPrimaryImage($imageId = null) {
        if ($imageId === null) {
            $imageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        }
        
        // Get image info
        $sql = "SELECT * FROM product_images WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();
        
        if (!$image) {
            $_SESSION['error_message'] = 'Hình ảnh không tồn tại.';
            header('Location: admin.php?action=adminProducts');
            exit;
        }
        
        // Remove primary flag from all images of this product
        $sql = "UPDATE product_images SET is_primary = 0 WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $image['product_id']);
        $stmt->execute();
        
        // Set this image as primary
        $sql = "UPDATE product_images SET is_primary = 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $imageId);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Đã đặt hình ảnh làm ảnh chính thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi đặt hình ảnh làm ảnh chính: ' . $this->db->error;
        }
        
        // Redirect back to edit product page if called directly
        if (!is_null($imageId) && isset($_GET['id'])) {
            header('Location: admin.php?action=editProduct&id=' . $image['product_id']);
            exit;
        }
        
        return $stmt->affected_rows > 0;
    }
    
    /**
     * Handle image uploads for a product
     */
    private function handleImageUploads($productId, $files) {
        // Create upload directory if it doesn't exist
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/MUJI/web_project/uploads/products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Check if there are any existing images for this product
        $sql = "SELECT COUNT(*) as count FROM product_images WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $existingImagesCount = $row['count'];
        
        // Process each uploaded file
        $uploadedCount = 0;
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $files['tmp_name'][$i];
                $originalName = $files['name'][$i];
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                
                // Generate a unique filename
                $newFilename = 'product_' . $productId . '_' . uniqid() . '.' . $extension;
                $destination = $uploadDir . $newFilename;
                
                // Move uploaded file
                if (move_uploaded_file($tmpName, $destination)) {
                    // Set relative path for database
                    $relativePath = '/MUJI/web_project/uploads/products/' . $newFilename;
                    
                    // Determine if this image should be primary
                    $isPrimary = ($existingImagesCount == 0 && $uploadedCount == 0) ? 1 : 0;
                    
                    // Save image info to database
                    $sql = "INSERT INTO product_images (product_id, image_path, is_primary) VALUES (?, ?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bind_param("isi", $productId, $relativePath, $isPrimary);
                    $stmt->execute();
                    
                    $uploadedCount++;
                }
            }
        }
        
        return $uploadedCount;
    }
    
    /**
     * Create a SEO-friendly slug from a string
     */
    private function createSlug($string, $exceptId = null) {
        // Convert to lowercase
        $slug = mb_strtolower($string, 'UTF-8');
        
        // Replace accented characters with non-accented
        $slug = $this->removeAccents($slug);
        
        // Replace spaces with hyphens
        $slug = preg_replace('/\s+/', '-', $slug);
        
        // Remove all non-alphanumeric characters except hyphens
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        
        // Remove duplicate hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Trim hyphens from beginning and end
        $slug = trim($slug, '-');
        
        // Ensure slug is unique
        $baseSlug = $slug;
        $count = 1;
        
        while (true) {
            // Check if slug exists for another product
            $sql = "SELECT id FROM products WHERE slug = ?";
            if ($exceptId !== null) {
                $sql .= " AND id != ?";
            }
            
            $stmt = $this->db->prepare($sql);
            if ($exceptId !== null) {
                $stmt->bind_param("si", $slug, $exceptId);
            } else {
                $stmt->bind_param("s", $slug);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 0) {
                // Slug is unique
                break;
            }
            
            // Append counter to slug
            $slug = $baseSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }
    
    /**
     * Remove accents from a string
     */
    private function removeAccents($string) {
        if (!preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }
        
        $accentMap = [
            'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'đ' => 'd',
            'é' => 'e', 'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e', 'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o', 'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u', 'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y'
        ];
        
        return strtr($string, $accentMap);
    }
    
    /**
     * Validate product form data
     */
    private function validateProductForm($data) {
        $errors = [];
        
        // Required fields
        $requiredFields = [
            'name' => 'Tên sản phẩm',
            'category_id' => 'Danh mục',
            'price' => 'Giá bán',
            'quantity' => 'Số lượng',
            'description' => 'Mô tả',
            'status' => 'Trạng thái'
        ];
        
        foreach ($requiredFields as $field => $label) {
            if (empty($data[$field])) {
                $errors[] = "Vui lòng nhập {$label}.";
            }
        }
        
        // Numeric fields
        if (!empty($data['price']) && !is_numeric($data['price'])) {
            $errors[] = 'Giá bán phải là số.';
        }
        
        if (!empty($data['sale_price']) && !is_numeric($data['sale_price'])) {
            $errors[] = 'Giá khuyến mãi phải là số.';
        }
        
        if (!empty($data['quantity']) && !is_numeric($data['quantity'])) {
            $errors[] = 'Số lượng phải là số.';
        }
        
        // Sale price must be less than regular price
        if (!empty($data['sale_price']) && !empty($data['price']) && $data['sale_price'] >= $data['price']) {
            $errors[] = 'Giá khuyến mãi phải nhỏ hơn giá bán.';
        }
        
        return $errors;
    }
    
    /**
     * Check admin authentication
     */
    private function checkAdminAuth() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Redirect to login page
            $_SESSION['error_message'] = 'Bạn cần đăng nhập với tư cách quản trị viên để truy cập trang này.';
            header('Location: index.php?action=login');
            exit;
        }
    }
}