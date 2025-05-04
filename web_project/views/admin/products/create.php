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
                <h4 class="card-title">Thêm sản phẩm mới</h4>
                <a href="admin.php?action=adminProducts" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
            <div class="card-body">
                <!-- Error messages -->
                <?php if (!empty($data['errors'])): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($data['errors'] as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <!-- Create product form -->
                <form action="admin.php?action=createProduct" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="<?php echo isset($data['formData']['name']) ? htmlspecialchars($data['formData']['name']) : ''; ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($data['categories'] as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" 
                                                <?php echo (isset($data['formData']['category_id']) && $data['formData']['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="price" name="price" required min="0" step="1000"
                                                   value="<?php echo isset($data['formData']['price']) ? htmlspecialchars($data['formData']['price']) : ''; ?>">
                                            <span class="input-group-text">₫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="sale_price" class="form-label">Giá khuyến mãi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="sale_price" name="sale_price" min="0" step="1000"
                                                   value="<?php echo isset($data['formData']['sale_price']) ? htmlspecialchars($data['formData']['sale_price']) : ''; ?>">
                                            <span class="input-group-text">₫</span>
                                        </div>
                                        <small class="text-muted">Để trống nếu không có khuyến mãi</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="quantity" class="form-label">Số lượng trong kho <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required min="0"
                                       value="<?php echo isset($data['formData']['quantity']) ? htmlspecialchars($data['formData']['quantity']) : '0'; ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Mô tả sản phẩm <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="6" required><?php echo isset($data['formData']['description']) ? htmlspecialchars($data['formData']['description']) : ''; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Product Status -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title">Trạng thái</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Trạng thái sản phẩm</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="active" <?php echo (isset($data['formData']['status']) && $data['formData']['status'] == 'active') ? 'selected' : ''; ?>>
                                                Đang bán
                                            </option>
                                            <option value="inactive" <?php echo (isset($data['formData']['status']) && $data['formData']['status'] == 'inactive') ? 'selected' : ''; ?>>
                                                Ẩn
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                               <?php echo (isset($data['formData']['featured']) && $data['formData']['featured'] == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="featured">
                                            Sản phẩm nổi bật
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Product Images -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Hình ảnh sản phẩm</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tải lên hình ảnh</label>
                                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                                        <small class="text-muted">Có thể chọn nhiều ảnh. Ảnh đầu tiên sẽ là ảnh chính.</small>
                                    </div>
                                    
                                    <div class="image-preview mt-3" id="image-preview">
                                        <div class="text-center text-muted">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <p>Hình ảnh sẽ được hiển thị ở đây</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='admin.php?action=adminProducts'">
                                <i class="fas fa-times"></i> Hủy
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu sản phẩm
                            </button>
                        </div>
                    </div>
                </form>
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
    
    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.querySelector('input[name="images[]"]');
        const imagePreview = document.getElementById('image-preview');
        
        imageInput.addEventListener('change', function() {
            // Clear preview
            imagePreview.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                const previewContainer = document.createElement('div');
                previewContainer.className = 'row g-2';
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        continue;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6';
                        
                        const imageContainer = document.createElement('div');
                        imageContainer.className = 'border rounded p-1 mb-2';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-fluid';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        
                        imageContainer.appendChild(img);
                        col.appendChild(imageContainer);
                        previewContainer.appendChild(col);
                    };
                    
                    reader.readAsDataURL(file);
                }
                
                imagePreview.appendChild(previewContainer);
            } else {
                imagePreview.innerHTML = `
                    <div class="text-center text-muted">
                        <i class="fas fa-image fa-3x mb-2"></i>
                        <p>Hình ảnh sẽ được hiển thị ở đây</p>
                    </div>
                `;
            }
        });
    });
</script>