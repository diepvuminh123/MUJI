<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/SliderModel.php';

class SliderController {
    private $model;

    public function __construct() {
        $conn = $GLOBALS['conn'];
        $this->model = new SliderModel($conn);
    }

    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['slider_image'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            $fileName = basename($_FILES['slider_image']['name']);
            $fullPath = $uploadDir . $fileName;

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $fullPath)) {
                $relativePath = 'uploads/' . $fileName;
                $this->model->insert($relativePath);
                return ['success' => true];
            } else {
                return ['error' => 'Không thể upload ảnh.'];
            }
        }
        return [];
    }
}
