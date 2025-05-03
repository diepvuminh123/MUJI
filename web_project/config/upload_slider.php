<?php
require_once 'config.php'; // dùng lại kết nối có sẵn
$conn = $GLOBALS['conn'];

// Xử lý khi người dùng submit ảnh
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['slider_image'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["slider_image"]["name"]);
    $targetPath = $targetDir . $fileName;

    // Tạo thư mục nếu chưa có
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["slider_image"]["tmp_name"], $targetPath)) {
        $stmt = $conn->prepare("INSERT INTO sliders (image_path) VALUES (?)");
        $stmt->bind_param("s", $targetPath);
        $stmt->execute();
        $message = "✅ Upload thành công!";
    } else {
        $message = "❌ Upload thất bại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload ảnh slider</title>
</head>
<body>
    <h2>Upload ảnh slider</h2>

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="slider_image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>

    <hr>

    <h3>Ảnh slider mới nhất:</h3>
    <?php
    $result = $conn->query("SELECT * FROM sliders ORDER BY id DESC LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        echo '<img src="' . $row['image_path'] . '" style="max-width: 300px; margin: 10px;">';
    }
    ?>
</body>
</html>
