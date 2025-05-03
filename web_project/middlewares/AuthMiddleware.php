<?php
class AuthMiddleware {
    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     * 
     * @return bool True nếu đã đăng nhập, false nếu chưa
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user']);
    }
    
    /**
     * Yêu cầu đăng nhập để truy cập
     * 
     * @param string $redirectUrl URL để chuyển hướng sau khi đăng nhập
     */
    public static function requireLogin($redirectUrl = null) {
        if (!self::isLoggedIn()) {
            if ($redirectUrl) {
                $_SESSION['redirect_after_login'] = $redirectUrl;
            } else {
                $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            }
            
            $_SESSION['error_message'] = 'Vui lòng đăng nhập để tiếp tục';
            header('Location: index.php?action=login');
            exit;
        }
    }
    
    /**
     * Kiểm tra người dùng có phải là admin không
     * 
     * @return bool True nếu là admin, false nếu không phải
     */
    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION['user']['role'] === 'admin';
    }
    
    /**
     * Yêu cầu quyền admin để truy cập
     */
    public static function requireAdmin() {
        self::requireLogin();
        
        if (!self::isAdmin()) {
            $_SESSION['error_message'] = 'Bạn không có quyền truy cập trang này';
            header('Location: index.php');
            exit;
        }
    }
}
?>