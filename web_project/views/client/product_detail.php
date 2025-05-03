<?php 
// Set page title based on product name
$page_title = isset($data['product']['name']) ? $data['product']['name'] : 'Chi tiết sản phẩm';

// Include header template
include  __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <!-- Product details -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Product images -->
                <div class="col-md-6 mb-4">
                    <?php if (!empty($data['images'])): ?>
                        <img src="<?php echo $data['images'][0]['image_path']; ?>" 
                             class="img-fluid rounded" alt="<?php echo htmlspecialchars($data['product']['name'] ?? ''); ?>">
                    <?php else: ?>
                        <img src="assets/images/no-image.jpg" class="img-fluid rounded" alt="No image available">
                    <?php endif; ?>
                </div>
                
                <!-- Product info -->
                <div class="col-md-6">
                    <h2 class="mb-3"><?php echo htmlspecialchars($data['product']['name'] ?? ''); ?></h2>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary"><?php echo htmlspecialchars($data['product']['category_name'] ?? ''); ?></span>
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        <?php if (!empty($data['product']['sale_price']) && $data['product']['sale_price'] < $data['product']['price']): ?>
                            <div class="d-flex align-items-center">
                                <span class="h3 text-danger fw-bold me-3"><?php echo number_format($data['product']['sale_price']); ?>₫</span>
                                <span class="h5 text-muted text-decoration-line-through"><?php echo number_format($data['product']['price']); ?>₫</span>
                            </div>
                        <?php elseif (isset($data['product']['price'])): ?>
                            <span class="h3 fw-bold"><?php echo number_format($data['product']['price']); ?>₫</span>
                        <?php else: ?>
                            <span class="h3 fw-bold">Giá: Liên hệ</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Availability -->
                    <div class="mb-4">
                        <?php if (isset($data['product']['quantity']) && $data['product']['quantity'] > 0): ?>
                            <span class="text-success"><i class="fas fa-check-circle"></i> Còn hàng</span>
                        <?php else: ?>
                            <span class="text-danger"><i class="fas fa-times-circle"></i> Hết hàng</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h5>Mô tả sản phẩm:</h5>
                        <div><?php echo $data['product']['description'] ?? 'Không có thông tin mô tả.'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related products -->
    <?php if (!empty($data['relatedProducts'])): ?>
        <h3 class="mb-3">Sản phẩm liên quan</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($data['relatedProducts'] as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>">
                            <img src="<?php echo !empty($product['primary_image']) ? $product['primary_image'] : 'assets/images/no-image.jpg'; ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>" class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h6>
                            <div>
                                <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                                    <span class="text-danger fw-bold me-2"><?php echo number_format($product['sale_price']); ?>₫</span>
                                    <span class="text-muted text-decoration-line-through"><?php echo number_format($product['price']); ?>₫</span>
                                <?php else: ?>
                                    <span class="fw-bold"><?php echo number_format($product['price']); ?>₫</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include  __DIR__ . '/../Template/Footer.php'; ?>