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

    if (!empty($_FILES['logo']['name'])) {
        $targetDir = __DIR__ . '/../../assets/uploads/';
        $targetFile = $targetDir . basename($_FILES['logo']['name']);
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            $relativePath = 'assets/uploads/' . basename($_FILES['logo']['name']);
            updateSiteValue($conn, 'logo', $relativePath);
        }
    }

    echo "<div class='alert alert-success text-center' id='success-alert'>Cập nhật thành công!</div>";
}

$GLOBALS['site_info'] = [
    'hotline' => getSiteValue($conn, 'hotline'),
    'address' => getSiteValue($conn, 'address'),
    'logo' => getSiteValue($conn, 'logo')
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
                <?php if (!empty($GLOBALS['site_info']['logo'])): ?>
                  <img src="<?= $GLOBALS['site_info']['logo'] ?>" alt="Logo" style="max-height: 100px;">
                <?php endif; ?>
                <p class="mt-2"><strong>Hotline:</strong> <?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($GLOBALS['site_info']['address']) ?></p>
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
                    <label class="form-label">Logo công ty:</label>
                    <input type="file" name="logo" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
              </div>
            </div>
          </div>
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