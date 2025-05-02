<?php
$conn = mysqli_connect("localhost", "root", "", "muji_web", 3307);
if (!$conn) {
    die("Kết nối MySQL thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
$GLOBALS['conn'] = $conn;
?>
