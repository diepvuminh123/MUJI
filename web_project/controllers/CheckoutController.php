<?php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/SiteInfoModel.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';

class CheckoutController {
    private $db;
    private $cartModel;
    private $orderModel;
    private $userModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->cartModel = new Cart($db);
        $this->orderModel = new Order($db);
        $this->userModel = new User($db);
        
        // Đảm bảo session đã được khởi tạo
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Hiển thị trang thanh toán
     */
    public function index() {
        // Kiểm tra giỏ hàng
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        $sessionId = session_id();
        
        // Lấy thông tin giỏ hàng
        $cart = $this->cartModel->getCart($userId, $sessionId);
        
        if (!$cart || $this->cartModel->countCartItems($userId, $sessionId) === 0) {
            // Giỏ hàng trống
            $_SESSION['error_message'] = 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.';
            header('Location: index.php?action=cart');
            exit;
        }
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Lấy danh sách sản phẩm trong giỏ hàng
        $cartItems = $this->cartModel->getCartItems($cart['id']);
        $cartTotal = $this->cartModel->getCartTotal($cart['id']);
        
        // Tạo form data (nếu người dùng đã đăng nhập, lấy thông tin từ tài khoản)
        $formData = [];
        
        if ($userId) {
            $user = $this->userModel->getUserById($userId);
            
            if ($user) {
                $formData = [
                    'customer_name' => $user['full_name'],
                    'customer_email' => $user['email'],
                    'customer_phone' => $user['phone'],
                    'customer_address' => $user['address'],
                ];
            }
        }
        
        // Dữ liệu gửi cho view
        $data = [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'formData' => $formData
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/checkout.php';
    }
    
    /**
     * Xử lý đặt hàng
     */
    public function placeOrder() {
        // Kiểm tra nếu là yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=checkout');
            exit;
        }
        
        // Kiểm tra giỏ hàng
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        $sessionId = session_id();
        
        // Lấy thông tin giỏ hàng
        $cart = $this->cartModel->getCart($userId, $sessionId);
        
        if (!$cart || $this->cartModel->countCartItems($userId, $sessionId) === 0) {
            // Giỏ hàng trống
            $_SESSION['error_message'] = 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.';
            header('Location: index.php?action=cart');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $orderData = [
            'user_id' => $userId,
            'customer_name' => $_POST['customer_name'] ?? '',
            'customer_email' => $_POST['customer_email'] ?? '',
            'customer_phone' => $_POST['customer_phone'] ?? '',
            'customer_address' => $_POST['customer_address'] ?? '',
            'payment_method' => $_POST['payment_method'] ?? 'cod',
            'order_notes' => $_POST['order_notes'] ?? ''
        ];
        
        // Validate dữ liệu
        $errors = [];
        
        if (empty($orderData['customer_name'])) {
            $errors[] = 'Vui lòng nhập họ tên.';
        }
        
        if (empty($orderData['customer_email']) || !filter_var($orderData['customer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Vui lòng nhập email hợp lệ.';
        }
        
        if (empty($orderData['customer_phone'])) {
            $errors[] = 'Vui lòng nhập số điện thoại.';
        }
        
        if (empty($orderData['customer_address'])) {
            $errors[] = 'Vui lòng nhập địa chỉ giao hàng.';
        }
        
        if (!in_array($orderData['payment_method'], ['cod', 'bank_transfer'])) {
            $errors[] = 'Phương thức thanh toán không hợp lệ.';
        }
        
        // Nếu có lỗi, hiển thị lại form thanh toán kèm thông báo lỗi
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            $_SESSION['checkout_form_data'] = $orderData;
            header('Location: index.php?action=checkout');
            exit;
        }
        
        // Tạo đơn hàng
        $orderId = $this->orderModel->createFromCart($cart['id'], $orderData);
        
        if (!$orderId) {
            // Lỗi khi tạo đơn hàng
            $_SESSION['error_message'] = 'Đã xảy ra lỗi khi xử lý đơn hàng. Vui lòng thử lại sau.';
            header('Location: index.php?action=checkout');
            exit;
        }
        
        // Đặt hàng thành công
        $_SESSION['success_message'] = 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.';
        
        // Chuyển hướng đến trang xác nhận đơn hàng
        header("Location: index.php?action=order_confirmation&id=$orderId");
        exit;
    }
    
    /**
     * Hiển thị trang xác nhận đơn hàng
     */
    public function orderConfirmation() {
        // Lấy ID đơn hàng
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($orderId <= 0) {
            // ID đơn hàng không hợp lệ
            header('Location: index.php');
            exit;
        }
        
        // Lấy thông tin đơn hàng
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order) {
            // Đơn hàng không tồn tại
            $_SESSION['error_message'] = 'Đơn hàng không tồn tại.';
            header('Location: index.php');
            exit;
        }
        
        // Kiểm tra quyền truy cập (chỉ cho phép xem đơn hàng của chính mình)
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        
        if ($order['user_id'] && $order['user_id'] != $userId) {
            // Đơn hàng không thuộc về người dùng hiện tại
            $_SESSION['error_message'] = 'Bạn không có quyền xem đơn hàng này.';
            header('Location: index.php');
            exit;
        }
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Lấy danh sách sản phẩm trong đơn hàng
        $orderItems = $this->orderModel->getOrderItems($orderId);
        
        // Dữ liệu gửi cho view
        $data = [
            'order' => $order,
            'orderItems' => $orderItems
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/order_confirmation.php';
    }
    
    /**
     * Hiển thị danh sách đơn hàng của người dùng
     */
    public function myOrders() {
        // Yêu cầu đăng nhập
        AuthMiddleware::requireLogin();
        
        // Lấy ID người dùng
        $userId = $_SESSION['user']['id'];
        
        // Phân trang
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Lấy danh sách đơn hàng
        $orders = $this->orderModel->getOrdersByUser($userId, $limit, $offset);
        $totalOrders = $this->orderModel->countOrdersByUser($userId);
        
        // Tính tổng số trang
        $totalPages = ceil($totalOrders / $limit);
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Dữ liệu gửi cho view
        $data = [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/my_orders.php';
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function orderDetail() {
        // Yêu cầu đăng nhập
        AuthMiddleware::requireLogin();
        
        // Lấy ID đơn hàng
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($orderId <= 0) {
            // ID đơn hàng không hợp lệ
            $_SESSION['error_message'] = 'ID đơn hàng không hợp lệ.';
            header('Location: index.php?action=my_orders');
            exit;
        }
        
        // Lấy thông tin đơn hàng
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order) {
            // Đơn hàng không tồn tại
            $_SESSION['error_message'] = 'Đơn hàng không tồn tại.';
            header('Location: index.php?action=my_orders');
            exit;
        }
        
        // Kiểm tra quyền truy cập (chỉ cho phép xem đơn hàng của chính mình)
        $userId = $_SESSION['user']['id'];
        
        if ($order['user_id'] != $userId) {
            // Đơn hàng không thuộc về người dùng hiện tại
            $_SESSION['error_message'] = 'Bạn không có quyền xem đơn hàng này.';
            header('Location: index.php?action=my_orders');
            exit;
        }
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Lấy danh sách sản phẩm trong đơn hàng
        $orderItems = $this->orderModel->getOrderItems($orderId);
        
        // Dữ liệu gửi cho view
        $data = [
            'order' => $order,
            'orderItems' => $orderItems
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/order_detail.php';
    }
    
    /**
     * Hủy đơn hàng
     */
    public function cancelOrder() {
        // Yêu cầu đăng nhập
        AuthMiddleware::requireLogin();
        
        // Kiểm tra nếu là yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=my_orders');
            exit;
        }
        
        // Lấy ID đơn hàng
        $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        
        if ($orderId <= 0) {
            // ID đơn hàng không hợp lệ
            $_SESSION['error_message'] = 'ID đơn hàng không hợp lệ.';
            header('Location: index.php?action=my_orders');
            exit;
        }
        
        // Lấy ID người dùng
        $userId = $_SESSION['user']['id'];
        
        // Hủy đơn hàng
        $result = $this->orderModel->cancelOrder($orderId, $userId);
        
        if ($result) {
            // Hủy đơn hàng thành công
            $_SESSION['success_message'] = 'Đơn hàng đã được hủy thành công.';
        } else {
            // Lỗi khi hủy đơn hàng
            $_SESSION['error_message'] = 'Không thể hủy đơn hàng. Đơn hàng có thể đã được xử lý hoặc giao hàng.';
        }
        
        // Chuyển hướng đến trang chi tiết đơn hàng
        header("Location: index.php?action=order_detail&id=$orderId");
        exit;
    }
}
?>