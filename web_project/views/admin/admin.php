<?php
require_once __DIR__ . '/../../config/config.php';

function getSiteValue($conn, $key) {
    $stmt = $conn->prepare("SELECT value FROM site_info WHERE `key` = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['value'] ?? '';
}

function updateSiteValue($conn, $key, $value) {
    $stmt = $conn->prepare("UPDATE site_info SET value = ? WHERE `key` = ?");
    $stmt->bind_param("ss", $value, $key);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'updateSiteInfo') {
    updateSiteValue($conn, 'hotline', $_POST['hotline']);
    updateSiteValue($conn, 'address', $_POST['address']);
    updateSiteValue($conn, 'Company_name', $_POST['Company_name']);
    updateSiteValue($conn, 'Slogan ', $_POST['Slogan']);





    echo "<div class='alert alert-success text-center' id='success-alert'>Cập nhật thành công!</div>";
}

$GLOBALS['site_info'] = [
    'hotline' => getSiteValue($conn, 'hotline'),
    'address' => getSiteValue($conn, 'address'),
    'logo' => getSiteValue($conn, 'logo'),
    'Company_name' => getSiteValue($conn, 'Company_name'),
    'Slogan' => getSiteValue($conn, 'Slogan')

];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Mazer Admin Dashboard</title>
  <link rel="stylesheet" href="./assets/compiled/css/app.css">
  <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
  <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
  <style>
    #success-alert {
      transition: opacity 1s ease;
    }
  </style>
</head>
<body>
<script src="assets/static/js/initTheme.js"></script>
<div id="app">
  <div id="sidebar">
    <div class="sidebar-wrapper active">
      <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
          <div class="logo">
            <a href="admin.php"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
          </div>
        </div>
      </div>
      <div class="sidebar-menu">
        <ul class="menu">
          <li class="sidebar-title">Menu</li>
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'dashboard' || !isset($_GET['action']) ? 'active' : '' ?>">
            <a href="admin.php?action=dashboard" class="sidebar-link">
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'updateSiteInfo' ? 'active' : '' ?>">
            <a href="admin.php?action=updateSiteInfo" class="sidebar-link">
              <i class="bi bi-pencil-square"></i>
              <span>Chỉnh sửa công ty</span>
            </a>
          </li>
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'viewContacts' ? 'active' : '' ?>">
            <a href="admin.php?action=viewContacts" class="sidebar-link">
              <i class="bi bi-envelope-fill"></i>
              <span>Xem liên hệ</span>
            </a>
         </li>

        </ul>
      </div>
    </div>
  </div>
  <div id="main">
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <div class="page-content">
      <section class="row">
        <?php if (($_GET['action'] ?? '') === 'updateSiteInfo'): ?>
          <div class="col-12 col-lg-8">
            <div class="card mt-4">
              <div class="card-header">
                <h4>Thông tin hiện tại</h4>
              </div>
              <div class="card-body text-center">
                <p class="mt-2"><strong>Tên công ty (Logo):</strong> <?= htmlspecialchars($GLOBALS['site_info']['Company_name']) ?></p>
                <p class="mt-2"><strong>Hotline:</strong> <?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($GLOBALS['site_info']['address']) ?></p>
                <p><strong>Slogan:</strong> <?= htmlspecialchars($GLOBALS['site_info']['Slogan']) ?></p>
              </div>
            </div>
            <div class="card mt-4">
              <div class="card-header">
                <h4>Chỉnh sửa thông tin công ty</h4>
              </div>
              <div class="card-body">
                <form method="post" action="?action=updateSiteInfo" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label class="form-label">Hotline:</label>
                    <input type="text" name="hotline" class="form-control" value="<?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Địa chỉ:</label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($GLOBALS['site_info']['address']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Tên công ty (Logo):</label>
                    <input type="text" name="Company_name" class="form-control" value="<?= htmlspecialchars($GLOBALS['site_info']['Company_name']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Slogan:</label>
                    <input type="text" name="Slogan" class="form-control" value="<?= htmlspecialchars($GLOBALS['site_info']['Slogan']) ?>" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <?php if (($_GET['action'] ?? '') === 'viewContacts'): ?>
<?php
// Xử lý POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_read'])) {
        $id = (int)$_POST['toggle_read'];
        $res = $conn->query("SELECT is_read FROM contact_messages WHERE id = $id");
        if ($res && $res->num_rows > 0) {
            $curr = (int)$res->fetch_assoc()['is_read'];
            $conn->query("UPDATE contact_messages SET is_read = " . (1 - $curr) . " WHERE id = $id");
        }
    }

    if (isset($_POST['mark_selected_read']) && !empty($_POST['selected_ids'])) {
        $ids = array_map('intval', $_POST['selected_ids']);
        $idList = implode(',', $ids);
        $conn->query("UPDATE contact_messages SET is_read = 1 WHERE id IN ($idList)");
    }

    if (isset($_POST['delete_read'])) {
        $conn->query("DELETE FROM contact_messages WHERE is_read = 1");
    }

    if (isset($_POST['send_reply']) && !empty($_POST['reply_content'])) {
        $id = (int)$_POST['reply_id'];
        $reply = trim($_POST['reply_content']);
        $stmt = $conn->prepare("UPDATE contact_messages SET admin_reply = ?, is_read = 1 WHERE id = ?");
        $stmt->bind_param("si", $reply, $id);
        $stmt->execute();
    }
}

// Phân trang
$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM contact_messages");
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
?>

<div class="col-12 col-lg-12">
  <div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4>Danh sách tin nhắn liên hệ</h4>
      <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa tất cả tin nhắn đã đọc?');">
        <button name="delete_read" type="submit" class="btn btn-danger btn-sm">🗑 Xóa mục đã đọc</button>
      </form>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
              <tr>
                <th><input type="checkbox" id="check-all"></th>
                <th>#</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
                <th>Trả lời</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php $i = $offset + 1; while($row = $result->fetch_assoc()): ?>
                  <tr class="<?= $row['is_read'] ? 'table-secondary' : '' ?>">
                    <td><input type="checkbox" name="selected_ids[]" value="<?= $row['id'] ?>"></td>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                      <?php if (!empty($row['admin_reply'])): ?>
                        <div class="text-success"><?= nl2br(htmlspecialchars($row['admin_reply'])) ?></div>
                      <?php else: ?>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleReply(<?= $row['id'] ?>)">
                          💬 Trả lời
                        </button>
                        <form method="post" class="mt-2 d-none" id="reply-form-<?= $row['id'] ?>">
                          <input type="hidden" name="reply_id" value="<?= $row['id'] ?>">
                          <textarea name="reply_content" rows="2" class="form-control mb-2" placeholder="Nhập phản hồi..." required></textarea>
                          <button type="submit" name="send_reply" class="btn btn-sm btn-primary">📤 Gửi trả lời</button>
                        </form>
                      <?php endif; ?>
                    </td>
                    <td>
                      <form method="post">
                        <input type="hidden" name="toggle_read" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-sm <?= $row['is_read'] ? 'btn-secondary' : 'btn-outline-success' ?>">
                          <?= $row['is_read'] ? '↩ Khôi phục' : '✔ Đã đọc' ?>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan="9" class="text-center">Không có tin nhắn nào.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <button type="submit" name="mark_selected_read" class="btn btn-success mt-3">✔ Đánh dấu đã đọc các mục đã chọn</button>
      </form>

      <?php if ($total_pages > 1): ?>
        <nav class="mt-4">
          <ul class="pagination justify-content-center">
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
              <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                <a class="page-link" href="admin.php?action=viewContacts&page=<?= $p ?>"><?= $p ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  function toggleReply(id) {
    const form = document.getElementById('reply-form-' + id);
    form.classList.toggle('d-none');
  }

  document.getElementById('check-all')?.addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>
<?php endif; ?>


        



      </section>
    </div>

    <footer>
      <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
          <p>2023 &copy; Mazer</p>
        </div>
        <div class="float-end">
          <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> by <a href="https://saugi.me">Saugi</a></p>
        </div>
      </div>
    </footer>
  </div>
</div>
<script>
  setTimeout(() => {
    const alert = document.getElementById('success-alert');
    if (alert) alert.style.opacity = '0';
  }, 5000);
</script>
<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/compiled/js/app.js"></script>
<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/static/js/pages/dashboard.js"></script>
</body>
</html>