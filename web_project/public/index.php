<?php
$action = $_GET['action'] ?? 'home';

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

    default:
        echo "404 - Không tìm thấy hành động.";
        break;
}
