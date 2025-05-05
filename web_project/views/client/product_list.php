<?php 
// Set page title
$page_title = 'Danh sách sản phẩm';

// Include header template
include  __DIR__ . '/../Template/Header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar with categories -->
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Danh mục sản phẩm</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="index.php?action=products" class="text-decoration-none <?php echo empty($category) ? 'fw-bold' : ''; ?>">
                                Tất cả sản phẩm
                            </a>
                        </li>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <li class="mb-2">
                                    <a href="index.php?action=products&category=<?php echo $cat['id']; ?>" 
                                    class="text-decoration-none <?php echo ($category == $cat['id']) ? 'fw-bold' : ''; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Product listing -->
        <div class="col-lg-9">
            <!-- Search bar -->
            <!-- Thêm bộ lọc dưới thanh search hiện tại -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="index.php" method="GET" class="d-flex flex-column">
                        <input type="hidden" name="action" value="products">
                        <?php if (!empty($category)): ?>
                            <input type="hidden" name="category" value="<?php echo $category; ?>">
                        <?php endif; ?>
                        <?php if (!empty($search)): ?>
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <?php endif; ?>
                        
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="sort" class="form-label">Sắp xếp theo:</label>
                                <select name="sort" id="sort" class="form-select">
                                    <option value="">Mặc định</option>
                                    <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                                    <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                                    <option value="name_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : ''; ?>>Tên: A đến Z</option>
                                    <option value="name_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : ''; ?>>Tên: Z đến A</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="sale" class="form-label">Trạng thái:</label>
                                <select name="sale" id="sale" class="form-select">
                                    <option value="">Tất cả sản phẩm</option>
                                    <option value="1" <?php echo (isset($_GET['sale']) && $_GET['sale'] == '1') ? 'selected' : ''; ?>>Sản phẩm đang giảm giá</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter"></i> Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Products grid -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php if (empty($products)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            Không tìm thấy sản phẩm nào.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col">
                            <div class="card h-100 product-card">
                                <!-- Product image -->
                                <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>">
                                    <!-- <img src="<?php echo !empty($product['primary_image']) ? $product['primary_image'] : 'assets/images/no-image.jpg'; ?>"  -->
                                    <img src="<?php echo !empty($product['primary_image']) ? 
                    (substr($product['primary_image'], 0, 1) === '/' ? $product['primary_image'] : '/'.$product['primary_image']) : 
                    '/MUJI/web_project/assets/images/no-image.jpg';  ?>" 
                                         class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </a>
                                
                                <div class="card-body">
                                    <!-- Product name -->
                                    <h5 class="card-title">
                                        <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h5>
                                    
                                    <!-- Price -->
                                    <div class="mb-2">
                                        <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                                            <span class="text-danger fw-bold me-2"><?php echo number_format($product['sale_price']); ?>₫</span>
                                            <span class="text-muted text-decoration-line-through"><?php echo number_format($product['price']); ?>₫</span>
                                        <?php else: ?>
                                            <span class="fw-bold"><?php echo number_format($product['price']); ?>₫</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-white">
                                    <a href="index.php?action=product&slug=<?php echo $product['slug']; ?>" class="btn btn-sm btn-outline-primary w-100">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?action=products&page=<?php echo $i; ?>
                                    <?php echo !empty($category) ? '&category='.$category : ''; ?>
                                    <?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>
                                    <?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>
                                    <?php echo isset($_GET['sale']) ? '&sale='.$_GET['sale'] : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include  __DIR__ . '/../Template/Footer.php'; ?>