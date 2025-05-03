<?php
class ArticleModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllArticles() {
        $sql = "SELECT * FROM articles ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $sql);
    
        if (!$result) {
            die("Lỗi truy vấn SQL: " . mysqli_error($this->conn));
        }
    
        return $result;
    }
    
    
    public function getArticleById($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "SELECT * FROM articles WHERE id = $id LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}
?>
