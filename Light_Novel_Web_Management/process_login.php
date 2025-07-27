<?php
session_start(); // Start session

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if (!empty($username) && !empty($password)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "user_accounts";

    // Create database connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "SELECT id, username, email, password FROM dang_ky WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['accountid'] = $row['id']; // Lưu ID người dùng
            $_SESSION['username'] = $row['username']; // Lưu đúng tên tài khoản từ DB
            $_SESSION['email'] = $row['email'];
            header("Location: index.php");
            exit;
        } else {
            header("Location: login.php?error=sai_mat_khau");
            exit;
        }
    } else {
        header("Location: login.php?error=tai_khoan_khong_ton_tai");
        exit;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Vui lòng nhập đầy đủ username và password.";
}
?>