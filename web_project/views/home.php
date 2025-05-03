<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang chủ MUJI</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script defer src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script> <!-- Carousel JS (Flowbite) -->
</head>

<body class="bg-white text-gray-900">
  <?php $GLOBALS['site_info'] = $site_info; ?>
  <?php include 'Template/Header.php'; ?>

  <!-- Nội dung trang chủ -->
  <div class="  w-full mx-auto px-4 py-6">
    

    <!-- Slider Carousel -->
    <div id="controls-carousel" class="relative w-full" data-carousel="static">
      <!-- Wrapper -->
      <div class="relative h-56 overflow-hidden rounded-lg md:h-96" style="height: 650px;">

      <?php
$first = true;
foreach ($GLOBALS['slider_images'] as $img):
    $path = '../' . $img['image_path']; // CHỈNH ĐƯỜNG DẪN
    echo '<!-- DEBUG: ' . $path . ' -->'; // hiển thị đường dẫn HTML xem có đúng không
?>
  <div class="hidden duration-700 ease-in-out" data-carousel-item<?= $first ? '="active"' : '' ?>>
    <img src="<?= $path ?>" class="absolute block w-full h-full object-cover top-0 left-0" alt="Slide">
  </div>
<?php
$first = false;
endforeach;
?>

$first = false;
endforeach;
?>

      </div>

      <!-- Navigation buttons -->
      <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/50 hover:bg-white">
          <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 6 10">
            <path d="M5 1 1 5l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </button>
      <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/50 hover:bg-white">
          <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 6 10">
            <path d="m1 9 4-4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </button>
    </div>
      
  </div>
  <!-- Sản phẩm nổi bật -->
  
<h1 class="text-4xl font-bold dark:text-white pl-12">Sản phẩm nổi bật</h1>


<div class="flex flex-wrap gap-40 ml-12 mt-4 space-x-6  ">
  <!-- Card 1 -->
  <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
    <a href="#"><img class="rounded-t-lg" src="../uploads/Gray.jpg" alt="" /></a>
    <div class="p-5">
      <a href="#"><h5 class="mb-2 text-2xl font-bold">Tiêu đề 1</h5></a>
      <p class="mb-3 text-gray-700">Nội dung mô tả ngắn...</p>
      <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg">Read more</a>
    </div>
  </div>
</div>
  <!-- Sản phẩm mới về -->
  
  <h1 class="text-4xl font-bold dark:text-white pl-12 pt-8">Sản phẩm mới về </h1>


<div class="flex flex-wrap gap-40 ml-12 mt-4 space-x-6  ">
  <!-- Card 1 -->
  <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
    <a href="#"><img class="rounded-t-lg" src="../uploads/Gray.jpg" alt="" /></a>
    <div class="p-5">
      <a href="#"><h5 class="mb-2 text-2xl font-bold">Tiêu đề 1</h5></a>
      <p class="mb-3 text-gray-700">Nội dung mô tả ngắn...</p>
      <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg">Read more</a>
    </div>
  </div>
</div>

 <!-- Sản phẩm bán chạy -->
  
 <h1 class="text-4xl font-bold dark:text-white pl-12 pt-8">Sản phẩm bán chạy </h1>


<div class="flex flex-wrap gap-40 ml-12 mt-4 space-x-6  ">
  <!-- Card 1 -->
  <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
    <a href="#"><img class="rounded-t-lg" src="../uploads/Gray.jpg" alt="" /></a>
    <div class="p-5">
      <a href="#"><h5 class="mb-2 text-2xl font-bold">Tiêu đề 1</h5></a>
      <p class="mb-3 text-gray-700">Nội dung mô tả ngắn...</p>
      <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg">Read more</a>
    </div>
  </div>
</div>

<!--Event -->
<section class="bg-white py-10 px-4">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-8">
    
    <!-- Hình ảnh -->
    <div class="w-full md:w-2/3">
      <img src="../uploads/Gray.jpg" alt="Bộ sưu tập Xuân Hè 2025" class="w-full rounded">
    </div>

    <!-- Nội dung -->
    <div class="w-full md:w-1/3 text-center md:text-left">
      <h2 class="text-xl font-semibold mb-2">BỘ SƯU TẬP</h2>
      <h1 class="text-4xl font-bold text-green-700 mb-4">XUÂN HÈ 2025</h1>
      <p class="text-gray-700 mb-6">
        Đón chào mùa mới theo phong cách riêng với bộ sưu tập áo, quần, và nhiều sản phẩm khác dành đến từ MUJI
      </p>
      <a href="#" class="inline-block bg-gray-800 text-white px-6 py-3 rounded hover:bg-gray-700 transition">
        Khám phá thêm
      </a>
    </div>
    
  </div>
</section>

<!--Dowload app --> 


<div class="w-full p-4 text-center bg-white  shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Work fast from anywhere</h5>
    <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">Stay up to date and move work forward with Flowbite on iOS & Android. Download the app today.</p>
    <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
        <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
            <svg class="me-3 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="apple" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"></path></svg>
            <div class="text-left rtl:text-right">
                <div class="mb-1 text-xs">Download on the</div>
                <div class="-mt-1 font-sans text-sm font-semibold">Mac App Store</div>
            </div>
        </a>
        <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
            <svg class="me-3 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google-play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path></svg>
            <div class="text-left rtl:text-right">
                <div class="mb-1 text-xs">Get in on</div>
                <div class="-mt-1 font-sans text-sm font-semibold">Google Play</div>
            </div>
        </a>
    </div>
</div>





  <?php include 'Template/Footer.php'; ?>
</body>
</html>
