<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/SiteInfoModel.php';

class ProductController {
    private $db;
    private $productModel;
    private $categoryModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }
    
    // Display product listing
    public function index() {
        // Get site info
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        
        // Validate page number
        if ($page < 1) $page = 1;
        
        // Get products with pagination
        $products = $this->productModel->getAllProducts($page, 12, $category, $search);
        $totalProducts = $this->productModel->countProducts($category, $search);
        $totalPages = ceil($totalProducts / 12); // 12 products per page
        
        // Get categories for sidebar
        $categories = $this->categoryModel->getAllCategories();
        
        // Define the data variable explicitly to be used in the view
        $data = [
            'products' => $products,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'category' => $category,
            'search' => $search
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/product_list.php';
    }
    
    // Display product details
    public function view($slug) {
        // Get site info
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Get product by slug
        $product = $this->productModel->getProductBySlug($slug);
        
        if (!$product) {
            // Product not found
            header('Location: /products');
            exit;
        }
        
        // Get product images
        $images = $this->productModel->getProductImages($product['id']);
        
        // Get related products
        $relatedProducts = $this->productModel->getRelatedProducts($product['id'], $product['category_id']);
        
        // Define the data variable explicitly to be used in the view
        $data = [
            'product' => $product,
            'images' => $images,
            'relatedProducts' => $relatedProducts
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/product_detail.php';
    }
}
?>