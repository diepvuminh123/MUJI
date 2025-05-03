<?php
require_once __DIR__ . '/../models/ContactModel.php';

class ContactController {
    private $model;

    public function __construct($conn) {
        $this->model = new ContactModel($conn);
    }

    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($name && $email && $message) {
                $this->model->saveContactMessage($name, $email, $subject, $message);
                return ['success' => true];
            } else {
                return ['error' => 'Vui lòng điền đầy đủ thông tin bắt buộc.'];
            }
        }
        return [];
    }
}
?>
