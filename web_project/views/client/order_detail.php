<?php 
// Set page title
$page_title = 'Chi tiết đơn hàng';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Chi tiết đơn hàng</h1>
        <a href="index.php?action=my_orders" class="flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại đơn hàng
        </a>
    </div>
    
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Đơn hàng #<?php echo $data['order']['order_code']; ?></h2>
                <!-- Badge trạng thái -->
                <?php 
                // Xác định class màu theo order_status
                switch ($data['order']['order_status']) {
                    case 'pending':
                    $badgeBg = 'bg-yellow-100'; $badgeText = 'text-yellow-800'; break;
                    case 'processing':
                    $badgeBg = 'bg-blue-100';   $badgeText = 'text-blue-800';   break;
                    case 'shipping':
                    $badgeBg = 'bg-indigo-100'; $badgeText = 'text-indigo-800'; break;
                    case 'completed':
                    $badgeBg = 'bg-green-100';  $badgeText = 'text-green-800';  break;
                    case 'cancelled':
                    $badgeBg = 'bg-red-100';    $badgeText = 'text-red-800';    break;
                    default:
                    $badgeBg = 'bg-gray-100';   $badgeText = 'text-gray-800';   break;
                }
                ?>
                <span class="inline-block px-3 py-1 rounded-full <?php echo $badgeBg . ' ' . $badgeText; ?>">
                <?php
                    switch ($data['order']['order_status']) {
                    case 'pending':    echo 'Chờ xử lý';      break;
                    case 'processing': echo 'Đang xử lý';     break;
                    case 'shipping':   echo 'Đang giao hàng'; break;
                    case 'completed':  echo 'Hoàn thành';      break;
                    case 'cancelled':  echo 'Đã hủy';          break;
                    default:           echo htmlspecialchars($data['order']['order_status']);
                    }
                ?>
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold mb-3">Thông tin giao hàng</h3>
                    <p class="mb-2"><span class="font-medium">Họ tên:</span> <?php echo htmlspecialchars($data['order']['customer_name']); ?></p>
                    <p class="mb-2"><span class="font-medium">Email:</span> <?php echo htmlspecialchars($data['order']['customer_email']); ?></p>
                    <p class="mb-2"><span class="font-medium">Số điện thoại:</span> <?php echo htmlspecialchars($data['order']['customer_phone']); ?></p>
                    <p class="mb-0"><span class="font-medium">Địa chỉ:</span> <?php echo nl2br(htmlspecialchars($data['order']['customer_address'])); ?></p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-3">Thông tin đơn hàng</h3>
                    <p class="mb-2"><span class="font-medium">Mã đơn hàng:</span> <?php echo $data['order']['order_code']; ?></p>
                    <p class="mb-2"><span class="font-medium">Ngày đặt:</span> <?php echo date('d/m/Y H:i', strtotime($data['order']['created_at'])); ?></p>
                    <p class="mb-2">
                        <span class="font-medium">Thanh toán:</span> 
                        <?php 
                        if ($data['order']['payment_method'] == 'cod') {
                            echo 'COD';
                        } elseif ($data['order']['payment_method'] == 'bank_transfer') {
                            echo 'Chuyển khoản';
                        } else {
                            echo htmlspecialchars($data['order']['payment_method']);
                        }
                        ?>
                    </p>
                    <p class="mb-2">
                        <span class="font-medium">Trạng thái TT:</span> 
                        <span class="px-2 py-1 text-sm rounded <?php
                        if ($data['order']['payment_status'] == 'paid') {
                            echo 'bg-green-100 text-green-800';
                        } elseif ($data['order']['payment_status'] == 'refunded') {
                            echo 'bg-blue-100 text-blue-800';
                        } else {
                            echo 'bg-yellow-100 text-yellow-800';
                        }
                        ?>">
                            <?php 
                            if ($data['order']['payment_status'] == 'paid') {
                                echo 'Đã thanh toán';
                            } elseif ($data['order']['payment_status'] == 'refunded') {
                                echo 'Đã hoàn tiền';
                            } else {
                                echo 'Chưa thanh toán';
                            }
                            ?>
                        </span>
                    </p>
                    
                    <?php if (!empty($data['order']['order_notes'])): ?>
                        <p class="mb-0"><span class="font-medium">Ghi chú:</span> <?php echo nl2br(htmlspecialchars($data['order']['order_notes'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold mb-4">Chi tiết sản phẩm</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Sản phẩm</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Số lượng</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Đơn giá</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($data['orderItems'] as $item): ?>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <?php if (!empty($item['image_path'])): ?>
                                            <img src="<?php echo $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="w-12 h-12 object-cover rounded mr-3">
                                        <?php endif; ?>
                                        <span class="truncate max-w-xs"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center"><?php echo $item['quantity']; ?></td>
                                <td class="px-4 py-3 text-right"><?php echo number_format($item['price']); ?>₫</td>
                                <td class="px-4 py-3 text-right"><?php echo number_format($item['subtotal']); ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <th colspan="3" class="px-4 py-3 text-right">Tạm tính:</th>
                            <td class="px-4 py-3 text-right"><?php echo number_format($data['order']['subtotal']); ?>₫</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="px-4 py-3 text-right">Phí vận chuyển:</th>
                            <td class="px-4 py-3 text-right">
                                <?php 
                                if ($data['order']['shipping_fee'] > 0) {
                                    echo number_format($data['order']['shipping_fee']) . '₫';
                                } else {
                                    echo '<span class="text-green-600">Miễn phí</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3" class="px-4 py-3 text-right">Tổng cộng:</th>
                            <td class="px-4 py-3 text-right font-bold text-red-600"><?php echo number_format($data['order']['total_amount']); ?>₫</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <?php if ($data['order']['order_status'] == 'pending' || $data['order']['order_status'] == 'processing'): ?>
            <div class="border-t px-6 py-4">
                <form action="index.php?action=cancel_order" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                    <input type="hidden" name="order_id" value="<?php echo $data['order']['id']; ?>">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition-colors">
                        Hủy đơn hàng
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>