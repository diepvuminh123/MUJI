<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <title>Home</title> -->
  <title><?php echo $page_title ?? 'Home'; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />   <!-- Tailwind CSS CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" /> <!-- Font Awesome CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" /> <!-- Font Awesome CDN -->
  <link href="/MUJI/web_project/assets/css/products.css" rel="stylesheet" />
  <link href="/MUJI/web_project/assets/css/footer.css" rel="stylesheet" />
  <script src="/MUJI/web_project/assets/js/Header.js"></script>
  <script src="/MUJI/web_project/assets/js/main.js"></script>
</head>
<body class="bg-white font-sans text-sm text-gray-800">

<!-- Header1  -->
<div class=" bg-white" style="font-size: 20px;">
  <div class="container mx-auto px-6 flex justify-between items-center" style="padding-top: 23px;">
    <!-- Thông báo -->
    
    <div class="text-red-800 font-semibold" style="font-size: px;">
        <span><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ: <?= $GLOBALS['site_info']['address'] ?? '152 Điện Biên Phủ' ?></span>
        <span class="mx-2">|</span>
        <span><i class="fas fa-phone-alt mr-1"></i> Hotline: <?= $GLOBALS['site_info']['hotline'] ?? '0915728661' ?></span>
    </div>

    <!-- Ngôn ngữ + Đăng nhập -->
    <div class="flex items-center space-x-6 text-xl">
    <div class="relative inline-block text-left">
  <!-- Nút bấm -->
  <button onclick="toggleLang()" class="flex items-center text-red-800 font-semibold">
    <span id="selectedLang">Tiếng Việt</span>
    <svg class="ml-1 w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
    </svg>
  </button>

  <!-- Danh sách ngôn ngữ -->
  <div id="langDropdown" class="hidden absolute mt-2 w-32 bg-white shadow rounded z-20">
      <button onclick="selectLang('English')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">English</button>
      <button onclick="selectLang('Tiếng Việt')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Tiếng Việt</button>
    </div>
  </div>  

      <!-- Phần đăng nhập/đăng ký trong Header.php -->
      <div class="flex items-center space-x-2 text-xl">
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
                      <!-- <li><a class="dropdown-item" href="index.php?action=profile">Tài khoản của tôi</a></li> -->
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
      <!-- <div class="flex items-center space-x-2 text-xl">
        <span class="text-red-800">👤</span>
        <a href="/login.php" class="text-red-800 font-semibold hover:underline">Đăng nhập</a>
        <span class="text-red-800">|</span>
        <a href="/register.php" class="text-red-800 font-semibold hover:underline">Đăng ký</a>
      </div> -->
    </div>
  </div>
</div>

<!-- Thanh navbar chính -->
<div class="bg-red-800 text-white sticky top-0 z-50 mt-3">
  <div class=" w-full; mx-auto py-4 flex items-center justify-between">
    
    <!-- Logo App -->
    <div class="flex-shrink-0 ml-8 pl-12 pr-12 ">
      <h1 class="text-3xl font-bold leading-tight">
      <?="".($GLOBALS['site_info']['Company_name'] ?? 'Chưa có tên') ?>
        
        <br><span class="text-xs text-xl"><?="".($GLOBALS['site_info']['Slogan '] ?? 'Chưa có slogan ') ?></span>
      </h1>
    </div>

    <!--  Menu chính -->
    <ul class="hidden md:flex  font-semibold " style="gap:30px;">
      <li><a href="index.php?action=products" class="hover:underline " style="font-size: 22px;">Danh sách sản phẩm </a></li>
      <li><a href="index.php?action=contact" class="hover:underline " style="font-size: 22px;">Liên Hệ</a></li>
      <li><a href="index.php?action=about" class="hover:underline " style="font-size: 22px;">Giới Thiệu</a></li>
      <li><a href="index.php?action=qa" class="hover:underline " style="font-size: 22px;">Hỏi Đáp</a></li>
      <li><a href="index.php?action=listartical" class="hover:underline " style="font-size: 22px;">Danh sách bài viết</a></li>

     
    </ul>

    <!-- Tìm kiếm & Giỏ hàng -->
    <div class="flex items-center space-x-4 ml-auto">
      
      <!-- search -->
       


      <form class="mx-auto" style="width: 480px;" action="index.php" method="GET">
        <input type="hidden" name="action" value="products">
          
        <label for="default-search" class="mb-2 pl-6 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>

        <div class="relative">
          <!-- Icon search -->
          <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>

          <!-- Input with padding left & right -->
          <input
            type="search"
            id="default-search"
            name="search"
            class="block w-full p-4 pr-24 pl-10 text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50
                  focus:ring-blue-500 focus:border-blue-500
                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                  dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  
            placeholder="Tìm kiếm sản phẩm "
            required
          />

          <!-- Button search -->
          <button
            type="submit"
            class="absolute right-2.5 bottom-2.5 bg-gray-700 hover:bg-blue-800 text-white font-medium rounded-lg text-lg px-4 py-2
                  focus:outline-none focus:ring-4 focus:ring-blue-300
                  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Search
          </button>
        </div>
     </form>
  
    <!-- Đoạn code giỏ hàng trong Header.php -->
      <div class="relative ml-1 mr-4 pl-4 pr-12">
          <a href="index.php?action=cart" class="flex items-center text-white font-semibold hover:underline">
              <img src="/MUJI/web_project/assets/images/shopping-cart.png" class="h-12 w-12" alt="Giỏ hàng"/>
              <span class="hidden md:inline ml-1 text-black font-bold">Giỏ hàng</span>
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
                  <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full transform scale-100 transition-transform duration-300 hover:scale-110" id="cart-count">
                      <?php echo $cartCount; ?>
                  </span> 
              <?php endif; ?>
          </a>
      </div>
  </div>
</div>
</div>
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