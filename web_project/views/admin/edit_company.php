<?php
/**
 * Hệ thống quản lý thông tin trang web - Upload + Xoá ảnh Slider
 */
require_once __DIR__ . '/../../config/config.php';
$conn = $GLOBALS['conn'];

// Đảm bảo session đã được bắt đầu
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

// Hiển thị thông báo từ session nếu có
$successMessage = '';
$errorMessage = '';

if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Xử lý xoá ảnh slider
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_slider'])) {
    $id = (int) $_POST['delete_slider'];
    
    try {
        // Lấy đường dẫn ảnh
        $stmt = $conn->prepare("SELECT image_path FROM sliders WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn: " . $conn->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $filePath = __DIR__ . '/../../' . $row['image_path'];
            
            // Xoá file nếu tồn tại
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    throw new Exception("Không thể xoá file: Kiểm tra quyền truy cập");
                }
            }

            // Xoá bản ghi trong CSDL
            $stmt = $conn->prepare("DELETE FROM sliders WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị truy vấn xoá: " . $conn->error);
            }
            
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception("Không thể xoá bản ghi: " . $conn->error);
            }

            $_SESSION['success_message'] = "Đã xoá ảnh slider thành công";
        } else {
            throw new Exception("Không tìm thấy ảnh với ID: " . $id);
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Lỗi khi xoá ảnh: " . $e->getMessage();
    }
    
    // Chuyển hướng để tránh gửi lại form khi refresh
    header("Location: admin.php?action=updateSiteInfo");
    exit;
}

// Xử lý form cập nhật thông tin công ty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateSiteInfo') {
    updateSiteValue($conn, 'hotline', $_POST['hotline']);
    updateSiteValue($conn, 'address', $_POST['address']);
    updateSiteValue($conn, 'Company_name', $_POST['Company_name']);
    updateSiteValue($conn, 'Slogan', $_POST['Slogan']);

    $_SESSION['success_message'] = "Cập nhật thông tin thành công ✅";
    header("Location: admin.php?action=updateSiteInfo");
    exit;
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
            $_SESSION['success_message'] = "Tải ảnh slider thành công 📸";
        } else {
            $_SESSION['error_message'] = "Tải ảnh thất bại ❌";
        }
        
        header("Location: admin.php?action=updateSiteInfo");
        exit;
    }
}

ob_start();
?>

<!-- Thêm JavaScript để tự động ẩn thông báo sau 2 giây -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tìm tất cả các thông báo
    var alerts = document.querySelectorAll('.alert');
    
    // Tự động ẩn sau 2 giây
    if (alerts.length > 0) {
        setTimeout(function() {
            alerts.forEach(function(alert) {
                // Thêm hiệu ứng fade out
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                
                // Xóa khỏi DOM sau khi fade out hoàn tất
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 2000);
    }
});
</script>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success text-center fs-5"><?= htmlspecialchars($successMessage) ?></div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger text-center fs-5"><?= htmlspecialchars($errorMessage) ?></div>
<?php endif; ?>

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
      <form method="post">
        <input type="hidden" name="action" value="updateSiteInfo">
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

  <!-- Hiển thị ảnh slider dạng bảng -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header">
      <h3>Quản lý ảnh slider</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Hình ảnh</th>
              <th scope="col">Tên hình</th>
              <th scope="col">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $conn->query("SELECT * FROM sliders ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                // Lấy tên file từ đường dẫn
                $imageName = basename($row['image_path']);
                
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td><img src="../' . htmlspecialchars($row['image_path']) . '" style="max-width: 100px; max-height: 100px;"></td>';
                echo '<td>' . htmlspecialchars($imageName) . '</td>';
                echo '<td>
                      <form method="post" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa ảnh này không?\')">
                        <input type="hidden" name="delete_slider" value="' . $row['id'] . '">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                      </form>
                    </td>';
                echo '</tr>';
            }
            if ($result->num_rows === 0) {
                echo '<tr><td colspan="4" class="text-center">Không có ảnh slider nào</td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/admin_layout.php';
?>