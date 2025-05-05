<?php

require_once __DIR__ . '/../models/SiteInfoModel.php';
$GLOBALS['site_info'] = SiteInfoModel::getAll();

require_once __DIR__ . '/../models/Product.php'; 

require_once __DIR__ . '/../models/SliderModel.php'; // Thêm dòng này
require_once __DIR__ . '/../config/config.php';      // Đảm bảo có kết nối DB

class HomeController {
    public function index() {
        
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;

        // Lấy danh sách ảnh từ DB
        $conn = $GLOBALS['conn'];
        $sliderModel = new SliderModel($conn);
        $slider_images = $sliderModel->getAll();
        $productModel = new Product($conn);

        $GLOBALS['featured_products'] = $productModel->getFeaturedProducts();
        $GLOBALS['new_products'] = $productModel->getNewProducts();
        $GLOBALS['bestseller_products'] = $productModel->getBestsellerProducts();


        $GLOBALS['slider_images'] = $slider_images; // Truyền qua view

        include __DIR__ . '/../views/home.php';
    }
}
