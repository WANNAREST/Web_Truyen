<?php
session_start();

// Kiểm tra nếu quản trị viên chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

// Lấy dữ liệu từ session
$admin_username = htmlspecialchars($_SESSION['admin_username']); // Tên quản trị viên
$admin_email = $_SESSION['admin_email'] ?? 'admin@domain.com'; // Email quản trị viên (nếu có)
$admin_join_date = $_SESSION['admin_join_date'] ?? date('d/m/Y'); // Ngày tham gia (nếu có)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin quản trị viên</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/app.css">
</head>

<body>
    <!-- Header -->
    <header class="header d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
            <div class="container">
                <a class="navbar-brand" href="admin_dashboard.php">
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
                            <a class="nav-link" href="admin_dashboard.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user_management.php">Quản lý người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="story_list.php">Quản lý truyện</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->

    <main class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white">
                <h3>Thông tin quản trị viên</h3>
            </div>
            <div class="card-body">
                <p><strong>Tên quản trị viên:</strong> <span id="admin_username"><?= htmlspecialchars($admin_username) ?></span></p>
                <p><strong>Email:</strong> <span id="admin_email"><?= htmlspecialchars($admin_email) ?></span></p>
                <p><strong>Ngày tham gia:</strong> <span id="admin_join_date"><?= htmlspecialchars($admin_join_date) ?></span></p>
            </div>
            <div class="card-footer text-end">
                <a href="edit_admin_profile.php" class="btn btn-primary">Chỉnh sửa hồ sơ</a>
                <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Admin Dashboard. All rights reserved.</p>
    </footer>

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
</body>

</html>