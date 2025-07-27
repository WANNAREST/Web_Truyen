<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['accountid'])) {
    header("Location: login.php?error=chua_dang_nhap");
    exit;
}

$userid = (int)$_SESSION['accountid'];
$truyenid = isset($_GET['truyenid']) ? (int)$_GET['truyenid'] : 0;

if ($truyenid > 0) {
    // Kết nối CSDL
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "user_accounts";
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
    }

    // Xóa truyện khỏi fav_book
    $stmt = $conn->prepare("DELETE FROM fav_book WHERE userid = ? AND truyenid = ?");
    $stmt->bind_param("ii", $userid, $truyenid);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Quay lại trang danh sách ưa thích
header("Location: fav_book.php");
exit;