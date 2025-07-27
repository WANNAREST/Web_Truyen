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
    <title>Register</title>
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
                            <h3>Đăng ký</h3>
                        </div>
                        <div class="card-body">
                            <form action="process_register.php" method="POST">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                                    </div>
                                    <!-- Hiển thị thông báo lỗi -->
                                    <?php if (isset($_GET['error']) && $_GET['error'] === 'ten_dang_nhap_ton_tai'): ?>
                                        <div class="text-danger mt-2">Tên đăng nhập đã tồn tại!</div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
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
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="verify_password" class="form-label">Xác nhận mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Nhập lại mật khẩu" required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleVerifyPassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <!-- Hiển thị thông báo lỗi -->
                                    <?php if (isset($_GET['error']) && $_GET['error'] === 'loi_xac_nhan_mat_khau'): ?>
                                        <div class="text-danger mt-2">Xác nhận mật khẩu không khớp, vui lòng thử lại!</div>
                                    <?php endif; ?>
                                    <?php if (isset($_GET['error']) && $_GET['error'] === 'mat_khau_qua_ngan'): ?>
                                        <div class="text-danger mt-2">Mật khẩu phải ít nhất 8 ký tự!</div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 py-2">Đăng ký</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <a href="login.php" class="text-decoration-none text-dark">Đã có tài khoản? <strong>Đăng nhập ngay</strong></a>
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
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // Xử lý nút "icon con mắt" để hiển thị/ẩn xác nhận mật khẩu
        const toggleVerifyPassword = document.querySelector('#toggleVerifyPassword');
        const verifyPasswordField = document.querySelector('#verify_password');
        toggleVerifyPassword.addEventListener('click', function () {
            const type = verifyPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            verifyPasswordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>