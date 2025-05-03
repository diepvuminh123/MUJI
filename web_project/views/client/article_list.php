<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Danh sách bài viết</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/css/article.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- header -->
    <?php include __DIR__ . '/../Template/Header.php'; ?>


    <!--  -->
    <div class="max-w-7xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6">Danh sách bài viết</h2>

    <?php if (!isset($articles) || !is_iterable($articles)) : ?>
      <p class="text-red-600">Không có bài viết nào hoặc lỗi kết nối CSDL.</p>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while($row = mysqli_fetch_assoc($articles)) { ?>
      <div class="bg-white rounded shadow hover:shadow-lg transition overflow-hidden card-hover">
        <img src="uploads/<?= $row['thumbnail'] ?>" alt="Ảnh bài viết" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($row['title']) ?></h3>
          <p class="text-sm text-gray-700 mb-3"><?= htmlspecialchars(substr($row['summary'], 0, 100)) ?>...</p>
          <a href="index.php?controller=article&action=detail&id=<?= $row['id'] ?>" class="btn-primary-custom">Xem chi tiết</a>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>
