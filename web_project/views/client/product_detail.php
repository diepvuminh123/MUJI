<?php 
// Set page title based on product name
$page_title = isset($data['product']['name']) ? $data['product']['name'] : 'Chi tiết sản phẩm';

// Include header template
include  __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <!-- Product details -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Product images -->
                <div class="col-md-6 mb-4">
                    <?php if (!empty($data['images'])): ?>
                        <img src="<?php echo $data['images'][0]['image_path']; ?>" 
                             class="img-fluid rounded" alt="<?php echo htmlspecialchars($data['product']['name'] ?? ''); ?>">
                    <?php else: ?>
                        <img src="assets/images/no-image.jpg" class="img-fluid rounded" alt="No image available">
                    <?php endif; ?>
                </div>
                
                <!-- Product info -->
                <div class="col-md-6">
                    <h2 class="mb-3"><?php echo htmlspecialchars($data['product']['name'] ?? ''); ?></h2>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary"><?php echo htmlspecialchars($data['product']['category_name'] ?? ''); ?></span>
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        <?php if (!empty($data['product']['sale_price']) && $data['product']['sale_price'] < $data['product']['price']): ?>
                            <div class="d-flex align-items-center">
                                <span class="h3 text-danger fw-bold me-3"><?php echo number_format($data['product']['sale_price']); ?>₫</span>
                                <span class="h5 text-muted text-decoration-line-through"><?php echo number_format($data['product']['price']); ?>₫</span>
                            </div>
                        <?php elseif (isset($data['product']['price'])): ?>
                            <span class="h3 fw-bold"><?php echo number_format($data['product']['price']); ?>₫</span>
                        <?php else: ?>
                            <span class="h3 fw-bold">Giá: Liên hệ</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Availability -->
                    <div class="mb-4">
                        <?php if (isset($data['product']['quantity']) && $data['product']['quantity'] > 0): ?>
                            <span class="text-success"><i class="fas fa-check-circle"></i> Còn hàng</span>
                        <?php else: ?>
                            <span class="text-danger"><i class="fas fa-times-circle"></i> Hết hàng</span>
                        <?php endif; ?>
                    </div>
                    <!-- Thêm vào giỏ hàng sau phần hiển thị "Còn hàng" / "Hết hàng" -->
                    <div class="mb-4">
                        <?php if (isset($data['product']['quantity']) && $data['product']['quantity'] > 0): ?>
                            <form action="index.php?action=addToCart" method="post" class="add-to-cart-form">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="quantity" class="form-label">Số lượng:</label>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group" style="width: 130px;">
                                            <button type="button" class="btn btn-outline-secondary decrease-qty">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center" id="quantity" name="quantity" 
                                                value="1" min="1" max="<?php echo min($data['product']['quantity'], 10); ?>">
                                            <button type="button" class="btn btn-outline-secondary increase-qty">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="hidden" name="product_id" value="<?php echo $data['product']['id']; ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const decreaseBtn = document.querySelector('.decrease-qty');
                                    const increaseBtn = document.querySelector('.increase-qty');
                                    const quantityInput = document.getElementById('quantity');
                                    const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                                    
                                    // Giảm số lượng
                                    decreaseBtn.addEventListener('click', function() {
                                        let value = parseInt(quantityInput.value);
                                        if (value > 1) {
                                            quantityInput.value = value - 1;
                                        }
                                    });
                                    
                                    // Tăng số lượng
                                    increaseBtn.addEventListener('click', function() {
                                        let value = parseInt(quantityInput.value);
                                        if (value < maxQuantity) {
                                            quantityInput.value = value + 1;
                                        }
                                    });
                                    
                                    // AJAX thêm vào giỏ hàng
                                    const form = document.querySelector('.add-to-cart-form');
                                    form.addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        
                                        const productId = this.querySelector('input[name="product_id"]').value;
                                        const quantity = this.querySelector('input[name="quantity"]').value;
                                        
                                        fetch('index.php?action=addToCart', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-Requested-With': 'XMLHttpRequest'
                                            },
                                            body: JSON.stringify({
                                                product_id: productId,
                                                quantity: quantity
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                alert('Đã thêm sản phẩm vào giỏ hàng!');
                                                
                                                // Cập nhật số lượng sản phẩm trong giỏ hàng hiển thị trên header
                                                const cartCountElement = document.getElementById('cart-count');
                                                if (cartCountElement) {
                                                    cartCountElement.textContent = data.cart_count;
                                                    cartCountElement.style.display = 'inline-block';
                                                }
                                            } else {
                                                alert(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Lỗi:', error);
                                            alert('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng!');
                                        });
                                    });
                                });
                            </script>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-shopping-cart me-2"></i> Hết hàng
                            </button>
                        <?php endif; ?>
                    </div>
                    <!-- Description -->
                    <div class="mb-4">
                        <h5>Mô tả sản phẩm:</h5>
                        <div><?php echo $data['product']['description'] ?? 'Không có thông tin mô tả.'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related products -->
    <?php if (!empty($data['relatedProducts'])): ?>
        <h3 class="mb-3">Sản phẩm liên quan</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($data['relatedProducts'] as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>">
                            <!-- <img src="<?php echo !empty($product['primary_image']) ? $product['primary_image'] : 'assets/images/no-image.jpg'; ?>"  -->
                            <img src="<?php echo !empty($product['primary_image']) ? 
                    (substr($product['primary_image'], 0, 1) === '/' ? $product['primary_image'] : '/'.$product['primary_image']) : 
                    '/assets/images/no-image.jpg'; ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>" class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h6>
                            <div>
                                <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                                    <span class="text-danger fw-bold me-2"><?php echo number_format($product['sale_price']); ?>₫</span>
                                    <span class="text-muted text-decoration-line-through"><?php echo number_format($product['price']); ?>₫</span>
                                <?php else: ?>
                                    <span class="fw-bold"><?php echo number_format($product['price']); ?>₫</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include  __DIR__ . '/../Template/Footer.php'; ?>