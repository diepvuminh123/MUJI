<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Danh sách bài viết</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- header -->
    <?php $GLOBALS['site_info'] = $site_info; ?>
    <?php include 'Template/Header.php'; ?>

  <div class="max-w-3xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($article['title']) ?></h2>
    <img src="uploads/<?= $article['thumbnail'] ?>" alt="Ảnh bài viết" class="w-full rounded mb-4 object-cover max-h-96">
    <div class="prose prose-lg max-w-none bg-white p-5 rounded shadow">
      <?= $article['content'] ?>
    </div>
  </div>
</body>
</html>
