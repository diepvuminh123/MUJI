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
  <div class=" w-3/4 mx-auto py-4 flex items-center justify-between">
    
    <!-- Logo App -->
    <div class="flex-shrink-0 pl-3 ">
      <h1 class="text-3xl font-bold leading-tight">
      <?="".($GLOBALS['site_info']['Company_name'] ?? 'Chưa có tên') ?>
        
        <br><span class="text-xs text-xl"><?="".($GLOBALS['site_info']['Slogan '] ?? 'Chưa có slogan ') ?></span>
      </h1>
    </div>

    <!--  Menu chính -->
    <ul class="hidden md:flex space-x-5 font-semibold">
      <li><a href="#" class="hover:underline text-2xl">Danh sách sản phẩm </a></li>
      <li><a href="#" class="hover:underline text-2xl">Liên Hệ</a></li>
      <li><a href="#" class="hover:underline text-2xl">Giới Thiệu</a></li>
      <li><a href="#" class="hover:underline text-2xl">Hỏi Đáp</a></li>
      <li><a href="#" class="hover:underline text-2xl ">Danh sách bài viết</a></li>

     
    </ul>

    <!-- Tìm kiếm & Giỏ hàng -->
    <div class="flex items-center space-x-4 ">
      
      <!-- search -->
       
      <form class="mx-auto" style="width: 480px;">
      <input type="hidden" name="search" value="true">
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
    </div>
    <!-- Giỏ hàng -->
    <div class="ml-1">
        <img src="../../assets/images/shopping-cart.png" class="h-12 w-12" alt="Giỏ hàng" />
        </div>
  </div>
</div>
