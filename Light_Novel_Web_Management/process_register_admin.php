<?php
// Start session
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get form data
$admin_username = filter_input(INPUT_POST, 'username');
$admin_password = filter_input(INPUT_POST, 'password');
$verify_admin_password = filter_input(INPUT_POST, 'verify_password');
$verify_admin_code = filter_input(INPUT_POST, 'admin_code');

// Validate inputs
$errors = [];

// Kiểm tra tên đăng nhập
if (empty($admin_username)) {
    $errors[] = "Tên đăng nhập không được để trống.";
}

// Kiểm tra mật khẩu
if (empty($admin_password)) {
    $errors[] = "Mật khẩu không được để trống.";
} elseif (strlen($admin_password) < 8) {
    $errors[] = "Mật khẩu phải có ít nhất 8 ký tự.";
}

// Kiểm tra xác nhận mật khẩu
if (empty($verify_admin_password)) {
    $errors[] = "Xác nhận mật khẩu không được để trống.";
} elseif ($admin_password !== $verify_admin_password) {
    $errors[] = "Mật khẩu và xác nhận mật khẩu không khớp.";
}

// Kiểm tra mã xác thực quản trị viên
$required_admin_code = "ADMIN123"; // Mã xác thực cố định (có thể thay đổi)
if (empty($verify_admin_code)) {
    $errors[] = "Mã xác thực không được để trống.";
} elseif ($verify_admin_code !== $required_admin_code) {
    $errors[] = "Mã xác thực không đúng.";
}

// Nếu có lỗi, hiển thị và dừng xử lý
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    die();
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

// Kiểm tra xem tên đăng nhập đã tồn tại chưa
$check_sql = "SELECT admin_username FROM admin WHERE admin_username = ?";
$stmt = $conn->prepare($check_sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Nếu tên đăng nhập đã tồn tại
    header("Location: register_admin.php?error=ten_dang_nhap_ton_tai");
    exit;
}
$stmt->close();

// Mã hóa mật khẩu
$hashed_admin_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Thêm quản trị viên mới vào cơ sở dữ liệu
$insert_sql = "INSERT INTO admin (admin_username, admin_password) VALUES (?, ?)";
$stmt = $conn->prepare($insert_sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("ss", $admin_username, $hashed_admin_password);

if ($stmt->execute()) {
    ?>
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' href='./assets/bootstrap.min.css'>
        <link rel='stylesheet' href='./assets/app.css'>
        <title>Đăng ký quản trị viên thành công</title>
    </head>
    <body>
        <div class='container mt-5'>
            <div class='row justify-content-center'>
                <div class='col-md-6'>
                    <div class='card mt-5 shadow-lg'>
                        <div class='card-header text-center bg-dark text-white'>
                            <h3>Đăng ký thành công</h3>
                        </div>
                        <div class='card-body text-center'>
                            <p>Chào mừng, <strong><?php echo htmlspecialchars($admin_username); ?></strong>! Tài khoản quản trị viên của bạn đã được tạo thành công.</p>
                            <a href='login_admin.php' class='btn btn-primary w-100 py-2'>Đăng nhập ngay</a>
                        </div>
                        <div class='card-footer text-center'>
                            <a href='index.php' class='text-decoration-none text-dark'>Quay lại trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src='./assets/bootstrap.min.js'></script>
    </body>
    </html>
    <?php
} else {
    echo "Lỗi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>