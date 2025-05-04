<?php 
// Set page title
$page_title = 'Đơn hàng của tôi';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <h1 class="mb-4">Đơn hàng của tôi</h1>
    
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (empty($data['orders'])): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                </div>
                <h3 class="mb-3">Bạn chưa có đơn hàng nào</h3>
                <p class="mb-4">Hãy tiếp tục mua sắm để đặt đơn hàng đầu tiên của bạn!</p>
                <a href="index.php?action=products" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i> Mua sắm ngay
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <td>
                                        <a href="index.php?action=order_detail&id=<?php echo $order['id']; ?>" class="text-decoration-none">
                                            <?php echo $order['order_code']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo number_format($order['total_amount']); ?>₫</td>
                                    <td>
                                        <?php
                                        switch ($order['order_status']) {
                                            case 'pending':
                                                echo '<span class="badge bg-warning text-dark">Chờ xử lý</span>';
                                                break;
                                            case 'processing':
                                                echo '<span class="badge bg-info">Đang xử lý</span>';
                                                break;
                                            case 'shipping':
                                                echo '<span class="badge bg-primary">Đang giao hàng</span>';
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
                                        <?php
                                        switch ($order['payment_status']) {
                                            case 'pending':
                                                echo '<span class="badge bg-warning text-dark">Chưa thanh toán</span>';
                                                break;
                                            case 'paid':
                                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                                                break;
                                            case 'refunded':
                                                echo '<span class="badge bg-info">Đã hoàn tiền</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-secondary">' . htmlspecialchars($order['payment_status']) . '</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="index.php?action=order_detail&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php if ($data['totalPages'] > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <?php if ($data['currentPage'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?action=my_orders&page=<?php echo $data['currentPage'] - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&laquo;</span>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                                <li class="page-item <?php echo ($i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?action=my_orders&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($data['currentPage'] < $data['totalPages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?action=my_orders&page=<?php echo $data['currentPage'] + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>