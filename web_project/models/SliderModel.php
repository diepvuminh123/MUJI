<?php
class SliderModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($imagePath) {
        $stmt = $this->conn->prepare("INSERT INTO sliders (image_path) VALUES (?)");
        $stmt->bind_param("s", $imagePath);
        return $stmt->execute();
    }
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM sliders ORDER BY id DESC LIMIT 5");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}
