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
}
