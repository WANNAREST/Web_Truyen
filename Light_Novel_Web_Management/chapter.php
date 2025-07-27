<?php
session_start(); 

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";
$genres_list = [
    'Shounen', 'Shoujo', 'Seinen', 'Josei', 'Isekai', 'Harem', 'Mecha', 'Slice of Life', 'Sports', 'Supernatural',
    'Romance', 'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Mystery', 'Psychological', 'School Life', 'Tragedy'
];

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID truyện và ID chương từ URL
$story_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$chapter_id = filter_input(INPUT_GET, 'chapter_id', FILTER_VALIDATE_INT);

if (!$story_id) {
    die("ID truyện không hợp lệ.");
}
if (!$chapter_id) {
    die("ID chương không hợp lệ.");
}

// Lấy thông tin truyện
$sql_story = "SELECT * FROM truyen WHERE id = ?";
$stmt_story = $conn->prepare($sql_story);
$stmt_story->bind_param("i", $story_id);
$stmt_story->execute();
$result_story = $stmt_story->get_result();
$story = $result_story->fetch_assoc();

// Lấy danh sách chương của truyện
$sql_chapters = "SELECT * FROM chapters WHERE story_id = ? ORDER BY id ASC";
$stmt_chapters = $conn->prepare($sql_chapters);
$stmt_chapters->bind_param("i", $story_id);
$stmt_chapters->execute();
$result_chapters = $stmt_chapters->get_result();

$chapters = [];
$chapter_number = 1;
while ($c = $result_chapters->fetch_assoc()) {
    $c['number'] = $chapter_number++; // Gán số chương
    $chapters[] = $c;
}

// Lấy thông tin chương hiện tại
$sql_chapter = "SELECT * FROM chapters WHERE id = ? AND story_id = ?";
$stmt_chapter = $conn->prepare($sql_chapter);
$stmt_chapter->bind_param("ii", $chapter_id, $story_id);
$stmt_chapter->execute();
$result_chapter = $stmt_chapter->get_result();
$chapter = $result_chapter->fetch_assoc();

if (!$chapter) {
    die("Không tìm thấy chương!");
}

// Gán số chương cho chương hiện tại
foreach ($chapters as $c) {
    if ($c['id'] == $chapter['id']) {
        $chapter['number'] = $c['number'];
        break;
    }
}

// Xác định chương trước và chương sau
$current_index = null;
foreach ($chapters as $idx => $c) {
    if ($c['id'] == $chapter['id']) {
        $current_index = $idx;
        break;
    }
}
$prev_chapter = ($current_index > 0) ? $chapters[$current_index - 1] : null;
$next_chapter = ($current_index < count($chapters) - 1) ? $chapters[$current_index + 1] : null;
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

    <title>Database Project</title>
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
                        </div>
                        <form class="d-flex header__form-search" action="" method="GET">
                            <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word"
                                value="">
                            <div class="col-12 search-result shadow no-result d-none">
                                <div class="card text-white bg-light">
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush d-none">
                                            <li class="list-group-item">
                                                <a href="#" class="text-dark hover-title"><?= htmlspecialchars($story['name']) ?>
                                                    </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button class="btn" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                    viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                    </path>
                                </svg>

                            </button>
                     </form>
                </div>
            </div>
        </nav>
    </div>
    </div>
    <div class="bg-light header-bottom">
        <div class="container py-1">
            <p class="mb-0">Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên
                tục.</p>
        </div>
    </div>


    <main>
        <div class="chapter-wrapper container my-5">
            <a href="story.php?id=<?= htmlspecialchars($story['id']) ?>" class="text-decoration-none">
                <h1 class="text-center text-success"><?= htmlspecialchars($story['name']) ?></h1>
            </a>
<a href="#" class="text-decoration-none">
    <p class="text-center text-dark">
        <?= "Chương " . htmlspecialchars($chapter['number']) . ": " . htmlspecialchars($chapter['title']) ?>
    </p>
</a>
            <hr class="chapter-start container-fluid">
            <div class="chapter-nav text-center">
                <div class="chapter-actions chapter-actions-origin d-flex align-items-center justify-content-center">
<a class="btn btn-success me-1 chapter-prev"
    href="<?= $prev_chapter ? 'chapter.php?id=' . htmlspecialchars($story_id) . '&chapter_id=' . htmlspecialchars($prev_chapter['id']) : '#' ?>"
    title="" <?= $prev_chapter ? '' : 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' ?>>
    <span>Chương</span> trước
</a>

<div class="dropdown select-chapter me-1">
    <a class="btn btn-secondary dropdown-toggle" role="button"
        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Chọn chương
    </a>
    <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink" style="max-height:300px;overflow:auto;">
        <?php foreach ($chapters as $c): ?>
            <li>
                <a class="dropdown-item<?= $c['id'] == $chapter['id'] ? ' active' : '' ?>"
                   href="chapter.php?id=<?= htmlspecialchars($story_id) ?>&chapter_id=<?= htmlspecialchars($c['id']) ?>">
                    <?= "Chương " . $c['number'] . ": " . htmlspecialchars($c['title']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<a class="btn btn-success chapter-next"
    href="<?= $next_chapter ? 'chapter.php?id=' . htmlspecialchars($story_id) . '&chapter_id=' . htmlspecialchars($next_chapter['id']) : '#' ?>"
    title="" <?= $next_chapter ? '' : 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' ?>>
    <span>Chương</span> tiếp
</a>
</div>
            </div>
            <hr class="chapter-end container-fluid">


            <div class="chapter-content mb-3">
                <?= nl2br(htmlspecialchars($chapter['content'])) ?>
</div>
<hr class="chapter-start container-fluid">
        <div class="chapter-actions chapter-actions-origin d-flex align-items-center justify-content-center">
<a class="btn btn-success me-1 chapter-prev"
    href="<?= $prev_chapter ? 'chapter.php?id=' . htmlspecialchars($story_id) . '&chapter_id=' . htmlspecialchars($prev_chapter['id']) : '#' ?>"
    title="" <?= $prev_chapter ? '' : 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' ?>>
    <span>Chương</span> trước
</a>

<div class="dropdown select-chapter me-1">
    <a class="btn btn-secondary dropdown-toggle" role="button"
        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Chọn chương
    </a>
    <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink" style="max-height:300px;overflow:auto;">
        <?php foreach ($chapters as $c): ?>
            <li>
                <a class="dropdown-item<?= $c['id'] == $chapter['id'] ? ' active' : '' ?>"
                   href="chapter.php?id=<?= htmlspecialchars($story_id) ?>&chapter_id=<?= htmlspecialchars($c['id']) ?>">
                    <?= "Chương " . $c['number'] . ": " . htmlspecialchars($c['title']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<a class="btn btn-success chapter-next"
    href="<?= $next_chapter ? 'chapter.php?id=' . htmlspecialchars($story_id) . '&chapter_id=' . htmlspecialchars($next_chapter['id']) : '#' ?>"
    title="" <?= $next_chapter ? '' : 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' ?>>
    <span>Chương</span> tiếp
</a>
</div>
<hr class="chapter-end container-fluid">
    </main>

    <!-- Thanh bình luận cho chapter -->
<div id="comment-section">
    <div class="comment">
        <div class="comment_body">
            <div class="comment_body_left">
                <div class="commenter_avatar"></div>
            </div>
            <div class="comment_body_right">
                 <?php if (isset($_SESSION['accountid'])): ?>
                                        <textarea type="text" class="comment_body_right_input" placeholder="Viết bình luận của bạn tại đây" name="comment"></textarea>
                                        <div class="comment_body_right_bottom">
                                            <div class="action_button" id="clear_button">
                                                <div class="action_button_text">Xóa</div>
                                                <img src="./assets/images/trash-can-regular.svg" alt="" class="action_button_icon">
                                            </div>
                                            <div class="action_button" id="post_button">
                                                <div class="action_button_text">Đăng</div>
                                                <img src="./assets/images/paper-plane-regular.svg" alt="" class="action_button_icon">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning mb-0">
                                            Vui lòng <a href="login.php" class="text-primary">đăng nhập</a> để bình luận và xem bình luận.
                                        </div>
                                    <?php endif; ?>
            </div>
        </div>
        <div class="comment_limit">0/1000</div>
    </div>
    <select id="comment_filter_dropdown" class="comment_filter_dropdown mt-3 mb-2">
        <option value="desc" selected>Mới nhất</option>
        <option value="asc">Cũ nhất</option>
        <option value="like">Có nhiều lượt thích nhất</option>
    </select>
    <div class="show_comment">
        <div class="show_comment_body_right">
            <!-- JS sẽ render comment vào đây -->
        </div>
    </div>
</div>

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
    $random_genres = $genres_list;
    shuffle($random_genres);
    $display_genres = array_slice($random_genres, 0, 12);
    foreach ($display_genres as $i => $genre):
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
  <div class="chapter-bottom-bar d-flex justify-content-center align-items-center gap-2">
    <a class="btn btn-home ms-2" href="index.php" title="Trang chủ">
        <svg width="20" height="20" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path d="M8 3.293l6 6V15a1 1 0 0 1-1 1h-3v-4H6v4H3a1 1 0 0 1-1-1v-5.707l6-6zm5 6.414V15h-2v-4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v4H3V9.707l5-5 5 5z"/></svg>
        Home
    </a>
    <!-- Nút chương trước -->
    <a class="btn btn-light chapter-prev"
        href="<?= $prev_chapter ? 'chapter.php?id=' . htmlspecialchars($story_id) . '&chapter_id=' . htmlspecialchars($prev_chapter['id']) : '#' ?>"
        <?= $prev_chapter ? '' : 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' ?>>
        <svg width="20" height="20" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path d="M11 1.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.8.4l-7-6a.5.5 0 0 1 0-.8l7-6a.5.5 0 0 1 .3-.1z"/></svg>
        Trước
    </a>
    <!-- Chọn chương -->
    <div class="dropdown select-chapter">
        <a class="btn btn-secondary dropdown-toggle" role="button"
            id="dropdownMenuBottom" data-bs-toggle="dropdown" aria-expanded="false">
            Chọn chương
        </a>
        <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuBottom" style="max-height:300px;overflow:auto;">
            <?php foreach ($chapters as $c): ?>
                <li>
                    <a class="dropdown-item<?= $c['id'] == $chapter['id'] ? ' active' : '' ?>"
                       href="chapter.php?id=<?= htmlspecialchars($story_id) ?>&chapter_id=<?= htmlspecialchars($c['id']) ?>">
                        <?= "Chương " . $c['number'] . ": " . htmlspecialchars($c['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- Nút chương tiếp -->
    <a class="btn btn-light chapter-next"
        href="<?= $next_chapter ? 'chapter.php?id=' . htmlspecialchars($story_id) . '&chapter_id=' . htmlspecialchars($next_chapter['id']) : '#' ?>"
        <?= $next_chapter ? '' : 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' ?>>
        Tiếp
        <svg width="20" height="20" fill="currentColor" class="ms-1" viewBox="0 0 16 16"><path d="M5 1.5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .8.4l7-6a.5.5 0 0 0 0-.8l-7-6A.5.5 0 0 0 5 1.5z"/></svg>
    </a>
    <!-- Nút home -->
    
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
    <script src="./assets/chapter.js"></script>



    <div id="loadingPage" class="loading-full">
        <div class="loading-full_icon">
            <div class="spinner-grow"><span class="visually-hidden">Loading...</span></div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchResult = document.getElementById('search-result');
    let timeout = null;

    if (!searchInput) return;

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
                            html += `<li class="list-group-item">
                                <a href="category.php?key_word=${encodeURIComponent(keyword)}" class="text-dark text-decoration-none">${story.name}</a>
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
            e.preventDefault();
            window.location.href = e.target.href;
        }
    });

    // Khi nhấn Enter trong ô tìm kiếm
    searchInput.form.addEventListener('submit', function(e) {
        if (searchInput.value.trim() === '') {
            e.preventDefault();
        }
    });
});
  window.currentTruyenId = <?= (int)$story['id'] ?>;
  window.currentChapterId = <?= (int)$chapter['id'] ?>;
  window.currentAccountId = <?= isset($_SESSION['accountid']) ? (int)$_SESSION['accountid'] : 'null' ?>;
window.currentChapterId = <?= (int)$chapter['id'] ?>;
 window.currentAccountId = <?= isset($_SESSION['accountid']) ? (int)$_SESSION['accountid'] : 'null' ?>;
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
</script>
<script src="./assets/comment.js"></script>
<link rel="stylesheet" href="./assets/comment.css">
</body>

</html>