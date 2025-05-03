<?php
class User {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Đăng nhập người dùng
     * 
     * @param string $username Tên đăng nhập
     * @param string $password Mật khẩu
     * @return array|bool Thông tin người dùng nếu đăng nhập thành công, false nếu thất bại
     */
    public function login($username, $password) {
        // Tìm người dùng theo username
        $sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'active' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Kiểm tra mật khẩu
            if (password_verify($password, $user['password'])) {
                // Loại bỏ mật khẩu trước khi trả về thông tin người dùng
                unset($user['password']);
                return $user;
            }
        }
        
        return false;
    }
    
    /**
     * Đăng ký người dùng mới
     * 
     * @param array $userData Thông tin người dùng
     * @return int|bool ID người dùng nếu đăng ký thành công, false nếu thất bại
     */
    public function register($userData) {
        // Kiểm tra xem username hoặc email đã tồn tại chưa
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $userData['username'], $userData['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return false; // Username hoặc email đã tồn tại
        }
        
        // Hash mật khẩu
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Thêm người dùng mới
        $sql = "INSERT INTO users (username, password, email, full_name, phone, address, role, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'user', 'active')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssss", 
            $userData['username'], 
            $hashedPassword, 
            $userData['email'], 
            $userData['full_name'], 
            $userData['phone'], 
            $userData['address']
        );
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        
        return false;
    }
    
    /**
     * Lấy thông tin người dùng theo ID
     * 
     * @param int $userId ID người dùng
     * @return array|bool Thông tin người dùng nếu tìm thấy, false nếu không tìm thấy
     */
    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            unset($user['password']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Cập nhật thông tin người dùng
     * 
     * @param int $userId ID người dùng
     * @param array $userData Thông tin cần cập nhật
     * @return bool True nếu cập nhật thành công, false nếu thất bại
     */
    public function updateUser($userId, $userData) {
        $sql = "UPDATE users SET ";
        $params = [];
        $types = "";
        
        foreach ($userData as $key => $value) {
            if ($key != 'id' && $key != 'password') {
                $sql .= "$key = ?, ";
                $params[] = $value;
                $types .= "s";
            }
        }
        
        // Xử lý riêng cho mật khẩu nếu có
        if (isset($userData['password']) && !empty($userData['password'])) {
            $sql .= "password = ?, ";
            $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
            $params[] = $hashedPassword;
            $types .= "s";
        }
        
        $sql .= "updated_at = NOW() WHERE id = ?";
        $params[] = $userId;
        $types .= "i";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        return $stmt->execute();
    }
    
    /**
     * Kiểm tra xem người dùng có phải là admin không
     * 
     * @param int $userId ID người dùng
     * @return bool True nếu là admin, false nếu không phải
     */
    public function isAdmin($userId) {
        $sql = "SELECT role FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            return $user['role'] === 'admin';
        }
        
        return false;
    }
}
?>