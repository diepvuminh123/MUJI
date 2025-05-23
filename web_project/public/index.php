<?php
// Đảm bảo session đã được khởi tạo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$action = $_GET['action'] ?? 'home';

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/SiteInfoModel.php';
$GLOBALS['site_info'] = SiteInfoModel::getAll();

$db = $GLOBALS['conn'];

if (!$db) {
    die("Kết nối database thất bại: Không tìm thấy kết nối");
}

// Kiểm tra "Remember me"
require_once __DIR__ . '/../controllers/AuthController.php';
$authController = new AuthController($db);
$authController->checkRememberMe();

switch ($action) {
    case 'home':
        require_once '../controllers/HomeController.php';
        (new HomeController())->index();
        break;
    case 'contact':
        require_once '../views/contact.php';
        break;
    case 'about':
        require_once '../views/about.php';
        break;   
    case 'qa':
        require_once '../views/qa.php';
        break;  
    case 'listartical':
        require_once '../views/listartical.php';
        break; 

    case 'admin':
        require_once '../views/admin/admin.php';
        break;

    case 'showSiteInfo':
        require_once '../controllers/AdminController.php';
        (new AdminController())->showForm();
        break;

    case 'updateSiteInfo':
        require_once '../controllers/AdminController.php';
        (new AdminController())->updateSiteInfo();
        break;

    case 'products':
        require_once __DIR__ . '/../controllers/ProductController.php';
        $productController = new ProductController($db);
        $productController->index();
        break;
        
    case 'product':
        require_once __DIR__ . '/../controllers/ProductController.php';
        $productController = new ProductController($db);
        $slug = $_GET['slug'] ?? '';
        if (!empty($slug)) {
            $productController->view($slug);
        } else {
            header('Location: index.php?action=products');
            exit;
        }
        break;
    
    case 'cart':
        require_once __DIR__ . '/../controllers/CartController.php';
        $cartController = new CartController($db);
        $cartController->index();
        break;
        
    case 'addToCart':
        require_once __DIR__ . '/../controllers/CartController.php';
        $cartController = new CartController($db);
        $cartController->addToCart();
        break;
        
    case 'updateCartItem':
        require_once __DIR__ . '/../controllers/CartController.php';
        $cartController = new CartController($db);
        $cartController->updateCartItem();
        break;
        
    case 'removeCartItem':
        require_once __DIR__ . '/../controllers/CartController.php';
        $cartController = new CartController($db);
        $cartController->removeCartItem();
        break;
        
    case 'clearCart':
        require_once __DIR__ . '/../controllers/CartController.php';
        $cartController = new CartController($db);
        $cartController->clearCart();
        break;
    
    case 'login':
        $authController->showLoginForm();
        break;
        
    case 'process_login':
        $authController->processLogin();
        break;
        
    case 'register':
        $authController->showRegisterForm();
        break;
        
    case 'process_register':
        $authController->processRegister();
        break;
        
    case 'logout':
        $authController->logout();
        break;
        
    case 'forgot_password':
        $authController->showForgotPasswordForm();
        break;
        
    case 'process_forgot_password':
        $authController->processForgotPassword();
        break;

    case 'checkout':
        require_once __DIR__ . '/../controllers/CheckoutController.php';
        $checkoutController = new CheckoutController($db);
        $checkoutController->index();
        break;
        
    case 'place_order':
        require_once __DIR__ . '/../controllers/CheckoutController.php';
        $checkoutController = new CheckoutController($db);
        $checkoutController->placeOrder();
        break;
        
    case 'order_confirmation':
        require_once __DIR__ . '/../controllers/CheckoutController.php';
        $checkoutController = new CheckoutController($db);
        $checkoutController->orderConfirmation();
        break;
        
    case 'my_orders':
        require_once __DIR__ . '/../controllers/CheckoutController.php';
        $checkoutController = new CheckoutController($db);
        $checkoutController->myOrders();
        break;
        
    case 'order_detail':
        require_once __DIR__ . '/../controllers/CheckoutController.php';
        $checkoutController = new CheckoutController($db);
        $checkoutController->orderDetail();
        break;
        
    case 'cancel_order':
        require_once __DIR__ . '/../controllers/CheckoutController.php';
        $checkoutController = new CheckoutController($db);
        $checkoutController->cancelOrder();
        break;

    // Product Management
    case 'adminProducts':
        require_once __DIR__ . '/../controllers/AdminProductController.php';
        $adminProductController = new AdminProductController($db);
        $adminProductController->index();
        exit; // Add exit to prevent the rest of admin.php from executing
        
    case 'createProduct':
        require_once __DIR__ . '/../controllers/AdminProductController.php';
        $adminProductController = new AdminProductController($db);
        $adminProductController->create();
        exit;
        
    case 'editProduct':
        require_once __DIR__ . '/../controllers/AdminProductController.php';
        $adminProductController = new AdminProductController($db);
        $adminProductController->edit();
        exit;
        
    case 'deleteProduct':
        require_once __DIR__ . '/../controllers/AdminProductController.php';
        $adminProductController = new AdminProductController($db);
        $adminProductController->delete();
        exit;
        
    case 'deleteImage':
        require_once __DIR__ . '/../controllers/AdminProductController.php';
        $adminProductController = new AdminProductController($db);
        $adminProductController->deleteImage();
        exit;
        
    case 'setPrimaryImage':
        require_once __DIR__ . '/../controllers/AdminProductController.php';
        $adminProductController = new AdminProductController($db);
        $adminProductController->setPrimaryImage();
        exit;
    
    // default:
    // header("HTTP/1.0 404 Not Found");
    // require_once __DIR__ . '/../views/errors/404.php';
    // break;
    default:
        echo "404 - Không tìm thấy hành động.";
        break;
}