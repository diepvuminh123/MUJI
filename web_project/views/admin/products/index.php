<?php
// Show success or error messages if they exist
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success text-center fs-5" id="success-alert">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger text-center fs-5" id="error-alert">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Quản lý sản phẩm</h4>
                <a href="index.php?action=createProduct" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sản phẩm mới
                </a>
            </div>
            <div class="card-body">
                <!-- Search form -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form action="index.php" method="GET" class="d-flex">
                            <input type="hidden" name="action" value="adminProducts">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." 
                                       name="search" value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="mb-0">Tổng số: <strong><?php echo $data['totalProducts']; ?></strong> sản phẩm</p>
                    </div>
                </div>

                <!-- Products table -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Giá KM</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data['products'])): ?>
                                <tr>
                                    <td colspan="9" class="text-center">Không có sản phẩm nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['products'] as $product): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td>
                                            <?php if (!empty($product['primary_image'])): ?>
                                                <img src="<?php echo substr($product['primary_image'], 0, 1) === '/' ? $product['primary_image'] : '/'.$product['primary_image']; ?>" 
                                                     class="img-thumbnail" alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                                     style="max-width: 50px; max-height: 50px;">
                                            <?php else: ?>
                                                <img src="/MUJI/web_project/assets/images/no-image.jpg" class="img-thumbnail" alt="No image" 
                                                     style="max-width: 50px; max-height: 50px;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($product['name']); ?>
                                            <?php if ($product['featured'] == 1): ?>
                                                <span class="badge bg-warning">Nổi bật</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $product['category_name'] ?? '---'; ?></td>
                                        <td><?php echo number_format($product['price']); ?>₫</td>
                                        <td>
                                            <?php if (!empty($product['sale_price'])): ?>
                                                <?php echo number_format($product['sale_price']); ?>₫
                                            <?php else: ?>
                                                ---
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($product['quantity'] <= 0): ?>
                                                <span class="badge bg-danger">Hết hàng</span>
                                            <?php elseif ($product['quantity'] <= 5): ?>
                                                <span class="badge bg-warning"><?php echo $product['quantity']; ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?php echo $product['quantity']; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($product['status'] == 'active'): ?>
                                                <span class="badge bg-success">Đang bán</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Ẩn</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="index.php?action=editProduct&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>" class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="confirmDelete(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars(addslashes($product['name'])); ?>')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($data['totalPages'] > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?action=adminProducts&page=<?php echo $data['currentPage'] - 1; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?>">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            
                            <?php 
                            $startPage = max(1, $data['currentPage'] - 2);
                            $endPage = min($startPage + 4, $data['totalPages']);
                            
                            if ($endPage - $startPage < 4) {
                                $startPage = max(1, $endPage - 4);
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item <?php echo ($i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?action=adminProducts&page=<?php echo $i; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?action=adminProducts&page=<?php echo $data['currentPage'] + 1; ?><?php echo !empty($data['search']) ? '&search=' . urlencode($data['search']) : ''; ?>">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="product-name"></strong>?</p>
                <p class="text-danger">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" id="delete-link" class="btn btn-danger">Xóa</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto hide alerts after 5 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
    
    // Function to handle delete confirmation
    function confirmDelete(id, name) {
        document.getElementById('product-name').textContent = name;
        document.getElementById('delete-link').href = 'index.php?action=deleteProduct&id=' + id;
        
        // Show the modal
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>