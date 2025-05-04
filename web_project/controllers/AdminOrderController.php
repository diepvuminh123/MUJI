<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/User.php';

class AdminOrderController {
    private $db;
    private $orderModel;
    private $userModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->orderModel = new Order($db);
        $this->userModel = new User($db);
        
        // Check if user is logged in and is admin
        $this->checkAdminAuth();
    }
    
    /**
     * Display orders list in admin
     */
    public function index() {
        // Get query parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        
        // Validate page number
        if ($page < 1) $page = 1;
        
        // Get orders with pagination
        $limit = 10; // Orders per page
        $orders = $this->getAllOrders($page, $limit, $status, $search);
        $totalOrders = $this->countOrders($status, $search);
        
        // Calculate total pages
        $totalPages = ceil($totalOrders / $limit);
        
        // Pass data to view
        $data = [
            'orders' => $orders,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalOrders' => $totalOrders,
            'search' => $search,
            'status' => $status
        ];
        
        // Load view
        $pageTitle = 'Quản lý đơn hàng';
        require_once __DIR__ . '/../views/admin/orders/index.php';
    }
    
    /**
     * View order details
     */
    public function view() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Get order by ID
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            // Order not found
            $_SESSION['error_message'] = 'Đơn hàng không tồn tại.';
            header('Location: admin.php?action=adminOrders');
            exit;
        }
        
        // Get order items
        $orderItems = $this->orderModel->getOrderItems($id);
        
        // Get customer info if user account exists
        $customer = null;
        if ($order['user_id']) {
            $customer = $this->userModel->getUserById($order['user_id']);
        }
        
        // Pass data to view
        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'customer' => $customer
        ];
        
        // Load view
        $pageTitle = 'Chi tiết đơn hàng #' . $order['order_code'];
        require_once __DIR__ . '/../views/admin/orders/view.php';
        
    }
    
    /**
     * Generate printable invoice
     */
    public function invoice() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Get order by ID
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            // Order not found
            $_SESSION['error_message'] = 'Đơn hàng không tồn tại.';
            header('Location: admin.php?action=adminOrders');
            exit;
        }
        
        // Get order items
        $orderItems = $this->orderModel->getOrderItems($id);
        
        // Get customer info if user account exists
        $customer = null;
        if ($order['user_id']) {
            $customer = $this->userModel->getUserById($order['user_id']);
        }
        
        // Pass data to view
        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'customer' => $customer
        ];
        
        // Load view
        $pageTitle = 'Hóa đơn #' . $order['order_code'];
        require_once __DIR__ . '/../views/admin/orders/invoice.php';
    }
    
    /**
     * Update order status
     */
    public function updateStatus() {
        // Check if request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: admin.php?action=adminOrders');
            exit;
        }
        
        $id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        $status = isset($_POST['order_status']) ? $_POST['order_status'] : '';
        $paymentStatus = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';
        
        // Validate status
        $validOrderStatuses = ['pending', 'processing', 'shipping', 'completed', 'cancelled'];
        $validPaymentStatuses = ['pending', 'paid', 'refunded'];
        
        if (!in_array($status, $validOrderStatuses) || !in_array($paymentStatus, $validPaymentStatuses)) {
            $_SESSION['error_message'] = 'Trạng thái không hợp lệ.';
            header('Location: admin.php?action=viewOrder&id=' . $id);
            exit;
        }
        
        // Update order status
        $result = $this->updateOrderStatus($id, $status, $paymentStatus);
        
        if ($result) {
            $_SESSION['success_message'] = 'Cập nhật trạng thái đơn hàng thành công.';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.';
        }
        
        header('Location: admin.php?action=viewOrder&id=' . $id);
        exit;
    }
    
    /**
     * Get all orders with filters and pagination
     */
    private function getAllOrders($page = 1, $limit = 10, $status = null, $search = null) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT o.*, u.full_name as user_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE 1=1";
        
        $params = [];
        $types = "";
        
        // Apply status filter if provided
        if ($status) {
            $sql .= " AND o.order_status = ?";
            $params[] = $status;
            $types .= "s";
        }
        
        // Apply search if provided
        if ($search) {
            $sql .= " AND (o.order_code LIKE ? OR o.customer_name LIKE ? OR o.customer_email LIKE ? OR o.customer_phone LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "ssss";
        }
        
        // Order by latest first
        $sql .= " ORDER BY o.created_at DESC LIMIT ?, ?";
        
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
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        
        return $orders;
    }
    
    /**
     * Count total orders with filters
     */
    private function countOrders($status = null, $search = null) {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE 1=1";
        
        $params = [];
        $types = "";
        
        // Apply status filter if provided
        if ($status) {
            $sql .= " AND order_status = ?";
            $params[] = $status;
            $types .= "s";
        }
        
        // Apply search if provided
        if ($search) {
            $sql .= " AND (order_code LIKE ? OR customer_name LIKE ? OR customer_email LIKE ? OR customer_phone LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "ssss";
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
     * Update order status
     */
    private function updateOrderStatus($orderId, $status, $paymentStatus) {
        $sql = "UPDATE orders SET order_status = ?, payment_status = ?, updated_at = NOW() WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $status, $paymentStatus, $orderId);
        
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