<?php
class SiteInfoModel {
    public static function getAll() {
        require __DIR__ . '/../config/config.php'; // Tự khai báo $conn ở đây

        $query = "SELECT * FROM site_info";
        $result = mysqli_query($conn, $query);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[$row['key']] = $row['value'];
        }

        return $data;
    }
    public static function update($key, $value) {
        require __DIR__ . '/../config/config.php';
        $stmt = mysqli_prepare($conn, "INSERT INTO site_info (`key`, `value`)
            VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
        mysqli_stmt_bind_param($stmt, "ss", $key, $value);
        mysqli_stmt_execute($stmt);
    }
    
}
