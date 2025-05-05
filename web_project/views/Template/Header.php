<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title><?php echo $page_title ?? 'Home'; ?></title>
  <link rel="icon" type="image/png" href="/MUJI/web_project/uploads/LOGO.png" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="/MUJI/web_project/assets/css/products.css" rel="stylesheet" />
  <link href="/MUJI/web_project/assets/css/footer.css" rel="stylesheet" />
  <script src="/MUJI/web_project/assets/js/Header.js"></script>
  <script src="/MUJI/web_project/assets/js/main.js"></script>
  <style>
    /* Custom styles for better mobile display */
    @media (max-width: 640px) {
      .mobile-header-info {
        flex-direction: column;
        align-items: flex-start;
      }
      .mobile-menu-button {
        display: block;
      }
      .mobile-menu {
        display: none;
      }
      .mobile-menu.active {
        display: block;
      }
      .search-container {
        width: 100%;
        margin: 10px 0;
      }
      .cart-text {
        display: none;
      }
    }
  </style>
</head>
<body class="bg-white font-sans text-sm text-gray-800">

<!-- Header - Contact Info -->
<div class="bg-white py-2 border-b border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mobile-header-info">
      <!-- Contact Information -->
      <div class="text-red-800 font-semibold text-sm sm:text-base mb-2 sm:mb-0">
        <span><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ: <?= $GLOBALS['site_info']['address'] ?? '152 Điện Biên Phủ' ?></span>
        <span class="mx-2 hidden sm:inline">|</span>
        <div class="sm:inline-block mt-1 sm:mt-0">
          <span><i class="fas fa-phone-alt mr-1"></i> Hotline: <?= $GLOBALS['site_info']['hotline'] ?? '0915728661' ?></span>
        </div>
      </div>

      <!-- Language & Login -->
      <div class="flex items-center text-sm sm:text-base space-x-2 sm:space-x-4">
        <!-- Language Selector -->
        <div class="relative inline-block text-left">
          <button onclick="toggleLang()" class="flex items-center text-red-800 font-semibold">
            <span id="selectedLang">Tiếng Việt</span>
            <svg class="ml-1 w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </button>

          <!-- Language Dropdown -->
          <div id="langDropdown" class="hidden absolute mt-2 w-32 bg-white shadow rounded z-20">
            <button onclick="selectLang('English')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">English</button>
            <button onclick="selectLang('Tiếng Việt')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Tiếng Việt</button>
          </div>
        </div>

        <!-- Login/Register Section -->
        <div class="flex items-center space-x-1 sm:space-x-2">
          <span class="text-red-800">👤</span>
          <?php if (isset($_SESSION['user'])): ?>
            <div class="dropdown">
              <a href="#" class="text-red-800 font-semibold hover:underline dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo htmlspecialchars($_SESSION['user']['full_name']); ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                  <li><a class="dropdown-item" href="index.php?action=admin">Quản trị</a></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="index.php?action=my_orders">Đơn hàng của tôi</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="index.php?action=logout">Đăng xuất</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="index.php?action=login" class="text-red-800 font-semibold hover:underline">Đăng nhập</a>
            <span class="text-red-800">|</span>
            <a href="index.php?action=register" class="text-red-800 font-semibold hover:underline">Đăng ký</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Navigation -->
<div class="bg-red-800 text-white sticky top-0 z-50">
  <div class="container mx-auto px-4">
    <div class="flex flex-col sm:flex-row items-center justify-between py-3">
      
      <!-- Logo & Company Name -->
      <div class="flex items-center justify-center sm:justify-start w-full sm:w-auto mb-3 sm:mb-0">
        <a href="index.php?action=home" class="flex items-center">
          <h1 class="text-2xl sm:text-3xl font-bold leading-tight text-center sm:text-left">
            <?= $GLOBALS['site_info']['Company_name'] ?? 'Sakura' ?>
            <br><span class="text-sm sm:text-xl"><?= $GLOBALS['site_info']['Slogan'] ?? 'いい製品' ?></span>
          </h1>
        </a>
      </div>

      <!-- Mobile Menu Toggle -->
      <button id="mobile-menu-button" class="sm:hidden absolute right-4 top-16 text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

      <!-- Search & Navigation -->
      <div class="w-full sm:flex sm:items-center sm:justify-end">
        <!-- Search Bar -->
        <div class="search-container w-full sm:w-80 md:w-96 mb-3 sm:mb-0 mx-auto sm:mx-0">
          <form action="index.php" method="GET" class="relative">
            <input type="hidden" name="action" value="products">
            <div class="relative">
              <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
              </div>
              <input type="search" id="default-search" name="search" class="block w-full p-2 sm:p-3 pl-10 pr-16 text-sm sm:text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Tìm kiếm sản phẩm" required />
              <button type="submit" class="absolute right-1 bottom-1 bg-gray-700 hover:bg-blue-800 text-white font-medium rounded-lg text-sm px-2 py-1 sm:px-3 sm:py-1.5 focus:outline-none focus:ring-4 focus:ring-blue-300">
                Search
              </button>
            </div>
          </form>
        </div>

        <!-- Cart Icon -->
        <div class="relative ml-0 sm:ml-4 mt-2 sm:mt-0">
          <a href="index.php?action=cart" class="flex items-center justify-center text-white font-semibold hover:underline">
            <?php
            // Lấy số lượng sản phẩm trong giỏ hàng
            $cartCount = 0;
            if (isset($db)) {
                require_once __DIR__ . '/../../models/Cart.php';
                $cartModel = new Cart($db);
                $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
                $sessionId = session_id();
                $cartCount = $cartModel->countCartItems($userId, $sessionId);
            }
            ?>
            <?php if ($cartCount > 0): ?>
              <span class="absolute -top-2 -left-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full transform scale-100 transition-transform duration-300 hover:scale-110" id="cart-count">
                <?php echo $cartCount; ?>
              </span> 
            <?php endif; ?>
            <img src="/MUJI/web_project/assets/images/shopping-cart.png" class="h-8 w-8 sm:h-10 sm:w-10" alt="Giỏ hàng"/>
            <span class="hidden sm:inline ml-1 text-white font-bold cart-text">Giỏ hàng</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="mobile-menu py-2 border-t border-red-700">
      <ul class="flex flex-col space-y-2">
        <li><a href="index.php?action=products" class="block py-1 px-2 hover:bg-red-700 font-semibold">Danh sách sản phẩm</a></li>
        <li><a href="index.php?action=contact" class="block py-1 px-2 hover:bg-red-700 font-semibold">Liên Hệ</a></li>
        <li><a href="index.php?action=about" class="block py-1 px-2 hover:bg-red-700 font-semibold">Giới Thiệu</a></li>
        <li><a href="index.php?action=qa" class="block py-1 px-2 hover:bg-red-700 font-semibold">Hỏi Đáp</a></li>
        <li><a href="index.php?action=listartical" class="block py-1 px-2 hover:bg-red-700 font-semibold">Danh sách bài viết</a></li>
      </ul>
    </div>

    <!-- Desktop Navigation Menu -->
    <nav class="hidden sm:block pb-3">
      <ul class="flex justify-center space-x-6 text-lg font-semibold">
        <li><a href="index.php?action=products" class="hover:underline">Danh sách sản phẩm</a></li>
        <li><a href="index.php?action=contact" class="hover:underline">Liên Hệ</a></li>
        <li><a href="index.php?action=about" class="hover:underline">Giới Thiệu</a></li>
        <li><a href="index.php?action=qa" class="hover:underline">Hỏi Đáp</a></li>
        <li><a href="index.php?action=listartical" class="hover:underline">Danh sách bài viết</a></li>
      </ul>
    </nav>
  </div>
</div>

<!-- JavaScript for Mobile Menu Toggle -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
      mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
      });
    }
  });
</script>

<!-- Main Content -->
<main>
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>
  
  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>
</main>
</body>
</html>