<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
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
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 shadow-lg">
                        <div class="card-header text-center bg-dark text-white">
                            <h3>Quên mật khẩu</h3>
                        </div>
                        <div class="card-body">
                            <form action="process_forgot_password.php" method="POST">
                                <div class="mb-4">
                                    <label for="email" class="form-label">Nhập email đã đăng ký</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 py-2">Gửi yêu cầu</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <a href="login.php" class="text-decoration-none text-dark">Quay lại đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="./assets/bootstrap.min.js"></script>
</body>
</html>