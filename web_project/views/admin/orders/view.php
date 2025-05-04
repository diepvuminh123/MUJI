<?php 
// Set page title
$page_title = 'Chi tiết đơn hàng';

// Include header template
require_once __DIR__ . '/../Template/Header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Chi tiết đơn hàng #<?php echo $data['order']['order_code']; ?></h4>
                <div>
                    <a href="admin.php?action=orderInvoice&id=<?php echo $data['order']['id']; ?>" class="btn btn-info" target="_blank">
                        <i class="fas fa-file-invoice"></i> In hóa đơn
                    </a>
                    <a href="admin.php?action=adminOrders" class="btn btn-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
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
                
                <div class="row mb-4">
                    <!-- Order Details -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th>Mã đơn hàng:</th>
                                        <td class="fw-bold"><?php echo $data['order']['order_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày đặt hàng:</th>
                                        <td><?php echo date('d/m/Y H:i', strtotime($data['order']['created_at'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            <?php
                                            switch ($data['order']['order_status']) {
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
                                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($data['order']['order_status']) . '</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức:</th>
                                        <td>
                                            <?php 
                                            if ($data['order']['payment_method'] == 'cod') {
                                                echo 'Thanh toán khi nhận hàng (COD)';
                                            } elseif ($data['order']['payment_method'] == 'bank_transfer') {
                                                echo 'Chuyển khoản ngân hàng';
                                            } else {
                                                echo htmlspecialchars($data['order']['payment_method']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái TT:</th>
                                        <td>
                                            <?php if ($data['order']['payment_status'] == 'paid'): ?>
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            <?php elseif ($data['order']['payment_status'] == 'refunded'): ?>
                                                <span class="badge bg-info">Đã hoàn tiền</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th>Họ tên:</th>
                                        <td><?php echo htmlspecialchars($data['order']['customer_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo htmlspecialchars($data['order']['customer_email']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại:</th>
                                        <td><?php echo htmlspecialchars($data['order']['customer_phone']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</th>
                                        <td><?php echo nl2br(htmlspecialchars($data['order']['customer_address'])); ?></td>
                                    </tr>
                                    <?php if (isset($data['customer']) && $data['customer']): ?>
                                    <tr>
                                        <th>Tài khoản:</th>
                                        <td>
                                            <span class="badge bg-primary">Thành viên</span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Ghi chú</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($data['order']['order_notes'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($data['order']['order_notes'])); ?></p>
                                <?php else: ?>
                                    <p class="text-muted"><em>Không có ghi chú</em></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Update -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Cập nhật trạng thái</h5>
                            </div>
                            <div class="card-body">
                                <form action="admin.php?action=updateOrderStatus" method="post">
                                    <input type="hidden" name="order_id" value="<?php echo $data['order']['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label for="order_status" class="form-label">Trạng thái đơn hàng</label>
                                        <select class="form-select" id="order_status" name="order_status">
                                            <option value="pending" <?php echo ($data['order']['order_status'] == 'pending') ? 'selected' : ''; ?>>Chờ xử lý</option>
                                            <option value="processing" <?php echo ($data['order']['order_status'] == 'processing') ? 'selected' : ''; ?>>Đang xử lý</option>
                                            <option value="shipping" <?php echo ($data['order']['order_status'] == 'shipping') ? 'selected' : ''; ?>>Đang giao hàng</option>
                                            <option value="completed" <?php echo ($data['order']['order_status'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                                            <option value="cancelled" <?php echo ($data['order']['order_status'] == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="payment_status" class="form-label">Trạng thái thanh toán</label>
                                        <select class="form-select" id="payment_status" name="payment_status">
                                            <option value="pending" <?php echo ($data['order']['payment_status'] == 'pending') ? 'selected' : ''; ?>>Chưa thanh toán</option>
                                            <option value="paid" <?php echo ($data['order']['payment_status'] == 'paid') ? 'selected' : ''; ?>>Đã thanh toán</option>
                                            <option value="refunded" <?php echo ($data['order']['payment_status'] == 'refunded') ? 'selected' : ''; ?>>Đã hoàn tiền</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Chi tiết sản phẩm</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
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
                                                        <?php if (!empty($item['product_id'])): ?>
                                                            <div class="small text-muted">ID: <?php echo $item['product_id']; ?></div>
                                                        <?php endif; ?>
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
                                        <td class="text-end"><strong class="text-danger fs-5"><?php echo number_format($data['order']['total_amount']); ?>₫</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Order Timeline -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Lịch sử đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-left">
                                    <div class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($data['order']['created_at'])); ?></div>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-indicator bg-primary"></div>
                                    <div class="timeline-title">Tạo đơn hàng</div>
                                    <div class="timeline-text">Đơn hàng đã được tạo với mã <?php echo $data['order']['order_code']; ?></div>
                                </div>
                            </div>
                            
                            <?php if ($data['order']['order_status'] != 'pending'): ?>
                                <div class="timeline-item">
                                    <div class="timeline-left">
                                        <div class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($data['order']['updated_at'])); ?></div>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-indicator bg-info"></div>
                                        <div class="timeline-title">Cập nhật trạng thái</div>
                                        <div class="timeline-text">
                                            Trạng thái đơn hàng đã được cập nhật thành 
                                            <?php
                                            switch ($data['order']['order_status']) {
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
                                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($data['order']['order_status']) . '</span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($data['order']['payment_status'] == 'paid'): ?>
                                <div class="timeline-item">
                                    <div class="timeline-left">
                                        <div class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($data['order']['updated_at'])); ?></div>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-indicator bg-success"></div>
                                        <div class="timeline-title">Thanh toán</div>
                                        <div class="timeline-text">Đơn hàng đã được thanh toán</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Timeline styles */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 11px;
        height: 100%;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-left {
        position: absolute;
        left: -30px;
        width: 30px;
    }
    
    .timeline-date {
        font-size: 0.8rem;
        color: #6c757d;
        white-space: nowrap;
        position: absolute;
        left: -120px;
        width: 120px;
        text-align: right;
    }
    
    .timeline-content {
        position: relative;
        padding-left: 20px;
    }
    
    .timeline-indicator {
        position: absolute;
        top: 3px;
        left: -5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #007bff;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }
    
    .timeline-title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .timeline-text {
        color: #6c757d;
    }
</style>

<script>
    // Auto hide alerts after 5 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
</script>
<?php require_once __DIR__ . '/../Template/Footer.php'; ?>