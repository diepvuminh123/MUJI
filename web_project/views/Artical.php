<?php
// article.php - Trang hiển thị chi tiết bài viết
// Phần này sẽ kết nối database sau này

// Giả lập dữ liệu bài viết (sau này sẽ lấy từ database)
$article = [
    'id' => 1,
    'title' => 'Tiêu đề bài viết mẫu',
    'author' => 'Nguyễn Văn A',
    'date' => '04/05/2025',
    'category' => 'Công nghệ',
    'content' => 'Nội dung chi tiết của bài viết sẽ được hiển thị ở đây. Đây là phần nội dung mẫu để minh họa giao diện.',
    'image' => 'https://via.placeholder.com/800x400',
    'views' => 1250,
    'comments' => [
        [
            'user' => 'Trần Văn B',
            'date' => '04/05/2025',
            'content' => 'Bài viết rất hay và bổ ích!'
        ],
        [
            'user' => 'Lê Thị C',
            'date' => '03/05/2025',
            'content' => 'Cảm ơn tác giả đã chia sẻ thông tin.'
        ]
    ]
];

// Các bài viết liên quan (sau này sẽ query từ database)
$relatedArticles = [
    [
        'id' => 2,
        'title' => 'Bài viết liên quan 1',
        'image' => 'https://via.placeholder.com/300x200',
        'date' => '03/05/2025'
    ],
    [
        'id' => 3,
        'title' => 'Bài viết liên quan 2',
        'image' => 'https://via.placeholder.com/300x200',
        'date' => '02/05/2025'
    ],
    [
        'id' => 4,
        'title' => 'Bài viết liên quan 3',
        'image' => 'https://via.placeholder.com/300x200',
        'date' => '01/05/2025'
    ]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['title']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: var(--text-color);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header */
        header {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            color: var(--secondary-color);
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: var(--primary-color);
        }

        .search-bar {
            background-color: white;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .search-container {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-container input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        /* Main content */
        .main-content {
            padding: 30px 0;
        }

        .article-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .article {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .article-header {
            padding: 20px;
        }

        .article-title {
            font-size: 28px;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .article-meta span {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        .article-meta i {
            margin-right: 5px;
        }

        .article-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .article-content {
            padding: 20px;
            line-height: 1.8;
            font-size: 16px;
        }

        .article-content p {
            margin-bottom: 20px;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .sidebar-title {
            font-size: 18px;
            color: var(--secondary-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .related-articles {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .related-article {
            display: flex;
            gap: 10px;
        }

        .related-article-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .related-article-info {
            flex: 1;
        }

        .related-article-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .related-article-date {
            font-size: 12px;
            color: #666;
        }

        /* Comments section */
        .comments-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-top: 30px;
        }

        .comments-title {
            font-size: 20px;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .comment {
            padding: 15px;
            background-color: var(--light-gray);
            border-radius: 8px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-user {
            font-weight: 500;
        }

        .comment-date {
            font-size: 12px;
            color: #666;
        }

        .comment-content {
            font-size: 14px;
        }

        .comment-form {
            margin-top: 30px;
        }

        .comment-form h3 {
            margin-bottom: 15px;
        }

        .comment-form textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            resize: vertical;
            margin-bottom: 10px;
        }

        .comment-form button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Footer */
        footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 40px 0;
            margin-top: 40px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .footer-section p, .footer-section ul {
            font-size: 14px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .article-container {
                grid-template-columns: 1fr;
            }

            .header-container {
                flex-direction: column;
                gap: 15px;
            }

            nav ul {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">TinTức247</div>
            <nav>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="#">Tin mới</a></li>
                    <li><a href="#">Công nghệ</a></li>
                    <li><a href="#">Thể thao</a></li>
                    <li><a href="#">Giải trí</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="search-bar">
        <div class="container">
            <div class="search-container">
                <input type="text" placeholder="Tìm kiếm bài viết...">
                <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="article-container">
                <div class="main-article">
                    <article class="article">
                        <div class="article-header">
                            <h1 class="article-title"><?php echo $article['title']; ?></h1>
                            <div class="article-meta">
                                <span><i class="fas fa-user"></i> <?php echo $article['author']; ?></span>
                                <span><i class="fas fa-calendar"></i> <?php echo $article['date']; ?></span>
                                <span><i class="fas fa-folder"></i> <?php echo $article['category']; ?></span>
                                <span><i class="fas fa-eye"></i> <?php echo $article['views']; ?> lượt xem</span>
                            </div>
                        </div>
                        <img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>" class="article-image">
                        <div class="article-content">
                            <p><?php echo $article['content']; ?></p>
                            <p>Để hiển thị nội dung bài viết phong phú hơn, chúng ta sẽ lấy dữ liệu từ database. Nội dung này có thể bao gồm các đoạn văn, hình ảnh, video, và các định dạng HTML khác.</p>
                            <p>Phần này sẽ được kết nối với database để hiển thị nội dung thực tế của bài viết khi triển khai.</p>
                        </div>
                    </article>

                    <div class="comments-section">
                        <h2 class="comments-title">Bình luận (<?php echo count($article['comments']); ?>)</h2>
                        <div class="comments-list">
                            <?php foreach ($article['comments'] as $comment): ?>
                                <div class="comment">
                                    <div class="comment-header">
                                        <span class="comment-user"><?php echo $comment['user']; ?></span>
                                        <span class="comment-date"><?php echo $comment['date']; ?></span>
                                    </div>
                                    <div class="comment-content">
                                        <?php echo $comment['content']; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="comment-form">
                            <h3>Để lại bình luận</h3>
                            <form id="commentForm">
                                <!-- Phần này sẽ gửi dữ liệu đến database -->
                                <textarea name="comment" placeholder="Nhập bình luận của bạn..." required></textarea>
                                <button type="submit">Gửi bình luận</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="sidebar">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Bài viết liên quan</h3>
                        <div class="related-articles">
                            <?php foreach ($relatedArticles as $relatedArticle): ?>
                                <div class="related-article">
                                    <img src="<?php echo $relatedArticle['image']; ?>" alt="<?php echo $relatedArticle['title']; ?>" class="related-article-image">
                                    <div class="related-article-info">
                                        <h4 class="related-article-title">
                                            <a href="article.php?id=<?php echo $relatedArticle['id']; ?>"><?php echo $relatedArticle['title']; ?></a>
                                        </h4>
                                        <div class="related-article-date"><?php echo $relatedArticle['date']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Chuyên mục</h3>
                        <ul>
                            <!-- Phần này sẽ lấy dữ liệu từ database -->
                            <li><a href="#">Công nghệ (45)</a></li>
                            <li><a href="#">Thể thao (32)</a></li>
                            <li><a href="#">Giải trí (28)</a></li>
                            <li><a href="#">Kinh doanh (21)</a></li>
                            <li><a href="#">Đời sống (19)</a></li>
                        </ul>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Tin nổi bật</h3>
                        <!-- Phần này sẽ lấy dữ liệu từ database -->
                        <div class="related-articles">
                            <div class="related-article">
                                <img src="https://via.placeholder.com/300x200" alt="Tin nổi bật 1" class="related-article-image">
                                <div class="related-article-info">
                                    <h4 class="related-article-title">
                                        <a href="#">Tin nổi bật 1</a>
                                    </h4>
                                    <div class="related-article-date">04/05/2025</div>
                                </div>
                            </div>
                            <div class="related-article">
                                <img src="https://via.placeholder.com/300x200" alt="Tin nổi bật 2" class="related-article-image">
                                <div class="related-article-info">
                                    <h4 class="related-article-title">
                                        <a href="#">Tin nổi bật 2</a>
                                    </h4>
                                    <div class="related-article-date">03/05/2025</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Về chúng tôi</h3>
                    <p>TinTức247 là trang tin tức cập nhật hàng ngày với các thông tin nóng hổi và đáng tin cậy từ nhiều lĩnh vực.</p>
                </div>
                <div class="footer-section">
                    <h3>Liên hệ</h3>
                    <p>Email: info@tintuc247.com</p>
                    <p>Điện thoại: 0123-456-789</p>
                    <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                </div>
                <div class="footer-section">
                    <h3>Chuyên mục</h3>
                    <ul>
                        <li><a href="#">Công nghệ</a></li>
                        <li><a href="#">Thể thao</a></li>
                        <li><a href="#">Giải trí</a></li>
                        <li><a href="#">Kinh doanh</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Theo dõi chúng tôi</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i> Facebook</a><br>
                        <a href="#"><i class="fab fa-twitter"></i> Twitter</a><br>
                        <a href="#"><i class="fab fa-instagram"></i> Instagram</a><br>
                        <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 TinTức247. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script>
        // JavaScript để xử lý gửi bình luận (sẽ kết nối với database sau)
        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const commentText = this.querySelector('textarea').value;
            alert('Chức năng gửi bình luận sẽ được kết nối với database sau này!');
            // Sau này sẽ gửi dữ liệu đến server qua AJAX và lưu vào database
            this.reset();
        });
    </script>
</body>
</html>