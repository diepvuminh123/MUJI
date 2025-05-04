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

// Check admin authentication
if (($_GET['action'] ?? '') !== 'showSiteInfo' && ($_GET['action'] ?? '') !== 'updateSiteInfo') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['error_message'] = 'Bạn cần đăng nhập với tư cách quản trị viên để truy cập trang này.';
        header('Location: index.php?action=login');
        exit;
    }
}

// Handle admin actions
switch ($_GET['action'] ?? '') {
    case 'showSiteInfo':
    case 'updateSiteInfo':
    case 'viewContacts':
        // These are handled by the existing code in admin.php
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

        
    case 'admin':
    default:
        require_once '../views/admin/admin.php';
        // Default dashboard
        // Continue with the existing code
        break;
}
?>