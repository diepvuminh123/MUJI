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

// Tải tất cả thông tin trang web vào một mảng toàn cục để dễ dàng truy cập trong toàn bộ ứng dụng
$GLOBALS['site_info'] = [
    'hotline' => getSiteValue($conn, 'hotline'),
    'address' => getSiteValue($conn, 'address'),
    'logo' => getSiteValue($conn, 'logo'),
    'Company_name' => getSiteValue($conn, 'Company_name'),
    'Slogan' => getSiteValue($conn, 'Slogan')
    // MỞ RỘNG: Thêm các trường thông tin trang web mới tại đây
];


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Mazer Admin Dashboard</title>
  <!-- CSS Stylesheets -->
  <link rel="stylesheet" href="/MUJI/web_project/views/admin/assets/compiled/css/app.css">
  <link rel="stylesheet" href="/MUJI/web_project/views/admin/assets/compiled/css/app-dark.css">
  <!--font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/MUJI/web_project/views/admin/assets/compiled/css/admin.css">
  <style>
    /* Hiệu ứng cho cảnh báo thành công */
    #success-alert {
      transition: opacity 1s ease;
    }
  </style>
</head>
<body>
<!-- Script khởi tạo chủ đề -->
<script src="assets/static/js/initTheme.js"></script>
<div id="app">
  <!-- Thanh điều hướng bên -->
  <div id="sidebar">
    <div class="sidebar-wrapper active">
      <!-- Phần Logo/Tiêu đề -->
      <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
          <div class="logo">
            <a href="admin.php"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
          </div>
        </div>
      </div>
      <!-- Menu điều hướng -->
      <div class="sidebar-menu">
        <ul class="menu">
          <li class="sidebar-title">Menu</li>
          <!-- Mục Menu Dashboard -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'dashboard' || !isset($_GET['action']) ? 'active' : '' ?>">
            <a href="admin.php?action=dashboard" class="sidebar-link">
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <!-- Mục Menu Thông tin Trang web -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'updateSiteInfo' ? 'active' : '' ?>">
            <a href="admin.php?action=updateSiteInfo" class="sidebar-link">
              <i class="bi bi-pencil-square"></i>
              <span>Chỉnh sửa công ty</span>
            </a>
          </li>
          <!-- Mục Menu Tin nhắn Liên hệ -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'viewContacts' ? 'active' : '' ?>">
            <a href="admin.php?action=viewContacts" class="sidebar-link">
              <i class="bi bi-envelope-fill"></i>
              <span>Xem liên hệ</span>
            </a>
         </li>
         <!-- Mục Menu Quản lý Sản phẩm -->
          <li class="sidebar-item <?= ($_GET['action'] ?? '') === 'adminProducts' || ($_GET['action'] ?? '') === 'createProduct' || ($_GET['action'] ?? '') === 'editProduct' ? 'active' : '' ?>">
            <a href="index.php?action=adminProducts" class="sidebar-link">
              <i class="bi bi-box-seam"></i>
              <span>Quản lý sản phẩm</span>
            </a>
          </li>
         <!-- MỞ RỘNG: Thêm các mục menu mới tại đây -->
        </ul>
      </div>
    </div>
  </div>
  
  <!-- Khu vực Nội dung Chính -->
  <div id="main">
    <!-- Tiêu đề di động với menu hamburger -->
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <!-- Nội dung Trang -->
    <div class="page-content">
      <section class="row">
        <?php if (($_GET['action'] ?? '') === 'updateSiteInfo'): ?>
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
        <?php endif; ?>
        
        <?php if (($_GET['action'] ?? '') === 'viewContacts'): ?>
<?php
/**
 * Phần Quản lý Tin nhắn Liên hệ
 * 
 * Phần này xử lý việc hiển thị, trả lời và quản lý tin nhắn liên hệ
 * từ khách truy cập trang web.
 */

// Xử lý các hành động POST cho quản lý tin nhắn liên hệ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Chuyển đổi trạng thái đã đọc/chưa đọc cho một tin nhắn
    if (isset($_POST['toggle_read'])) {
        $id = (int)$_POST['toggle_read'];
        $res = $conn->query("SELECT is_read FROM contact_messages WHERE id = $id");
        if ($res && $res->num_rows > 0) {
            $curr = (int)$res->fetch_assoc()['is_read'];
            $conn->query("UPDATE contact_messages SET is_read = " . (1 - $curr) . " WHERE id = $id");
            // MỞ RỘNG: Thêm thông báo thành công/thất bại
           
            $page = $_GET['page'] ?? 1;
            header("Location: admin.php?action=viewContacts&page=$page");
        }
    }

    // Đánh dấu nhiều tin nhắn đã chọn là đã đọc
    if (isset($_POST['mark_selected_read']) && !empty($_POST['selected_ids'])) {
        $ids = array_map('intval', $_POST['selected_ids']); // Làm sạch ID
        $idList = implode(',', $ids);
        $conn->query("UPDATE contact_messages SET is_read = 1 WHERE id IN ($idList)");
        // MỞ RỘNG: Thêm thông báo thành công/thất bại
    }
    
    // Đánh dấu nhiều tin nhắn đã chọn là chưa đọc - CHỨC NĂNG MỚI
    if (isset($_POST['mark_selected_unread']) && !empty($_POST['selected_ids'])) {
        $ids = array_map('intval', $_POST['selected_ids']); // Làm sạch ID
        $idList = implode(',', $ids);
        $conn->query("UPDATE contact_messages SET is_read = 0 WHERE id IN ($idList)");
        // MỞ RỘNG: Thêm thông báo thành công/thất bại
    }

    // Xóa tất cả tin nhắn đã đọc
    if (isset($_POST['delete_read'])) {
        $conn->query("DELETE FROM contact_messages WHERE is_read = 1");
        // MỞ RỘNG: Thêm thông báo thành công/thất bại
        // MỞ RỘNG: Thêm hộp thoại xác nhận trước khi xóa
    }
    
    // Xóa các tin nhắn đã chọn - CHỨC NĂNG MỚI
    if (isset($_POST['delete_selected']) && !empty($_POST['selected_ids'])) {
        $ids = array_map('intval', $_POST['selected_ids']); // Làm sạch ID
        $idList = implode(',', $ids);
        $conn->query("DELETE FROM contact_messages WHERE id IN ($idList)");
        // MỞ RỘNG: Thêm thông báo thành công/thất bại
    }

    // Trả lời tin nhắn
    if (isset($_POST['send_reply']) && !empty($_POST['reply_content'])) {
        $id = (int)$_POST['reply_id'];
        $reply = trim($_POST['reply_content']);
        $stmt = $conn->prepare("UPDATE contact_messages SET admin_reply = ?, is_read = 1 WHERE id = ?");
        $stmt->bind_param("si", $reply, $id);
        $stmt->execute();
        // MỞ RỘNG: Thêm thông báo email cho người dùng
        // MỞ RỘNG: Thêm thông báo thành công/thất bại
    }
}

/**
 * Phân trang cho tin nhắn liên hệ
 */
// Thiết lập tham số phân trang
$limit = 20; // Số tin nhắn mỗi trang
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Lấy tổng số tin nhắn cho phân trang
$total_result = $conn->query("SELECT COUNT(*) as total FROM contact_messages");
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Lấy tin nhắn cho trang hiện tại
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
// MỞ RỘNG: Thêm tùy chọn lọc (theo ngày, đã đọc/chưa đọc, v.v.)
?>

<!-- Phần Danh sách Tin nhắn Liên hệ -->
<div class="col-12 col-lg-12">
  <div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3>Danh sách tin nhắn liên hệ</h3>
      
    </div>
    <div class="card-body">
      <form method="post" id="messages-form">
        <!-- Bảng Tin nhắn -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table ">
              <tr>
                <th></th>
                <th class="fs-5">Số thứ tự</th>
                <th class="fs-5" >Họ tên</th>
                <th class="fs-5">Email</th>
                <th class="fs-5">Tiêu đề</th>
                <th class="fs-5">Nội dung</th>
                <th class="fs-5">Thời gian</th>
                <th class="fs-5">Trả lời</th>
                <th class="fs-5">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php $i = $offset + 1; while($row = $result->fetch_assoc()): ?>
                  <!-- Hàng tin nhắn (nền xám cho tin nhắn đã đọc) -->
                  <tr class="<?= $row['is_read'] ? 'table-light' : '' ?>">
                    <td><input type="checkbox" name="selected_ids[]" value="<?= $row['id'] ?>"></td>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                      <?php if (!empty($row['admin_reply'])): ?>
                        <!-- Hiển thị trả lời đã tồn tại -->
                        <div class="text-success"><?= nl2br(htmlspecialchars($row['admin_reply'])) ?></div>
                        <!-- MỞ RỘNG: Thêm tùy chọn để chỉnh sửa trả lời đã tồn tại -->
                      <?php else: ?>
                        <!-- Nút chuyển đổi biểu mẫu trả lời -->
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleReply(<?= $row['id'] ?>)">
                          💬 Trả lời
                        </button>
                        <!-- Biểu mẫu trả lời ẩn - đã sửa để không tự mở ở dòng đầu tiên -->
                        <form method="post" class="mt-2 d-none" id="reply-form-<?= $row['id'] ?>">
                          <input type="hidden" name="reply_id" value="<?= $row['id'] ?>">
                          <textarea name="reply_content" rows="2" class="form-control mb-2" placeholder="Nhập phản hồi..." required></textarea>
                          <button type="submit" name="send_reply" class="btn btn-sm btn-primary">Gửi trả lời</button>
                        </form>
                      <?php endif; ?>
                    </td>
                    <td>
                      <!-- Biểu mẫu chuyển đổi trạng thái đã đọc/chưa đọc -->
                      <form method="post">
                        <input type="hidden" name="toggle_read" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-light <?= $row['is_read'] ? 'btn-outline-success' : 'btn btn-success' ?>">
                          <?= $row['is_read'] ? 'Đã đọc' : 'Chưa đọc' ?>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <!-- Thông báo không có tin nhắn -->
                <tr><td colspan="9" class="text-center">Không có tin nhắn nào.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Hành động cho các tin nhắn đã chọn - Đã sửa để thêm các nút mới và sắp xếp cùng hàng -->
        <div class="mt-3 d-flex gap-2">
        <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa tất cả tin nhắn đã đọc?');">
          <button name="delete_read" type="submit" class="btn btn-danger btn-lg"> Xóa mục đã đọc</button>
        </form>
        </div>
        <!-- MỞ RỘNG: Thêm nhiều hành động hàng loạt hơn tại đây (gửi email hàng loạt, v.v.) -->
      </form>

      <!-- Phân trang -->
      <?php if ($total_pages > 1): ?>
        <nav class="mt-4 fs-3">
          <ul class="pagination justify-content-center">
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
              <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                <a class="page-link fs-4" href="admin.php?action=viewContacts&page=<?= $p ?>"><?= $p ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- JavaScript cho phần tin nhắn liên hệ -->
<script>
  /**
   * Chuyển đổi hiển thị của biểu mẫu trả lời cho một tin nhắn cụ thể
   * 
   * @param {number} id ID của tin nhắn để chuyển đổi biểu mẫu trả lời
   */
  function toggleReply(id) {
    const form = document.getElementById('reply-form-' + id);
    form.classList.toggle('d-none');
  }

  // Thiết lập chức năng hộp kiểm "chọn tất cả"
  document.getElementById('check-all')?.addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
  
  // Đảm bảo không có form trả lời nào được mở khi tải trang
  
  
  // MỞ RỘNG: Thêm hộp thoại xác nhận cho các hành động
  // MỞ RỘNG: Thêm chức năng tìm kiếm/lọc
</script>
<?php endif; ?>




      </section>
    </div>

    <!-- Chân trang -->
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

<!-- JavaScript cho tự động ẩn cảnh báo thành công -->
<script>
  // Ẩn cảnh báo thành công sau 5 giây
  setTimeout(() => {
    const alert = document.getElementById('success-alert');
    if (alert) alert.style.opacity = '0';
  }, 5000);
</script>

<!-- Tệp JavaScript Cốt lõi -->
<script src="MUJI/web_project/views/admin/assets/static/js/components/dark.js"></script>
<script src="MUJI/web_project/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="MUJI/web_project/views/admin/assets/compiled/js/app.js"></script>

<!-- JavaScript Dành riêng cho Dashboard -->
<script src="MUJI/web_project/views/admin/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="MUJI/web_project/views/admin/assets/static/js/pages/dashboard.js"></script>
</body>
</html>