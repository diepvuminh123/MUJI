<?php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/User.php';

class AdminCartController {
    private $db;
    private $cartModel;
    private $userModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->cartModel = new Cart($db);
        $this->userModel = new User($db);
        
        // Check if user is logged in and is admin
        $this->checkAdminAuth();
    }
    
    /**
     * Display carts list in admin
     */
    public function index() {
        // Get query parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
        
        // Validate page number
        if ($page < 1) $page = 1;
        
        // Get carts with pagination
        $limit = 10; // Carts per page
        $carts = $this->getAllCarts($page, $limit, $userId, $search);
        $totalCarts = $this->countCarts($userId, $search);
        
        // Calculate total pages
        $totalPages = ceil($totalCarts / $limit);
        
        // Pass data to view
        $data = [
            'carts' => $carts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCarts' => $totalCarts,
            'search' => $search,
            'userId' => $userId
        ];
        
        // Load view
        $pageTitle = 'Quản lý giỏ hàng';
        require_once __DIR__ . '/../views/admin/carts/index.php';
    }
    
    /**
     * View cart details
     */
    public function view() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Get cart by ID
        $cart = $this->getCartById($id);
        
        if (!$cart) {
            // Cart not found
            $_SESSION['error_message'] = 'Giỏ hàng không tồn tại.';
            header('Location: admin.php?action=adminCarts');
            exit;
        }
        
        // Get cart items
        $cartItems = $this->cartModel->getCartItems($id);
        
        // Get cart total
        $cartTotal = $this->cartModel->getCartTotal($id);
        
        // Get customer info if user account exists
        $customer = null;
        if ($cart['user_id']) {
            $customer = $this->userModel->getUserById($cart['user_id']);
        }
        
        // Pass data to view
        $data = [
            'cart' => $cart,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'customer' => $customer
        ];
        
        // Load view
        $pageTitle = 'Chi tiết giỏ hàng #' . $cart['id'];
        require_once __DIR__ . '/../views/admin/carts/view.php';
    }
    
    /**
     * Delete cart item
     */
    public function removeCartItem() {
        $itemId = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;
        $cartId = isset($_GET['cart_id']) ? (int)$_GET['cart_id'] : 0;
        
        if (!$itemId || !$cartId) {
            $_SESSION['error_message'] = 'Thiếu thông tin cần thiết.';
            header('Location: admin.php?action=adminCarts');
            exit;
        }
        
        // Remove cart item
        $result = $this->cartModel->removeCartItem($itemId);
        
        if ($result) {
            $_SESSION['success_message'] = 'Đã xóa sản phẩm khỏi giỏ hàng thành công.';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.';
        }
        
        header('Location: admin.php?action=viewCart&id=' . $cartId);
        exit;
    }
    
    /**
     * Clear cart
     */
    public function clearCart() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            $_SESSION['error_message'] = 'Thiếu thông tin cần thiết.';
            header('Location: admin.php?action=adminCarts');
            exit;
        }
        
        // Clear cart
        $result = $this->cartModel->clearCart($id);
        
        if ($result) {
            $_SESSION['success_message'] = 'Đã xóa tất cả sản phẩm trong giỏ hàng thành công.';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa giỏ hàng.';
        }
        
        header('Location: admin.php?action=viewCart&id=' . $id);
        exit;
    }
    
    /**
     * Delete cart
     */
    public function deleteCart() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            $_SESSION['error_message'] = 'Thiếu thông tin cần thiết.';
            header('Location: admin.php?action=adminCarts');
            exit;
        }
        
        // Delete cart
        $result = $this->deleteCartFromDB($id);
        
        if ($result) {
            $_SESSION['success_message'] = 'Đã xóa giỏ hàng thành công.';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa giỏ hàng.';
        }
        
        header('Location: admin.php?action=adminCarts');
        exit;
    }
    
    /**
     * Get all carts with filters and pagination
     */
    private function getAllCarts($page = 1, $limit = 10, $userId = null, $search = null) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT c.*, u.full_name as user_name, 
                COUNT(ci.id) as item_count, 
                SUM(ci.quantity) as total_quantity 
                FROM carts c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN cart_items ci ON c.id = ci.cart_id 
                WHERE 1=1";
        
        $params = [];
        $types = "";
        
        // Apply user filter if provided
        if ($userId) {
            $sql .= " AND c.user_id = ?";
            $params[] = $userId;
            $types .= "i";
        }
        
        // Apply search if provided
        if ($search) {
            $sql .= " AND (u.full_name LIKE ? OR u.email LIKE ? OR c.session_id LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "sss";
        }
        
        // Group by cart ID
        $sql .= " GROUP BY c.id";
        
        // Order by latest first
        $sql .= " ORDER BY c.updated_at DESC LIMIT ?, ?";
        
        // Add pagination parameters
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";
        
        // Execute query
        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $carts = [];
        while ($row = $result->fetch_assoc()) {
            $carts[] = $row;
        }
        
        return $carts;
    }
    
    /**
     * Count total carts with filters
     */
    private function countCarts($userId = null, $search = null) {
        $sql = "SELECT COUNT(DISTINCT c.id) as total FROM carts c LEFT JOIN users u ON c.user_id = u.id WHERE 1=1";
        
        $params = [];
        $types = "";
        
        // Apply user filter if provided
        if ($userId) {
            $sql .= " AND c.user_id = ?";
            $params[] = $userId;
            $types .= "i";
        }
        
        // Apply search if provided
        if ($search) {
            $sql .= " AND (u.full_name LIKE ? OR u.email LIKE ? OR c.session_id LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "sss";
        }
        
        // Execute query
        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    /**
     * Get cart by ID
     */
    private function getCartById($id) {
        $sql = "SELECT c.*, u.full_name as user_name, u.email as user_email 
                FROM carts c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Delete cart from database
     */
    private function deleteCartFromDB($id) {
        $sql = "DELETE FROM carts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
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