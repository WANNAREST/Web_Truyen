<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://suustore.com/assets/frontend/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/app.css">
    <title>Login Admin</title>
</head>

<body>
    <!-- Header -->
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 shadow-lg">
                        <div class="card-header text-center bg-dark text-white">
                            <h3>Đăng nhập quản trị viên</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="process_login_admin.php">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <!-- Icon con mắt -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM8 13c-3.866 0-7-4-7-5s3.134-5 7-5 7 4 7 5-3.134 5-7 5z"/>
                                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="admin_code" class="form-label">Mã xác thực quản trị viên</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="admin_code" name="admin_code" placeholder="Nhập mã xác thực" required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleAdminCode">
                                            <!-- Icon con mắt -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM8 13c-3.866 0-7-4-7-5s3.134-5 7-5 7 4 7 5-3.134 5-7 5z"/>
                                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Hiển thị thông báo lỗi -->
                                    <?php if (isset($_GET['error']) && $_GET['error'] === 'ma_xac_thuc_sai'): ?>
                                        <div class="text-danger mt-2">Mã xác thực không đúng!</div>
                                    <?php endif; ?>
                                    <!-- Hiển thị thông báo lỗi -->
                                    <?php if (isset($_GET['error']) && $_GET['error'] === 'sai_mat_khau'): ?>
                                        <div class="text-danger mt-2">Sai mật khẩu!</div>
                                    <?php endif; ?>
                                    <?php if (isset($_GET['error']) && $_GET['error'] === 'tai_khoan_khong_ton_tai'): ?>
                                        <div class="text-danger mt-2">Tài khoản không tồn tại!</div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 py-2">Đăng nhập</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <a href="register_admin.php" class="text-decoration-none text-dark">Chưa có tài khoản? <strong>Đăng ký ngay</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <div id="footer" class="footer border-top pt-2">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <strong>Suu Truyện</strong> - <a title="Đọc truyện online" class="text-dark text-decoration-none" href="#">Đọc truyện</a> online một cách nhanh nhất.
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/popper.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
    <script src="./assets/app.js"></script>
    <script src="./assets/common.js"></script>
    <script>
        // Xử lý nút "icon con mắt" để hiển thị/ẩn mật khẩu
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Kiểm tra trạng thái hiện tại của trường mật khẩu
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Đổi icon giữa "bi-eye" và "bi-eye-slash"
            this.querySelector('svg').classList.toggle('bi-eye');
            this.querySelector('svg').classList.toggle('bi-eye-slash');
        });

        // Xử lý nút "icon con mắt" cho mã xác thực quản trị viên
        const toggleAdminCode = document.querySelector('#toggleAdminCode');
        const adminCodeField = document.querySelector('#admin_code');

        toggleAdminCode.addEventListener('click', function () {
            const type = adminCodeField.getAttribute('type') === 'password' ? 'text' : 'password';
            adminCodeField.setAttribute('type', type);

            this.querySelector('svg').classList.toggle('bi-eye');
            this.querySelector('svg').classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>