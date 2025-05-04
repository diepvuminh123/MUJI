<?php
/**
 * Hệ thống quản lý thông tin trang web
 * 
 * File này xử lý chức năng quản lý thông tin công ty cho trang quản trị
 * bao gồm việc lấy, hiển thị và cập nhật thông tin công ty như tên, slogan,
 * đường dây nóng và địa chỉ.
 * 
 * @version 1.0
 */
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/AdminProductController.php';
require_once __DIR__ . '/../../../controllers/HomeController.php';
/**
 * Lấy giá trị thông tin trang web cụ thể từ cơ sở dữ liệu
 */
if (!function_exists('getSiteValue')) {
    function getSiteValue($conn, $key) {
        $stmt = $conn->prepare("SELECT value FROM site_info WHERE `key` = ?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['value'] ?? '';
    }
}

/**
 * Cập nhật giá trị thông tin trang web cụ thể trong cơ sở dữ liệu
 */
function updateSiteValue($conn, $key, $value) {
    $stmt = $conn->prepare("UPDATE site_info SET value = ? WHERE `key` = ?");
    $stmt->bind_param("ss", $value, $key);
    $result = $stmt->execute();
    return $result;
}

// Xử lý gửi biểu mẫu để cập nhật thông tin trang web
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'updateSiteInfo') {
    // Cập nhật từng trường thông tin trang web
    updateSiteValue($conn, 'hotline', $_POST['hotline']);
    updateSiteValue($conn, 'address', $_POST['address']);
    updateSiteValue($conn, 'Company_name', $_POST['Company_name']);
    updateSiteValue($conn, 'Slogan', $_POST['Slogan']);
    
    // Hiển thị thông báo thành công
    echo "<div class='alert alert-success text-center fs-5' id='success-alert'>Cập nhật thành công 🥳🥳🥳</div>";
}

function getSiteValue($conn, $key) {
    if (!$conn) {
        return ''; // Return empty if no connection
    }
    
    $stmt = $conn->prepare("SELECT value FROM site_info WHERE `key` = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['value'] ?? '';
}

// At the top of Header.php
// Default site info values
$GLOBALS['site_info'] = [
    'hotline' => 'Default Hotline',
    'address' => 'Default Address',
    'logo' => 'default-logo.png',
    'Company_name' => 'Default Company Name',
    'Slogan' => 'Default Slogan'
];

// Only try to fetch from database if connection is available
if (isset($conn) && $conn) {
    $GLOBALS['site_info'] = [
        'hotline' => getSiteValue($conn, 'hotline'),
        'address' => getSiteValue($conn, 'address'),
        'logo' => getSiteValue($conn, 'logo'),
        'Company_name' => getSiteValue($conn, 'Company_name'),
        'Slogan' => getSiteValue($conn, 'Slogan')
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Mazer Admin Dashboard</title>
  <!-- CSS Stylesheets -->
  <link rel="stylesheet" href="/MUJI/web_project/views/admin/assets/compiled/css/app.css">
  <link rel="stylesheet" href="/MUJI/web_project/views/admin/assets/compiled/css/app-dark.css">
  <!--font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/MUJI/web_project/views/admin/assets/compiled/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    #success-alert, #error-alert {
      transition: opacity 1s ease;
    }
  </style>
</head>
<body>
<!-- Script khởi tạo chủ đề -->
<script src="assets/static/js/initTheme.js"></script>
<div id="app">
  <!-- Thanh điều hướng bên -->
  <div id="sidebar">
    <div class="sidebar-wrapper active">
      <!-- Phần Logo/Tiêu đề -->
      <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
          <div class="logo">
            <a href="admin.php"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
          </div>
        </div>
      </div>
      <!-- Menu điều hướng -->
      <div class="sidebar-menu">
        <ul class="menu">
          <li class="sidebar-title">Menu</li>
          <!-- Mục Menu Dashboard -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'dashboard' || !isset($_GET['action']) ? 'active' : '' ?>">
            <a href="admin.php?action=dashboard" class="sidebar-link">
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <!-- Mục Menu Thông tin Trang web -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'updateSiteInfo' ? 'active' : '' ?>">
            <a href="admin.php?action=updateSiteInfo" class="sidebar-link">
              <i class="bi bi-pencil-square"></i>
              <span>Chỉnh sửa công ty</span>
            </a>
          </li>
          <!-- Mục Menu Tin nhắn Liên hệ -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'viewContacts' ? 'active' : '' ?>">
            <a href="admin.php?action=viewContacts" class="sidebar-link">
              <i class="bi bi-envelope-fill"></i>
              <span>Xem liên hệ</span>
            </a>
         </li>
         <!-- Mục Menu Quản lý Sản phẩm -->
            <li class="sidebar-item has-sub <?= (($_GET['action'] ?? '') === 'adminProducts' || ($_GET['action'] ?? '') === 'createProduct' || ($_GET['action'] ?? '') === 'editProduct') ? 'active' : '' ?>">
                <a href="javascript:void(0)" class="sidebar-link">
                <i class="bi bi-box-seam"></i>
                <span>Quản lý sản phẩm</span>
                </a>
                <ul class="submenu <?= (($_GET['action'] ?? '') === 'adminProducts' || ($_GET['action'] ?? '') === 'createProduct' || ($_GET['action'] ?? '') === 'editProduct') ? 'active' : '' ?>">
                <li class="submenu-item <?= ($_GET['action'] ?? '') === 'adminProducts' ? 'active' : '' ?>">
                    <a href="index.php?action=adminProducts">Xem danh sách</a>
                </li>
                <li class="submenu-item <?= ($_GET['action'] ?? '') === 'createProduct' ? 'active' : '' ?>">
                    <a href="index.php?action=createProduct">Thêm sản phẩm</a>
                </li>
                <?php if (($_GET['action'] ?? '') === 'editProduct'): ?>
                <li class="submenu-item active">
                    <a href="#">Chỉnh sửa sản phẩm</a>
                </li>
                <?php endif; ?>
                </ul>
            </li>
            <!-- Mục Menu Quản lý Đơn hàng -->
            <li class="sidebar-item <?= (($_GET['action'] ?? '') === 'adminOrders' || ($_GET['action'] ?? '') === 'viewOrder' || ($_GET['action'] ?? '') === 'orderInvoice') ? 'active' : '' ?>">
            <a href="admin.php?action=adminOrders" class="sidebar-link">
                <i class="bi bi-cart-check"></i>
                <span>Quản lý đơn hàng</span>
            </a>
            </li>
            <!-- Mục Menu Quản lý Giỏ hàng -->
            <li class="sidebar-item <?= (($_GET['action'] ?? '') === 'adminCarts' || ($_GET['action'] ?? '') === 'viewCart') ? 'active' : '' ?>">
              <a href="admin.php?action=adminCarts" class="sidebar-link">
                <i class="bi bi-cart"></i>
                <span>Quản lý giỏ hàng</span>
              </a>
            </li>
        </ul>
      </div>
    </div>
  </div>
  
  <!-- Khu vực Nội dung Chính -->
  <div id="main">
    <!-- Tiêu đề di động với menu hamburger -->
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <!-- Nội dung Trang -->
    <div class="page-content">
      <section class="row">