<?php
/**
 * Hệ thống quản lý thông tin trang web
 * 
 * File này xử lý chức năng quản lý thông tin công ty cho trang quản trị
 * bao gồm việc lấy, hiển thị và cập nhật thông tin công ty như tên, slogan,
 * đường dây nóng và địa chỉ.
 * 
 * @version 1.0
 */
require_once __DIR__ . '/../../config/config.php';

/**
 * Lấy giá trị thông tin trang web cụ thể từ cơ sở dữ liệu
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $key Khóa để lấy giá trị
 * @return string Giá trị liên kết với khóa hoặc chuỗi rỗng nếu không tìm thấy
 */
function getSiteValue($conn, $key) {
    $stmt = $conn->prepare("SELECT value FROM site_info WHERE `key` = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['value'] ?? '';
    // MỞ RỘNG: Thêm xử lý lỗi cho vấn đề kết nối cơ sở dữ liệu
}

/**
 * Cập nhật giá trị thông tin trang web cụ thể trong cơ sở dữ liệu
 * 
 * @param mysqli $conn Kết nối cơ sở dữ liệu
 * @param string $key Khóa cần cập nhật
 * @param string $value Giá trị mới để lưu trữ
 * @return bool True nếu cập nhật thành công, false nếu ngược lại
 */
function updateSiteValue($conn, $key, $value) {
    $stmt = $conn->prepare("UPDATE site_info SET value = ? WHERE `key` = ?");
    $stmt->bind_param("ss", $value, $key);
    $result = $stmt->execute();
    // MỞ RỘNG: Thêm xác thực cho giá trị đầu vào trước khi cập nhật
    // MỞ RỘNG: Trả về kết quả của thao tác để xử lý lỗi
    return $result;
}

// Tải tất cả thông tin trang web vào một mảng toàn cục để dễ dàng truy cập trong toàn bộ ứng dụng
$GLOBALS['site_info'] = [
    'hotline' => getSiteValue($conn, 'hotline'),
    'address' => getSiteValue($conn, 'address'),
    'logo' => getSiteValue($conn, 'logo'),
    'Company_name' => getSiteValue($conn, 'Company_name'),
    'Slogan' => getSiteValue($conn, 'Slogan')
    // MỞ RỘNG: Thêm các trường thông tin trang web mới tại đây
];

// Xử lý gửi biểu mẫu để cập nhật thông tin trang web
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'updateSiteInfo') {
    // Cập nhật từng trường thông tin trang web
    updateSiteValue($conn, 'hotline', $_POST['hotline']);
    updateSiteValue($conn, 'address', $_POST['address']);
    updateSiteValue($conn, 'Company_name', $_POST['Company_name']);
    updateSiteValue($conn, 'Slogan', $_POST['Slogan']);  // Đã sửa lỗi khoảng trắng trong tên khóa
    
    // MỞ RỘNG: Thêm các trường bổ sung tại đây khi cần thiết
    // MỞ RỘNG: Thêm xác thực cho các trường đầu vào
    // MỞ RỘNG: Thêm xử lý lỗi cho các cập nhật không thành công
    
    // Hiển thị thông báo thành công
    echo "<div class='alert alert-success text-center fs-5' id='success-alert'>Cập nhật thành công 🥳🥳🥳</div>";
}

// Tạo nội dung
ob_start();
?>

<!-- Phần Cập nhật Thông tin Trang web -->
<div class="col-12 col-lg-8 mx-auto ">
  <!-- Thẻ Thông tin Hiện tại -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header">
      <h3>Thông tin hiện tại</h3>
    </div>
    <div class="card-body text-center ">
      <p class="mt-2 fs-3"><strong>Tên công ty (Logo):</strong> <?= htmlspecialchars($GLOBALS['site_info']['Company_name']) ?></p>
      <p class="mt-2 fs-3"><strong>Hotline: </strong> <?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?></p>
      <p class="fs-3"><strong>Địa chỉ:</strong> <?= htmlspecialchars($GLOBALS['site_info']['address']) ?></p>
      <p class="fs-3"><strong>Slogan:</strong> <?= htmlspecialchars($GLOBALS['site_info']['Slogan']) ?></p>
      <!-- MỞ RỘNG: Thêm các trường thông tin khác tại đây -->
    </div>
  </div>
  
  <!-- Biểu mẫu Chỉnh sửa Thông tin Trang web -->
  <div class="card mt-4 hover-shadow">
    <div class="card-header ">
      <h3>Chỉnh sửa thông tin công ty</h3>
    </div>
    <div class="card-body">
      <form method="post" action="?action=updateSiteInfo" enctype="multipart/form-data">
        <!-- Trường Hotline -->
        <div class="mb-3 fs-4">
          <label class="form-label">Hotline:</label>
          <input type="text" name="hotline" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['hotline']) ?>" required>
        </div>
        <!-- Trường Địa chỉ -->
        <div class="mb-3 fs-4">
          <label class="form-label">Địa chỉ:</label>
          <input type="text" name="address" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['address']) ?>" required>
        </div>
        <!-- Trường Tên công ty -->
        <div class="mb-3 fs-4">
          <label class="form-label">Tên công ty (Logo):</label>
          <input type="text" name="Company_name" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['Company_name']) ?>" required>
        </div>
        <!-- Trường Slogan -->
        <div class="mb-3 fs-4">
          <label class="form-label">Slogan:</label>
          <input type="text" name="Slogan" class="form-control fs-4" value="<?= htmlspecialchars($GLOBALS['site_info']['Slogan']) ?>" required>
        </div>
        <!-- MỞ RỘNG: Thêm các trường biểu mẫu khác tại đây -->
        <button type="submit" class="btn btn-primary btn-lg ">Cập nhật</button>
      </form>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/admin_layout.php';
?>