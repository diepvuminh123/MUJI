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
    echo "<div class='alert alert-success text-center'>Cập nhật thành công!</div>";
}

$GLOBALS['site_info'] = [
    'hotline' => getSiteValue($conn, 'hotline'),
    'address' => getSiteValue($conn, 'address')
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
                <h4>Chỉnh sửa thông tin công ty</h4>
              </div>
              <div class="card-body">
                <form method="post" action="?action=updateSiteInfo">
                  <div class="mb-3">
                    <label class="form-label">Hotline:</label>
                    <input type="text" name="hotline" class="form-control" value="<?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Địa chỉ:</label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($GLOBALS['site_info']['address']) ?>" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
              </div>
            </div>
          </div>
        <?php else: ?>
            
<div class="col-12 col-lg-9">
  <div class="row">
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="stats-icon purple mb-2">
            <i class="iconly-boldShow"></i>
          </div>
          <h6 class="text-muted font-semibold">Profile Views</h6>
          <h6 class="font-extrabold mb-0">112.000</h6>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="stats-icon blue mb-2">
            <i class="iconly-boldProfile"></i>
          </div>
          <h6 class="text-muted font-semibold">Followers</h6>
          <h6 class="font-extrabold mb-0">183.000</h6>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="stats-icon green mb-2">
            <i class="iconly-boldAdd-User"></i>
          </div>
          <h6 class="text-muted font-semibold">Following</h6>
          <h6 class="font-extrabold mb-0">80.000</h6>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="stats-icon red mb-2">
            <i class="iconly-boldBookmark"></i>
          </div>
          <h6 class="text-muted font-semibold">Saved Post</h6>
          <h6 class="font-extrabold mb-0">112</h6>
        </div>
      </div>
    </div>
  </div>
</div>
    </div>
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
<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/compiled/js/app.js"></script>
<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/static/js/pages/dashboard.js"></script>
</body>
</html>
