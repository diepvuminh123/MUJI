<?php 
// Kiểm tra quyền admin
require_once __DIR__ . '/../../middlewares/AuthMiddleware.php';
AuthMiddleware::requireAdmin();

// Set page title
$page_title = 'Bảng điều khiển quản trị';

// Include header template
include __DIR__ . '/../Template/Header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Quản trị hệ thống</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="index.php?action=admin_dashboard" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i> Tổng quan
                    </a>
                    <a href="index.php?action=admin_products" class="list-group-item list-group-item-action">
                        <i class="fas fa-box me-2"></i> Quản lý sản phẩm
                    </a>
                    <a href="index.php?action=admin_categories" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Quản lý danh mục
                    </a>
                    <a href="index.php?action=admin_orders" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart me-2"></i> Quản lý đơn hàng
                    </a>
                    <a href="index.php?action=admin_users" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Quản lý người dùng
                    </a>
                    <a href="index.php?action=admin_settings" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Cài đặt hệ thống
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Main content -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tổng quan hệ thống</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Tổng sản phẩm</h6>
                                            <h2 class="mb-0">150</h2>
                                        </div>
                                        <i class="fas fa-box fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Đơn hàng mới</h6>
                                            <h2 class="mb-0">10</h2>
                                        </div>
                                        <i class="fas fa-shopping-cart fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Người dùng</h6>
                                            <h2 class="mb-0">42</h2>
                                        </div>
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent orders -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Đơn hàng gần đây</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD001</td>
                                        <td>Nguyễn Văn A</td>
                                        <td>01/05/2023</td>
                                        <td>1,500,000₫</td>
                                        <td><span class="badge bg-success">Đã thanh toán</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD002</td>
                                        <td>Trần Thị B</td>
                                        <td>02/05/2023</td>
                                        <td>800,000₫</td>
                                        <td><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD003</td>
                                        <td>Lê Văn C</td>
                                        <td>03/05/2023</td>
                                        <td>2,100,000₫</td>
                                        <td><span class="badge bg-danger">Đã hủy</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../Template/Footer.php'; ?>