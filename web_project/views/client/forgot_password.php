<?php 
// Set page title
$page_title = 'Quên mật khẩu';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Quên mật khẩu</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>
                    
                    <p class="mb-4">Vui lòng nhập địa chỉ email của bạn. Chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu.</p>
                    
                    <form action="index.php?action=process_forgot_password" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="index.php?action=login" class="text-decoration-none">Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>