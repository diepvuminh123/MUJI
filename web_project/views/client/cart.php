<?php 
// Set page title
$page_title = 'Giỏ hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <!-- Highlighted cart heading -->
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Giỏ hàng của bạn</h1>
    
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['success_message']; ?></span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="Close">
                <span class="text-green-500 hover:text-green-800">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="Close">
                <span class="text-red-500 hover:text-red-800">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (empty($data['cartItems'])): ?>
        <!-- Empty cart -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="py-12 px-4 text-center">
                <div class="mb-6">
                    <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Giỏ hàng của bạn đang trống</h3>
                <p class="text-gray-600 mb-6">Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua hàng</p>
                <a href="index.php?action=products" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Cart with items -->
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h5 class="font-semibold text-lg text-gray-800">Sản phẩm trong giỏ hàng</h5>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Sản phẩm</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Đơn giá</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Số lượng</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Thành tiền</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($data['cartItems'] as $item): ?>
                                    <tr class="cart-item" data-id="<?php echo $item['id']; ?>">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 mr-4">
                                                    <a href="index.php?action=product&slug=<?php echo $item['slug']; ?>">
                                                        <img src="<?php echo !empty($item['image_path']) ? $item['image_path'] : 'assets/images/no-image.jpg'; ?>" 
                                                            alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                                            class="w-20 h-20 object-cover rounded">
                                                    </a>
                                                </div>
                                                <div>
                                                    <h6 class="font-medium mb-1">
                                                        <a href="index.php?action=product&slug=<?php echo $item['slug']; ?>" class="text-gray-800 hover:text-blue-600 no-underline">
                                                            <?php echo htmlspecialchars($item['name']); ?>
                                                        </a>
                                                    </h6>
                                                    <?php if ($item['stock'] <= 5): ?>
                                                        <div class="text-red-600 text-sm flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                            </svg>
                                                            Chỉ còn <?php echo $item['stock']; ?> sản phẩm
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if (!empty($item['sale_price']) && $item['sale_price'] < $item['price']): ?>
                                                <div>
                                                    <span class="text-red-600 font-semibold"><?php echo number_format($item['sale_price']); ?>₫</span>
                                                    <br>
                                                    <span class="text-gray-500 line-through text-sm"><?php echo number_format($item['price']); ?>₫</span>
                                                </div>
                                            <?php else: ?>
                                                <span class="font-semibold"><?php echo number_format($item['price']); ?>₫</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center">
                                                <div class="flex border border-gray-300 rounded-md w-32">
                                                    <button type="button" class="decrease-qty px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" class="w-full text-center border-0 focus:ring-0 item-quantity" 
                                                           value="<?php echo $item['quantity']; ?>" 
                                                           min="1" max="<?php echo $item['stock']; ?>"
                                                           data-id="<?php echo $item['id']; ?>">
                                                    <button type="button" class="increase-qty px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-semibold item-total"><?php echo number_format($item['total']); ?>₫</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button type="button" class="remove-item text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100" data-id="<?php echo $item['id']; ?>">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                        <a href="index.php?action=products" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Tiếp tục mua sắm
                        </a>
                        <form action="index.php?action=clearCart" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?');">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h5 class="font-semibold text-lg text-gray-800">Thông tin đơn hàng</h5>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-700">Tạm tính:</span>
                            <span class="font-semibold" id="cart-subtotal"><?php echo number_format($data['cartTotal']['subtotal']); ?>₫</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-700">Phí vận chuyển:</span>
                            <span id="cart-shipping">
                                <?php if ($data['cartTotal']['shipping'] > 0): ?>
                                    <span class="font-semibold"><?php echo number_format($data['cartTotal']['shipping']); ?>₫</span>
                                <?php else: ?>
                                    <span class="text-green-600 font-semibold">Miễn phí</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mt-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-800">Tổng cộng:</span>
                                <span class="font-bold text-red-600 text-xl" id="cart-total"><?php echo number_format($data['cartTotal']['total']); ?>₫</span>
                            </div>
                        </div>
                        <a href="index.php?action=checkout" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md flex items-center justify-center w-full mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Tiến hành thanh toán
                        </a>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 text-sm text-gray-600">
                        <div class="mb-2 flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Thanh toán an toàn
                        </div>
                        <div class="mb-2 flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                            Miễn phí vận chuyển cho đơn hàng từ 500.000₫
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Đổi trả trong vòng 7 ngày
                        </div>
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
                    
                    if (priceElement.querySelector('.text-red-600')) {
                        // Có giá khuyến mãi
                        price = parseFloat(priceElement.querySelector('.text-red-600').textContent.replace(/[^\d]/g, ''));
                    } else {
                        // Giá thường
                        price = parseFloat(priceElement.querySelector('.font-semibold').textContent.replace(/[^\d]/g, ''));
                    }
                    
                    const total = price * quantity;
                    totalElement.textContent = formatCurrency(total);
                    
                    // Cập nhật tổng giỏ hàng
                    document.getElementById('cart-subtotal').textContent = data.formatted_subtotal;
                    
                    const shippingElement = document.getElementById('cart-shipping');
                    if (data.shipping > 0) {
                        shippingElement.innerHTML = `<span class="font-semibold">${data.formatted_shipping}</span>`;
                    } else {
                        shippingElement.innerHTML = '<span class="text-green-600 font-semibold">Miễn phí</span>';
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
                        shippingElement.innerHTML = `<span class="font-semibold">${data.formatted_shipping}</span>`;
                    } else {
                        shippingElement.innerHTML = '<span class="text-green-600 font-semibold">Miễn phí</span>';
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