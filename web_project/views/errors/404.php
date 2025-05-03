<?php
$pageTitle = '404 - Không tìm thấy trang';
include __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-template">
                <h1 class="display-1">404</h1>
                <h2 class="mb-4">Không tìm thấy trang</h2>
                <div class="error-details mb-4">
                    Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển.
                </div>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-home me-2"></i>Về trang chủ
                    </a>
                    <a href="/products" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-box me-2"></i>Xem sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>