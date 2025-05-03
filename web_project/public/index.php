<?php
$action = $_GET['action'] ?? 'home';

require_once __DIR__ . '/../config/config.php';

$db = $GLOBALS['conn'];

if (!$db) {
    die("Kết nối database thất bại: Không tìm thấy kết nối");
}

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
    

    default:
        echo "404 - Không tìm thấy hành động.";
        break;
}