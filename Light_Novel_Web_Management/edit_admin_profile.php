<?php
session_start();

// Kiểm tra nếu admin chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

// Lấy thông tin từ session
$admin_username = htmlspecialchars($_SESSION['admin_username']);
$admin_email = isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email']) : 'Không có email';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa hồ sơ quản trị viên</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/app.css">
</head>
<body>
     <!-- Header giống các trang khác -->
    <header class="header d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
            <div class="container">
                <a class="navbar-brand" href="admin_profile.php">
                    <img src="./assets/images/logo_text.png" alt="Logo Suu Truyen" class="img-fluid" style="width: 200px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin_profile.php">Thông tin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Đăng xuất</a>
                        </li>
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


    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white">
                        <h3>Chỉnh sửa hồ sơ quản trị viên</h3>
                    </div>
                    <div class="card-body">
                        <form action="process_edit_admin_profile.php" method="POST">
                            <div class="mb-4">
                                <label for="admin_username" class="form-label">Tên quản trị viên</label>
                                <input type="text" class="form-control" id="admin_username" name="admin_username" value="<?php echo $admin_username; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label for="admin_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?php echo $admin_email; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Nhập mật khẩu hiện tại" required>
                                <?php if (isset($_GET['error']) && $_GET['error'] === 'sai_mat_khau_hien_tai'): ?>
                                    <div class="text-danger mt-2">Mật khẩu hiện tại không đúng! Vui lòng nhập lại.</div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
                                <?php if (isset($_GET['error']) && $_GET['error'] === 'mat_khau_trong'): ?>
                                    <div class="text-danger mt-2">Mật khẩu mới không được để trống!</div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                                <?php if (isset($_GET['error']) && $_GET['error'] === 'mat_khau_khong_khop'): ?>
                                    <div class="text-danger mt-2">Xác nhận mật khẩu mới không khớp! Vui lòng thử lại.</div>
                                <?php elseif (isset($_GET['error']) && $_GET['error'] === 'mat_khau_moi_qua_ngan'): ?>
                                    <div class="text-danger mt-2">Mật khẩu mới phải ít nhất 8 ký tự!</div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-2">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </script>
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Database Project. All rights reserved.</p>
    </footer>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/popper.min.js"></script>
    <script src="./assets/app.js"></script>
    <script src="./assets/common.js"></script>
    <script src="./assets/bootstrap.min.js"></script>

    <script src="./assets/bootstrap.min.js"></script>
</body>
</html>