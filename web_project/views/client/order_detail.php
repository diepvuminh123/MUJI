<?php 
// Set page title
$page_title = 'Chi tiết đơn hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Chi tiết đơn hàng</h1>
        <a href="index.php?action=my_orders" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Quay lại đơn hàng của tôi
        </a>
    </div>
    
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
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin đơn hàng #<?php echo $data['order']['order_code']; ?></h5>
                <span class="badge bg-white text-primary">
                    <?php
                    switch ($data['order']['order_status']) {
                        case 'pending':
                            echo 'Chờ xử lý';
                            break;
                        case 'processing':
                            echo 'Đang xử lý';
                            break;
                        case 'shipping':
                            echo 'Đang giao hàng';
                            break;
                        case 'completed':
                            echo 'Hoàn thành';
                            break;
                        case 'cancelled':
                            echo 'Đã hủy';
                            break;
                        default:
                            echo htmlspecialchars($data['order']['order_status']);
                    }
                    ?>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Thông tin giao hàng</h6>
                    <p class="mb-1"><strong>Họ tên:</strong> <?php echo htmlspecialchars($data['order']['customer_name']); ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($data['order']['customer_email']); ?></p>
                    <p class="mb-1"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($data['order']['customer_phone']); ?></p>
                    <p class="mb-0"><strong>Địa chỉ:</strong> <?php echo nl2br(htmlspecialchars($data['order']['customer_address'])); ?></p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Thông tin đơn hàng</h6>
                    <p class="mb-1"><strong>Mã đơn hàng:</strong> <?php echo $data['order']['order_code']; ?></p>
                    <p class="mb-1"><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i', strtotime($data['order']['created_at'])); ?></p>
                    <p class="mb-1">
                        <strong>Phương thức thanh toán:</strong> 
                        <?php 
                        if ($data['order']['payment_method'] == 'cod') {
                            echo 'Thanh toán khi nhận hàng (COD)';
                        } elseif ($data['order']['payment_method'] == 'bank_transfer') {
                            echo 'Chuyển khoản ngân hàng';
                        } else {
                            echo htmlspecialchars($data['order']['payment_method']);
                        }
                        ?>
                    </p>
                    <p class="mb-1">
                        <strong>Trạng thái thanh toán:</strong> 
                        <?php 
                        if ($data['order']['payment_status'] == 'paid') {
                            echo '<span class="badge bg-success">Đã thanh toán</span>';
                        } elseif ($data['order']['payment_status'] == 'refunded') {
                            echo '<span class="badge bg-info">Đã hoàn tiền</span>';
                        } else {
                            echo '<span class="badge bg-warning text-dark">Chưa thanh toán</span>';
                        }
                        ?>
                    </p>
                    
                    <?php if (!empty($data['order']['order_notes'])): ?>
                        <p class="mb-0"><strong>Ghi chú:</strong> <?php echo nl2br(htmlspecialchars($data['order']['order_notes'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <h6 class="fw-bold mb-3">Chi tiết sản phẩm</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['orderItems'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($item['image_path'])): ?>
                                            <img src="<?php echo $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div>
                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end"><?php echo number_format($item['price']); ?>₫</td>
                                <td class="text-end"><?php echo number_format($item['subtotal']); ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Tạm tính:</th>
                            <td class="text-end"><?php echo number_format($data['order']['subtotal']); ?>₫</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Phí vận chuyển:</th>
                            <td class="text-end">
                                <?php 
                                if ($data['order']['shipping_fee'] > 0) {
                                    echo number_format($data['order']['shipping_fee']) . '₫';
                                } else {
                                    echo '<span class="text-success">Miễn phí</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Tổng cộng:</th>
                            <td class="text-end"><strong class="text-danger"><?php echo number_format($data['order']['total_amount']); ?>₫</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <?php if ($data['order']['order_status'] == 'pending' || $data['order']['order_status'] == 'processing'): ?>
            <div class="card-footer">
                <form action="index.php?action=cancel_order" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                    <input type="hidden" name="order_id" value="<?php echo $data['order']['id']; ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i> Hủy đơn hàng
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>