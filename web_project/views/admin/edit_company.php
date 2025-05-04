<?php
/**
 * Hệ thống quản lý thông tin trang web - Upload + Xoá ảnh Slider
 */
require_once __DIR__ . '/../../config/config.php';
$conn = $GLOBALS['conn'];

/**
 * Lấy giá trị từ bảng site_info
 */
function getSiteValue($conn, $key) {
    $stmt = $conn->prepare("SELECT value FROM site_info WHERE `key` = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['value'] ?? '';
}

/**
 * Cập nhật giá trị trong bảng site_info
 */
function updateSiteValue($conn, $key, $value) {
    $stmt = $conn->prepare("UPDATE site_info SET value = ? WHERE `key` = ?");
    $stmt->bind_param("ss", $value, $key);
    return $stmt->execute();
}

// Load thông tin trang web
$GLOBALS['site_info'] = [
    'hotline' => getSiteValue($conn, 'hotline'),
    'address' => getSiteValue($conn, 'address'),
    'logo' => getSiteValue($conn, 'logo'),
    'Company_name' => getSiteValue($conn, 'Company_name'),
    'Slogan' => getSiteValue($conn, 'Slogan')
];

// Xử lý xoá ảnh slider
if (isset($_GET['delete_slider'])) {
  $id = (int) $_GET['delete_slider'];
  
  // Lấy đường dẫn ảnh
  $stmt = $conn->prepare("SELECT image_path FROM sliders WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($row) {
      $filePath = __DIR__ . '/../../' . $row['image_path'];
      
      // Xoá file nếu tồn tại
      if (file_exists($filePath)) {
          unlink($filePath);
      }

      // Xoá bản ghi trong CSDL
      $stmt = $conn->prepare("DELETE FROM sliders WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();

      // Redirect để không xoá lại nếu F5
      header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
      exit;
  }
}


// Xử lý form cập nhật thông tin công ty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'updateSiteInfo') {
    updateSiteValue($conn, 'hotline', $_POST['hotline']);
    updateSiteValue($conn, 'address', $_POST['address']);
    updateSiteValue($conn, 'Company_name', $_POST['Company_name']);
    updateSiteValue($conn, 'Slogan', $_POST['Slogan']);

    echo "<div class='alert alert-success text-center fs-5'>Cập nhật thông tin thành công ✅</div>";
}

// Xử lý upload slider riêng biệt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['slider_image'])) {
    if ($_FILES['slider_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES["slider_image"]["name"]);
        $safeName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
        $targetPath = $uploadDir . $safeName;
        $relativePath = 'uploads/' . $safeName;

        if (move_uploaded_file($_FILES["slider_image"]["tmp_name"], $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO sliders (image_path) VALUES (?)");
            $stmt->bind_param("s", $relativePath);
            $stmt->execute();
            echo "<div class='alert alert-success text-center fs-5'>Tải ảnh slider thành công 📸</div>";
        } else {
            echo "<div class='alert alert-danger text-center fs-5'>Tải ảnh thất bại ❌</div>";
        }
    }
}

ob_start();
?>

<div class="col-12 col-lg-8 mx-auto">
  <!-- Thông tin hiện tại -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header">
      <h3>Thông tin hiện tại</h3>
    </div>
    <div class="card-body text-center">
      <p class="mt-2 fs-3"><strong>Tên công ty (Logo):</strong> <?= htmlspecialchars($GLOBALS['site_info']['Company_name']) ?></p>
      <p class="fs-3"><strong>Hotline:</strong> <?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?></p>
      <p class="fs-3"><strong>Địa chỉ:</strong> <?= htmlspecialchars($GLOBALS['site_info']['address']) ?></p>
      <p class="fs-3"><strong>Slogan:</strong> <?= htmlspecialchars($GLOBALS['site_info']['Slogan']) ?></p>
    </div>
  </div>

  <!-- Form cập nhật thông tin công ty -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header">
      <h3>Chỉnh sửa thông tin công ty</h3>
    </div>
    <div class="card-body">
      <form method="post" action="?action=updateSiteInfo">
        <div class="mb-3 fs-4">
          <label class="form-label">Hotline:</label>
          <input type="text" name="hotline" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?>" required>
        </div>
        <div class="mb-3 fs-4">
          <label class="form-label">Địa chỉ:</label>
          <input type="text" name="address" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['address']) ?>" required>
        </div>
        <div class="mb-3 fs-4">
          <label class="form-label">Tên công ty (Logo):</label>
          <input type="text" name="Company_name" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['Company_name']) ?>" required>
        </div>
        <div class="mb-3 fs-4">
          <label class="form-label">Slogan:</label>
          <input type="text" name="Slogan" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['Slogan']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary btn-lg">Cập nhật</button>
      </form>
    </div>
  </div>

  <!-- Form upload ảnh slider -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header">
      <h3>Upload ảnh slider</h3>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3 fs-4">
          <label class="form-label">Chọn ảnh:</label>
          <input type="file" name="slider_image" class="form-control fs-4" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success btn-lg">Tải lên ảnh slider</button>
      </form>
    </div>
  </div>

  <!-- Hiển thị ảnh slider -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header">
      <h3>Ảnh slider mới nhất</h3>
    </div>
    <div class="card-body text-center">
      <?php
      $result = $conn->query("SELECT * FROM sliders ORDER BY id DESC LIMIT 5");
      while ($row = $result->fetch_assoc()) {
          echo '<div style="display: inline-block; margin: 10px; position: relative;">';
          echo '<img src="../' . htmlspecialchars($row['image_path']) . '" style="max-width: 300px; display: block;">';
          echo '<a href="?delete_slider=' . $row['id'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn xoá ảnh này không?\')" 
                style="position: absolute; top: 5px; right: 5px; background-color: red; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none;">X</a>';
          echo '</div>';
      }
      ?>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/admin_layout.php';
?>
