<?php require_once(__DIR__ . '/../config/config.php'); 
$conn = $GLOBALS['conn'];  
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; 
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
?>  

<!DOCTYPE html> 
<html lang="vi"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? "Chi tiết bài viết" : "Trang tin tức" ?></title>     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>         
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #95a5a6;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {             
            font-family: 'Segoe UI', Arial, sans-serif;             
            background: #f9f9f9;            
            margin: 0;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            background: var(--primary);
            color: white;
            padding: 1rem 0;
            box-shadow: var(--shadow);
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .menu {
            display: flex;
            list-style: none;
        }
        
        .menu li {
            margin-left: 20px;
        }
        
        .menu a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .menu a:hover {
            color: var(--light);
        }
        
        .content {
            padding: 40px 0;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 40px;
            color: var(--primary);
            font-size: 32px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }
        
        .category-nav {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .category-link {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            background: white;
            color: var(--dark);
            text-decoration: none;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }
        
        .category-link:hover, .category-link.active {
            background: var(--secondary);
            color: white;
        }
        
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .article-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }
        
        .article-card:hover {
            transform: translateY(-5px);
        }
        
        .article-image {
            height: 200px;
            overflow: hidden;
        }
        
        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .article-card:hover .article-image img {
            transform: scale(1.05);
        }
        
        .article-content {
            padding: 20px;
        }
        
        .article-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--dark);
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .article-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 15px;
        }
        
        .article-excerpt {
            color: #666;
            margin-bottom: 15px;
            font-size: 14px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .read-more {
            display: inline-block;
            padding: 8px 15px;
            background: var(--secondary);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        
        .read-more:hover {
            background: #2980b9;
        }
        
        /* Detail page styles */
        .article-detail {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        
        .article-header {
            margin-bottom: 20px;
        }
        
        .article-detail-title {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 15px;
        }
        
        .article-detail-meta {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .article-detail-meta div {
            margin-right: 20px;
            margin-bottom: 5px;
        }
        
        .article-detail-meta i {
            margin-right: 5px;
        }
        
        .article-detail-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .article-detail-content {
            line-height: 1.8;
            color: #444;
            font-size: 16px;
        }
        
        .article-detail-content p {
            margin-bottom: 20px;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.3s ease;
            margin-top: 20px;
        }
        
        .back-btn i {
            margin-right: 5px;
        }
        
        .back-btn:hover {
            background: #34495e;
        }
        
        .related-articles {
            margin-top: 40px;
        }
        
        .related-title {
            font-size: 22px;
            color: var(--primary);
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .related-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--secondary);
        }
        
        .footer {
            background: var(--primary);
            color: white;
            padding: 40px 0 20px;
            margin-top: 40px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .footer-section h3 {
            color: white;
            margin-bottom: 20px;
            font-size: 18px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-section h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--secondary);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #bdc3c7;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        
        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            margin: 0 5px;
            background: white;
            color: var(--dark);
            text-decoration: none;
            border-radius: 50%;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }
        
        .page-link:hover, .page-link.active {
            background: var(--secondary);
            color: white;
        }
        
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
            }
            
            .menu {
                margin-top: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .menu li {
                margin: 5px;
            }
            
            .articles-grid {
                grid-template-columns: 1fr;
            }
            
            .article-detail {
                padding: 20px;
            }
            
            .article-detail-title {
                font-size: 24px;
            }
        }
    </style>     
</head> 
<body>
    <!-- Header -->
    <?php include 'Template/Header.php'; ?>

    <!-- Main Content -->
    <main class="content">
        <div class="container">
            <?php if (!$id): ?>
                <h1 class="page-title">
                    <?= $category ? htmlspecialchars($category) : "Tin tức mới nhất" ?>
                </h1>
                
                <!-- Category Navigation -->
                <div class="category-nav">
                    <a href="home.php" class="category-link <?= !$category ? 'active' : '' ?>">
                        <i class="fas fa-th-large"></i> Tất cả
                    </a>
                    <?php
                    $categories = $conn->query("SELECT DISTINCT category FROM articles ORDER BY category");
                    while ($cat = $categories->fetch_assoc()):
                    ?>
                    <a href="?category=<?= urlencode($cat['category']) ?>" 
                       class="category-link <?= $category === $cat['category'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat['category']) ?>
                    </a>
                    <?php endwhile; ?>
                </div>
                
                <!-- Articles Grid -->
                <div class="articles-grid">
                    <?php
                    $query = "SELECT * FROM articles";
                    if ($category) {
                        $query .= " WHERE category = '$category'";
                    }
                    $query .= " ORDER BY date DESC";
                    
                    $result = $conn->query($query);
                    
                    if ($result->num_rows == 0):
                    ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 50px 0;">
                        <i class="fas fa-exclamation-circle" style="font-size: 40px; color: var(--gray); margin-bottom: 20px;"></i>
                        <p>Không có bài viết nào trong danh mục này.</p>
                    </div>
                    <?php 
                    else:
                        while ($row = $result->fetch_assoc()):
                    ?>
                    <div class="article-card">
                        <div class="article-image">
                            <img src="<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                        </div>
                        <div class="article-content">
                            <h3 class="article-title"><?= htmlspecialchars($row['title']) ?></h3>
                            <div class="article-meta">
                                <span><i class="fas fa-user"></i> <?= htmlspecialchars($row['author']) ?></span>
                                <span><i class="fas fa-calendar"></i> <?= $row['date'] ?></span>
                            </div>
                            <p class="article-excerpt"><?= mb_substr(strip_tags($row['content']), 0, 150) ?>...</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a class="read-more" href="?id=<?= $row['id'] ?>">Đọc tiếp</a>
                                <span style="font-size: 13px; color: var(--gray);"><i class="fas fa-eye"></i> <?= $row['views'] ?></span>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                    endif;
                    ?>
                </div>
                
                <!-- Pagination (Simple Example) -->
                <div class="pagination">
                    <a href="#" class="page-link active">1</a>
                    <a href="#" class="page-link">2</a>
                    <a href="#" class="page-link">3</a>
                    <a href="#" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </div>
            
            <?php else: ?>
                <?php
                $conn->query("UPDATE articles SET views = views + 1 WHERE id = $id");
                $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $article = $stmt->get_result()->fetch_assoc();
                
                if (!$article):
                ?>
                <div style="text-align: center; padding: 50px 0;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 60px; color: var(--accent); margin-bottom: 20px;"></i>
                    <h2>Bài viết không tồn tại.</h2>
                    <a href="home.php" class="back-btn" style="margin-top: 20px;">
                        <i class="fas fa-arrow-left"></i> Quay lại trang chủ
                    </a>
                </div>
                <?php 
                else:
                ?>
                <div class="article-detail">
                    <div class="article-header">
                        <h1 class="article-detail-title"><?= htmlspecialchars($article['title']) ?></h1>
                        <div class="article-detail-meta">
                            <div><i class="fas fa-user"></i> <?= htmlspecialchars($article['author']) ?></div>
                            <div><i class="fas fa-calendar"></i> <?= $article['date'] ?></div>
                            <div><i class="fas fa-tags"></i> <?= $article['category'] ?></div>
                            <div><i class="fas fa-eye"></i> <?= $article['views'] + 1 ?> lượt xem</div>
                        </div>
                    </div>
                    
                    <img src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="article-detail-image">
                    
                    <div class="article-detail-content">
                        <?= nl2br($article['content']) ?>
                    </div>
                    
                    <a href="<?= $category ? '?category='.urlencode($category) : 'home.php' ?>" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
                
                <!-- Related Articles -->
                <div class="related-articles">
                    <h2 class="related-title">Bài viết liên quan</h2>
                    <div class="articles-grid">
                        <?php
                        $relatedQuery = $conn->prepare("SELECT * FROM articles WHERE category = ? AND id != ? ORDER BY date DESC LIMIT 3");
                        $relatedQuery->bind_param("si", $article['category'], $article['id']);
                        $relatedQuery->execute();
                        $relatedResult = $relatedQuery->get_result();
                        
                        if ($relatedResult->num_rows > 0):
                            while ($related = $relatedResult->fetch_assoc()):
                        ?>
                        <div class="article-card">
                            <div class="article-image">
                                <img src="<?= $related['image'] ?>" alt="<?= htmlspecialchars($related['title']) ?>">
                            </div>
                            <div class="article-content">
                                <h3 class="article-title"><?= htmlspecialchars($related['title']) ?></h3>
                                <div class="article-meta">
                                    <span><i class="fas fa-calendar"></i> <?= $related['date'] ?></span>
                                    <span><i class="fas fa-eye"></i> <?= $related['views'] ?></span>
                                </div>
                                <p class="article-excerpt"><?= mb_substr(strip_tags($related['content']), 0, 100) ?>...</p>
                                <a class="read-more" href="?id=<?= $related['id'] ?>">Đọc tiếp</a>
                            </div>
                        </div>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <div style="grid-column: 1/-1; text-align: center; padding: 20px 0;">
                            <p>Không có bài viết liên quan.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Về chúng tôi</h3>
                    <p style="color: #bdc3c7; margin-bottom: 15px;">
                        Cập nhật tin tức mới nhất và nhanh nhất về các sự kiện nổi bật trong nước và quốc tế.
                    </p>
                    <div>
                        <i class="fas fa-envelope"></i> Email: contact@example.com<br>
                        <i class="fas fa-phone"></i> Hotline: 0123 456 789
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Danh mục</h3>
                    <ul class="footer-links">
                        <li><a href="?category=Gây Sốc">Tin nóng</a></li>
                        <li><a href="?category=Xã Hội">Xã hội</a></li>
                        <li><a href="?category=Giải Trí">Giải trí</a></li>
                        <li><a href="?category=Thể Thao">Thể thao</a></li>
                        <li><a href="?category=Công Nghệ">Công nghệ</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Liên kết</h3>
                    <ul class="footer-links">
                        <li><a href="#">Điều khoản sử dụng</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Quảng cáo</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                &copy; <?= date('Y') ?> Tin Tức Online. Tất cả quyền được bảo lưu.
            </div>
        </div>
    </footer>
</body> 
</html>