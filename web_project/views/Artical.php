<?php
require_once(__DIR__ . '/../config/config.php');
$conn = $GLOBALS['conn'];

// Xử lý thêm bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO articles (title, author, date, category, image, content) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $_POST['title'], $_POST['author'], $_POST['date'], $_POST['category'], $_POST['image'], $_POST['content']);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý xoá bài viết
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Lấy danh sách bài viết
$result = $conn->query("SELECT * FROM articles ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý bài viết</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #2c3e50;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        input, textarea {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: #fff;
        }
        .delete-btn {
            color: red;
            text-decoration: none;
        }
        .delete-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>📝 Thêm bài viết mới</h2>
<form method="POST">
    <input type="hidden" name="add" value="1">
    <input type="text" name="title" placeholder="Tiêu đề" required>
    <input type="text" name="author" placeholder="Tác giả">
    <input type="date" name="date">
    <input type="text" name="category" placeholder="Chuyên mục">
    <input type="text" name="image" placeholder="URL hình ảnh (https://...)">
    <textarea name="content" rows="5" placeholder="Nội dung bài viết"></textarea>
    <button type="submit">Thêm bài viết</button>
</form>

<h2>📋 Danh sách bài viết</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Tác giả</th>
            <th>Ngày</th>
            <th>Chuyên mục</th>
            <th>Lượt xem</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['views'] ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Bạn có chắc muốn xoá bài viết này?')">Xoá</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
