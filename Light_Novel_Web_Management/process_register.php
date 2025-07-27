<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get form data
$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$verify_password = filter_input(INPUT_POST, 'verify_password');

// Validate inputs
$errors = [];

if (empty($username)) {
    $errors[] = "Username should not be empty";
}


if (empty($password)) {
    $errors[] = "Password should not be empty";
} elseif (strlen($password) < 8) {
    header("Location: register.php?error=mat_khau_qua_ngan");
    exit;
}

if (empty($verify_password)) {
    $errors[] = "Xác nhận mật khẩu không được để trống";
} elseif ($password !== $verify_password) {
    header("Location: register.php?error=loi_xac_nhan_mat_khau");
    exit;
}
if (empty($email)) {
    $errors[] = "Email should not be empty";
} elseif (strlen($email) > 50) {
    $errors[] = "Email should not exceed 50 characters";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Nếu có lỗi thì hiển thị và dừng xử lý
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    die();
}

// Database connection
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die('Cannot connect to database: ' . $conn->connect_error);
}

// Check if username already exists
$check_sql = "SELECT username FROM dang_ky WHERE username = ?";
$stmt = $conn->prepare($check_sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Nếu tên đăng nhập đã tồn tại
    header("Location: register.php?error=ten_dang_nhap_ton_tai");
    exit;
}
$stmt->close(); 
// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user with prepared statement
$insert_sql = "INSERT INTO dang_ky (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert_sql);
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    ?>
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='preconnect' href='https://fonts.googleapis.com/'>
        <link rel='preconnect' href='https://fonts.gstatic.com/' crossorigin=''>
        <link rel='stylesheet' href='./assets/bootstrap.min.css'>
        <link rel='stylesheet' href='./assets/app.css'>
        <title>Đăng ký thành công</title>
    </head>
    <body>
        <header class="header d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="./assets/images/logo_text.png" alt="Logo Suu Truyen" class="img-fluid" style="width: 200px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Trang chủ</a>
                        </li>
                        <!-- Thêm các mục menu khác nếu cần -->
                    </ul>
                </div>
                <div class="form-check form-switch me-3 d-flex align-items-center">
                        <label class="form-check-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-brightness-high" viewBox="0 0 16 16" style="fill: #fff;">
                                <path
                                    d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                                </path>
                            </svg>
                        </label>
                        <input class="form-check-input theme_mode" type="checkbox"
                            style="transform: scale(1.3); margin-left: 12px; margin-right: 12px;">

                        <label class="form-check-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 384 512"
                                style="fill: #fff;">
                                <path
                                    d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z">
                                </path>
                            </svg>
                        </label>
                    </div>
            </div>
        </nav>
    </header>
        <div class='container mt-5'>
            <div class='row justify-content-center'>
                <div class='col-md-6'>
                    <div class='card mt-5 shadow-lg'>
                        <div class='card-header text-center bg-dark text-white'>
                            <h3>Đăng ký thành công</h3>
                        </div>
                        <div class='card-body text-center'>
                            <p>Chào mừng, <strong><?php echo htmlspecialchars($username); ?></strong>! Tài khoản của bạn đã được tạo thành công.</p>
                            <a href='login.php' class='btn btn-primary w-100 py-2'>Đăng nhập ngay</a>
                        </div>
                        <div class='card-footer text-center'>
                            <a href='index.php' class='text-decoration-none text-dark'>Quay lại trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src='./assets/bootstrap.min.js'></script>
        <script src="./assets/jquery.min.js"></script>
        <script src="./assets/popper.min.js"></script>
        <script src="./assets/app.js"></script>
        <script src="./assets/common.js"></script>
    </body>
    </html>
    <?php
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>