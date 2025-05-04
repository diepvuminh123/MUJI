<?php
/**
 * Layout chung cho trang quản trị
 */
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
    /* Hiệu ứng cho cảnh báo thành công */
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
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'manageArticles' ? 'active' : '' ?>">
            <a href="admin.php?action=manageArticles" class="sidebar-link">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Quản lý bài viết</span>
            </a>
          </li>

         <!-- MỞ RỘNG: Thêm các mục menu mới tại đây -->
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
        <?php echo $content; // Đây là nơi nội dung chính sẽ được chèn vào ?>
      </section>
    </div>
  </div>
</div>

<!-- JavaScript cho tự động ẩn cảnh báo thành công -->
<script>
  // Ẩn cảnh báo thành công sau 5 giây
  setTimeout(() => {
    const successAlert = document.getElementById('success-alert');
    if (successAlert) successAlert.style.opacity = '0';
    
    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) errorAlert.style.opacity = '0';
  }, 5000);
  
  // Xử lý menu con (submenu)
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
    
    sidebarItems.forEach(item => {
      item.querySelector('.sidebar-link').addEventListener('click', function(e) {
        e.preventDefault();
        
        item.classList.toggle('active');
        const submenu = item.querySelector('.submenu');
        if (submenu) {
          submenu.classList.toggle('active');
        }
      });
    });
    
    // Tự động mở submenu nếu có mục con đang active
    const activeSubmenuItems = document.querySelectorAll('.submenu-item.active');
    activeSubmenuItems.forEach(item => {
      const parentSubmenu = item.closest('.submenu');
      const parentItem = item.closest('.sidebar-item.has-sub');
      
      if (parentSubmenu && parentItem) {
        parentSubmenu.classList.add('active');
        parentItem.classList.add('active');
      }
    });
  });
</script>

<!-- Tệp JavaScript Cốt lõi -->
<script src="/MUJI/web_project/views/admin/assets/static/js/components/dark.js"></script>
<script src="/MUJI/web_project/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/MUJI/web_project/views/admin/assets/compiled/js/app.js"></script>

<!-- JavaScript Dành riêng cho Dashboard -->
<script src="/MUJI/web_project/views/admin/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="/MUJI/web_project/views/admin/assets/static/js/pages/dashboard.js"></script>
</body>
</html>