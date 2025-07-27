<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

// Lấy ID người dùng từ URL
$user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$user_id) {
    header("Location: user_management.php?error=id_khong_hop_le");
    exit;
}

// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Xóa người dùng khỏi cơ sở dữ liệu
$sql = "DELETE FROM dang_ky WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: user_management.php?success=xoa_nguoi_dung_thanh_cong");
    exit;
} else {
    header("Location: user_management.php?error=loi_xoa_nguoi_dung");
    exit;
}

$stmt->close();
$conn->close();
?>