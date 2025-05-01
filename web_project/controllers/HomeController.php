<?php
require_once __DIR__ . '/../models/SiteInfoModel.php';

class HomeController {
    public function index() {
        $site_info = SiteInfoModel::getAll();
        $GLOBALS['site_info'] = $site_info;
        include __DIR__ . '/../views/home.php';
    }
}
