<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy email từ form
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

if (!empty($email)) {
    // Kết nối cơ sở dữ liệu
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "user_accounts";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
    }

    // Kiểm tra email trong cơ sở dữ liệu
    $sql = "SELECT * FROM dang_ky WHERE email = '$email'";
    $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Nếu email tồn tại, xử lý gửi email khôi phục mật khẩu
        // (Ở đây chỉ hiển thị thông báo, bạn có thể tích hợp gửi email thực tế)
        echo "<script>alert('Yêu cầu khôi phục mật khẩu đã được gửi đến email của bạn!'); window.location.href='login.php';</script>";
    } else {
        // Nếu email không tồn tại
        echo "<script>alert('Email không tồn tại trong hệ thống!'); window.location.href='forgot_password.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Vui lòng nhập email!'); window.location.href='forgot_password.php';</script>";
}
?>