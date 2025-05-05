<?php 
// Set page title based on product name
$page_title = isset($data['product']['name']) ? $data['product']['name'] : 'Chi tiết sản phẩm';

// Include header template
include  __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <!-- Product details -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Product images -->
                <div class="md:w-1/2 mb-6 md:mb-0">
                    <?php if (!empty($data['images'])): ?>
                        <img src="<?php echo $data['images'][0]['image_path']; ?>" 
                             class="w-full h-auto rounded-lg" alt="<?php echo htmlspecialchars($data['product']['name'] ?? ''); ?>">
                    <?php else: ?>
                        <img src="assets/images/no-image.jpg" class="w-full h-auto rounded-lg" alt="No image available">
                    <?php endif; ?>
                </div>
                
                <!-- Product info -->
                <div class="md:w-1/2">
                    <!-- Highlighted product name - larger and bold -->
                    <h2 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($data['product']['name'] ?? ''); ?></h2>
                    
                    <div class="mb-4">
                        <span class="bg-blue-600 text-white text-sm font-medium px-3 py-1 rounded-full">
                            <?php echo htmlspecialchars($data['product']['category_name'] ?? ''); ?>
                        </span>
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-6">
                        <?php if (!empty($data['product']['sale_price']) && $data['product']['sale_price'] < $data['product']['price']): ?>
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-red-600 mr-3"><?php echo number_format($data['product']['sale_price']); ?>₫</span>
                                <span class="text-lg text-gray-500 line-through"><?php echo number_format($data['product']['price']); ?>₫</span>
                            </div>
                        <?php elseif (isset($data['product']['price'])): ?>
                            <span class="text-2xl font-bold"><?php echo number_format($data['product']['price']); ?>₫</span>
                        <?php else: ?>
                            <span class="text-2xl font-bold">Giá: Liên hệ</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Availability -->
                    <div class="mb-6">
                        <?php if (isset($data['product']['quantity']) && $data['product']['quantity'] > 0): ?>
                            <span class="text-green-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Còn hàng
                            </span>
                        <?php else: ?>
                            <span class="text-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Hết hàng
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Add to cart form with improved spacing -->
                    <div class="mb-6">
                        <?php if (isset($data['product']['quantity']) && $data['product']['quantity'] > 0): ?>
                            <form action="index.php?action=addToCart" method="post" class="add-to-cart-form">
                                <div class="flex flex-wrap items-center gap-4">
                                    <div class="flex items-center">
                                        <label for="quantity" class="font-medium mr-3">Số lượng:</label>
                                        <div class="flex items-center border border-gray-300 rounded-md w-32">
                                            <button type="button" class="decrease-qty px-3 py-2 text-gray-600 hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" class="w-full text-center border-0 focus:ring-0" id="quantity" name="quantity" 
                                                value="1" min="1" max="<?php echo min($data['product']['quantity'], 10); ?>">
                                            <button type="button" class="increase-qty px-3 py-2 text-gray-600 hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="hidden" name="product_id" value="<?php echo $data['product']['id']; ?>">
                                        <!-- Blue button as requested -->
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Thêm vào giỏ hàng
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
                            <button class="bg-gray-400 text-white font-medium py-2 px-4 rounded-md flex items-center cursor-not-allowed opacity-75" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Hết hàng
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Description with larger font and bold title -->
                    <div class="mb-4">
                        <h5 class="text-xl font-bold mb-3">Mô tả sản phẩm:</h5>
                        <div class="text-gray-700"><?php echo $data['product']['description'] ?? 'Không có thông tin mô tả.'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related products with larger font and bold title -->
    <?php if (!empty($data['relatedProducts'])): ?>
        <h3 class="text-2xl font-bold mb-6">Sản phẩm liên quan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($data['relatedProducts'] as $product): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>">
                        <img src="<?php echo !empty($product['primary_image']) ? 
                        (substr($product['primary_image'], 0, 1) === '/' ? $product['primary_image'] : '/'.$product['primary_image']) : 
                        '/MUJI/web_project/assets/images/no-image.jpg'; ?>" 
                             class="w-full h-48 object-cover" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </a>
                    <div class="p-4">
                        <h6 class="text-lg font-medium mb-2">
                            <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>" class="text-gray-800 hover:text-blue-600 no-underline">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </a>
                        </h6>
                        <div>
                            <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                                <span class="text-red-600 font-bold mr-2"><?php echo number_format($product['sale_price']); ?>₫</span>
                                <span class="text-gray-500 line-through"><?php echo number_format($product['price']); ?>₫</span>
                            <?php else: ?>
                                <span class="font-bold"><?php echo number_format($product['price']); ?>₫</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include  __DIR__ . '/../Template/Footer.php'; ?>