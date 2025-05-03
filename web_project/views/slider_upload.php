<?php
require_once __DIR__ . '/../controllers/SliderController.php';
$controller = new SliderController();
$response = $controller->upload();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload ảnh slider</title>
</head>
<body>
    <h2>Upload ảnh slider</h2>

    <?php if (!empty($response['success'])): ?>
        <p style="color: green;">✅ Upload thành công!</p>
    <?php elseif (!empty($response['error'])): ?>
        <p style="color: red;">❌ <?= $response['error'] ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="slider_image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
