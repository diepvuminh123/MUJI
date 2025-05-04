<?php 
// Set page title
$page_title = 'Xác nhận đơn hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success fa-5x"></i>
                    </div>
                    <h2 class="mb-3">Cảm ơn bạn đã đặt hàng!</h2>
                    <p class="mb-1">Đơn hàng của bạn đã được đặt thành công.</p>
                    <p class="mb-4">Mã đơn hàng của bạn là: <strong class="text-primary"><?php echo $data['order']['order_code']; ?></strong></p>
                    
                    <div class="alert alert-info mb-4" role="alert">
                        <p class="mb-1">Chúng tôi đã gửi email xác nhận đến <strong><?php echo htmlspecialchars($data['order']['customer_email']); ?></strong></p>
                        <p class="mb-0">Vui lòng kiểm tra hộp thư đến của bạn để xem chi tiết đơn hàng.</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Thông tin giao hàng</h5>
                                    <p class="card-text mb-1"><?php echo htmlspecialchars($data['order']['customer_name']); ?></p>
                                    <p class="card-text mb-1"><?php echo htmlspecialchars($data['order']['customer_phone']); ?></p>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($data['order']['customer_address'])); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Thông tin thanh toán</h5>
                                    <p class="card-text mb-1">
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
                                    <p class="card-text mb-1"><strong>Tổng tiền:</strong> <?php echo number_format($data['order']['total_amount']); ?>₫</p>
                                    <p class="card-text">
                                        <strong>Trạng thái thanh toán:</strong> 
                                        <?php 
                                        if ($data['order']['payment_status'] == 'paid') {
                                            echo '<span class="badge bg-success">Đã thanh toán</span>';
                                        } else {
                                            echo '<span class="badge bg-warning text-dark">Chưa thanh toán</span>';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="mb-3">Chi tiết đơn hàng</h4>
                    <div class="table-responsive mb-4">
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
                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
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
                    
                    <div class="d-flex justify-content-center mt-4">
                        <a href="index.php" class="btn btn-primary me-2">
                            <i class="fas fa-home me-2"></i> Trang chủ
                        </a>
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="index.php?action=my_orders" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i> Xem đơn hàng của tôi
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>