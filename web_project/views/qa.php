<?php require_once(__DIR__ . '/../config/config.php');  
$conn = $GLOBALS['conn'];  

// Lấy thông tin từ bảng siteinfo 
$result = $conn->query("SELECT `key`, `value` FROM site_info"); 
$data = []; 
while ($row = $result->fetch_assoc()) {     
    $data[$row['key']] = $row['value']; 
}

// Gửi câu hỏi
$submission_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO questions (name, email, question) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['question']);
    if ($stmt->execute()) {
        $submission_success = true;
    }
}

// Lấy câu hỏi đã trả lời
$result = $conn->query("SELECT * FROM questions WHERE answer IS NOT NULL ORDER BY created_at DESC");

// Lấy các câu hỏi phổ biến
$faqs = [
    [
        'question' => 'Làm thế nào để đặt hàng trực tuyến?',
        'answer' => 'Bạn có thể đặt hàng trực tuyến thông qua website chính thức của chúng tôi. Chỉ cần thêm sản phẩm vào giỏ hàng và làm theo các bước thanh toán đơn giản.'
    ],
    [
        'question' => 'Thời gian giao hàng là bao lâu?',
        'answer' => 'Thời gian giao hàng thông thường từ 1-3 ngày làm việc đối với khu vực nội thành và 3-5 ngày làm việc đối với khu vực ngoại thành.'
    ],
    [
        'question' => 'Chính sách đổi trả hàng như thế nào?',
        'answer' => 'Chúng tôi chấp nhận đổi trả trong vòng 7 ngày kể từ ngày nhận hàng, với điều kiện sản phẩm còn nguyên vẹn và đầy đủ bao bì.'
    ]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỏi & Đáp | <?= htmlspecialchars($data['Company_name'] ?? 'MUJI') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .faq-animation {
            transition: all 0.3s ease;
        }
        
        .faq-animation:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .question-card {
            transition: all 0.3s ease;
        }
        
        .question-card:hover {
            transform: scale(1.02);
        }
        
        .hero-pattern {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e5e7eb' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .submit-button {
            transition: all 0.3s ease;
        }
        
        .submit-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <?php include 'Template/Header.php'; ?>
    
    <!-- Hero Section -->
    <div class="hero-pattern py-16">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Hỏi & Đáp</h1>
            <p class="text-xl text-gray-600 mb-8">Tìm kiếm câu trả lời cho thắc mắc của bạn hoặc đặt câu hỏi mới</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#faq" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300 hover:bg-blue-700">
                    Câu hỏi thường gặp
                </a>
                <a href="#ask" class="bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded-lg font-bold transition duration-300 hover:bg-gray-100">
                    Đặt câu hỏi mới
                </a>
            </div>
        </div>
    </div>
    
    <!-- Search Section -->
    <div class="bg-white py-10">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-blue-50 p-8 rounded-2xl shadow-lg">
                <div class="flex items-center mb-6">
                    <i class="fas fa-search text-blue-600 text-2xl mr-4"></i>
                    <h2 class="text-2xl font-bold">Tìm kiếm câu trả lời</h2>
                </div>
                <div class="relative">
                    <input type="text" id="search-faq" placeholder="Nhập từ khóa để tìm kiếm..." 
                           class="w-full p-4 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-600">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div id="faq" class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="bg-blue-100 text-blue-800 px-4 py-1 rounded-full text-sm font-semibold">FAQ</span>
                <h2 class="text-3xl font-bold mt-4 mb-2">Câu hỏi thường gặp</h2>
                <p class="text-gray-600">Dưới đây là những câu hỏi phổ biến nhất mà chúng tôi nhận được</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-animation bg-white p-6 rounded-xl shadow-md" style="animation-delay: <?= 0.1 * $index ?>s">
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <i class="fas fa-question text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($faq['question']) ?></h3>
                            <p class="text-gray-600"><?= htmlspecialchars($faq['answer']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-12 text-center">
                <p class="text-gray-600 mb-4">Không tìm thấy câu trả lời bạn đang tìm kiếm?</p>
                <a href="#ask" class="text-blue-600 font-semibold hover:underline">
                    Gửi câu hỏi mới <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Ask Question Section -->
    <div id="ask" class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="bg-green-100 text-green-800 px-4 py-1 rounded-full text-sm font-semibold">HỎI ĐÁP</span>
                <h2 class="text-3xl font-bold mt-4 mb-2">Gửi câu hỏi của bạn</h2>
                <p class="text-gray-600">Chúng tôi sẽ phản hồi trong thời gian sớm nhất</p>
            </div>
            
            <?php if ($submission_success): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded fadeIn">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                    <p>Câu hỏi của bạn đã được gửi thành công! Chúng tôi sẽ trả lời trong thời gian sớm nhất.</p>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Form hỏi -->
            <form method="POST" class="bg-gray-50 p-8 rounded-xl shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Tên của bạn</label>
                        <input name="name" required placeholder="Nhập tên của bạn" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" />
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Email</label>
                        <input name="email" type="email" required placeholder="email@example.com" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" />
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2 font-medium">Nội dung câu hỏi</label>
                    <textarea name="question" required placeholder="Nhập câu hỏi của bạn tại đây..." rows="4"
                              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"></textarea>
                </div>
                
                <div class="text-center">
                    <button class="submit-button bg-blue-600 text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-blue-700">
                        Gửi câu hỏi <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-8">
                <p class="text-gray-600">Hoặc liên hệ trực tiếp qua</p>
                <div class="flex justify-center mt-4 space-x-4">
                    <a href="tel:<?= htmlspecialchars($data['hotline'] ?? '') ?>" class="flex items-center text-blue-600 hover:underline">
                        <i class="fas fa-phone-alt mr-2"></i> <?= htmlspecialchars($data['hotline'] ?? 'Hotline') ?>
                    </a>
                    <a href="contact.php" class="flex items-center text-blue-600 hover:underline">
                        <i class="fas fa-envelope mr-2"></i> Trang liên hệ
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Previous Questions Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="bg-purple-100 text-purple-800 px-4 py-1 rounded-full text-sm font-semibold">CÂU HỎI ĐÃ ĐƯỢC TRẢ LỜI</span>
                <h2 class="text-3xl font-bold mt-4 mb-2">Câu hỏi từ khách hàng</h2>
                <p class="text-gray-600">Những câu hỏi đã được chúng tôi giải đáp</p>
            </div>
            
            <div class="space-y-6">
                <?php 
                $has_questions = false;
                while ($row = $result->fetch_assoc()): 
                    $has_questions = true;
                ?>
                <div class="question-card bg-white border rounded-xl p-6 shadow-md">
                    <div class="flex items-start mb-4">
                        <div class="bg-blue-100 rounded-full p-3 mr-4 shrink-0">
                            <i class="fas fa-question text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($row['question']) ?></p>
                            <p class="text-gray-500 text-sm mt-1">Hỏi bởi: <?= htmlspecialchars($row['name']) ?> - <?= date('d/m/Y', strtotime($row['created_at'])) ?></p>
                        </div>
                    </div>
                    
                    <div class="flex items-start pl-14">
                        <div class="bg-green-100 rounded-full p-3 mr-4 shrink-0">
                            <i class="fas fa-comment-dots text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-green-800"><?= htmlspecialchars($row['answer']) ?></p>
                            <p class="text-gray-500 text-sm mt-1">Trả lời lúc: <?= date('d/m/Y', strtotime($row['updated_at'])) ?></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php if (!$has_questions): ?>
                <div class="text-center py-10">
                    <img src="https://cdn.pixabay.com/photo/2017/03/09/12/31/error-2129569_960_720.jpg" alt="Không có câu hỏi" class="mx-auto h-32 mb-4 opacity-50">
                    <p class="text-gray-500">Chưa có câu hỏi nào được trả lời</p>
                    <a href="#ask" class="inline-block mt-4 text-blue-600 font-semibold hover:underline">
                        Hãy là người đầu tiên đặt câu hỏi! <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Contact CTA Section -->
    <div class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold mb-4">Vẫn còn thắc mắc?</h2>
            <p class="text-xl mb-8">Hãy liên hệ trực tiếp với chúng tôi để được hỗ trợ nhanh nhất</p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="contact.php" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-lg font-bold transition duration-300">
                    <i class="fas fa-headset mr-2"></i> Liên hệ ngay
                </a>
                <a href="tel:<?= htmlspecialchars($data['hotline'] ?? '') ?>" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-bold transition duration-300">
                    <i class="fas fa-phone-alt mr-2"></i> <?= htmlspecialchars($data['hotline'] ?? 'Gọi ngay') ?>
                </a>
            </div>
        </div>
    </div>
    
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
        
        // Search functionality
        document.getElementById('search-faq').addEventListener('keyup', function() {
            let searchQuery = this.value.toLowerCase();
            let faqItems = document.querySelectorAll('.faq-animation');
            
            faqItems.forEach(item => {
                let questionText = item.querySelector('h3').textContent.toLowerCase();
                let answerText = item.querySelector('p').textContent.toLowerCase();
                
                if (questionText.includes(searchQuery) || answerText.includes(searchQuery)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>