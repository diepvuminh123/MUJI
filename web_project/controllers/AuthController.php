<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../models/SiteInfoModel.php';

class AuthController {
    private $db;
    private $userModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
        
        // Đảm bảo session đã được khởi tạo
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Hiển thị trang đăng nhập
     */
    public function showLoginForm() {
        // Nếu đã đăng nhập, chuyển hướng đến trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit;
        }
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Load view
        require_once __DIR__ . '/../views/client/login.php';
    }
    
    /**
     * Xử lý đăng nhập
     */
    public function processLogin() {
        // Kiểm tra nếu là yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=login');
            exit;
        }
        
        // Lấy dữ liệu đăng nhập
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']);
        
        // Validate dữ liệu
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Vui lòng nhập tên đăng nhập hoặc email';
        }
        
        if (empty($password)) {
            $errors[] = 'Vui lòng nhập mật khẩu';
        }
        
        // Nếu có lỗi, hiển thị lại form đăng nhập kèm thông báo lỗi
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            header('Location: index.php?action=login');
            exit;
        }
        
        // Đăng nhập
        $user = $this->userModel->login($username, $password);
        
        if ($user) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            
            // Xử lý "Remember me"
            if ($rememberMe) {
                $this->setRememberMeCookie($user['id']);
            }
            
            // Chuyển hướng đến trang tương ứng với vai trò
            if ($user['role'] === 'admin') {
                $_SESSION['success_message'] = 'Đăng nhập thành công! Chào mừng quản trị viên quay trở lại.';
                header('Location: index.php?action=admin');
            } else {
                $_SESSION['success_message'] = 'Đăng nhập thành công!';
                header('Location: index.php');
            }
            exit;
        } else {
            // Đăng nhập thất bại
            $_SESSION['error_message'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
            header('Location: index.php?action=login');
            exit;
        }
    }
    
    /**
     * Hiển thị trang đăng ký
     */
    public function showRegisterForm() {
        // Nếu đã đăng nhập, chuyển hướng đến trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit;
        }
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Load view
        require_once __DIR__ . '/../views/client/register.php';
    }
    
    /**
     * Xử lý đăng ký
     */
    public function processRegister() {
        // Kiểm tra nếu là yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=register');
            exit;
        }
        
        // Lấy dữ liệu đăng ký
        $userData = [
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
            'email' => $_POST['email'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ?? ''
        ];
        
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate dữ liệu
        $errors = [];
        
        if (empty($userData['username'])) {
            $errors[] = 'Vui lòng nhập tên đăng nhập';
        } elseif (strlen($userData['username']) < 4) {
            $errors[] = 'Tên đăng nhập phải có ít nhất 4 ký tự';
        }
        
        if (empty($userData['password'])) {
            $errors[] = 'Vui lòng nhập mật khẩu';
        } elseif (strlen($userData['password']) < 6) {
            $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }
        
        if ($userData['password'] !== $confirmPassword) {
            $errors[] = 'Xác nhận mật khẩu không khớp';
        }
        
        if (empty($userData['email'])) {
            $errors[] = 'Vui lòng nhập email';
        } elseif (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        }
        
        if (empty($userData['full_name'])) {
            $errors[] = 'Vui lòng nhập họ và tên';
        }
        
        // Nếu có lỗi, hiển thị lại form đăng ký kèm thông báo lỗi
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            $_SESSION['register_form_data'] = $userData;
            header('Location: index.php?action=register');
            exit;
        }
        
        // Đăng ký
        $userId = $this->userModel->register($userData);
        
        if ($userId) {
            // Đăng ký thành công
            $_SESSION['success_message'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            header('Location: index.php?action=login');
            exit;
        } else {
            // Đăng ký thất bại
            $_SESSION['error_message'] = 'Tên đăng nhập hoặc email đã tồn tại';
            $_SESSION['register_form_data'] = $userData;
            header('Location: index.php?action=register');
            exit;
        }
    }
    
    /**
     * Đăng xuất
     */
    public function logout() {
        // Xóa cookie "Remember me"
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }
        
        // Xóa session
        session_unset();
        session_destroy();
        
        // Chuyển hướng đến trang đăng nhập
        header('Location: index.php?action=login');
        exit;
    }
    
    /**
     * Thiết lập cookie "Remember me"
     * 
     * @param int $userId ID người dùng
     */
    private function setRememberMeCookie($userId) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + 30 * 24 * 60 * 60; // 30 ngày
        
        // Lưu token vào cơ sở dữ liệu
        $sql = "INSERT INTO user_tokens (user_id, token, expires) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $expiresDate = date('Y-m-d H:i:s', $expires);
        $stmt->bind_param("iss", $userId, $token, $expiresDate);
        $stmt->execute();
        
        // Thiết lập cookie
        setcookie('remember_user', $token, $expires, '/');
    }
    
    /**
     * Kiểm tra cookie "Remember me" và đăng nhập tự động
     */
    public function checkRememberMe() {
        // Nếu đã đăng nhập, không cần kiểm tra
        if (isset($_SESSION['user'])) {
            return;
        }
        
        // Kiểm tra nếu có cookie "Remember me"
        if (isset($_COOKIE['remember_user'])) {
            $token = $_COOKIE['remember_user'];
            
            // Tìm token trong cơ sở dữ liệu
            $sql = "SELECT u.* FROM users u 
                    JOIN user_tokens t ON u.id = t.user_id 
                    WHERE t.token = ? AND t.expires > NOW() AND u.status = 'active' 
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Xóa mật khẩu trước khi lưu vào session
                unset($user['password']);
                
                // Lưu thông tin người dùng vào session
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                
                // Cập nhật token
                $this->setRememberMeCookie($user['id']);
            }
        }
    }
    
    /**
     * Hiển thị trang quên mật khẩu
     */
    public function showForgotPasswordForm() {
        // Nếu đã đăng nhập, chuyển hướng đến trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit;
        }
        
        // Lấy thông tin site
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        
        // Load view
        require_once __DIR__ . '/../views/client/forgot_password.php';
    }
    
    /**
     * Xử lý yêu cầu đặt lại mật khẩu
     */
    public function processForgotPassword() {
        // Kiểm tra nếu là yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=forgot_password');
            exit;
        }
        
        // Lấy email
        $email = $_POST['email'] ?? '';
        
        // Validate email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = 'Vui lòng nhập email hợp lệ';
            header('Location: index.php?action=forgot_password');
            exit;
        }
        
        // Tìm người dùng theo email
        $sql = "SELECT * FROM users WHERE email = ? AND status = 'active' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // Không tìm thấy email
            $_SESSION['error_message'] = 'Không tìm thấy tài khoản với email này';
            header('Location: index.php?action=forgot_password');
            exit;
        }
        
        $user = $result->fetch_assoc();
        
        // Tạo token đặt lại mật khẩu
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 24 * 60 * 60); // 24 giờ
        
        // Lưu token vào cơ sở dữ liệu
        $sql = "INSERT INTO password_resets (user_id, token, expires) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iss", $user['id'], $token, $expires);
        $stmt->execute();
        
        // Gửi email đặt lại mật khẩu
        // (Trong thực tế, bạn sẽ tích hợp với dịch vụ gửi email)
        $resetLink = "http://yourdomain.com/index.php?action=reset_password&token=$token";
        $message = "Chào " . $user['full_name'] . ",\n\n";
        $message .= "Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình. Vui lòng nhấp vào liên kết sau để đặt lại mật khẩu:\n\n";
        $message .= $resetLink . "\n\n";
        $message .= "Liên kết này sẽ hết hạn sau 24 giờ.\n\n";
        $message .= "Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.\n\n";
        $message .= "Trân trọng,\n";
        $message .= "Đội ngũ " . ($GLOBALS['site_info']['company_name'] ?? 'Website');
        
        // Thông báo đã gửi email
        $_SESSION['success_message'] = 'Chúng tôi đã gửi email hướng dẫn đặt lại mật khẩu cho bạn. Vui lòng kiểm tra hộp thư đến của bạn.';
        header('Location: index.php?action=login');
        exit;
    }
}
?>