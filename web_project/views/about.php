<?php require_once(__DIR__ . '/../config/config.php');  
$conn = $GLOBALS['conn'];  

// Lấy thông tin từ bảng siteinfo 
$result = $conn->query("SELECT `key`, `value` FROM site_info"); 
$data = []; 
while ($row = $result->fetch_assoc()) {     
    $data[$row['key']] = $row['value']; 
}

// Lấy các ảnh slider để hiển thị trong trang giới thiệu
$sliders = [];
$result = $conn->query("SELECT image_path FROM sliders ORDER BY id DESC LIMIT 3");
while ($row = $result->fetch_assoc()) {
    $sliders[] = $row['image_path'];
}
?>  

<!DOCTYPE html> 
<html lang="vi"> 
<head>   
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu | <?= htmlspecialchars($data['Company_name'] ?? 'Công ty') ?></title>   
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('<?= !empty($sliders) ? "../" . htmlspecialchars($sliders[0]) : "https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" ?>');
            background-size: cover;
            background-position: center;
            height: 500px;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .scroll-down-arrow {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
    </style>
</head> 
<body class="bg-gray-50 text-gray-900">   
    <?php include 'Template/Header.php'; ?>    
    
    <!-- Hero Section -->
    <section class="hero-section flex items-center justify-center relative">
        <div class="text-center text-white z-10 px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4"><?= htmlspecialchars($data['Company_name'] ?? 'Công ty chúng tôi') ?></h1>
            <p class="text-2xl md:text-3xl italic mb-8">"<?= htmlspecialchars($data['Slogan'] ?? 'Slogan công ty') ?>"</p>
            <a href="#about" class="bg-white text-blue-600 hover:bg-blue-700 hover:text-white px-8 py-3 rounded-full font-bold transition duration-300 inline-block">Tìm hiểu thêm</a>
        </div>
        <div class="absolute bottom-10 w-full text-center text-white">
            <a href="#about" class="scroll-down-arrow inline-block">
                <i class="fas fa-chevron-down text-3xl"></i>
            </a>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Về Chúng Tôi</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    <?= htmlspecialchars($data['Company_name'] ?? '') ?> tự hào là doanh nghiệp hàng đầu trong lĩnh vực của mình, 
                    mang đến những sản phẩm và dịch vụ chất lượng hàng đầu kể từ khi thành lập.
                </p>
            </div>
            
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <div class="relative">
                        <img src="<?= !empty($sliders) && isset($sliders[1]) ? "../" . htmlspecialchars($sliders[1]) : "https://images.unsplash.com/photo-1606857521015-7f9fcf423740?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" ?>" 
                             alt="Văn phòng công ty" class="rounded-lg shadow-2xl w-full">
                        <div class="absolute -bottom-6 -right-6 bg-blue-600 text-white p-6 rounded-lg shadow-lg hidden md:block">
                            <p class="text-2xl font-bold">Chuyên nghiệp</p>
                            <p>Chất lượng là ưu tiên hàng đầu</p>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-1/2 mt-12 md:mt-0">
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">Tầm nhìn & Sứ mệnh</h3>
                    <p class="text-lg text-gray-600 mb-6">
                        Chúng tôi không ngừng nỗ lực để mang đến những sản phẩm và dịch vụ tốt nhất, đáp ứng mọi nhu cầu của khách hàng.
                        Với đội ngũ nhân viên giàu kinh nghiệm và chuyên môn cao, chúng tôi cam kết mang lại sự hài lòng tuyệt đối.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-check text-blue-600 text-xl"></i>
                            </div>
                            <p class="font-semibold">Chất lượng cao</p>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                            <p class="font-semibold">Đội ngũ chuyên nghiệp</p>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-clock text-blue-600 text-xl"></i>
                            </div>
                            <p class="font-semibold">Đúng tiến độ</p>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-hand-holding-usd text-blue-600 text-xl"></i>
                            </div>
                            <p class="font-semibold">Giá cả hợp lý</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Us -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Tại Sao Chọn Chúng Tôi?</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mb-8"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg feature-card">
                    <div class="inline-block p-4 bg-blue-600 text-white rounded-full mb-6">
                        <i class="fas fa-trophy text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Đẳng Cấp</h3>
                    <p class="text-gray-600">
                        Chúng tôi luôn đặt chất lượng lên hàng đầu, cam kết mang đến những sản phẩm tốt nhất cho khách hàng.
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg feature-card">
                    <div class="inline-block p-4 bg-blue-600 text-white rounded-full mb-6">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Uy Tín</h3>
                    <p class="text-gray-600">
                        Với nhiều năm kinh nghiệm trong ngành, chúng tôi tự hào về sự tin tưởng mà khách hàng dành cho chúng tôi.
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg feature-card">
                    <div class="inline-block p-4 bg-blue-600 text-white rounded-full mb-6">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Hỗ Trợ 24/7</h3>
                    <p class="text-gray-600">
                        Đội ngũ chăm sóc khách hàng chuyên nghiệp, sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi khi cần.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Information -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-12 md:mb-0">
                    <img src="<?= !empty($sliders) && isset($sliders[2]) ? "../" . htmlspecialchars($sliders[2]) : "https://images.unsplash.com/photo-1577412647305-991150c7d163?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" ?>"
                         alt="Liên hệ" class="rounded-lg shadow-xl">
                </div>
                
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Liên Hệ Với Chúng Tôi</h2>
                    <div class="w-20 h-1 bg-blue-600 mb-8"></div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Địa Chỉ</h3>
                                <p class="text-gray-600"><?= htmlspecialchars($data['address'] ?? 'Địa chỉ công ty') ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-phone-alt text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Hotline</h3>
                                <p class="text-gray-600"><?= htmlspecialchars($data['hotline'] ?? 'Số điện thoại') ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Email</h3>
                                <p class="text-gray-600">info@<?= strtolower(str_replace(' ', '', $data['Company_name'] ?? 'company')) ?>.com</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-10">
                        <a href="contact.php" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 inline-block">
                            Gửi Tin Nhắn <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-20 bg-gray-800 text-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Khách Hàng Nói Gì?</h2>
                <div class="w-20 h-1 bg-blue-400 mx-auto mb-8"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-700 p-8 rounded-lg">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="mb-6 italic">"Tôi rất hài lòng với dịch vụ của công ty. Đội ngũ nhân viên chuyên nghiệp, sản phẩm chất lượng cao và giá cả phải chăng."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="font-bold text-xl">NV</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Nguyễn Văn A</h4>
                            <p class="text-gray-400">Khách hàng</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-700 p-8 rounded-lg">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="mb-6 italic">"Tôi đã sử dụng dịch vụ của công ty trong nhiều năm. Họ luôn đáp ứng đúng yêu cầu của tôi và làm việc rất chuyên nghiệp."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="font-bold text-xl">TH</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Trần Hoàng B</h4>
                            <p class="text-gray-400">Đối tác</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-700 p-8 rounded-lg">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="mb-6 italic">"Dịch vụ chăm sóc khách hàng tuyệt vời. Tôi rất ấn tượng với cách họ giải quyết vấn đề nhanh chóng và hiệu quả."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="font-bold text-xl">LT</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Lê Thị C</h4>
                            <p class="text-gray-400">Khách hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-4xl font-bold mb-6">Sẵn sàng hợp tác với chúng tôi?</h2>
            <p class="text-xl mb-10">Liên hệ ngay hôm nay để được tư vấn miễn phí và nhận các ưu đãi đặc biệt!</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="contact.php" class="bg-white text-blue-600 hover:bg-gray-200 px-8 py-3 rounded-lg font-bold transition duration-300">
                    Liên Hệ Ngay
                </a>
                <a href="products.php" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-bold transition duration-300">
                    Xem Sản Phẩm
                </a>
            </div>
        </div>
    </section>
    
    <?php include 'Template/Footer.php'; ?>
    
    <script>
        // Smooth scroll functionality
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body> 
</html>