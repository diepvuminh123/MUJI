<?php
require_once(__DIR__ . '/../config/config.php');
$conn = $GLOBALS['conn'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? "Chi tiết bài viết" : "Tin tức" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 30px 0;
        }
        .page-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 32px;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
        }
        .page-title::after {
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
            box-shadow: var(--shadow);
            transition: 0.3s;
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
            transition: transform 0.3s;
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
            transition: transform 0.5s;
        }
        .article-card:hover .article-image img {
            transform: scale(1.05);
        }
        .article-content {
            padding: 20px;
        }
        .article-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .article-meta {
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .article-excerpt {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .read-more {
            background: var(--secondary);
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .read-more:hover {
            background: #2980b9;
        }
        .article-detail {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        .article-detail img {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
            margin: 20px 0;
        }
        .back-btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #34495e;
        }
        @media (max-width: 768px) {
            .articles-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php include 'Template/Header.php'; ?>

<div class="container">
    <?php if (!$id): ?>
        <h1 class="page-title"><?= $category ? htmlspecialchars($category) : "Tin tức mới nhất" ?></h1>
        <div class="category-nav">
            <a href="index.php?action=listartical" class="category-link <?= !$category ? 'active' : '' ?>">Tất cả</a>
            <?php
            $categories = $conn->query("SELECT DISTINCT category FROM articles ORDER BY category");
            while ($cat = $categories->fetch_assoc()):
            ?>
                <a href="index.php?action=listartical&category=<?= urlencode($cat['category']) ?>"
                   class="category-link <?= $category === $cat['category'] ? 'active' : '' ?>">
                   <?= htmlspecialchars($cat['category']) ?>
                </a>
            <?php endwhile; ?>
        </div>

        <div class="articles-grid">
            <?php
            $query = "SELECT * FROM articles";
            if ($category) {
                $query .= " WHERE category = '$category'";
            }
            $query .= " ORDER BY date DESC";
            $result = $conn->query($query);

            if ($result->num_rows === 0): ?>
                <p style="text-align: center; width: 100%;">Không có bài viết nào.</p>
            <?php else:
                while ($row = $result->fetch_assoc()):
            ?>
                <div class="article-card">
                    <div class="article-image">
                    <img src="../uploads/hot.jpg ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    </div>
                    <div class="article-content">
                        <h3 class="article-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <div class="article-meta">
                            <span><i class="fas fa-user"></i> <?= htmlspecialchars($row['author']) ?></span>
                            <span><i class="fas fa-calendar"></i> <?= $row['date'] ?></span>
                        </div>
                        <p class="article-excerpt"><?= mb_substr(strip_tags($row['content']), 0, 120) ?>...</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <a class="read-more" href="index.php?action=listartical&id=<?= $row['id'] ?>&category=<?= urlencode($row['category']) ?>">Đọc tiếp</a>
                            <span style="font-size: 13px; color: var(--gray);"><i class="fas fa-eye"></i> <?= $row['views'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>
        </div>
    <?php else:
        $conn->query("UPDATE articles SET views = views + 1 WHERE id = $id");
        $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $article = $stmt->get_result()->fetch_assoc();

        if (!$article): ?>
            <p>Bài viết không tồn tại.</p>
            <a href="index.php?action=listartical" class="back-btn">← Quay lại</a>
        <?php else: ?>
            <div class="article-detail">
                <h1><?= htmlspecialchars($article['title']) ?></h1>
                <div style="color: gray; margin-bottom: 10px;">
                    <i class="fas fa-user"></i> <?= htmlspecialchars($article['author']) ?> |
                    <i class="fas fa-calendar"></i> <?= $article['date'] ?> |
                    <i class="fas fa-tags"></i> <?= $article['category'] ?> |
                    <i class="fas fa-eye"></i> <?= $article['views'] + 1 ?>
                </div>
                <img src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                <div style="margin-top: 20px; font-size: 16px;"><?= nl2br($article['content']) ?></div>
                <a href="index.php?action=listartical<?= $category ? '&category='.urlencode($category) : '' ?>" class="back-btn" style="margin-top: 20px;">← Quay lại danh sách</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'Template/Footer.php'; ?>

</body>
</html>
