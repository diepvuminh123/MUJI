<?php
/**
 * Phần Quản lý Tin nhắn Liên hệ
 * 
 * Phần này xử lý việc hiển thị, trả lời và quản lý tin nhắn liên hệ
 * từ khách truy cập trang web.
 */
require_once __DIR__ . '/../../config/config.php';

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

// Bắt đầu thu thập nội dung
ob_start();
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

<!-- JavaScript riêng cho phần tin nhắn liên hệ -->
<script>
  function toggleReply(id) {
    const form = document.getElementById('reply-form-' + id);
    form.classList.toggle('d-none');
  }

  // Thiết lập chức năng hộp kiểm "chọn tất cả"
  document.getElementById('check-all')?.addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/admin_layout.php';
?>