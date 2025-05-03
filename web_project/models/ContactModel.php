<?php
class ContactModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function saveContactMessage($name, $email, $subject, $message) {
        $stmt = $this->conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        return $stmt->execute();
    }
}
?>
