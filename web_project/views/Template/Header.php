<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />   <!-- Tailwind CSS CDN -->
  <script src="../../assets/js/Header.js"></script>
</head>
<body class="bg-white font-sans text-sm text-gray-800">

<!-- Header1  -->
<div class=" bg-white h-19">
  <div class="container mx-auto px-4 py-7 flex justify-between items-center">
    <!-- Thông báo -->
    <div class="text-red-800 text-xl">
    <?=
    "Địa chỉ:".($GLOBALS['site_info']['address'] ?? 'Chưa có địa chỉ') . " | " ."".
    "Hotline: " . ($GLOBALS['site_info']['hotline'] ?? 'Chưa có hotline'); ?>


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

      <div class="flex items-center space-x-2 text-xl">
        <span class="text-red-800">👤</span>
        <a href="/login.php" class="text-red-800 font-semibold hover:underline">Đăng nhập</a>
        <span class="text-red-800">|</span>
        <a href="/register.php" class="text-red-800 font-semibold hover:underline">Đăng ký</a>
      </div>
    </div>
  </div>
</div>

<!-- Thanh navbar chính -->
<div class="bg-red-800 text-white ">
  <div class="container mx-auto px-4 py-4 flex items-center justify-between w-xl">
    
    <!-- Logo MUJI -->
    <div class="flex-shrink-0 pr-4">
      <h1 class="text-3xl font-bold leading-tight">
      <?="".($GLOBALS['site_info']['Company_name'] ?? 'Chưa có tên') ?>
        
        <br><span class="text-xs text-xl"><?="".($GLOBALS['site_info']['Slogan '] ?? 'Chưa có slogan ') ?></span>
      </h1>
    </div>

    <!--  Menu chính -->
    <ul class="hidden md:flex space-x-5 font-semibold">
      <li><a href="#" class="hover:underline text-2xl ">Hàng Mới</a></li>
      <li><a href="#" class="hover:underline text-2xl">Bán Chạy</a></li>
      <li><a href="#" class="hover:underline text-2xl">Quần áo ▾</a></li>
      <li><a href="#" class="hover:underline text-2xl">Sức Khoẻ & Làm Đẹp ▾</a></li>
      <li><a href="#" class="hover:underline text-2xl">Gia Dụng ▾</a></li>
      <li><a href="#" class="hover:underline text-2xl">Thực Phẩm ▾</a></li>
    </ul>

    <!-- Tìm kiếm & Giỏ hàng -->
    <div class="flex items-center space-x-4 w-1/3">
      
      <div class="relative flex-grow">
        <input type="text" placeholder="Bạn đang muốn tìm kiếm gì?" class="w-full rounded-full pl-10 pr-10 py-2 text-sm text-gray-700 focus:outline-none" />
        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        <span class="absolute right-3 top-2.5 text-gray-400 cursor-pointer">❌</span>
       
      </div>

      <a href="#" class="text-white text-xl">🛒</a>
    </div>
  </div>
</div>
