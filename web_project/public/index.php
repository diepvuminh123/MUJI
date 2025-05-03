<?php
// Đảm bảo session đã được khởi tạo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$action = $_GET['action'] ?? 'home';

require_once __DIR__ . '/../config/config.php';

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
    
    
    // default:
    // header("HTTP/1.0 404 Not Found");
    // require_once __DIR__ . '/../views/errors/404.php';
    // break;
    default:
        echo "404 - Không tìm thấy hành động.";
        break;
}