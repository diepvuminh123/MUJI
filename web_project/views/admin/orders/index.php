<?php 
// Set page title
$page_title = 'Quản lý đơn hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Quản lý đơn hàng</h4>
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
                            <input type="hidden" name="action" value="adminOrders">
                            
                            <div class="input-group me-2">
                                <input type="text" class="form-control" placeholder="Tìm theo mã đơn hàng, tên, email hoặc SĐT..." 
                                       name="search" value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form action="admin.php" method="GET" id="statusFilterForm">
                            <input type="hidden" name="action" value="adminOrders">
                            <?php if (!empty($data['search'])): ?>
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($data['search']); ?>">
                            <?php endif; ?>
                            
                            <select class="form-select" name="status" onchange="document.getElementById('statusFilterForm').submit();">
                                <option value="">-- Tất cả trạng thái --</option>
                                <option value="pending" <?php echo ($data['status'] == 'pending') ? 'selected' : ''; ?>>Chờ xử lý</option>
                                <option value="processing" <?php echo ($data['status'] == 'processing') ? 'selected' : ''; ?>>Đang xử lý</option>
                                <option value="shipping" <?php echo ($data['status'] == 'shipping') ? 'selected' : ''; ?>>Đang giao hàng</option>
                                <option value="completed" <?php echo ($data['status'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                                <option value="cancelled" <?php echo ($data['status'] == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <p class="mb-0">Tổng số: <strong><?php echo $data['totalOrders']; ?></strong> đơn hàng</p>
                    </div>
                </div>

                <!-- Orders table -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Thanh toán</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data['orders'])): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy đơn hàng nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['orders'] as $order): ?>
                                    <tr>
                                        <td>
                                            <a href="admin.php?action=viewOrder&id=<?php echo $order['id']; ?>" class="fw-bold text-decoration-none">
                                                <?php echo $order['order_code']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div><?php echo htmlspecialchars($order['customer_name']); ?></div>
                                            <div class="small text-muted"><?php echo htmlspecialchars($order['customer_email']); ?></div>
                                            <div class="small text-muted"><?php echo htmlspecialchars($order['customer_phone']); ?></div>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                        <td class="fw-bold text-end"><?php echo number_format($order['total_amount']); ?>₫</td>
                                        <td>
                                            <?php if ($order['payment_status'] == 'paid'): ?>
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            <?php elseif ($order['payment_status'] == 'refunded'): ?>
                                                <span class="badge bg-info">Đã hoàn tiền</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                            <?php endif; ?>
                                            
                                            <?php if ($order['payment_method'] == 'cod'): ?>
                                                <span class="badge bg-secondary">COD</span>
                                            <?php elseif ($order['payment_method'] == 'bank_transfer'): ?>
                                                <span class="badge bg-secondary">Chuyển khoản</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($order['order_status']) {
                                                case 'pending':
                                                    echo '<span class="badge bg-warning text-dark">Chờ xử lý</span>';
                                                    break;
                                                case 'processing':
                                                    echo '<span class="badge bg-primary">Đang xử lý</span>';
                                                    break;
                                                case 'shipping':
                                                    echo '<span class="badge bg-info">Đang giao hàng</span>';
                                                    break;
                                                case 'completed':
                                                    echo '<span class="badge bg-success">Hoàn thành</span>';
                                                    break;
                                                case 'cancelled':
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($order['order_status']) . '</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="admin.php?action=viewOrder&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <a href="admin.php?action=orderInvoice&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-file-invoice"></i> Hóa đơn
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
                                <a class="page-link" href="admin.php?action=adminOrders&page=<?php echo $data['currentPage'] - 1; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?><?php echo !empty($data['status']) ? '&status=' . urlencode($data['status']) : ''; ?>">
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
                                    <a class="page-link" href="admin.php?action=adminOrders&page=<?php echo $i; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?><?php echo !empty($data['status']) ? '&status=' . urlencode($data['status']) : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="admin.php?action=adminOrders&page=<?php echo $data['currentPage'] + 1; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?><?php echo !empty($data['status']) ? '&status=' . urlencode($data['status']) : ''; ?>">
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