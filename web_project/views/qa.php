<?php
require_once(__DIR__ . '/../config/config.php'); 
$conn = $GLOBALS['conn'];

// Gửi câu hỏi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO questions (name, email, question) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['question']);
    $stmt->execute();
}

// Lấy câu hỏi đã trả lời
$result = $conn->query("SELECT * FROM questions WHERE answer IS NOT NULL ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hỏi & Đáp | MUJI</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-white text-gray-900">
  <?php include 'Template/Header.php'; ?>

  <div class="max-w-3xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold mb-6">Hỏi & Đáp</h1>

    <!-- Form hỏi -->
    <form method="POST" class="bg-gray-100 p-6 rounded-lg mb-10">
      <h2 class="text-xl font-semibold mb-4">Gửi câu hỏi của bạn</h2>
      <input name="name" required placeholder="Tên của bạn" class="w-full p-2 mb-3 border rounded" />
      <input name="email" type="email" required placeholder="Email" class="w-full p-2 mb-3 border rounded" />
      <textarea name="question" required placeholder="Nội dung câu hỏi" class="w-full p-2 border rounded mb-3"></textarea>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Gửi câu hỏi</button>
    </form>

    <!-- Câu hỏi đã trả lời -->
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="bg-white border rounded p-4 mb-4 shadow">
        <p class="font-semibold">❓ <?= htmlspecialchars($row['question']) ?></p>
        <p class="text-green-700 mt-2">✅ <?= htmlspecialchars($row['answer']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>

  <?php include 'Template/Footer.php'; ?>
</body>
</html>
