<?php 
// Set page title
$page_title = 'Quản lý giỏ hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Quản lý giỏ hàng</h4>
            </div>
            <div class="card-body">
                <?php
                // Show success or error messages if they exist
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success text-center fs-5" id="success-alert">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }

                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger text-center fs-5" id="error-alert">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>
                
                <!-- Search and filter form -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <form action="admin.php" method="GET" class="d-flex">
                            <input type="hidden" name="action" value="adminCarts">
                            <?php if ($data['userId']): ?>
                                <input type="hidden" name="user_id" value="<?php echo $data['userId']; ?>">
                            <?php endif; ?>
                            
                            <div class="input-group me-2">
                                <input type="text" class="form-control" placeholder="Tìm theo tên, email người dùng hoặc ID phiên..." 
                                       name="search" value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 text-end">
                        <p class="mb-0">Tổng số: <strong><?php echo $data['totalCarts']; ?></strong> giỏ hàng</p>
                    </div>
                </div>

                <!-- Carts table -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Phiên</th>
                                <th class="text-center">Số sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th>Cập nhật lần cuối</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data['carts'])): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy giỏ hàng nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['carts'] as $cart): ?>
                                    <tr>
                                        <td><?php echo $cart['id']; ?></td>
                                        <td>
                                            <?php if ($cart['user_id']): ?>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-primary me-2">Thành viên</span>
                                                    <div>
                                                        <?php echo htmlspecialchars($cart['user_name'] ?? 'Không có tên'); ?>
                                                        <div class="small text-muted">ID: <?php echo $cart['user_id']; ?></div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Khách</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="small text-muted text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($cart['session_id']); ?>">
                                                <?php echo htmlspecialchars($cart['session_id']); ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($cart['item_count'] > 0): ?>
                                                <span class="badge bg-info"><?php echo $cart['item_count']; ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">0</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($cart['total_quantity'] > 0): ?>
                                                <span class="badge bg-success"><?php echo $cart['total_quantity']; ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">0</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $updatedAt = new DateTime($cart['updated_at']);
                                                $now = new DateTime();
                                                $interval = $now->diff($updatedAt);
                                                
                                                if ($interval->days > 0) {
                                                    echo $interval->days . ' ngày trước';
                                                } elseif ($interval->h > 0) {
                                                    echo $interval->h . ' giờ trước';
                                                } elseif ($interval->i > 0) {
                                                    echo $interval->i . ' phút trước';
                                                } else {
                                                    echo 'Vừa xong';
                                                }
                                            ?>
                                            <div class="small text-muted">
                                                <?php echo date('d/m/Y H:i', strtotime($cart['updated_at'])); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="admin.php?action=viewCart&id=<?php echo $cart['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <?php if ($cart['item_count'] > 0): ?>
                                                    <a href="admin.php?action=clearCart&id=<?php echo $cart['id']; ?>" 
                                                       class="btn btn-sm btn-warning"
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng này?');">
                                                        <i class="fas fa-broom"></i> Xóa hết SP
                                                    </a>
                                                <?php endif; ?>
                                                <a href="admin.php?action=deleteCart&id=<?php echo $cart['id']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa giỏ hàng này?');">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($data['totalPages'] > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="admin.php?action=adminCarts&page=<?php echo $data['currentPage'] - 1; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?><?php echo !empty($data['userId']) ? '&user_id=' . urlencode($data['userId']) : ''; ?>">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            
                            <?php 
                            $startPage = max(1, $data['currentPage'] - 2);
                            $endPage = min($startPage + 4, $data['totalPages']);
                            
                            if ($endPage - $startPage < 4) {
                                $startPage = max(1, $endPage - 4);
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item <?php echo ($i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="admin.php?action=adminCarts&page=<?php echo $i; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?><?php echo !empty($data['userId']) ? '&user_id=' . urlencode($data['userId']) : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="admin.php?action=adminCarts&page=<?php echo $data['currentPage'] + 1; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?><?php echo !empty($data['userId']) ? '&user_id=' . urlencode($data['userId']) : ''; ?>">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto hide alerts after 5 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
</script>
<?php include __DIR__ . '/../Template/Footer.php'; ?>