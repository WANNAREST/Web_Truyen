<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
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

// Lấy dữ liệu từ form
$user_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if (!$user_id || !$username || !$email) {
    header("Location: edit_user.php?id=$user_id&error=thieu_du_lieu");
    exit;
}

// Cập nhật thông tin người dùng
$sql = "UPDATE dang_ky SET username = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("ssi", $username, $email, $user_id);

if ($stmt->execute()) {
    header("Location: user_management.php?success=cap_nhat_thanh_cong");
    exit;
} else {
    header("Location: edit_user.php?id=$user_id&error=loi_cap_nhat");
    exit;
}

$stmt->close();
$conn->close();
?>