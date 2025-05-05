</main>
    
    <!-- Footer -->
    <footer class="footer bg-dark text-white mt-5 pt-5 pb-3">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="mb-3">Về chúng tôi</h5>
                    <p class="text-muted">LMH E-commerce là cửa hàng trực tuyến hàng đầu cung cấp các sản phẩm chất lượng cao với giá cả phải chăng.</p>
                    <div class="d-flex mt-3">
                        <a href="#" class="me-3 text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3 text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3 text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="mb-3">Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/" class="text-muted text-decoration-none">Trang chủ</a></li>
                        <li class="mb-2"><a href="/products" class="text-muted text-decoration-none">Sản phẩm</a></li>
                        <li class="mb-2"><a href="/about" class="text-muted text-decoration-none">Giới thiệu</a></li>
                        <li class="mb-2"><a href="/contact" class="text-muted text-decoration-none">Liên hệ</a></li>
                        <li class="mb-2"><a href="/blog" class="text-muted text-decoration-none">Blog</a></li>
                    </ul>
                </div>
                
                <!-- Customer Service -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="mb-3">Dịch vụ khách hàng</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/account" class="text-muted text-decoration-none">Tài khoản của tôi</a></li>
                        <li class="mb-2"><a href="/cart" class="text-muted text-decoration-none">Giỏ hàng</a></li>
                        <li class="mb-2"><a href="/wishlist" class="text-muted text-decoration-none">Danh sách yêu thích</a></li>
                        <li class="mb-2"><a href="/terms" class="text-muted text-decoration-none">Điều khoản & điều kiện</a></li>
                        <li class="mb-2"><a href="/privacy" class="text-muted text-decoration-none">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="mb-3">Thông tin liên hệ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>  <?= $GLOBALS['site_info']['address'] ?? 'error' ?></li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> <?= $GLOBALS['site_info']['hotline'] ?? 'error' ?></li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> <?= $GLOBALS['site_info']['email'] ?? 'error' ?></li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Thứ 2 - Thứ 6: 8:00 - 20:00</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Thứ 7 - Chủ nhật: 8:00 - 18:00</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 bg-secondary">
            
            <!-- Bottom Footer -->
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> LMH E-commerce. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="payment-methods">
                        <span class="me-3 text-white"><i class="fab fa-cc-visa"></i></span>
                        <span class="me-3 text-white"><i class="fab fa-cc-mastercard"></i></span>
                        <span class="me-3 text-white"><i class="fab fa-cc-paypal"></i></span>
                        <span class="text-white"><i class="fab fa-cc-amex"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to top button -->
    <button id="back-to-top" class="btn btn-primary btn-sm rounded-circle position-fixed bottom-0 end-0 translate-middle d-none">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="/assets/js/main.js"></script>
    
    <!-- Page specific scripts -->
    <?php if (isset($pageScripts)): ?>
        <?php foreach ($pageScripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Back to top button script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var backToTopButton = document.getElementById('back-to-top');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('d-none');
                    backToTopButton.classList.add('d-block', 'm-5');
                } else {
                    backToTopButton.classList.remove('d-block', 'm-5');
                    backToTopButton.classList.add('d-none');
                }
            });
            
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
