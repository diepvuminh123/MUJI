<?php
class Cart {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Lấy giỏ hàng theo user_id hoặc session_id
     */
    public function getCart($userId = null, $sessionId = null) {
        // Nếu người dùng đã đăng nhập
        if ($userId) {
            $sql = "SELECT * FROM carts WHERE user_id = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $userId);
        } else {
            // Đối với khách
            $sql = "SELECT * FROM carts WHERE session_id = ? AND user_id IS NULL LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $sessionId);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Tạo giỏ hàng mới
     */
    public function createCart($userId = null, $sessionId = null) {
        $currentTime = date('Y-m-d H:i:s');
        
        if ($userId) {
            $sql = "INSERT INTO carts (user_id, session_id, created_at, updated_at) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("isss", $userId, $sessionId, $currentTime, $currentTime);
        } else {
            $sql = "INSERT INTO carts (session_id, created_at, updated_at) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $sessionId, $currentTime, $currentTime);
        }
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        
        return false;
    }
    
    /**
     * Lấy hoặc tạo giỏ hàng
     */
    public function getOrCreateCart($userId = null, $sessionId = null) {
        $cart = $this->getCart($userId, $sessionId);
        
        if (!$cart) {
            $cartId = $this->createCart($userId, $sessionId);
            
            if ($cartId) {
                $cart = [
                    'id' => $cartId,
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }
        
        return $cart;
    }
    
    /**
     * Thêm sản phẩm vào giỏ hàng hoặc cập nhật số lượng nếu đã tồn tại
     */
    public function addToCart($cartId, $productId, $quantity = 1) {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $sql = "SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $cartId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartItem = $result->fetch_assoc();
        
        // Kiểm tra sản phẩm còn tồn tại và còn hàng
        $sqlProduct = "SELECT * FROM products WHERE id = ? AND status = 'active' AND quantity > 0";
        $stmtProduct = $this->db->prepare($sqlProduct);
        $stmtProduct->bind_param("i", $productId);
        $stmtProduct->execute();
        $resultProduct = $stmtProduct->get_result();
        $product = $resultProduct->fetch_assoc();
        
        if (!$product) {
            return false; // Sản phẩm không tồn tại hoặc hết hàng
        }
        
        // Kiểm tra số lượng tối đa có thể thêm vào giỏ
        $maxQuantity = min($product['quantity'], 10); // Giới hạn tối đa 10 sản phẩm
        
        if ($cartItem) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ
            $newQuantity = min($cartItem['quantity'] + $quantity, $maxQuantity);
            
            $sql = "UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $newQuantity, $cartItem['id']);
        } else {
            // Thêm sản phẩm mới vào giỏ
            $newQuantity = min($quantity, $maxQuantity);
            
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("iii", $cartId, $productId, $newQuantity);
        }
        
        // Cập nhật thời gian cập nhật giỏ hàng
        if ($stmt->execute()) {
            $sql = "UPDATE carts SET updated_at = NOW() WHERE id = ?";
            $stmtUpdate = $this->db->prepare($sql);
            $stmtUpdate->bind_param("i", $cartId);
            $stmtUpdate->execute();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function updateCartItem($itemId, $quantity) {
        // Lấy thông tin cart_item và sản phẩm
        $sql = "SELECT ci.*, p.quantity as stock 
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        
        if (!$item) {
            return false; // Item không tồn tại
        }
        
        // Xóa item nếu số lượng = 0
        if ($quantity <= 0) {
            return $this->removeCartItem($itemId);
        }
        
        // Giới hạn số lượng tối đa
        $maxQuantity = min($item['stock'], 10);
        $quantity = min($quantity, $maxQuantity);
        
        // Cập nhật số lượng
        $sql = "UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $quantity, $itemId);
        
        if ($stmt->execute()) {
            // Cập nhật thời gian cập nhật giỏ hàng
            $sql = "UPDATE carts SET updated_at = NOW() WHERE id = ?";
            $stmtUpdate = $this->db->prepare($sql);
            $stmtUpdate->bind_param("i", $item['cart_id']);
            $stmtUpdate->execute();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeCartItem($itemId) {
        // Lấy thông tin cart_id
        $sql = "SELECT cart_id FROM cart_items WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        
        if (!$item) {
            return false;
        }
        
        // Xóa item
        $sql = "DELETE FROM cart_items WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $itemId);
        
        if ($stmt->execute()) {
            // Cập nhật thời gian cập nhật giỏ hàng
            $sql = "UPDATE carts SET updated_at = NOW() WHERE id = ?";
            $stmtUpdate = $this->db->prepare($sql);
            $stmtUpdate->bind_param("i", $item['cart_id']);
            $stmtUpdate->execute();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Xóa tất cả sản phẩm trong giỏ hàng
     */
    public function clearCart($cartId) {
        $sql = "DELETE FROM cart_items WHERE cart_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $cartId);
        
        if ($stmt->execute()) {
            // Cập nhật thời gian cập nhật giỏ hàng
            $sql = "UPDATE carts SET updated_at = NOW() WHERE id = ?";
            $stmtUpdate = $this->db->prepare($sql);
            $stmtUpdate->bind_param("i", $cartId);
            $stmtUpdate->execute();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Lấy danh sách sản phẩm trong giỏ hàng với thông tin chi tiết
     */
    public function getCartItems($cartId) {
        $sql = "SELECT ci.*, p.name, p.slug, p.price, p.sale_price, p.quantity as stock, 
                (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as image_path
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.cart_id = ? 
                ORDER BY ci.created_at DESC";
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
            
            // Tính tổng giá trị
            $row['total'] = $row['current_price'] * $row['quantity'];
            
            $items[] = $row;
        }
        
        return $items;
    }
    
    /**
     * Tính tổng số sản phẩm trong giỏ hàng
     */
    public function countCartItems($userId = null, $sessionId = null) {
        $cart = $this->getCart($userId, $sessionId);
        
        if (!$cart) {
            return 0;
        }
        
        $sql = "SELECT SUM(quantity) as total FROM cart_items WHERE cart_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $cart['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] ? (int)$row['total'] : 0;
    }
    
    /**
     * Tính tổng giá trị giỏ hàng
     */
    public function getCartTotal($cartId) {
        $items = $this->getCartItems($cartId);
        
        $subtotal = 0;
        $count = 0;
        
        foreach ($items as $item) {
            $subtotal += $item['total'];
            $count += $item['quantity'];
        }
        
        // Tính phí vận chuyển
        $shipping = 0;
        if ($subtotal > 0 && $subtotal < 500000) {
            $shipping = 30000; // Phí vận chuyển mặc định
        }
        
        $total = $subtotal + $shipping;
        
        return [
            'count' => $count,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total
        ];
    }
}
?>