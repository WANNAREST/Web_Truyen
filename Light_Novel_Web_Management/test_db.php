<?php
$host = "127.0.0.1";
$user = "root";
$pass = ""; // hoặc mật khẩu nếu có

try {
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    echo "Kết nối thành công!";
    $conn->close();
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}
?>