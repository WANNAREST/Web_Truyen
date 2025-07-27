<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

$old_admin_username = $_SESSION['admin_username'];
$admin_username = trim($_POST['admin_username']);
$admin_email = trim($_POST['admin_email']);
$current_password = $_POST['current_password'];
$new_password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Kết nối CSDL
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Lấy mật khẩu hiện tại từ DB
$sql = "SELECT admin_password FROM admin WHERE admin_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $old_admin_username);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

// Kiểm tra mật khẩu hiện tại
if (!password_verify($current_password, $hashed_password)) {
    header("Location: edit_admin_profile.php?error=sai_mat_khau_hien_tai");
    exit;
}
if (empty($new_password)) {
    header("Location: edit_admin_profile.php?error=mat_khau_trong");
    exit;
}
if ($new_password !== $confirm_password) {
    header("Location: edit_admin_profile.php?error=mat_khau_khong_khop");
    exit;
}
if (strlen($new_password) < 8) {
    header("Location: edit_admin_profile.php?error=mat_khau_moi_qua_ngan");
    exit;
}
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Cập nhật thông tin
$sql = "UPDATE admin SET admin_username=?, admin_email=?, admin_password=? WHERE admin_username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $admin_username, $admin_email, $new_hashed_password, $old_admin_username);

if ($stmt->execute()) {
    $_SESSION['admin_username'] = $admin_username;
    $_SESSION['admin_email'] = $admin_email;
    header("Location: admin_profile.php?success=1");
    exit;
} else {
    header("Location: edit_admin_profile.php?error=cap_nhat_that_bai");
    exit;
}
?>