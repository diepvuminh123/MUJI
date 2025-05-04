<?php
require_once(__DIR__ . '/../../config/config.php');
$conn = $GLOBALS['conn'];

// Thêm bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO articles (title, author, date, category, image, content) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $_POST['title'], $_POST['author'], $_POST['date'], $_POST['category'], $_POST['image'], $_POST['content']);
    $stmt->execute();
    header("Location: admin.php?action=manageArticles");
    exit;
}

// Xoá bài viết
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php?action=manageArticles");
    exit;
}

// Lấy danh sách bài viết
$result = $conn->query("SELECT * FROM articles ORDER BY id DESC");

ob_start(); // bắt đầu nội dung trang
?>

<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3>📝 Thêm bài viết mới</h3>
    </div>
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="add" value="1">
        <div class="form-group mb-3">
          <input type="text" name="title" class="form-control" placeholder="Tiêu đề" required>
        </div>
        <div class="form-group mb-3">
          <input type="text" name="author" class="form-control" placeholder="Tác giả">
        </div>
        <div class="form-group mb-3">
          <input type="date" name="date" class="form-control">
        </div>
        <div class="form-group mb-3">
          <input type="text" name="category" class="form-control" placeholder="Chuyên mục">
        </div>
        <div class="form-group mb-3">
          <input type="text" name="image" class="form-control" placeholder="URL hình ảnh (https://...)">
        </div>
        <div class="form-group mb-3">
          <textarea name="content" class="form-control" rows="4" placeholder="Nội dung bài viết"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm bài viết</button>
      </form>
    </div>
  </div>

  <div class="card mt-4">
    <div class="card-header">
      <h3>📋 Danh sách bài viết</h3>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
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
                <a href="admin.php?action=manageArticles&delete=<?= $row['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Bạn có chắc muốn xoá bài viết này?')">Xoá</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/admin_layout.php';
