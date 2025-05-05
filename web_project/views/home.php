<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang chủ MUJI</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script defer src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
  <style>
    :root {
      --primary-color: #991b1b; /* bg-red-800 */
      --primary-hover: #7f1d1d; /* bg-red-900 */
      --secondary-color: #f9fafb;
      --text-light: #ffffff;
      --text-dark: #111827;
    }
    
    .hover-scale:hover {
      transform: scale(1.03);
      transition: transform 0.3s ease;
    }
    
    .product-card {
      transition: all 0.3s ease;
    }
    
    .product-card:hover {
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .slider-height {
      height: 600px;
    }
    
    @media (max-width: 768px) {
      .slider-height {
        height: 400px;
      }
    }
    
    .primary-btn {
      background-color: var(--primary-color);
      color: var(--text-light);
    }
    
    .primary-btn:hover {
      background-color: var(--primary-hover);
    }
    
    .outline-btn {
      border: 1px solid var(--primary-color);
      color: var(--primary-color);
    }
    
    .outline-btn:hover {
      background-color: var(--primary-color);
      color: var(--text-light);
    }
    
    /* Horizontal scrolling sections */
    .scroll-container {
      overflow-x: auto;
      scroll-behavior: smooth;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none; /* Firefox */
      -ms-overflow-style: none; /* IE and Edge */
      position: relative;
      padding: 0.5rem 0;
    }
    
    .scroll-container::-webkit-scrollbar {
      display: none; /* Chrome, Safari, Opera */
    }
    
    .scroll-content {
      display: flex;
      gap: 1rem;
    }
    
    .scroll-item {
      flex: 0 0 auto;
      width: 280px;
    }
    
    /* Modified navigation buttons to be centered vertically */
    .scroll-nav {
      position: relative;
      z-index: 10;
    }
    
    .scroll-nav button {
      position: absolute;
      top: 150px; /* Position in the middle vertically */
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.8);
      border: 1px solid #eee;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      z-index: 20;
    }
    
    .scroll-prev {
      left: 10px;
    }
    
    .scroll-next {
      right: 10px;
    }
    
    .fade-left {
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 40px;
      background: linear-gradient(to right, #fff, transparent);
      z-index: 5;
      pointer-events: none;
    }
    
    .fade-right {
      position: absolute;
      right: 0;
      top: 0;
      height: 100%;
      width: 40px;
      background: linear-gradient(to left, #fff, transparent);
      z-index: 5;
      pointer-events: none;
    }
    
    /* Override any existing green color classes */
    .bg-green-600, .hover\:bg-green-600, .hover\:bg-green-700, .bg-green-700 {
      background-color: var(--primary-color) !important;
    }
    
    .text-green-600, .text-green-700 {
      color: var(--primary-color) !important;
    }
    
    .border-green-600 {
      border-color: var(--primary-color) !important;
    }
    
    .hover\:text-green-600:hover {
      color: var(--primary-color) !important;
    }
    
    .hover\:border-green-600:hover {
      border-color: var(--primary-color) !important;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-900">
  <?php $GLOBALS['site_info'] = $site_info; ?>
  <?php include 'Template/Header.php'; ?>

  <!-- Nội dung trang chủ -->
  <div class="w-full mx-auto">
     <!-- Slider Carousel -->
     <div id="controls-carousel" class="relative w-full" data-carousel="static">
      <!-- Wrapper -->
      <div class="relative overflow-hidden rounded-lg slider-height">
        <?php
        // Lấy dữ liệu slider từ database
        if (!empty($GLOBALS['slider_images']) && is_array($GLOBALS['slider_images'])):
          $first = true;
          foreach ($GLOBALS['slider_images'] as $img):
            $path = '../' . $img['image_path']; // Điều chỉnh đường dẫn
        ?>
          <div class="hidden duration-700 ease-in-out" data-carousel-item<?= $first ? '="active"' : '' ?>>
            <img src="<?= $path ?>" class="absolute block w-full h-full object-cover top-0 left-0" alt="Slider">
          </div>
        <?php
            $first = false;
          endforeach;
        else:
        ?>
          <!-- Default slider nếu không có dữ liệu -->
          <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
            <img src="../uploads/Gray.jpg" class="absolute block w-full h-full object-cover top-0 left-0" alt="Default Slider">
          </div>
        <?php endif; ?>
      </div>

      <!-- Navigation buttons -->
      <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
          <i class="fas fa-chevron-left text-white text-xl"></i>
        </span>
      </button>
      <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
          <i class="fas fa-chevron-right text-white text-xl"></i>
        </span>
      </button>
    </div>
    
    <!-- Sản phẩm nổi bật - Horizontal Scrolling -->
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 relative pb-3 inline-block">
          Sản phẩm nổi bật
          <span class="absolute bottom-0 left-0 w-2/3 h-1 bg-red-800"></span>
        </h2>
        <a href="index.php?action=products&featured=1" class="outline-btn py-2 px-4 rounded-full transition">
          Xem tất cả
        </a>
      </div>
      
      <div class="relative">
        <!-- Navigation buttons in the middle -->
        <div class="scroll-nav">
          <button class="scroll-prev" data-target="featured-products">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="scroll-next" data-target="featured-products">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
        
        <div class="scroll-container" id="featured-products">
          <div class="scroll-content">
            <?php
            // Lấy sản phẩm nổi bật từ controller/model
            if (!empty($GLOBALS['featured_products']) && is_array($GLOBALS['featured_products'])):
              foreach($GLOBALS['featured_products'] as $product):
                // Fix image path
                $image_path = !empty($product['primary_image']) ? '/' . $product['primary_image'] : '/uploads/Gray.jpg';
                $price_html = !empty($product['sale_price']) ? 
                  '<p class="text-lg font-bold text-red-800">'.number_format($product['sale_price']).' ₫ <span class="text-sm line-through text-gray-500">'.number_format($product['price']).' ₫</span></p>' :
                  '<p class="text-lg font-bold text-red-800">'.number_format($product['price']).' ₫</p>';
            ?>
              <div class="scroll-item">
                <div class="bg-white rounded-lg overflow-hidden shadow product-card h-full">
                  <a href="index.php?action=product&slug=<?= $product['slug'] ?>">
                    <div class="h-56 overflow-hidden">
                      <img class="w-full h-full object-cover hover-scale" src="<?= $image_path ?>" alt="<?= $product['name'] ?>">
                    </div>
                    <div class="p-4">
                      <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate"><?= $product['name'] ?></h3>
                      <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= substr($product['description'], 0, 100) ?>...</p>
                      <?= $price_html ?>
                      
                    </div>
                  </a>
                </div>
              </div>
            <?php 
              endforeach;
            else:
            ?>
              <!-- Sản phẩm mẫu nếu không có dữ liệu -->
              <?php for($i = 0; $i < 8; $i++): ?>
              <div class="scroll-item">
                <div class="bg-white rounded-lg overflow-hidden shadow product-card h-full">
                  <div class="h-56 overflow-hidden">
                    <img class="w-full h-full object-cover hover-scale" src="/uploads/Gray.jpg" alt="Sản phẩm mẫu">
                  </div>
                  <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Áo thun unisex</h3>
                    <p class="text-sm text-gray-600 mb-3">Áo thun unisex chất liệu cotton 100%, form rộng thoải mái...</p>
                    <p class="text-lg font-bold text-red-800">320.000 ₫</p>
                  
                  </div>
                </div>
              </div>
              <?php endfor; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Banner khuyến mãi -->
    <div class="bg-gray-100 py-16">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-8">
          <div class="w-full md:w-1/2">
            <img src="../uploads/Khuyenmai.jpg" alt="Khuyến mãi" class="w-full h-80 object-cover rounded-lg shadow-lg">
          </div>
          <div class="w-full md:w-1/2 text-center md:text-left">
            <h2 class="text-xl font-semibold mb-2 text-red-800">KHUYẾN MÃI ĐẶC BIỆT</h2>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Giảm giá lên đến 50%</h1>
            <p class="text-gray-700 mb-6 text-lg">
              Nhân dịp khai trương cửa hàng mới, MUJI giảm giá lên đến 50% cho nhiều sản phẩm chất lượng cao.
              Nhanh tay mua sắm ngay hôm nay!
            </p>
            <a href="index.php?action=products&sale=1" class="primary-btn px-6 py-3 rounded-full transition">
              Mua ngay
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Sản phẩm mới về - Horizontal Scrolling -->
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 relative pb-3 inline-block">
          Sản phẩm mới về
          <span class="absolute bottom-0 left-0 w-2/3 h-1 bg-red-800"></span>
        </h2>
        <a href="index.php?action=products&new=1" class="outline-btn py-2 px-4 rounded-full transition">
          Xem tất cả
        </a>
      </div>
      
      <div class="relative">
        <!-- Navigation buttons in the middle -->
        <div class="scroll-nav">
          <button class="scroll-prev" data-target="new-products">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="scroll-next" data-target="new-products">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
        
        <div class="scroll-container" id="new-products">
          <div class="scroll-content">
            <?php
            // Lấy sản phẩm mới từ controller/model
            if (!empty($GLOBALS['new_products']) && is_array($GLOBALS['new_products'])):
              foreach($GLOBALS['new_products'] as $product):
                // Fix image path
                $image_path = !empty($product['primary_image']) ? '/' . $product['primary_image'] : '/uploads/Gray.jpg';
                $price_html = !empty($product['sale_price']) ? 
                  '<p class="text-lg font-bold text-red-800">'.number_format($product['sale_price']).' ₫ <span class="text-sm line-through text-gray-500">'.number_format($product['price']).' ₫</span></p>' :
                  '<p class="text-lg font-bold text-red-800">'.number_format($product['price']).' ₫</p>';
            ?>
              <div class="scroll-item">
                <div class="bg-white rounded-lg overflow-hidden shadow product-card h-full">
                  <a href="index.php?action=product&slug=<?= $product['slug'] ?>">
                    <div class="h-56 overflow-hidden">
                      <img class="w-full h-full object-cover hover-scale" src="<?= $image_path ?>" alt="<?= $product['name'] ?>">
                    </div>
                    <div class="p-4">
                      <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate"><?= $product['name'] ?></h3>
                      <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= substr($product['description'], 0, 100) ?>...</p>
                      <?= $price_html ?>
                      
                    </div>
                  </a>
                </div>
              </div>
            <?php 
              endforeach;
            else:
            ?>
              <!-- Sản phẩm mẫu nếu không có dữ liệu -->
              <?php for($i = 0; $i < 8; $i++): ?>
              <div class="scroll-item">
                <div class="bg-white rounded-lg overflow-hidden shadow product-card h-full">
                  <div class="h-56 overflow-hidden">
                    <img class="w-full h-full object-cover hover-scale" src="/uploads/Gray.jpg" alt="Sản phẩm mẫu">
                  </div>
                  <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Áo sơ mi linen</h3>
                    <p class="text-sm text-gray-600 mb-3">Áo sơ mi linen, chất vải mát mẻ, phù hợp cho mùa hè...</p>
                    <p class="text-lg font-bold text-red-800">450.000 ₫</p>
                    
                  </div>
                </div>
              </div>
              <?php endfor; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Bộ sưu tập -->
    <section class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-8">
          <div class="w-full md:w-2/3">
            <img src="/uploads/Gray.jpg" alt="Bộ sưu tập Xuân Hè" class="w-full rounded-lg shadow-lg">
          </div>
          <div class="w-full md:w-1/3 text-center md:text-left">
            <h2 class="text-xl font-semibold mb-2 text-red-800">BỘ SƯU TẬP</h2>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">XUÂN HÈ 2025</h1>
            <p class="text-gray-700 mb-6 text-lg">
              Đón chào mùa mới theo phong cách riêng với bộ sưu tập áo, quần, và nhiều sản phẩm khác đến từ MUJI.
              Thiết kế tối giản, màu sắc nhẹ nhàng, phù hợp cho mọi dịp.
            </p>
            <a href="index.php?action=products&collection=xuan-he-2025" class="primary-btn px-6 py-3 rounded-full transition">
              Khám phá ngay
            </a>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Sản phẩm bán chạy - Horizontal Scrolling -->
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 relative pb-3 inline-block">
          Sản phẩm bán chạy
          <span class="absolute bottom-0 left-0 w-2/3 h-1 bg-red-800"></span>
        </h2>
        <a href="index.php?action=products&bestseller=1" class="outline-btn py-2 px-4 rounded-full transition">
          Xem tất cả
        </a>
      </div>
      
      <div class="relative">
        <!-- Navigation buttons in the middle -->
        <div class="scroll-nav">
          <button class="scroll-prev" data-target="bestseller-products">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="scroll-next" data-target="bestseller-products">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
        
        <div class="scroll-container" id="bestseller-products">
          <div class="scroll-content">
            <?php
            // Lấy sản phẩm bán chạy từ controller/model
            if (!empty($GLOBALS['bestseller_products']) && is_array($GLOBALS['bestseller_products'])):
              foreach($GLOBALS['bestseller_products'] as $product):
                // Fix image path
                $image_path = !empty($product['primary_image']) ? '/' . $product['primary_image'] : '/uploads/Gray.jpg';
                $price_html = !empty($product['sale_price']) ? 
                  '<p class="text-lg font-bold text-red-800">'.number_format($product['sale_price']).' ₫ <span class="text-sm line-through text-gray-500">'.number_format($product['price']).' ₫</span></p>' :
                  '<p class="text-lg font-bold text-red-800">'.number_format($product['price']).' ₫</p>';
            ?>
              <div class="scroll-item">
                <div class="bg-white rounded-lg overflow-hidden shadow product-card h-full">
                  <a href="index.php?action=product&slug=<?= $product['slug'] ?>">
                    <div class="h-56 overflow-hidden">
                      <img class="w-full h-full object-cover hover-scale" src="<?= $image_path ?>" alt="<?= $product['name'] ?>">
                    </div>
                    <div class="p-4">
                      <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate"><?= $product['name'] ?></h3>
                      <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= substr($product['description'], 0, 100) ?>...</p>
                      <?= $price_html ?>
                      
                    </div>
                  </a>
                </div>
              </div>
            <?php 
              endforeach;
            else:
            ?>
              <!-- Sản phẩm mẫu nếu không có dữ liệu -->
              <?php for($i = 0; $i < 8; $i++): ?>
              <div class="scroll-item">
                <div class="bg-white rounded-lg overflow-hidden shadow product-card h-full">
                  <div class="h-56 overflow-hidden">
                    <img class="w-full h-full object-cover hover-scale" src="/uploads/Gray.jpg" alt="Sản phẩm mẫu">
                  </div>
                  <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Quần dài khaki</h3>
                    <p class="text-sm text-gray-600 mb-3">Quần dài khaki form regular phù hợp cho nhiều dịp...</p>
                    <p class="text-lg font-bold text-red-800">390.000 ₫</p>
                    
                  </div>
                </div>
              </div>
              <?php endfor; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Danh mục sản phẩm -->
    <div class="bg-white py-12">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 text-center relative pb-3 inline-block">
          Danh mục sản phẩm phổ biến
          <span class="absolute bottom-0 left-0 w-full h-1 bg-red-800"></span>
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
          <!-- Danh mục mẫu -->
          <a href="index.php?action=products&category=8" class="group">
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 text-center p-4">
              <div class="w-20 h-20 mx-auto mb-3 bg-white rounded-full flex items-center justify-center">
                <i class="fas fa-tshirt text-red-800 text-2xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-800 group-hover:text-red-800 transition">Áo</h3>
            </div>
          </a>
          <a href="index.php?action=products&category=9" class="group">
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 text-center p-4">
              <div class="w-20 h-20 mx-auto mb-3 bg-white rounded-full flex items-center justify-center">
                <i class="fas fa-socks text-red-800 text-2xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-800 group-hover:text-red-800 transition">Quần</h3>
            </div>
          </a>
          <a href="index.php?action=products&category=13" class="group">
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 text-center p-4">
              <div class="w-20 h-20 mx-auto mb-3 bg-white rounded-full flex items-center justify-center">
                <i class="fas fa-hat-wizard text-red-800 text-2xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-800 group-hover:text-red-800 transition">Phụ kiện nữ</h3>
            </div>
          </a>
          <a href="index.php?action=products&category=15" class="group">
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 text-center p-4">
              <div class="w-20 h-20 mx-auto mb-3 bg-white rounded-full flex items-center justify-center">
                <i class="fas fa-home text-red-800 text-2xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-800 group-hover:text-red-800 transition">Laptop </h3>
            </div>
          </a>
        </div>
      </div>
    </div>
    
    <!-- Download App Section -->
    <div class="bg-gray-100 py-16 px-4">
      <div class="max-w-5xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Mua sắm dễ dàng hơn với ứng dụng MUJI</h2>
        <p class="text-lg text-gray-600 mb-8 max-w-3xl mx-auto">
          Tải ứng dụng MUJI ngay để nhận thêm nhiều ưu đãi đặc biệt, theo dõi đơn hàng dễ dàng và khám phá các sản phẩm mới nhất từ MUJI.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
          <a href="#" class="bg-red-800 hover:bg-red-900 text-white rounded-lg inline-flex items-center justify-center px-6 py-3 w-full sm:w-auto">
            <svg class="mr-3 w-7 h-7" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
              <path fill="currentColor" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"></path>
            </svg>
            <div class="text-left">
              <div class="mb-1 text-xs">Tải về trên</div>
              <div class="-mt-1 font-sans text-sm font-semibold">App Store</div>
            </div>
          </a>
          <a href="#" class="bg-red-800 hover:bg-red-900 text-white rounded-lg inline-flex items-center justify-center px-6 py-3 w-full sm:w-auto">
            <svg class="mr-3 w-7 h-7" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path fill="currentColor" d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path>
            </svg>
            <div class="text-left">
              <div class="mb-1 text-xs">Tải về trên</div>
              <div class="-mt-1 font-sans text-sm font-semibold">Google Play</div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php include 'Template/Footer.php'; ?>
  
  <!-- JavaScript cho horizontal scrolling -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Xử lý horizontal scrolling
      const scrollPrevButtons = document.querySelectorAll('.scroll-prev');
      const scrollNextButtons = document.querySelectorAll('.scroll-next');
      
      scrollPrevButtons.forEach(button => {
        button.addEventListener('click', function() {
          const targetId = this.getAttribute('data-target');
          const container = document.getElementById(targetId);
          container.scrollBy({
            left: -600,
            behavior: 'smooth'
          });
        });
      });
      
      scrollNextButtons.forEach(button => {
        button.addEventListener('click', function() {
          const targetId = this.getAttribute('data-target');
          const container = document.getElementById(targetId);
          container.scrollBy({
            left: 600,
            behavior: 'smooth'
          });
        });
      });
      
      // Xử lý thêm vào giỏ hàng
      const addToCartButtons = document.querySelectorAll('.product-card button');
      
      addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          // Lấy đường dẫn sản phẩm từ link gần nhất
          const productLink = this.closest('.product-card').querySelector('a').getAttribute('href');
          // Lấy slug từ đường dẫn
          const slug = productLink.split('slug=')[1];
          
          // AJAX request để thêm vào giỏ hàng
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'index.php?action=addToCart', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onload = function() {
            if (this.status === 200) {
              // Hiển thị thông báo thành công
              alert('Đã thêm sản phẩm vào giỏ hàng!');
              
              // Cập nhật số lượng sản phẩm trong giỏ hàng (nếu có)
              const cartCountElem = document.getElementById('cart-count');
              if (cartCountElem) {
                try {
                  const response = JSON.parse(this.responseText);
                  if (response.cartCount) {
                    cartCountElem.textContent = response.cartCount;
                    cartCountElem.classList.remove('hidden');
                  }
                } catch (e) {
                  console.error('Lỗi phân tích phản hồi JSON:', e);
                }
              }
            } else {
              alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!');
            }
          };
          xhr.onerror = function() {
            alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!');
          };
          xhr.send('product_slug=' + encodeURIComponent(slug));
        });
      });
    });
  </script>
</body>
</html>