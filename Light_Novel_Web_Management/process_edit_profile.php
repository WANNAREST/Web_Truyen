<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$old_username = $_SESSION['username'];
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$current_password = $_POST['current_password'];
$new_password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Lấy mật khẩu hiện tại từ DB
$sql = "SELECT password FROM dang_ky WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $old_username);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

// Kiểm tra mật khẩu hiện tại
if (!password_verify($current_password, $hashed_password)) {
    header("Location: edit_profile.php?error=sai_mat_khau_hien_tai");
    exit;
}
if (empty($new_password)) {
    header("Location: edit_profile.php?error=mat_khau_trong");
    exit;
}
if ($new_password !== $confirm_password) {
    header("Location: edit_profile.php?error=mat_khau_khong_khop");
    exit;
}
if (strlen($new_password) < 8) {
    header("Location: edit_profile.php?error=mat_khau_moi_qua_ngan");
    exit;
}
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Cập nhật thông tin
$sql = "UPDATE dang_ky SET username=?, email=?, password=? WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $new_hashed_password, $old_username);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    header("Location: profile.php?success=1");
    exit;
} else {
    header("Location: edit_profile.php?error=cap_nhat_that_bai");
    exit;
}
?>