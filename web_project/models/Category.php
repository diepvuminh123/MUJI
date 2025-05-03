<?php
class Category {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    // Get all categories
    public function getAllCategories() {
        require_once __DIR__ . '/../config/config.php';
        
        $sql = "SELECT * FROM categories ORDER BY parent_id ASC, name ASC";
        $result = $this->db->query($sql);
        
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        
        return $categories;
    }
}
?>