<?php
// Start session
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy dữ liệu từ form
$admin_username = filter_input(INPUT_POST, 'username');
$admin_password = filter_input(INPUT_POST, 'password');
$admin_code = filter_input(INPUT_POST, 'admin_code');

if (!empty($admin_username) && !empty($admin_password) && !empty($admin_code)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "user_accounts";

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
    }

    // Mã xác thực quản trị viên cố định (có thể thay đổi)
    $required_admin_code = "ADMIN123";

    // Kiểm tra mã xác thực
    if ($admin_code !== $required_admin_code) {
        header("Location: login_admin.php?error=ma_xac_thuc_sai");
        exit;
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "SELECT admin_password FROM admin WHERE admin_username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Lỗi chuẩn bị câu lệnh: ' . $conn->error);
    }

    // Gắn tham số username
    $stmt->bind_param("s", $admin_username);
    // Thực thi câu lệnh và lấy kết quả
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['admin_password'];

        // Xác minh mật khẩu
        if (password_verify($admin_password, $hashed_password)) {
            $_SESSION['admin_username'] = $admin_username; // Lưu thông tin quản trị viên vào session
            header("Location: admin_dashboard.php"); // Chuyển hướng đến trang quản trị
            exit;
        } else {
            header("Location: login_admin.php?error=sai_mat_khau");
            exit;
        }
    } else {
        header("Location: login_admin.php?error=tai_khoan_khong_ton_tai");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Vui lòng nhập đầy đủ tên đăng nhập, mật khẩu và mã xác thực.";
}
?>