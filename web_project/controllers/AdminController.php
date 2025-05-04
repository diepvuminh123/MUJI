<?php
require_once __DIR__ . '/../models/SiteInfoModel.php';
 
 class AdminController {
    public function showForm() {
        $GLOBALS['site_info'] = SiteInfoModel::getAll();
        include __DIR__ . '/../views/admin/site_info_form.php';
    }
    
    public function updateSiteInfo() {
        SiteInfoModel::update('address', $_POST['address']);
        header("Location: ?action=showSiteInfo");
    }
    
}