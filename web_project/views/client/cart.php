<?php 
// Set page title
$page_title = 'Giỏ hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>
    
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
    
    <?php if (empty($data['cartItems'])): ?>
        <!-- Giỏ hàng trống -->
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                </div>
                <h3 class="mb-3">Giỏ hàng của bạn đang trống</h3>
                <p class="mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua hàng</p>
                <a href="index.php?action=products" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Giỏ hàng có sản phẩm -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Sản phẩm trong giỏ hàng</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Thành tiền</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['cartItems'] as $item): ?>
                                        <tr class="cart-item" data-id="<?php echo $item['id']; ?>">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <a href="index.php?action=product&slug=<?php echo $item['slug']; ?>">
                                                            <img src="<?php echo !empty($item['image_path']) ? $item['image_path'] : 'assets/images/no-image.jpg'; ?>" 
                                                                alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                                                class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="index.php?action=product&slug=<?php echo $item['slug']; ?>" class="text-decoration-none text-dark">
                                                                <?php echo htmlspecialchars($item['name']); ?>
                                                            </a>
                                                        </h6>
                                                        <?php if ($item['stock'] <= 5): ?>
                                                            <div class="text-danger small">
                                                                <i class="fas fa-exclamation-circle"></i> Chỉ còn <?php echo $item['stock']; ?> sản phẩm
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($item['sale_price']) && $item['sale_price'] < $item['price']): ?>
                                                    <div>
                                                        <span class="text-danger fw-bold"><?php echo number_format($item['sale_price']); ?>₫</span>
                                                        <br>
                                                        <span class="text-muted text-decoration-line-through"><?php echo number_format($item['price']); ?>₫</span>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="fw-bold"><?php echo number_format($item['price']); ?>₫</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group quantity-control" style="width: 120px; margin: 0 auto;">
                                                    <button type="button" class="btn btn-outline-secondary decrease-qty">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="form-control text-center item-quantity" 
                                                           value="<?php echo $item['quantity']; ?>" 
                                                           min="1" max="<?php echo $item['stock']; ?>"
                                                           data-id="<?php echo $item['id']; ?>">
                                                    <button type="button" class="btn btn-outline-secondary increase-qty">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold item-total"><?php echo number_format($item['total']); ?>₫</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-danger remove-item" data-id="<?php echo $item['id']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="index.php?action=products" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm
                        </a>
                        <form action="index.php?action=clearCart" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?');">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt me-2"></i> Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính:</span>
                            <span class="fw-bold" id="cart-subtotal"><?php echo number_format($data['cartTotal']['subtotal']); ?>₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span id="cart-shipping">
                                <?php if ($data['cartTotal']['shipping'] > 0): ?>
                                    <span class="fw-bold"><?php echo number_format($data['cartTotal']['shipping']); ?>₫</span>
                                <?php else: ?>
                                    <span class="text-success fw-bold">Miễn phí</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Tổng cộng:</span>
                            <span class="fw-bold text-danger fs-5" id="cart-total"><?php echo number_format($data['cartTotal']['total']); ?>₫</span>
                        </div>
                        <a href="index.php?action=checkout" class="btn btn-danger w-100">
                            <i class="fas fa-credit-card me-2"></i> Tiến hành thanh toán
                        </a>
                    </div>
                    <div class="card-footer small">
                        <div class="mb-1"><i class="fas fa-shield-alt text-success me-2"></i> Thanh toán an toàn</div>
                        <div class="mb-1"><i class="fas fa-truck text-success me-2"></i> Miễn phí vận chuyển cho đơn hàng từ 500.000₫</div>
                        <div><i class="fas fa-undo text-success me-2"></i> Đổi trả trong vòng 7 ngày</div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý tăng giảm số lượng
        const decreaseButtons = document.querySelectorAll('.decrease-qty');
        const increaseButtons = document.querySelectorAll('.increase-qty');
        const quantityInputs = document.querySelectorAll('.item-quantity');
        const removeButtons = document.querySelectorAll('.remove-item');
        
        // Giảm số lượng
        decreaseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.item-quantity');
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateCartItem(input);
                }
            });
        });
        
        // Tăng số lượng
        increaseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.item-quantity');
                const currentValue = parseInt(input.value);
                const maxValue = parseInt(input.getAttribute('max'));
                
                if (currentValue < maxValue) {
                    input.value = currentValue + 1;
                    updateCartItem(input);
                }
            });
        });
        
        // Cập nhật khi thay đổi số lượng
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                let value = parseInt(this.value);
                const min = parseInt(this.getAttribute('min'));
                const max = parseInt(this.getAttribute('max'));
                
                if (value < min) {
                    value = min;
                    this.value = min;
                } else if (value > max) {
                    value = max;
                    this.value = max;
                }
                
                updateCartItem(this);
            });
        });
        
        // Xóa sản phẩm
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    const itemId = this.getAttribute('data-id');
                    removeCartItem(itemId);
                }
            });
        });
        
        // Hàm cập nhật số lượng sản phẩm
        function updateCartItem(input) {
            const itemId = input.getAttribute('data-id');
            const quantity = parseInt(input.value);
            
            // Gửi Ajax request
            fetch('index.php?action=updateCartItem', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật thông tin hiển thị
                    const row = input.closest('.cart-item');
                    const totalElement = row.querySelector('.item-total');
                    
                    // Cập nhật tổng tiền sản phẩm
                    const priceElement = row.querySelector('td:nth-child(2)');
                    let price;
                    
                    if (priceElement.querySelector('.text-danger')) {
                        // Có giá khuyến mãi
                        price = parseFloat(priceElement.querySelector('.text-danger').textContent.replace(/[^\d]/g, ''));
                    } else {
                        // Giá thường
                        price = parseFloat(priceElement.querySelector('.fw-bold').textContent.replace(/[^\d]/g, ''));
                    }
                    
                    const total = price * quantity;
                    totalElement.textContent = formatCurrency(total);
                    
                    // Cập nhật tổng giỏ hàng
                    document.getElementById('cart-subtotal').textContent = data.formatted_subtotal;
                    
                    const shippingElement = document.getElementById('cart-shipping');
                    if (data.shipping > 0) {
                        shippingElement.innerHTML = `<span class="fw-bold">${data.formatted_shipping}</span>`;
                    } else {
                        shippingElement.innerHTML = '<span class="text-success fw-bold">Miễn phí</span>';
                    }
                    
                    document.getElementById('cart-total').textContent = data.formatted_total;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Đã xảy ra lỗi khi cập nhật giỏ hàng.');
            });
        }
        
        // Hàm xóa sản phẩm
        function removeCartItem(itemId) {
            // Gửi Ajax request
            fetch('index.php?action=removeCartItem', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    item_id: itemId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Xóa dòng sản phẩm
                    const row = document.querySelector(`.cart-item[data-id="${itemId}"]`);
                    if (row) {
                        row.remove();
                    }
                    
                    // Cập nhật tổng giỏ hàng
                    document.getElementById('cart-subtotal').textContent = data.formatted_subtotal;
                    
                    const shippingElement = document.getElementById('cart-shipping');
                    if (data.shipping > 0) {
                        shippingElement.innerHTML = `<span class="fw-bold">${data.formatted_shipping}</span>`;
                    } else {
                        shippingElement.innerHTML = '<span class="text-success fw-bold">Miễn phí</span>';
                    }
                    
                    document.getElementById('cart-total').textContent = data.formatted_total;
                    
                    // Nếu giỏ hàng trống thì tải lại trang
                    if (data.is_empty) {
                        window.location.reload();
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng.');
            });
        }
        
        // Hàm định dạng tiền tệ
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + '₫';
        }
    });
</script>

<?php include __DIR__ . '/../Template/Footer.php'; ?>