<?php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/SiteInfoModel.php';

class CartController {
    private $db;
    private $cartModel;
    private $productModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->cartModel = new Cart($db);
        $this->productModel = new Product($db);
        
        // Đảm bảo session đã được khởi tạo
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Hiển thị trang giỏ hàng
     */
    public function index() {
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Lấy ID người dùng nếu đã đăng nhập
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        $sessionId = session_id();
        
        // Lấy hoặc tạo giỏ hàng
        $cart = $this->cartModel->getOrCreateCart($userId, $sessionId);
        
        // Lấy danh sách sản phẩm trong giỏ hàng
        $cartItems = [];
        $cartTotal = [
            'count' => 0,
            'subtotal' => 0,
            'shipping' => 0,
            'total' => 0
        ];
        
        if ($cart) {
            $cartItems = $this->cartModel->getCartItems($cart['id']);
            $cartTotal = $this->cartModel->getCartTotal($cart['id']);
        }
        
        // Dữ liệu gửi cho view
        $data = [
            'cart' => $cart,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ];
        
        // Load view
        require_once __DIR__ . '/../views/client/cart.php';
    }
    
    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart() {
        // Kiểm tra nếu là yêu cầu AJAX
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        // Lấy dữ liệu từ request
        if ($isAjax) {
            // Lấy dữ liệu JSON
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
        } else {
            // Lấy dữ liệu từ form
            $data = $_POST;
        }
        
        // Kiểm tra dữ liệu
        if (empty($data['product_id'])) {
            $this->responseError('Thiếu thông tin sản phẩm', $isAjax);
            return;
        }
        
        $productId = (int)$data['product_id'];
        $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;
        
        // Kiểm tra số lượng
        if ($quantity <= 0) {
            $quantity = 1;
        }
        
        // Lấy ID người dùng nếu đã đăng nhập
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        $sessionId = session_id();
        
        // Lấy hoặc tạo giỏ hàng
        $cart = $this->cartModel->getOrCreateCart($userId, $sessionId);
        
        if (!$cart) {
            $this->responseError('Không thể tạo giỏ hàng', $isAjax);
            return;
        }
        
        // Thêm sản phẩm vào giỏ hàng
        $result = $this->cartModel->addToCart($cart['id'], $productId, $quantity);
        
        if ($result) {
            // Lấy số lượng sản phẩm trong giỏ hàng
            $cartCount = $this->cartModel->countCartItems($userId, $sessionId);
            
            $this->responseSuccess([
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cart_count' => $cartCount
            ], $isAjax);
        } else {
            $this->responseError('Không thể thêm sản phẩm vào giỏ hàng', $isAjax);
        }
    }
    
    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function updateCartItem() {
        // Kiểm tra nếu là yêu cầu AJAX
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        // Lấy dữ liệu từ request
        if ($isAjax) {
            // Lấy dữ liệu JSON
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
        } else {
            // Lấy dữ liệu từ form
            $data = $_POST;
        }
        
        // Kiểm tra dữ liệu
        if (empty($data['item_id']) || !isset($data['quantity'])) {
            $this->responseError('Thiếu thông tin', $isAjax);
            return;
        }
        
        $itemId = (int)$data['item_id'];
        $quantity = (int)$data['quantity'];
        
        // Cập nhật số lượng
        $result = $this->cartModel->updateCartItem($itemId, $quantity);
        
        if ($result) {
            // Lấy ID người dùng nếu đã đăng nhập
            $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
            $sessionId = session_id();
            
            // Lấy giỏ hàng
            $cart = $this->cartModel->getCart($userId, $sessionId);
            
            if ($cart) {
                // Lấy thông tin giỏ hàng
                $cartTotal = $this->cartModel->getCartTotal($cart['id']);
                
                $this->responseSuccess([
                    'message' => 'Đã cập nhật giỏ hàng',
                    'cart_count' => $cartTotal['count'],
                    'subtotal' => $cartTotal['subtotal'],
                    'shipping' => $cartTotal['shipping'],
                    'total' => $cartTotal['total'],
                    'formatted_subtotal' => number_format($cartTotal['subtotal']) . '₫',
                    'formatted_shipping' => number_format($cartTotal['shipping']) . '₫',
                    'formatted_total' => number_format($cartTotal['total']) . '₫'
                ], $isAjax);
            } else {
                $this->responseError('Không tìm thấy giỏ hàng', $isAjax);
            }
        } else {
            $this->responseError('Không thể cập nhật giỏ hàng', $isAjax);
        }
    }
    
    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeCartItem() {
        // Kiểm tra nếu là yêu cầu AJAX
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        // Lấy dữ liệu từ request
        if ($isAjax) {
            // Lấy dữ liệu JSON
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
        } else {
            // Lấy dữ liệu từ form
            $data = $_POST;
        }
        
        // Kiểm tra dữ liệu
        if (empty($data['item_id'])) {
            $this->responseError('Thiếu thông tin', $isAjax);
            return;
        }
        
        $itemId = (int)$data['item_id'];
        
        // Xóa sản phẩm
        $result = $this->cartModel->removeCartItem($itemId);
        
        if ($result) {
            // Lấy ID người dùng nếu đã đăng nhập
            $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
            $sessionId = session_id();
            
            // Lấy giỏ hàng
            $cart = $this->cartModel->getCart($userId, $sessionId);
            
            if ($cart) {
                // Lấy thông tin giỏ hàng
                $cartTotal = $this->cartModel->getCartTotal($cart['id']);
                
                $this->responseSuccess([
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                    'cart_count' => $cartTotal['count'],
                    'subtotal' => $cartTotal['subtotal'],
                    'shipping' => $cartTotal['shipping'],
                    'total' => $cartTotal['total'],
                    'formatted_subtotal' => number_format($cartTotal['subtotal']) . '₫',
                    'formatted_shipping' => number_format($cartTotal['shipping']) . '₫',
                    'formatted_total' => number_format($cartTotal['total']) . '₫',
                    'is_empty' => ($cartTotal['count'] == 0)
                ], $isAjax);
            } else {
                $this->responseError('Không tìm thấy giỏ hàng', $isAjax);
            }
        } else {
            $this->responseError('Không thể xóa sản phẩm khỏi giỏ hàng', $isAjax);
        }
    }
    
    /**
     * Xóa tất cả sản phẩm trong giỏ hàng
     */
    public function clearCart() {
        // Lấy ID người dùng nếu đã đăng nhập
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        $sessionId = session_id();
        
        // Lấy giỏ hàng
        $cart = $this->cartModel->getCart($userId, $sessionId);
        
        if ($cart) {
            // Xóa tất cả sản phẩm
            $this->cartModel->clearCart($cart['id']);
            
            $_SESSION['success_message'] = 'Đã xóa tất cả sản phẩm trong giỏ hàng';
        } else {
            $_SESSION['error_message'] = 'Không tìm thấy giỏ hàng';
        }
        
        // Chuyển hướng về trang giỏ hàng
        header('Location: index.php?action=cart');
        exit;
    }
    
    /**
     * Phản hồi thành công
     */
    private function responseSuccess($data, $isAjax = false) {
        if ($isAjax) {
            // Phản hồi JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true] + $data);
            exit;
        } else {
            // Chuyển hướng
            if (isset($data['message'])) {
                $_SESSION['success_message'] = $data['message'];
            }
            
            header('Location: index.php?action=cart');
            exit;
        }
    }
    
    /**
     * Phản hồi lỗi
     */
    private function responseError($message, $isAjax = false) {
        if ($isAjax) {
            // Phản hồi JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $message
            ]);
            exit;
        } else {
            // Chuyển hướng
            $_SESSION['error_message'] = $message;
            
            header('Location: index.php?action=cart');
            exit;
        }
    }
}
?>