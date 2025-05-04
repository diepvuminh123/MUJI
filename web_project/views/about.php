<?php
require_once(__DIR__ . '/../config/config.php'); 
$conn = $GLOBALS['conn'];

// Lấy thông tin từ bảng siteinfo
$result = $conn->query("SELECT `key`, `value` FROM site_info");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['key']] = $row['value'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giới thiệu | <?= $data['Company_name'] ?? 'Công ty' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50 text-gray-900">
  <?php include 'Template/Header.php'; ?>

  <div class="max-w-4xl mx-auto py-12 px-6">
    <h1 class="text-4xl font-bold mb-6">Giới thiệu</h1>
    <p class="mb-4 text-lg"><strong>Công ty:</strong> <?= $data['Company_name'] ?? '' ?></p>
    <p class="mb-4 text-lg"><strong>Địa chỉ:</strong> <?= $data['address'] ?? '' ?></p>
    <p class="mb-4 text-lg"><strong>Hotline:</strong> <?= $data['hotline'] ?? '' ?></p>
    <p class="mb-4 text-lg"><strong>Slogan:</strong> <?= $data['Slogan'] ?? '' ?></p>
  </div>

  <?php include 'Template/Footer.php'; ?>
</body>
</html>
