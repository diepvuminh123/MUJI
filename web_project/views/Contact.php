<?php require_once __DIR__ . '/../config/config.php'; 
require_once __DIR__ . '/../controllers/ContactController.php'; 

// Khởi tạo controller
$controller = new ContactController($conn);
$result = $controller->handleFormSubmission(); // xử lý nếu có gửi form
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liên hệ - Chúng tôi luôn lắng nghe bạn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Animation library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Map library -->
  <link rel="icon" type="image/png" href="/MUJI/web_project/uploads/LOGO.png" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
  <style>
    .contact-card {
      transition: all 0.3s ease;
    }
    .contact-card:hover {
      transform: translateY(-5px);
    }
    #map {
      height: 300px;
      width: 100%;
      border-radius: 0.5rem;
    }
    .animated-element {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .slide-in {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen">
  <?php include 'Template/Header.php'; ?>
  
  <!-- Hero Section -->
  <div class="relative overflow-hidden bg-blue-600 text-white">
    </div>
    <div class="max-w-6xl mx-auto px-4 py-16 relative">
      <div class="animate__animated animate__fadeIn">
        <h1 class="text-4xl md:text-5xl font-bold mb-3">Hãy kết nối với chúng tôi</h1>
        <p class="text-xl opacity-90 max-w-2xl">Chúng tôi tin rằng mỗi cuộc trò chuyện là khởi đầu của một cơ hội hợp tác tuyệt vời.</p>
      </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-50 to-transparent"></div>
  </div>

  <div class="max-w-6xl mx-auto px-4 py-12 -mt-8">
    <!-- Contact Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
      <div class="contact-card bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-500 animate__animated animate__fadeInUp animate__delay-1s">
        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
        <a href="mailto:<?= htmlspecialchars($GLOBALS['site_info']['email']) ?>" class="text-blue-600 hover:underline font-medium block"><?= htmlspecialchars($GLOBALS['site_info']['email']) ?></a>
        <p class="text-gray-600 mt-2 text-sm">Phản hồi trong vòng 24 giờ</p>
      </div>
      
      <div class="contact-card bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Hotline</h3>
        <a href="tel:<?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?>" class="text-green-600 hover:underline font-medium block"><?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?></a>
        <p class="text-gray-600 mt-2 text-sm">Hỗ trợ từ 8:00 - 18:00</p>
      </div>
      
      <div class="contact-card bg-white p-6 rounded-lg shadow-lg border-t-4 border-purple-500 animate__animated animate__fadeInUp animate__delay-3s">
        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Địa chỉ</h3>
        <p class="text-gray-700"><?= htmlspecialchars($GLOBALS['site_info']['address']) ?></p>
      </div>
    </div>

    <!-- Main Contact Section -->
    <div class="grid md:grid-cols-2 gap-12">
      <!-- Form Section -->
      <div class="bg-white rounded-xl shadow-xl p-8 order-2 md:order-1 animated-element">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Gửi tin nhắn cho chúng tôi</h2>
        
        <?php if (!empty($result['success'])): ?>
          <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded animate__animated animate__fadeIn">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm">Gửi thành công! Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất.</p>
              </div>
            </div>
          </div>
        <?php elseif (!empty($result['error'])): ?>
          <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded animate__animated animate__fadeIn">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm"><?= htmlspecialchars($result['error']) ?></p>
              </div>
            </div>
          </div>
        <?php endif; ?>
        
        <form method="post" action="" class="space-y-5">
          <div class="grid md:grid-cols-2 gap-5">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
              <input type="text" id="name" name="name" required
                class="w-full rounded-md py-3 px-4 border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" />
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" id="email" name="email" required
                class="w-full rounded-md py-3 px-4 border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" />
            </div>
          </div>
          
          <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
            <input type="text" id="subject" name="subject"
              class="w-full rounded-md py-3 px-4 border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" />
          </div>
          
          <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Nội dung tin nhắn</label>
            <textarea id="message" name="message" rows="5" required
              class="w-full rounded-md py-3 px-4 border border-gray-300 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm resize-none"></textarea>
          </div>
          
          <div class="flex items-center">
            <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="terms" class="ml-2 block text-sm text-gray-700">
              Tôi đồng ý với <a href="#" class="text-blue-600 hover:underline">chính sách bảo mật</a> và <a href="#" class="text-blue-600 hover:underline">điều khoản sử dụng</a>
            </label>
          </div>
          
          <button type="submit"
            class="w-full py-3 px-6 text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-md transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <div class="flex items-center justify-center">
              <span>Gửi tin nhắn</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </div>
          </button>
        </form>
      </div>
      
      <!-- Information Section -->
      <div class="order-1 md:order-2 animated-element">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Thông tin liên hệ</h2>
        
        <p class="text-lg text-gray-600 mb-8">
          Chúng tôi luôn sẵn sàng lắng nghe mọi ý kiến đóng góp, câu hỏi và đề xuất hợp tác từ bạn. 
          Đừng ngần ngại liên hệ với chúng tôi qua các kênh dưới đây hoặc gửi tin nhắn trực tiếp.
        </p>
        
        <div class="space-y-6 mb-10">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-base font-medium text-gray-900">Giờ làm việc</h3>
              <p class="text-gray-600 mt-1">Thứ 2 - Thứ 6: 8:00 - 18:00</p>
              <p class="text-gray-600">Thứ 7: 8:00 - 12:00</p>
            </div>
          </div>
          
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-base font-medium text-gray-900">Hỗ trợ khách hàng</h3>
              <p class="text-gray-600 mt-1">Phản hồi trong vòng 24 giờ</p>
              <p class="text-gray-600">Hỗ trợ khẩn cấp 24/7</p>
            </div>
          </div>
        </div>
        
        <!-- Map -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Vị trí của chúng tôi</h3>
        <div id="map" class="mb-8 shadow-md"></div>
        
        <!-- Social Media -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Kết nối với chúng tôi</h3>
        <div class="flex space-x-4">
          <a href="#" class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
            </svg>
          </a>
          <a href="#" class="w-12 h-12 bg-blue-400 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
              <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
            </svg>
          </a>
          <a href="#" class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 rounded-full flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
            </svg>
          </a>
          <a href="#" class="w-12 h-12 bg-red-600 hover:bg-red-700 rounded-full flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-20 animated-element">
      <h2 class="text-3xl font-bold text-center mb-12">Câu hỏi thường gặp</h2>
      
      <div class="max-w-3xl mx-auto">
        <div class="space-y-6">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
              <span class="text-lg font-medium text-gray-900">Thời gian phản hồi của dịch vụ hỗ trợ?</span>
              <svg class="faq-icon h-6 w-6 text-blue-600 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content bg-gray-50 px-6 py-4 hidden">
              <p class="text-gray-700">Chúng tôi cam kết phản hồi mọi yêu cầu hỗ trợ trong vòng 24 giờ làm việc. Đối với các trường hợp khẩn cấp, chúng tôi có đường dây nóng hỗ trợ 24/7 để đảm bảo vấn đề của bạn được giải quyết nhanh chóng.</p>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
              <span class="text-lg font-medium text-gray-900">Làm thế nào để tôi có thể theo dõi tiến độ dự án?</span>
              <svg class="faq-icon h-6 w-6 text-blue-600 transform transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content bg-gray-50 px-6 py-4 hidden">
              <p class="text-gray-700">Chúng tôi sử dụng hệ thống quản lý dự án trực tuyến, nơi khách hàng có thể đăng nhập và theo dõi tiến độ dự án theo thời gian thực. Ngoài ra, chúng tôi cũng gửi báo cáo tiến độ định kỳ qua email và tổ chức các cuộc họp cập nhật trực tuyến.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Newsletter Section -->
    <div class="mt-20 bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl p-8 text-white shadow-xl animated-element">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-2xl font-bold mb-4">Đăng ký nhận tin tức & khuyến mãi</h2>
        <p class="mb-6 opacity-90">Cập nhật những thông tin mới nhất về sản phẩm, dịch vụ và ưu đãi đặc biệt từ chúng tôi.</p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
          <input type="email" placeholder="Email của bạn" class="flex-grow py-3 px-4 rounded-md border-none focus:ring-2 focus:ring-blue-300 text-gray-800">
          <button type="submit" class="bg-white text-blue-600 font-medium py-3 px-6 rounded-md hover:bg-blue-50 transition">Đăng ký</button>
        </form>
      </div>
    </div>
  </div>

  <?php include 'Template/Footer.php'; ?>

  <script>
    // Scroll animations
    document.addEventListener('DOMContentLoaded', function() {
      // FAQ accordions
      const faqToggles = document.querySelectorAll('.faq-toggle');
      faqToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
          const content = toggle.nextElementSibling;
          const icon = toggle.querySelector('.faq-icon');
          
          // Toggle the content
          content.classList.toggle('hidden');
          
          // Rotate the icon
          if (content.classList.contains('hidden')) {
            icon.classList.remove('rotate-180');
          } else {
            icon.classList.add('rotate-180');
          }
        });
      });
      
      // Map initialization
      // Thay đổi tọa độ này theo vị trí thực tế của bạn
      const lat = 10.7769;
      const lng = 106.7009;
      
      const map = L.map('map').setView([lat, lng], 15);
      
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      
      L.marker([lat, lng]).addTo(map)
        .bindPopup('<?= htmlspecialchars($GLOBALS['site_info']['address']) ?>')
        .openPopup();
      
      // Scroll animations
      const animatedElements = document.querySelectorAll('.animated-element');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('slide-in');
          }
        });
      }, { threshold: 0.1 });
      
      animatedElements.forEach(el => {
        observer.observe(el);
      });
    });
  </script>
</body>