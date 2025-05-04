<?php
class Order {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Tạo đơn hàng mới từ giỏ hàng
     * 
     * @param int $cartId ID của giỏ hàng
     * @param array $orderData Thông tin đơn hàng
     * @return int|bool ID đơn hàng nếu thành công, false nếu thất bại
     */
    public function createFromCart($cartId, $orderData) {
        // Bắt đầu transaction
        $this->db->begin_transaction();
        
        try {
            // Lấy thông tin giỏ hàng
            $cartItems = $this->getCartItems($cartId);
            
            if (empty($cartItems)) {
                return false; // Giỏ hàng trống
            }
            
            // Tính tổng tiền đơn hàng
            $total = 0;
            $subtotal = 0;
            
            foreach ($cartItems as $item) {
                $subtotal += $item['current_price'] * $item['quantity'];
            }
            
            // Tính phí vận chuyển
            $shipping = $subtotal >= 500000 ? 0 : 30000;
            $total = $subtotal + $shipping;
            
            // Tạo đơn hàng mới
            $sql = "INSERT INTO orders (
                user_id, 
                order_code,
                customer_name, 
                customer_email, 
                customer_phone, 
                customer_address, 
                subtotal, 
                shipping_fee, 
                total_amount, 
                payment_method, 
                payment_status, 
                order_status, 
                order_notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Tạo mã đơn hàng
            $orderCode = 'ORD' . date('YmdHis') . rand(100, 999);
            
            $stmt = $this->db->prepare($sql);
            
            $userId = $orderData['user_id'] ?? null;
            $paymentStatus = 'pending';
            $orderStatus = 'pending';
            
            $stmt->bind_param(
                "isssssddsssss", 
                $userId, 
                $orderCode,
                $orderData['customer_name'], 
                $orderData['customer_email'], 
                $orderData['customer_phone'], 
                $orderData['customer_address'], 
                $subtotal, 
                $shipping, 
                $total, 
                $orderData['payment_method'], 
                $paymentStatus, 
                $orderStatus, 
                $orderData['order_notes']
            );
            
            $stmt->execute();
            $orderId = $this->db->insert_id;
            
            // Thêm các sản phẩm vào chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $sql = "INSERT INTO order_items (
                    order_id, 
                    product_id, 
                    product_name,
                    quantity, 
                    price,
                    subtotal
                ) VALUES (?, ?, ?, ?, ?, ?)";
                
                $stmt = $this->db->prepare($sql);
                $itemSubtotal = $item['current_price'] * $item['quantity'];
                
                $stmt->bind_param(
                    "iisidi", 
                    $orderId, 
                    $item['product_id'], 
                    $item['name'],
                    $item['quantity'], 
                    $item['current_price'],
                    $itemSubtotal
                );
                
                $stmt->execute();
                
                // Cập nhật số lượng sản phẩm
                $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ? AND quantity >= ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iii", $item['quantity'], $item['product_id'], $item['quantity']);
                $stmt->execute();
            }
            
            // Xóa giỏ hàng
            $sql = "DELETE FROM cart_items WHERE cart_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $cartId);
            $stmt->execute();
            
            // Commit transaction
            $this->db->commit();
            
            return $orderId;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->db->rollback();
            return false;
        }
    }
    
    /**
     * Lấy thông tin sản phẩm trong giỏ hàng
     * 
     * @param int $cartId ID của giỏ hàng
     * @return array Danh sách sản phẩm trong giỏ hàng
     */
    private function getCartItems($cartId) {
        $sql = "SELECT ci.*, p.name, p.slug, p.price, p.sale_price, p.quantity as stock
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.cart_id = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $cartId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            // Tính giá sản phẩm (nếu có giá khuyến mãi thì lấy giá khuyến mãi)
            if (!empty($row['sale_price']) && $row['sale_price'] < $row['price']) {
                $row['current_price'] = $row['sale_price'];
            } else {
                $row['current_price'] = $row['price'];
            }
            
            $items[] = $row;
        }
        
        return $items;
    }
    
    /**
     * Lấy thông tin đơn hàng theo ID
     * 
     * @param int $orderId ID của đơn hàng
     * @return array|bool Thông tin đơn hàng nếu tìm thấy, false nếu không tìm thấy
     */
    public function getOrderById($orderId) {
        $sql = "SELECT * FROM orders WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Lấy danh sách sản phẩm trong đơn hàng
     * 
     * @param int $orderId ID của đơn hàng
     * @return array Danh sách sản phẩm trong đơn hàng
     */
    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, 
                (SELECT image_path FROM product_images WHERE product_id = oi.product_id AND is_primary = 1 LIMIT 1) as image_path
                FROM order_items oi 
                WHERE oi.order_id = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
    }
    
    /**
     * Lấy danh sách đơn hàng của người dùng
     * 
     * @param int $userId ID của người dùng
     * @param int $limit Số lượng đơn hàng mỗi trang
     * @param int $offset Vị trí bắt đầu
     * @return array Danh sách đơn hàng
     */
    public function getOrdersByUser($userId, $limit = 10, $offset = 0) {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT ?, ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $userId, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        
        return $orders;
    }
    
    /**
     * Đếm tổng số đơn hàng của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return int Tổng số đơn hàng
     */
    public function countOrdersByUser($userId) {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    /**
     * Hủy đơn hàng
     * 
     * @param int $orderId ID của đơn hàng
     * @param int $userId ID của người dùng (để kiểm tra quyền)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function cancelOrder($orderId, $userId) {
        // Kiểm tra xem đơn hàng có thuộc về người dùng không
        $sql = "SELECT * FROM orders WHERE id = ? AND user_id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $orderId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false; // Đơn hàng không tồn tại hoặc không thuộc về người dùng
        }
        
        $order = $result->fetch_assoc();
        
        // Chỉ cho phép hủy đơn hàng khi trạng thái là 'pending' hoặc 'processing'
        if ($order['order_status'] !== 'pending' && $order['order_status'] !== 'processing') {
            return false;
        }
        
        // Bắt đầu transaction
        $this->db->begin_transaction();
        
        try {
            // Cập nhật trạng thái đơn hàng
            $sql = "UPDATE orders SET order_status = 'cancelled', updated_at = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            
            // Khôi phục số lượng sản phẩm
            $sql = "SELECT product_id, quantity FROM order_items WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($item = $result->fetch_assoc()) {
                $sql = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ii", $item['quantity'], $item['product_id']);
                $stmt->execute();
            }
            
            // Commit transaction
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->db->rollback();
            return false;
        }
    }
}
?>