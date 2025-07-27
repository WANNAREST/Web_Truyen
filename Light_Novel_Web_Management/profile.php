<?php
session_start();

// Lấy dữ liệu từ session
$username = htmlspecialchars($_SESSION['username']); // nếu có
$email = $_SESSION['email'] ?? '***@gmail.com'; // nếu có, nếu không thì hiển thị email ẩn
$join_date = $_SESSION['join_date'] ?? date('d/m/Y'); // nếu có
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/app.css">
</head>

<body>
    <!-- Header giống các trang khác -->
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
            </div>
        </nav>
    </header>
    <!-- End Header -->

    <main class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white">
                <h3>Thông tin tài khoản</h3>
            </div>
            <div class="card-body">
                <p><strong>Tên người dùng:</strong> <span id="username"><?= htmlspecialchars($username) ?></span></p>
                <p><strong>Email:</strong> <span id="email"><?= htmlspecialchars($email) ?></span></p>
                <p><strong>Ngày tham gia:</strong> <span id="join_date"><?= htmlspecialchars($join_date) ?></span></p>
            </div>
            <div class="card-footer text-end">
                <a href="edit_profile.php" class="btn btn-primary">Chỉnh sửa hồ sơ</a>
                <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Database Project. All rights reserved.</p>
    </footer>

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
</body>

</html>