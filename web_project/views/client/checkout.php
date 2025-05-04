<?php 
// Set page title
$page_title = 'Thanh toán';

// Include header template
include __DIR__ . '/../Template/Header.php';

// Lấy dữ liệu form cũ nếu có
$formData = $_SESSION['checkout_form_data'] ?? $data['formData'] ?? [];
unset($_SESSION['checkout_form_data']);
?>

<div class="container py-5">
    <h1 class="mb-4">Thanh toán</h1>
    
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <form action="index.php?action=place_order" method="post">
        <div class="row">
            <!-- Thông tin thanh toán -->
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                       value="<?php echo htmlspecialchars($formData['customer_name'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                       value="<?php echo htmlspecialchars($formData['customer_email'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                                   value="<?php echo htmlspecialchars($formData['customer_phone'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required><?php echo htmlspecialchars($formData['customer_address'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="order_notes" class="form-label">Ghi chú đơn hàng</label>
                            <textarea class="form-control" id="order_notes" name="order_notes" rows="3"><?php echo htmlspecialchars($formData['order_notes'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">Ghi chú về đơn hàng của bạn, ví dụ: thời gian giao hàng hoặc địa điểm cụ thể.</small>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                <strong>Thanh toán khi nhận hàng (COD)</strong>
                                <p class="text-muted mb-0">Thanh toán bằng tiền mặt khi nhận hàng.</p>
                            </label>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                            <label class="form-check-label" for="bank_transfer">
                                <strong>Chuyển khoản ngân hàng</strong>
                                <p class="text-muted mb-0">Thực hiện thanh toán trực tiếp vào tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng Mã đơn hàng của bạn trong phần Nội dung thanh toán. Đơn hàng sẽ được giao sau khi tiền đã được chuyển vào tài khoản của chúng tôi.</p>
                                <div class="mt-2 p-3 bg-light">
                                    <p class="mb-1"><strong>Thông tin tài khoản:</strong></p>
                                    <p class="mb-1">Ngân hàng: Vietcombank</p>
                                    <p class="mb-1">Số tài khoản: 1234567890</p>
                                    <p class="mb-1">Chủ tài khoản: CÔNG TY TNHH ABC</p>
                                    <p class="mb-0">Chi nhánh: Hồ Chí Minh</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tổng quan đơn hàng -->
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Tạm tính</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['cartItems'] as $item): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($item['name']); ?> 
                                                <strong>× <?php echo $item['quantity']; ?></strong>
                                            </td>
                                            <td class="text-end"><?php echo number_format($item['total']); ?>₫</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Tạm tính</th>
                                        <td class="text-end"><?php echo number_format($data['cartTotal']['subtotal']); ?>₫</td>
                                    </tr>
                                    <tr>
                                        <th>Phí vận chuyển</th>
                                        <td class="text-end">
                                            <?php if ($data['cartTotal']['shipping'] > 0): ?>
                                                <?php echo number_format($data['cartTotal']['shipping']); ?>₫
                                            <?php else: ?>
                                                <span class="text-success">Miễn phí</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tổng cộng</th>
                                        <td class="text-end"><strong class="text-danger fs-5"><?php echo number_format($data['cartTotal']['total']); ?>₫</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đã đọc và đồng ý với <a href="#" class="text-decoration-none">điều khoản và điều kiện</a> của website
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-lock me-2"></i> Đặt hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>