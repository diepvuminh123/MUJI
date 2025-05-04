<?php 
// Set page title
$page_title = 'Chi tiết giỏ hàng';

// Include header template
require_once __DIR__ . '/../Template/Header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Chi tiết giỏ hàng #<?php echo $data['cart']['id']; ?></h4>
                <div>
                    <?php if (count($data['cartItems']) > 0): ?>
                        <a href="admin.php?action=clearCart&id=<?php echo $data['cart']['id']; ?>" 
                           class="btn btn-warning me-2"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng này?');">
                            <i class="fas fa-broom"></i> Xóa tất cả sản phẩm
                        </a>
                    <?php endif; ?>
                    <a href="admin.php?action=deleteCart&id=<?php echo $data['cart']['id']; ?>" 
                       class="btn btn-danger me-2"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa giỏ hàng này?');">
                        <i class="fas fa-trash"></i> Xóa giỏ hàng
                    </a>
                    <a href="admin.php?action=adminCarts" class="btn btn-secondary">
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
                    <!-- Cart Info -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Thông tin giỏ hàng</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="150">ID Giỏ hàng:</th>
                                        <td><?php echo $data['cart']['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo:</th>
                                        <td><?php echo date('d/m/Y H:i', strtotime($data['cart']['created_at'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cập nhật lần cuối:</th>
                                        <td><?php echo date('d/m/Y H:i', strtotime($data['cart']['updated_at'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>ID phiên:</th>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="<?php echo htmlspecialchars($data['cart']['session_id']); ?>">
                                                <?php echo htmlspecialchars($data['cart']['session_id']); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tổng sản phẩm:</th>
                                        <td>
                                            <?php if (count($data['cartItems']) > 0): ?>
                                                <span class="badge bg-info"><?php echo count($data['cartItems']); ?> loại</span>
                                                <span class="badge bg-success"><?php echo $data['cartTotal']['count']; ?> sản phẩm</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Giỏ hàng trống</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tổng tiền:</th>
                                        <td>
                                            <?php if ($data['cartTotal']['total'] > 0): ?>
                                                <span class="fw-bold text-danger"><?php echo number_format($data['cartTotal']['total']); ?>₫</span>
                                            <?php else: ?>
                                                <span class="text-muted">0₫</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($data['cart']['user_id']): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge bg-primary me-2">Thành viên</span>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($data['cart']['user_name'] ?? 'Không có tên'); ?></h6>
                                    </div>
                                    
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th width="150">ID Người dùng:</th>
                                            <td><?php echo $data['cart']['user_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td><?php echo htmlspecialchars($data['cart']['user_email'] ?? ''); ?></td>
                                        </tr>
                                        <?php if (isset($data['customer'])): ?>
                                            <?php if (!empty($data['customer']['phone'])): ?>
                                                <tr>
                                                    <th>Số điện thoại:</th>
                                                    <td><?php echo htmlspecialchars($data['customer']['phone']); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php if (!empty($data['customer']['address'])): ?>
                                                <tr>
                                                    <th>Địa chỉ:</th>
                                                    <td><?php echo nl2br(htmlspecialchars($data['customer']['address'])); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </table>
                                    
                                    <div class="mt-3">
                                        <a href="admin.php?action=adminCarts&user_id=<?php echo $data['cart']['user_id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-shopping-cart"></i> Xem tất cả giỏ hàng của người dùng này
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-secondary">
                                        <i class="fas fa-user-clock me-2"></i> Khách hàng chưa đăng nhập
                                        <div class="small text-muted mt-2">Khách mua hàng không có tài khoản sẽ sử dụng ID phiên để lưu giỏ hàng.</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cart Items -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Các sản phẩm trong giỏ hàng</h5>
                    </div>
                    
                    <?php if (empty($data['cartItems'])): ?>
                        <div class="card-body">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i> Giỏ hàng này hiện đang trống.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="80">Hình ảnh</th>
                                            <th>Sản phẩm</th>
                                            <th class="text-center" width="100">Số lượng</th>
                                            <th class="text-end" width="150">Đơn giá</th>
                                            <th class="text-end" width="150">Thành tiền</th>
                                            <th class="text-center" width="120">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['cartItems'] as $item): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($item['image_path'])): ?>
                                                        <img src="<?php echo substr($item['image_path'], 0, 1) === '/' ? $item['image_path'] : '/' . $item['image_path']; ?>" 
                                                             alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                                             class="img-fluid img-thumbnail" style="max-height: 60px;">
                                                    <?php else: ?>
                                                        <div class="text-center text-muted">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="fw-bold"><?php echo htmlspecialchars($item['name']); ?></div>
                                                    <div class="small text-muted">ID: <?php echo $item['product_id']; ?></div>
                                                    
                                                    <?php if ($item['stock'] <= 5): ?>
                                                        <div class="text-danger small">
                                                            <i class="fas fa-exclamation-circle"></i> Chỉ còn <?php echo $item['stock']; ?> sản phẩm
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center fw-bold">
                                                    <?php echo $item['quantity']; ?>
                                                </td>
                                                <td class="text-end">
                                                    <?php if (!empty($item['sale_price']) && $item['sale_price'] < $item['price']): ?>
                                                        <div class="text-danger fw-bold"><?php echo number_format($item['sale_price']); ?>₫</div>
                                                        <div class="text-muted text-decoration-line-through small"><?php echo number_format($item['price']); ?>₫</div>
                                                    <?php else: ?>
                                                        <div class="fw-bold"><?php echo number_format($item['price']); ?>₫</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end fw-bold"><?php echo number_format($item['total']); ?>₫</td>
                                                <td class="text-center">
                                                    <a href="admin.php?action=removeCartItem&item_id=<?php echo $item['id']; ?>&cart_id=<?php echo $data['cart']['id']; ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="4" class="text-end">Tạm tính:</th>
                                            <td class="text-end fw-bold"><?php echo number_format($data['cartTotal']['subtotal']); ?>₫</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Phí vận chuyển:</th>
                                            <td class="text-end">
                                                <?php if ($data['cartTotal']['shipping'] > 0): ?>
                                                    <?php echo number_format($data['cartTotal']['shipping']); ?>₫
                                                <?php else: ?>
                                                    <span class="text-success">Miễn phí</span>
                                                <?php endif; ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Tổng cộng:</th>
                                            <td class="text-end text-danger fw-bold fs-5"><?php echo number_format($data['cartTotal']['total']); ?>₫</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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
<?php require_once __DIR__ . '/../Template/Footer.php'; ?>