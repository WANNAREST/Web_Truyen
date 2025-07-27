<?php
session_start();

// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách truyện
$sql = "SELECT id, name, genres, chapter, rating, state, image FROM truyen ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);
// Thêm truy vấn lấy truyện hot
$sql_hot = "SELECT id, name, genres, chapter, rating, state, image FROM truyen WHERE rating >= 8 ORDER BY rating DESC, id DESC LIMIT 10";
$result_hot = $conn->query($sql_hot);

// Lấy danh sách thể loại duy nhất từ bảng truyen
$genres_list = [];
$sql_genres = "SELECT genres FROM truyen";
$result_genres = $conn->query($sql_genres);
if ($result_genres) {
    while ($row = $result_genres->fetch_assoc()) {
        // Tách các thể loại nếu có nhiều thể loại trong 1 truyện (phân cách bởi dấu phẩy)
        $genres = explode(',', $row['genres']);
        foreach ($genres as $genre) {
            $genre = trim($genre);
            if ($genre !== '' && !in_array($genre, $genres_list)) {
                $genres_list[] = $genre;
            }
        }
    }
}
sort($genres_list); // Sắp xếp theo bảng chữ cái
?>
<!DOCTYPE html>
<!-- saved from url=(0021)https://suustore.com/ -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">


    <!-- Bootstrap CSS v5.2.1 -->

    <link href="./assets/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="https://suustore.com/assets/frontend/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/app.css">



    <script>
        window.SuuTruyen = {
            baseUrl: 'https://suustore.com',
            urlCurrent: 'https://suustore.com',
            csrfToken: '4EebYu2rWivdRk1ET12dyuY0CJjpRERhJynPtvUy'
        }
    </script>

    <title>Trang chủ | Suu Truyện</title>
    <meta name="description"
        content="Đọc truyện online, truyện hay. Demo Truyện luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.">
</head>

<body>
    <header class="header d-none d-lg-block">
        <!-- place navbar here -->
        <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="./assets/images/logo_text.png" alt="Logo Suu Truyen" srcset="" class="img-fluid"
                        style="width: 200px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Thể loại
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom">
<li><a class="dropdown-item" href="category.php?genre=shounen">Shounen</a></li>
<li><a class="dropdown-item" href="category.php?genre=shoujo">Shoujo</a></li>
<li><a class="dropdown-item" href="category.php?genre=seinen">Seinen</a></li>
<li><a class="dropdown-item" href="category.php?genre=josei">Josei</a></li>
<li><a class="dropdown-item" href="category.php?genre=isekai">Isekai</a></li>
<li><a class="dropdown-item" href="category.php?genre=harem">Harem</a></li>
<li><a class="dropdown-item" href="category.php?genre=mecha">Mecha</a></li>
<li><a class="dropdown-item" href="category.php?genre=slice_of_life">Slice of Life</a></li>
<li><a class="dropdown-item" href="category.php?genre=sports">Sports</a></li>
<li><a class="dropdown-item" href="category.php?genre=supernatural">Supernatural</a></li>
<li><a class="dropdown-item" href="category.php?genre=romance">Romance</a></li>
<li><a class="dropdown-item" href="category.php?genre=action">Action</a></li>
<li><a class="dropdown-item" href="category.php?genre=adventure">Adventure</a></li>
<li><a class="dropdown-item" href="category.php?genre=comedy">Comedy</a></li>
<li><a class="dropdown-item" href="category.php?genre=drama">Drama</a></li>
<li><a class="dropdown-item" href="category.php?genre=fantasy">Fantasy</a></li>
<li><a class="dropdown-item" href="category.php?genre=mystery">Mystery</a></li>
<li><a class="dropdown-item" href="category.php?genre=psychological">Psychological</a></li>
<li><a class="dropdown-item" href="category.php?genre=school_life">School Life</a></li>
<li><a class="dropdown-item" href="category.php?genre=tragedy">Tragedy</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Theo số chương
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom">
        <li><a class="dropdown-item" href="category.php?chapter_range=under_50">Dưới 50</a></li>
        <li><a class="dropdown-item" href="category.php?chapter_range=50_100">50 - 100</a></li>
        <li><a class="dropdown-item" href="category.php?chapter_range=100_500">100 - 500</a></li>
        <li><a class="dropdown-item" href="category.php?chapter_range=500_1000">500 - 1000</a></li>
        <li><a class="dropdown-item" href="category.php?chapter_range=over_1000">Trên 1000</a></li>
    </ul>
                        </li>
                        
                        <!-- Thêm mục Trạng thái -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Trạng thái
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom">
<li><a class="dropdown-item" href="category.php?state=Đang tiến hành">Đang phát hành</a></li>
<li><a class="dropdown-item" href="category.php?state=Hoàn thành">Đã hoàn thành</a></li>
    </ul>
                        </li>
                    </ul>

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
                     <!--Chú thích 3: Chỉnh các icon, nút sáng tối và hộp tìm kiếm và tài khoản đứng cạnh nhau-->
<!-- Thay thế toàn bộ form tìm kiếm hiện tại (cả desktop và mobile) bằng đoạn sau: -->
<form class="d-flex align-items-center header__form-search position-relative" action="category.php" method="GET" autocomplete="off">
    <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word" id="search-input" style="height: 35px;">
    <button class="btn" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
        </svg>
    </button>
    <div id="search-result" class="search-result shadow d-none position-absolute w-100" style="top: 100%; left: 0; z-index: 1000; background: #fff; max-height: 350px; overflow-y: auto;">
        <!-- Kết quả sẽ được JS render vào đây -->
    </div>
</form>
                        <!--Chú thích 4: Thêm icon hình người và menu Tài khoản-->
<?php if (isset($_SESSION['username'])): ?>
    <div class="nav-item dropdown ms-3">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Icon hình người -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z"/>
            </svg>
            <?= htmlspecialchars($_SESSION['username']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">Thông tin tài khoản</a></li>
            <li><a class="dropdown-item" href="fav_book.php">Truyện ưa thích</a></li>
            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
        </ul>
    </div>
<?php else: ?>
    <div class="nav-item dropdown ms-3">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Icon hình người -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z"/>
            </svg>
            Tài khoản
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="login.php">Đăng nhập người dùng</a></li>
            <li><a class="dropdown-item" href="login_admin.php">Đăng nhập quản trị viên</a></li>
            <li><a class="dropdown-item" href="register.php">Đăng ký người dùng</a></li>
            <li><a class="dropdown-item" href="register_admin.php">Đăng ký quản trị viên</a></li>
        </ul>
    </div>
<?php endif; ?>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <div class="header-mobile d-sm-block d-lg-none">
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="./assets/images/logo_text.png" alt="Logo Suu Truyen" srcset="" class="img-fluid"
                        style="width: 200px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark w-75" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <img src="./assets/images/logo_text.png" alt="Logo Suu Truyen" srcset="" class="img-fluid"
                            style="width: 200px;">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-3">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="https://suustore.com/#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Thể loại
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li><a class="dropdown-item" href="#">Mạt
                                            Thế</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Xuyên
                                            Nhanh</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Hệ
                                            Thống</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Nữ
                                            Cường</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="form-check form-switch d-flex align-items-center mb-3 p-0">
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
                        <!--Chú thích 3: Chỉnh các icon, nút sáng tối và hộp tìm kiếm và tài khoản đứng cạnh nhau-->
<form class="d-flex align-items-center header__form-search position-relative" action="category.php" method="GET" autocomplete="off">
    <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word" id="search-input" style="height: 35px;">
    <button class="btn" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
        </svg>
    </button>
    <div id="search-result" class="search-result shadow d-none position-absolute w-100" style="top: 100%; left: 0; z-index: 1000; background: #fff; max-height: 350px; overflow-y: auto;">
        <!-- Kết quả sẽ được JS render vào đây -->
    </div>
</form>
                            <!--Chú thích 4: Thêm icon hình người và menu Tài khoản-->
                            <div class="nav-item dropdown ms-3">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- Icon hình người -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z"/>
                                    </svg>
                                    Tài khoản
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="login.php">Đăng nhập người dùng</a></li>
                                    <li><a class="dropdown-item" href="login_admin.php">Đăng nhập quản trị viên</a></li>
                                    <li><a class="dropdown-item" href="register.php">Đăng ký người dùng</a></li>
                                    <li><a class="dropdown-item" href="register_admin.php">Đăng ký quản trị viên</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="bg-light header-bottom">
        <div class="container py-1">
            <p class="mb-0">Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên
                tục.</p>
        </div>
    </div>

    <main>
<?php
// Kết nối đến cơ sở dữ liệu
// Lấy 10 truyện hot nhất theo rating để làm hero section
$sql_hero = "SELECT id, name, image, rating, genres, content FROM truyen WHERE rating IS NOT NULL ORDER BY rating DESC, id DESC LIMIT 10";
$result_hero = $conn->query($sql_hero);
$hero_stories = [];
if ($result_hero) {
    while ($row = $result_hero->fetch_assoc()) {
        $hero_stories[] = $row;
    }
}
?>      
        <!-- Hero Section -->
<div class="hero-section position-relative mb-4">
    <div class="hero-carousel">
        <?php foreach ($hero_stories as $i => $story): ?>
        <div class="hero-slide<?= $i === 0 ? ' active' : '' ?>"
             style="background-image: url('uploads/<?= htmlspecialchars(trim($story['image']) ?: 'default.jpg') ?>');">
            <div class="hero-overlay"></div>
            <div class="hero-content container d-flex align-items-center" style="gap:32px;">
                <img src="uploads/<?= htmlspecialchars(trim($story['image']) ?: 'default.jpg') ?>"
                     alt="<?= htmlspecialchars($story['name']) ?>"
                     style="max-width:150px;max-height:220px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.2);flex-shrink:0;">
                <div>
                
                    <h1 class="hero-title"><?= htmlspecialchars($story['name']) ?></h1>
                    <div class="hero-rating mb-2">⭐ <?= htmlspecialchars($story['rating']) ?></div>
                    <div class="hero-genres mb-2">
            <?php foreach (explode(',', $story['genres']) as $genre): ?>
                <span class="badge bg-secondary me-1"><?= htmlspecialchars(trim($genre)) ?></span>
            <?php endforeach; ?>
        </div> 
               <div class="hero-info">
            <?= htmlspecialchars(mb_substr($story['content'], 0, 180)) ?><?= mb_strlen($story['content']) > 180 ? '...' : '' ?>
              </div>
                    <a href="story.php?id=<?= $story['id'] ?>" class="btn btn-success">Đọc ngay</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
       <button class="hero-prev btn btn-light rounded-circle shadow" type="button">
    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11 1.5a.5.5 0 0 1 0 .707L5.207 8l5.793 5.793a.5.5 0 0 1-.707.707l-6-6a.5.5 0 0 1 0-.707l6-6a.5.5 0 0 1 .707 0z"/>
    </svg>
</button>
<button class="hero-next btn btn-light rounded-circle shadow" type="button">
    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
        <path d="M5 1.5a.5.5 0 0 1 .707 0l6 6a.5.5 0 0 1 0 .707l-6 6a.5.5 0 0 1-.707-.707L10.793 8 5 2.207a.5.5 0 0 1 0-.707z"/>
    </svg>
</button>
<div class="hero-dots d-flex justify-content-center align-items-center mt-3">
    <?php foreach ($hero_stories as $i => $story): ?>
        <button type="button" class="hero-dot<?= $i === 0 ? ' active' : '' ?>" data-slide="<?= $i ?>"></button>
    <?php endforeach; ?>
</div>
    </div>
</div>

<div class="section-stories-hot mb-3">
    <div class="container">
        <div class="row">
            <div class="head-title-global d-flex justify-content-between mb-2">
                <div class="col-6 col-md-4 col-lg-4 head-title-global__left d-flex align-items-center">
                    <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                        <a href="category.php?key_word=Truyện Hot" class="d-block text-decoration-none text-dark fs-4 story-name"
                            title="Truyện Hot">Truyện Hot</a>
                    </h2>
                    <i class="fa-solid fa-fire-flame-curved"></i>
                </div>
                <div class="col-4 col-md-3 col-lg-2">
                    <form method="get" id="hot-genre-form">
                        <select class="form-select select-stories-hot" aria-label="Truyen hot" id="select-hot-genre" name="hot_genre">
                            <option value="all" <?= (!isset($_GET['hot_genre']) || $_GET['hot_genre'] === 'all') ? 'selected' : '' ?>>Tất cả</option>
                            <?php foreach ($genres_list as $genre): ?>
                                <option value="<?= htmlspecialchars($genre) ?>" <?= (isset($_GET['hot_genre']) && $_GET['hot_genre'] === $genre) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($genre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="section-stories-hot__list" id="hot-stories-list">
                    <?php
                    // Lấy thể loại được chọn
                    $selected_genre = isset($_GET['hot_genre']) ? trim($_GET['hot_genre']) : 'all';
                    if ($selected_genre === 'all') {
                        $sql_hot = "SELECT id, name, genres, chapter, rating, state, image FROM truyen WHERE rating >= 8 ORDER BY rating DESC, id DESC LIMIT 16";
                        $result_hot = $conn->query($sql_hot);
                    } else {
                        $sql_hot = "SELECT id, name, genres, chapter, rating, state, image FROM truyen WHERE rating >= 8 AND FIND_IN_SET(?, REPLACE(genres, ', ', ',')) > 0 ORDER BY rating DESC, id DESC LIMIT 16";
                        $stmt = $conn->prepare($sql_hot);
                        $stmt->bind_param("s", $selected_genre);
                        $stmt->execute();
                        $result_hot = $stmt->get_result();
                    }
                    if ($result_hot && $result_hot->num_rows > 0): ?>
                        <?php while ($row = $result_hot->fetch_assoc()): ?>
                            <div class="story-item">
                                <a href="story.php?id=<?= $row['id'] ?>" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name"><?= htmlspecialchars($row['name']) ?></h3>
                                    <div class="list-badge">
                                        <?php if ($row['state'] === 'Hoàn thành'): ?>
                                            <span class="story-item__badge badge text-bg-success">Full</span>
                                        <?php endif; ?>
                                        <span class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>
                                        <span class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div>Chưa có truyện hot.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="container">
            <div class="row align-items-start">
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="section-stories-new mb-3">
                        <div class="row">
                            <div class="head-title-global d-flex justify-content-between mb-2">
                                <div class="col-6 col-md-4 col-lg-4 head-title-global__left d-flex align-items-center">
                                    <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                        <a href="category.php?key_word=Truyện Mới"
                                            class="d-block text-decoration-none text-dark fs-4 story-name"
                                            title="Truyện Mới">Truyện Mới</a>
                                    </h2>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="section-stories-new__list">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="story-item-no-image">
                <div class="story-item-no-image__name d-flex align-items-center">
                    <h3 class="me-1 mb-0 d-flex align-items-center">
                        <svg style="width: 10px; margin-right: 5px;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                            <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                        </svg>
                        <a href="story.php?id=<?= $row['id'] ?>"
                            class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">
                            <?= htmlspecialchars($row['name']) ?>
                        </a>
                    </h3>
                    <span class="badge text-bg-info text-light me-1">New</span>
                    <?php if ($row['state'] === 'Hoàn thành'): ?>
                        <span class="badge text-bg-success text-light me-1">Full</span>
                    <?php endif; ?>
                    <?php if ($row['rating'] >= 8): ?>
                        <span class="badge text-bg-danger text-light">Hot</span>
                    <?php endif; ?>
                </div>
                <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                    <p class="mb-0">
                        <?php foreach (explode(',', $row['genres']) as $genre): ?>
                            <a href="#" class="hover-title text-decoration-none text-dark category-name"><?= htmlspecialchars(trim($genre)) ?></a>
                        <?php endforeach; ?>
                    </p>
                </div>
                <div class="story-item-no-image__chapters ms-2">
                    <a href="story.php?id=<?= $row['id'] ?>" class="hover-title text-decoration-none text-info">
                        Chương <?= htmlspecialchars($row['chapter']) ?>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div>Chưa có truyện mới.</div>
    <?php endif; ?>
</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                    <div class="row">

                        <div class="col-12">
                            <div class="section-list-category bg-light p-2 rounded card-custom">
                                <div class="head-title-global mb-2">
                                    <div class="col-12 col-md-12 head-title-global__left">
                                        <h2 class="mb-0 border-bottom border-secondary pb-1">
                                            <span href="#" class="d-block text-decoration-none text-dark fs-4"
                                                title="Truyện đang đọc">Thể loại truyện</span>
                                        </h2>
                                    </div>
                                </div>
<ul class="list-category">
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=shounen">Shounen</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=shoujo">Shoujo</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=seinen">Seinen</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=josei">Josei</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=isekai">Isekai</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=harem">Harem</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=mecha">Mecha</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=slice_of_life">Slice of Life</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=sports">Sports</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=supernatural">Supernatural</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=romance">Romance</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=action">Action</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=adventure">Adventure</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=comedy">Comedy</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=drama">Drama</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=fantasy">Fantasy</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=mystery">Mystery</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=psychological">Psychological</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=school_life">School Life</a></li>
    <li><a class="text-decoration-none text-dark hover-title" href="category.php?genre=tragedy">Tragedy</a></li>
</ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-stories-new__list">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $count = 0; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php if ($count >= 10) break; // Hiển thị 10 truyện mới nhất ?>
                            <div class="story-item-no-image">
                                <div class="story-item-no-image__name d-flex align-items-center">
                                    <h3 class="me-1 mb-0 d-flex align-items-center">
                                        <svg style="width: 10px; margin-right: 5px;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                                            <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                                        </svg>
                                        <a href="story.php?id=<?= $row['id'] ?>"
                                            class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">
                                            <?= htmlspecialchars($row['name']) ?>
                                        </a>
                                    </h3>
                                    <span class="badge text-bg-info text-light me-1">New</span>
                                    <?php if ($row['state'] === 'Hoàn thành'): ?>
                                        <span class="badge text-bg-success text-light me-1">Full</span>
                                    <?php endif; ?>
                                    <?php if ($row['rating'] >= 8): // Ví dụ: rating >= 8 là Hot ?>
                                        <span class="badge text-bg-danger text-light">Hot</span>
                                    <?php endif; ?>
                                </div>
                                <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                    <p class="mb-0">
                                        <?php foreach (explode(',', $row['genres']) as $genre): ?>
                                            <a href="#" class="hover-title text-decoration-none text-dark category-name"><?= htmlspecialchars(trim($genre)) ?></a>
                                        <?php endforeach; ?>
                                    </p>
                                </div>
                                <div class="story-item-no-image__chapters ms-2">
                                    <a href="story.php?id=<?= $row['id'] ?>" class="hover-title text-decoration-none text-info">
                                        Chương <?= htmlspecialchars($row['chapter']) ?>
                                    </a>
                                </div>
                            </div>
                            <?php $count++; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div>Chưa có truyện mới.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="section-stories-full mb-3 mt-3">
            <div class="container">
                <div class="row">
                    <div class="head-title-global d-flex justify-content-between mb-2">
                        <div class="col-12 col-md-4 head-title-global__left d-flex">
                            <a href="category.php?key_word=Truyện đã hoàn thành" title="Truyện đã hoàn thành" class="d-block text-decoration-none text-dark fs-4 title-head-name">
                            <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                Truyện đã hoàn thành
                            </h2>
                        </a>
                            <!-- <i class="fa-solid fa-fire-flame-curved"></i> -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="section-stories-full__list">
    <?php
    // Lấy danh sách truyện hoàn thành từ CSDL
    $sql_full = "SELECT id, name, image, chapter FROM truyen WHERE state = 'Hoàn thành' ORDER BY id DESC";
    $result_full = $conn->query($sql_full);
    if ($result_full && $result_full->num_rows > 0):
        while ($row_full = $result_full->fetch_assoc()):
    ?>
        <div class="story-item-full text-center">
            <a href="story.php?id=<?= $row_full['id'] ?>" class="d-block story-item-full__image">
                <img src="uploads/<?= htmlspecialchars($row_full['image']) ?>"
                     alt="<?= htmlspecialchars($row_full['name']) ?>"
                     class="img-fluid w-100"
                     width="150" height="230" loading="lazy">
            </a>
            <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                <a href="story.php?id=<?= $row_full['id'] ?>"
                   class="text-decoration-none text-one-row story-name">
                    <?= htmlspecialchars($row_full['name']) ?>
                </a>
            </h3>
            <span class="story-item-full__badge badge text-bg-success">
                Full - <?= htmlspecialchars($row_full['chapter']) ?> chương
            </span>
        </div>
    <?php
        endwhile;
    else:
    ?>
        <div>Chưa có truyện hoàn thành.</div>
    <?php endif; ?>
</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="footer" class="footer border-top pt-2">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <strong>Suu Truyện</strong> - <a title="Đọc truyện online" class="text-dark text-decoration-none"
                        href="#">Đọc truyện</a> online một cách nhanh nhất. Hỗ trợ mọi thiết bị như
                    di
                    động và máy tính bảng.
                </div>
                <ul class="col-12 col-md-7 list-unstyled d-flex flex-wrap list-tag">
    <?php
    // Lấy danh sách thể loại duy nhất từ $genres_list (đã có ở đầu file)
    // Lấy ngẫu nhiên 12 thể loại (hoặc ít hơn nếu không đủ)
    $random_genres = $genres_list;
    shuffle($random_genres);
    $display_genres = array_slice($random_genres, 0, 12);
    foreach ($display_genres as $i => $genre):
        // Chuyển về dạng snake_case cho URL
        $genre_url = strtolower(str_replace(' ', '_', $genre));
    ?>
        <li class="<?= $i % 2 === 0 ? 'me-1' : '' ?>">
            <span class="badge text-bg-light">
                <a class="text-dark text-decoration-none"
                   href="category.php?genre=<?= urlencode($genre_url) ?>"
                   title="<?= htmlspecialchars($genre) ?>">
                    <?= htmlspecialchars($genre) ?>
                </a>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

                <div class="col-12"> <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img
                            alt="Creative Commons License" style="border-width:0;margin-bottom: 10px"
                            src="./assets/images/88x31.png"></a><br>
                    <p>Website hoạt động dưới Giấy phép truy cập mở <a rel="license"
                            class="text-decoration-none text-dark hover-title"
                            href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0
                            International License</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/jquery.min.js">
    </script>

    <script src="./assets/popper.min.js">
    </script>

    <script src="./assets/bootstrap.min.js">
    </script>



    <script src="./assets/app.js">
    </script>
    <script src="./assets/common.js"></script>



    <div id="loadingPage" class="loading-full">
        <div class="loading-full_icon">
            <div class="spinner-grow"><span class="visually-hidden">Loading...</span></div>
        </div>
    </div>

<script>
// Khi chọn thể loại, chuyển trang với tham số hot_genre
document.getElementById('select-hot-genre').addEventListener('change', function() {
    var genre = this.value;
    var url = new URL(window.location.href);
    if (genre === 'all') {
        url.searchParams.delete('hot_genre');
    } else {
        url.searchParams.set('hot_genre', genre);
    }
    window.location.href = url.toString();
});
</script>
<script>
// Khi chọn thể loại, submit form để giữ đúng trạng thái selected
document.getElementById('select-hot-genre').addEventListener('change', function() {
    document.getElementById('hot-genre-form').submit();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchResult = document.getElementById('search-result');
    let timeout = null;

    searchInput.addEventListener('input', function() {
        const keyword = this.value.trim();
        if (timeout) clearTimeout(timeout);
        if (keyword.length === 0) {
            searchResult.classList.add('d-none');
            searchResult.innerHTML = '';
            return;
        }
        timeout = setTimeout(function() {
            fetch('search_ajax.php?key_word=' + encodeURIComponent(keyword))
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '<ul class="list-group list-group-flush">';
                        data.forEach(story => {
                            html += `<li class="list-group-item d-flex align-items-start" style="gap:10px;">
                                <img src="uploads/${story.image}" alt="${story.name}" style="width:50px;height:70px;object-fit:cover;flex-shrink:0;">
                                <div style="min-width:0;">
                                    <a href="story.php?id=${story.id}" class="text-dark text-decoration-none fw-bold">${story.name}</a>
                                    <div style="font-size:13px;color:#666;">Chương ${story.chapter ?? ''}</div>
                                    <div style="font-size:12px;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                                        ${story.genres ?? ''}
                                    </div>
                                </div>
                            </li>`;
                        });
                        html += '</ul>';
                        searchResult.innerHTML = html;
                        searchResult.classList.remove('d-none');
                    } else {
                        searchResult.innerHTML = '<div class="p-2 text-muted">Không tìm thấy truyện phù hợp.</div>';
                        searchResult.classList.remove('d-none');
                    }
                });
        }, 250);
    });

    // Ẩn kết quả khi click ngoài
    document.addEventListener('click', function(e) {
        if (!searchResult.contains(e.target) && e.target !== searchInput) {
            searchResult.classList.add('d-none');
        }
    });

    // Khi chọn truyện trong danh sách
    searchResult.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            // Chuyển sang category.php?key_word=...
            e.preventDefault();
            window.location.href = e.target.href;
        }
    });

    // Khi nhấn Enter trong ô tìm kiếm
    searchInput.form.addEventListener('submit', function(e) {
        if (searchInput.value.trim() === '') {
            e.preventDefault();
        }
        // Nếu có giá trị, form sẽ submit đến category.php?key_word=...
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchResult = document.getElementById('search-result');
    let timeout = null;

    // searchInput.addEventListener('input', function() {
    //     const keyword = this.value.trim();
    //     if (timeout) clearTimeout(timeout);
    //     if (keyword.length === 0) {
    //         searchResult.classList.add('d-none');
    //         searchResult.innerHTML = '';
    //         return;
    //     }
    //     timeout = setTimeout(function() {
    //         fetch('search_ajax.php?key_word=' + encodeURIComponent(keyword))
    //             .then(res => res.json())
    //             .then(data => {
    //                 if (data.length > 0) {
    //                     let html = '<ul class="list-group list-group-flush">';
    //                     data.forEach(story => {
    //                         html += `<li class="list-group-item">
    //                             <a href="category.php?key_word=${encodeURIComponent(keyword)}" class="text-dark text-decoration-none">${story.name}</a>
    //                         </li>`;
    //                     });
    //                     html += '</ul>';
    //                     searchResult.innerHTML = html;
    //                     searchResult.classList.remove('d-none');
    //                 } else {
    //                     searchResult.innerHTML = '<div class="p-2 text-muted">Không tìm thấy truyện phù hợp.</div>';
    //                     searchResult.classList.remove('d-none');
    //                 }
    //             });
    //     }, 250);
    // });

    // Ẩn kết quả khi click ngoài
    document.addEventListener('click', function(e) {
        if (!searchResult.contains(e.target) && e.target !== searchInput) {
            searchResult.classList.add('d-none');
        }
    });

    // Khi chọn truyện trong danh sách gợi ý
    searchResult.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
           e.preventDefault();
         window.location.href = e.target.href;
       }
    });

    // Khi nhấn Enter trong ô tìm kiếm
    searchInput.form.addEventListener('submit', function(e) {
        if (searchInput.value.trim() === '') {
            e.preventDefault();
        }
        // Nếu có giá trị, form sẽ submit đến category.php?key_word=...
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.querySelector('.hero-prev');
    const nextBtn = document.querySelector('.hero-next');
    let idx = 0;
    function showSlide(i) {
        slides.forEach((s, j) => s.classList.toggle('active', j === i));
    }
    prevBtn.onclick = function() {
        idx = (idx - 1 + slides.length) % slides.length;
        showSlide(idx);
    };
    nextBtn.onclick = function() {
        idx = (idx + 1) % slides.length;
        showSlide(idx);
    };
    // Tự động chuyển slide mỗi 6s
    setInterval(() => {
        idx = (idx + 1) % slides.length;
        showSlide(idx);
    }, 6000);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút chuyển theme (có thể nhiều nút trên desktop/mobile)
    const themeSwitches = document.querySelectorAll('.theme_mode');
    // Kiểm tra trạng thái dark mode từ localStorage
    const isDark = localStorage.getItem('dark-theme') === 'true';
    if (isDark) {
        document.body.classList.add('dark-theme');
        themeSwitches.forEach(sw => sw.checked = true);
    } else {
        document.body.classList.remove('dark-theme');
        themeSwitches.forEach(sw => sw.checked = false);
    }
    // Lắng nghe sự kiện thay đổi trên bất kỳ nút nào
    themeSwitches.forEach(sw => {
        sw.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-theme');
                localStorage.setItem('dark-theme', 'true');
                themeSwitches.forEach(s => s.checked = true);
            } else {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('dark-theme', 'false');
                themeSwitches.forEach(s => s.checked = false);
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.querySelector('.hero-prev');
    const nextBtn = document.querySelector('.hero-next');
    const dots = document.querySelectorAll('.hero-dot');
    let idx = 0;

    function showSlide(i) {
        slides.forEach((s, j) => s.classList.toggle('active', j === i));
        dots.forEach((d, j) => d.classList.toggle('active', j === i));
        idx = i;
    }

    prevBtn.onclick = function() {
        idx = (idx - 1 + slides.length) % slides.length;
        showSlide(idx);
    };
    nextBtn.onclick = function() {
        idx = (idx + 1) % slides.length;
        showSlide(idx);
    };
    dots.forEach((dot, i) => {
        dot.onclick = function() {
            showSlide(i);
        };
    });
    setInterval(() => {
        idx = (idx + 1) % slides.length;
        showSlide(idx);
    }, 6000);
});
</script>

</body>

</html>