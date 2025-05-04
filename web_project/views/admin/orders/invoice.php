<?php 
// Set page title
$page_title = 'Hóa đơn #' . $data['order']['order_code'];

// We're not including the header template here as we want a clean invoice
// that can be printed directly
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .invoice-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .invoice-body {
            padding: 20px;
        }
        
        .invoice-footer {
            background-color: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #dee2e6;
        }
        
        .logo {
            max-height: 80px;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: 700;
            color: #343a40;
        }
        
        .invoice-details {
            margin-top: 20px;
        }
        
        table.items {
            margin-top: 20px;
        }
        
        .total-row {
            font-weight: 700;
            font-size: 16px;
        }
        
        @media print {
            body {
                padding: 0;
                background-color: #fff;
            }
            
            .invoice-container {
                box-shadow: none;
                max-width: 100%;
            }
            
            .no-print {
                display: none !important;
            }
            
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="container invoice-container">
        <!-- Print Button (No Print) -->
        <div class="d-flex justify-content-end mb-3 no-print">
            <button class="btn btn-primary me-2" onclick="window.print()">
                <i class="fas fa-print me-2"></i> In hóa đơn
            </button>
            <button class="btn btn-secondary" onclick="window.close()">
                <i class="fas fa-times me-2"></i> Đóng
            </button>
        </div>
        
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="fw-bold fs-4 mb-1"><?php echo $GLOBALS['site_info']['Company_name'] ?? 'MUJI Store'; ?></div>
                    <div class="text-muted small"><?php echo $GLOBALS['site_info']['Slogan'] ?? 'Hàng Nhật chính hãng'; ?></div>
                    <div class="text-muted small mt-2"><?php echo $GLOBALS['site_info']['address'] ?? '123 Đường ABC, Quận XYZ, Thành phố Hồ Chí Minh'; ?></div>
                    <div class="text-muted small">Hotline: <?php echo $GLOBALS['site_info']['hotline'] ?? '0123 456 789'; ?></div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="invoice-title">HÓA ĐƠN</div>
                    <div class="text-muted">#<?php echo $data['order']['order_code']; ?></div>
                    <div class="mt-2">
                        <div>Ngày đặt hàng: <?php echo date('d/m/Y', strtotime($data['order']['created_at'])); ?></div>
                        <div>Ngày in hóa đơn: <?php echo date('d/m/Y'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Invoice Body -->
        <div class="invoice-body">
            <div class="row invoice-details">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Thông tin khách hàng:</h6>
                    <div><strong>Tên:</strong> <?php echo htmlspecialchars($data['order']['customer_name']); ?></div>
                    <div><strong>Email:</strong> <?php echo htmlspecialchars($data['order']['customer_email']); ?></div>
                    <div><strong>Điện thoại:</strong> <?php echo htmlspecialchars($data['order']['customer_phone']); ?></div>
                    <div><strong>Địa chỉ:</strong> <?php echo nl2br(htmlspecialchars($data['order']['customer_address'])); ?></div>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Thông tin đơn hàng:</h6>
                    <div><strong>Mã đơn hàng:</strong> <?php echo $data['order']['order_code']; ?></div>
                    <div>
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
                    </div>
                    <div>
                        <strong>Trạng thái thanh toán:</strong> 
                        <?php 
                        if ($data['order']['payment_status'] == 'paid') {
                            echo 'Đã thanh toán';
                        } elseif ($data['order']['payment_status'] == 'refunded') {
                            echo 'Đã hoàn tiền';
                        } else {
                            echo 'Chưa thanh toán';
                        }
                        ?>
                    </div>
                    <div>
                        <strong>Trạng thái đơn hàng:</strong> 
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
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered items">
                    <thead class="table-light">
                        <tr>
                            <th width="50">STT</th>
                            <th>Sản phẩm</th>
                            <th class="text-center" width="80">Số lượng</th>
                            <th class="text-end" width="120">Đơn giá</th>
                            <th class="text-end" width="150">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; foreach ($data['orderItems'] as $item): ?>
                            <tr>
                                <td class="text-center"><?php echo $counter++; ?></td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end"><?php echo number_format($item['price']); ?>₫</td>
                                <td class="text-end"><?php echo number_format($item['subtotal']); ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end">Tạm tính:</td>
                            <td class="text-end"><?php echo number_format($data['order']['subtotal']); ?>₫</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Phí vận chuyển:</td>
                            <td class="text-end">
                                <?php 
                                if ($data['order']['shipping_fee'] > 0) {
                                    echo number_format($data['order']['shipping_fee']) . '₫';
                                } else {
                                    echo 'Miễn phí';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="4" class="text-end">Tổng cộng:</td>
                            <td class="text-end"><?php echo number_format($data['order']['total_amount']); ?>₫</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <?php if (!empty($data['order']['order_notes'])): ?>
                <div class="mt-4">
                    <h6 class="fw-bold">Ghi chú:</h6>
                    <p><?php echo nl2br(htmlspecialchars($data['order']['order_notes'])); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Invoice Footer -->
        <div class="invoice-footer text-center">
            <p class="mb-1">Cảm ơn bạn đã mua hàng tại <?php echo $GLOBALS['site_info']['Company_name'] ?? 'MUJI Store'; ?>!</p>
            <p class="mb-0 small">Nếu có bất kỳ thắc mắc nào về đơn hàng, vui lòng liên hệ Hotline: <?php echo $GLOBALS['site_info']['hotline'] ?? '0123 456 789'; ?></p>
        </div>
    </div>
    
    <script>
        // Auto print when page loads (optional, uncomment if needed)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>