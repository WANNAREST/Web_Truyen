<?php
session_start(); 

// if (!isset($_SESSION['accountid'])) {
//     header("Location: login.php?error=chua_dang_nhap");
//     exit;
// }

$userid = isset($_SESSION['accountid']) ? (int)$_SESSION['accountid'] : 0;

// Kết nối cơ sở dữ liệu
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

// Lấy ID truyện từ URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("ID truyện không hợp lệ.");
}

// Lấy thông tin truyện
$sql_story = "SELECT * FROM truyen WHERE id = ?";
$stmt_story = $conn->prepare($sql_story);
$stmt_story->bind_param("i", $id);
$stmt_story->execute();
$result_story = $stmt_story->get_result();
$story = $result_story->fetch_assoc();

// Lấy danh sách chương
$sql_chapters = "SELECT * FROM chapters WHERE story_id = ?";
$stmt_chapters = $conn->prepare($sql_chapters);
$stmt_chapters->bind_param("i", $id);
$stmt_chapters->execute();
$result_chapters = $stmt_chapters->get_result();

$chapters = [];
$chapter_number = 1;
while ($chapter = $result_chapters->fetch_assoc()) {
    $chapter['number'] = $chapter_number++; // Gán số chương
    $chapters[] = $chapter;
}
$total = count($chapters);
$half = ceil($total / 2);
$chapters_col1 = array_slice($chapters, 0, $half);
$chapters_col2 = array_slice($chapters, $half);

$chapters_per_page = 50;
$total_chapters = count($chapters);
$total_pages = ceil($total_chapters / $chapters_per_page);

// Lấy trang hiện tại từ URL, mặc định là 1
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
if ($current_page > $total_pages) $current_page = $total_pages;

// Lấy danh sách chương cho trang hiện tại
$start = ($current_page - 1) * $chapters_per_page;
$chapters_on_page = array_slice($chapters, $start, $chapters_per_page);

// Hàm tạo URL phân trang
function build_page_url($page) {
    $url = $_SERVER['PHP_SELF'] . '?id=' . urlencode($_GET['id']) . '&page=' . $page;
    return $url;
}

// Lấy top 5 truyện theo rating
$sql_top = "SELECT id, name, genres, rating FROM truyen ORDER BY rating DESC, id DESC LIMIT 11";
$result_top = $conn->query($sql_top);
$top_ratings = [];
if ($result_top && $result_top->num_rows > 0) {
    while ($item = $result_top->fetch_assoc()) {
        $top_ratings[] = $item;
    }
}
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



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <title><?= htmlspecialchars($story['name']) ?> - Chi tiết truyện</title>
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
    <!-- Thêm mục Xếp hạng -->

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
    <label class="form-check-label mb-0" for="themeSwitch">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-brightness-high" viewBox="0 0 16 16" style="fill: #ffc107;">
            <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"></path>
        </svg>
    </label>
    <input class="form-check-input theme_mode" type="checkbox" id="themeSwitch"
        style="transform: scale(1.3); margin-left: 12px; margin-right: 12px;">
    <label class="form-check-label mb-0" for="themeSwitch">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 384 512"
            style="fill: #fff; margin-left: 4px;">
            <path d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z"></path>
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
                            

                            <label class="form-check-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 384 512"
                                    style="fill: #fff;">
                                    <path
                                        d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z">
                                </path>
                            </svg>
                            </label>
                        </div>

                        <form class="d-flex align-items-center header__form-search" action="" method="GET">
                            <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word"
                                value="" style="height: 35px;">
                            <div class="col-12 search-result shadow no-result d-none">
                                <div class="card text-white bg-light">
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush d-none">
                                            <li class="list-group-item">
                                                <a href="#" class="text-dark hover-title"><?= htmlspecialchars($story['name']) ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button class="btn" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                </path>
                            </svg>

                            </button>
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
    <input type="hidden" id="story_slug" value="<?= htmlspecialchars($story['name']) ?>">
    <div class="container">
        <div class="row align-items-start">
            <!-- Cột trái: Nội dung truyện, chương, bình luận -->
            <div class="col-12 col-md-8 col-lg-8">
                <!-- Tiêu đề và thông tin truyện -->
                <div class="head-title-global d-flex justify-content-between mb-4">
                    <div class="col-12 col-md-12 col-lg-4 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                title="Thông tin truyện">Thông tin truyện</span>
                        </h2>
                    </div>
                </div>
                <div class="story-detail">
                    <div class="d-flex align-items-start">
                        <!-- Ảnh + nút ưa thích -->
                        <div class="story-detail__top--image me-4" style="width:200px;flex-shrink:0;">
                            <div class="book-3d">
                                <img src="uploads/<?= htmlspecialchars($story['image']) ?>"
                                    alt="<?= htmlspecialchars($story['name']) ?>" class="img-fluid w-100" width="200"
                                    height="300" loading="lazy">
                            </div>
                            <!-- Nút ưa thích -->
                            <div class="mt-2 text-center">
                                <?php if (isset($_SESSION['accountid'])): ?>
                                    <?php
                                    $is_fav = false;
                                    $userid = (int)$_SESSION['accountid'];
                                    $storyid = (int)$story['id'];
                                    $sql_fav = "SELECT 1 FROM fav_book WHERE userid = ? AND truyenid = ? LIMIT 1";
                                    $stmt_fav = $conn->prepare($sql_fav);
                                    $stmt_fav->bind_param("ii", $userid, $storyid);
                                    $stmt_fav->execute();
                                    $stmt_fav->store_result();
                                    if ($stmt_fav->num_rows > 0) $is_fav = true;
                                    $stmt_fav->close();
                                    ?>
                                    <button id="fav-btn" class="btn btn-outline-danger<?= $is_fav ? ' active' : '' ?>">
                                        <span id="fav-btn-text"><?= $is_fav ? 'Đã thêm vào ưa thích' : 'Thêm vào ưa thích' ?></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-heart ms-1" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514 3.053 3.824 6.143c.636 1.528 2.293 3.313 4.176 4.905 1.883-1.592 3.54-3.377 4.176-4.905C13.486 3.053 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                        </svg>
                                    </button>
                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('fav-btn').addEventListener('click', function() {
                                            var btn = this;
                                            fetch('fav_book_api.php', {
                                                method: 'POST',
                                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                                body: 'action=toggle&truyenid=<?= $storyid ?>&userid=<?= $userid ?>'
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.status === 'added') {
                                                    btn.classList.add('active');
                                                    document.getElementById('fav-btn-text').innerText = 'Đã thêm vào ưa thích';
                                                } else if (data.status === 'removed') {
                                                    btn.classList.remove('active');
                                                    document.getElementById('fav-btn-text').innerText = 'Thêm vào ưa thích';
                                                }
                                            });
                                        });
                                    });
                                    </script>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-danger">
                                        <span>Thêm vào ưa thích</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-heart ms-1" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514 3.053 3.824 6.143c.636 1.528 2.293 3.313 4.176 4.905 1.883-1.592 3.54-3.377 4.176-4.905C13.486 3.053 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <!-- Thông tin tác giả, thể loại, trạng thái đặt dưới nút ưa thích -->
                            <div class="mt-3 text-start">
                                <p class="mb-1">
                                    <strong>Tác giả:</strong>
                                    <a href="#" class="text-decoration-none text-dark hover-title"><?= htmlspecialchars($story['author']) ?></a>
                                </p>
                                <div class="d-flex align-items-center mb-1 flex-wrap">
                                    <strong class="me-1">Thể loại:</strong>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <?php foreach (explode(',', $story['genres']) as $genre): ?>
                                            <span class="badge bg-secondary me-1 mb-1"><?= htmlspecialchars(trim($genre)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <p class="mb-1">
                                    <strong>Trạng thái:</strong>
                                    <span class="text-info"><?= htmlspecialchars($story['state']) ?></span>
                                </p>
                            </div>
                        </div>
                        <!-- Đánh giá đặt bên phải ảnh -->
                        <div class="flex-grow-1">
                            <h3 class="text-center story-name"><?= htmlspecialchars($story['name']) ?></h3>
                            <div class="rate-story mb-2 text-start" style="margin-left: 0;">
                                <div class="rate-story__holder mb-2" data-score="<?= htmlspecialchars($story['rating']) ?>">
                                    <?php
                                        $rating = floatval($story['rating']);
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                                        $offStars = 10 - $fullStars - $halfStar;
                                        for ($i = 1; $i <= $fullStars; $i++) {
                                            echo '<img alt="'.$i.'" src="./assets/images/star-on.png">';
                                        }
                                        if ($halfStar) {
                                            echo '<img alt="'.($fullStars+1).'" src="./assets/images/star-half.png">';
                                        }
                                        for ($i = 1; $i <= $offStars; $i++) {
                                            echo '<img alt="'.($fullStars+$halfStar+$i).'" src="./assets/images/star-off.png">';
                                        }
                                    ?>
                                </div>
                                <em class="rate-story__text"></em>
                                <div class="rate-story__value" itemprop="aggregateRating" itemscope=""
                                    itemtype="https://schema.org/AggregateRating">
                                    <em>Đánh giá:
                                        <strong>
                                            <span itemprop="ratingValue"><?= htmlspecialchars($story['rating']) ?></span>
                                        </strong>
                                        /
                                        <span class="" itemprop="bestRating">10</span>
                                    </em>
                                </div>
                            </div>
                            <div class="story-detail__top--desc px-3" style="max-height: 120px; overflow: hidden;">
                                <?= nl2br(htmlspecialchars($story['content'])) ?>
                            </div>
                            <div class="info-more">
                                <div class="info-more--more active" id="info_more">
                                    <span class="me-1 text-dark-for-more">Xem thêm</span>
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.70749 7.70718L13.7059 1.71002C14.336 1.08008 13.8899 0.00283241 12.9989 0.00283241L1.002 0.00283241C0.111048 0.00283241 -0.335095 1.08008 0.294974 1.71002L6.29343 7.70718C6.68394 8.09761 7.31699 8.09761 7.70749 7.70718Z"
                                            fill="#2C2C37"></path>
                                    </svg>
                                </div>
                                <a class="info-more--collapse text-decoration-none"
                                    href="story.php#info_more">
                                    <span class="me-1 text-dark">Thu gọn</span>
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.70749 0.292817L13.7059 6.28998C14.336 6.91992 13.8899 7.99717 12.9989 7.99717L1.002 7.99717C0.111048 7.99717 -0.335095 6.91992 0.294974 6.28998L6.29343 0.292817C6.68394 -0.097606 7.31699 -0.0976055 7.70749 0.292817Z"
                                            fill="#2C2C37"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Danh sách chương -->
                    <div class="story-detail__list-chapter">
                        <div class="head-title-global d-flex justify-content-between mb-4">
                            <div class="col-6 col-md-12 col-lg-4 head-title-global__left d-flex">
                                <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                    <span href="#"
                                        class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                        title="Truyện hot">Danh sách chương</span>
                                </h2>
                            </div>
                        </div>
                       <div class="story-detail__list-chapter--list">
    <div class="row">
        <?php
        // Chia danh sách chương thành 2 cột, mỗi cột 25 chương
        $chapters_per_col = 25;
        $total_chapters = count($chapters_on_page);
        $col1 = array_slice($chapters_on_page, 0, $chapters_per_col);
        $col2 = array_slice($chapters_on_page, $chapters_per_col, $chapters_per_col);
        ?>
        <div class="col-12 col-md-6">
            <ul class="list-unstyled">
                <?php foreach ($col1 as $chapter): ?>
                    <li>
                        <span style="color:#007bff;">&#9733;</span>
                        <a href="chapter.php?id=<?= htmlspecialchars($story['id']) ?>&chapter_id=<?= htmlspecialchars($chapter['id']) ?>"
                           class="text-decoration-none text-dark hover-title">
                            <?= "Chương " . $chapter['number'] . ": " . htmlspecialchars($chapter['title']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-12 col-md-6">
            <ul class="list-unstyled">
                <?php foreach ($col2 as $chapter): ?>
                    <li>
                        <span style="color:#007bff;">&#9733;</span>
                        <a href="chapter.php?id=<?= htmlspecialchars($story['id']) ?>&chapter_id=<?= htmlspecialchars($chapter['id']) ?>"
                           class="text-decoration-none text-dark hover-title">
                            <?= "Chương " . $chapter['number'] . ": " . htmlspecialchars($chapter['title']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
                    </div>
                   
                    <div class="d-flex justify-content-center my-4">
    <ul class="pagination" style="align-items: center; display: flex; flex-wrap: wrap; list-style: none; padding-left: 0; margin-bottom: 0;">
        <!-- Nút << -->
        <?php if ($current_page > 1): ?>
            <li class="pagination__arrow pagination__item">
                <a href="<?= build_page_url($current_page - 1) ?>" class="page-link">&lt;&lt;</a>
            </li>
        <?php endif; ?>

        <!-- Trang đầu -->
        <li class="pagination__item <?= $current_page == 1 ? 'page-current' : '' ?>">
            <a href="<?= build_page_url(1) ?>" class="page-link">1</a>
        </li>

        <?php
        // Hiển thị các nút phân trang động
        if ($total_pages > 2) {
            if ($current_page == 1) {
                if ($total_pages >= 3) {
                    for ($i = 2; $i <= min(3, $total_pages); $i++) {
                        echo '<li class="pagination__item '.($current_page == $i ? 'page-current' : '').'">
                                <a href="'.build_page_url($i).'" class="page-link">'.$i.'</a>
                              </li>';
                    }
                    if ($total_pages > 3) {
                        echo '<li class="pagination__item disabled"><span class="page-link">...</span></li>';
                    }
                }
            } elseif ($current_page == $total_pages) {
                if ($total_pages > 3) {
                    echo '<li class="pagination__item disabled"><span class="page-link">...</span></li>';
                }
                for ($i = max(2, $total_pages-2); $i < $total_pages; $i++) {
                    echo '<li class="pagination__item '.($current_page == $i ? 'page-current' : '').'">
                            <a href="'.build_page_url($i).'" class="page-link">'.$i.'</a>
                          </li>';
                }
            } else {
                if ($current_page > 3) {
                    echo '<li class="pagination__item disabled"><span class="page-link">...</span></li>';
                }
                for ($i = $current_page-1; $i <= $current_page+1; $i++) {
                    if ($i > 1 && $i < $total_pages) {
                        echo '<li class="pagination__item '.($current_page == $i ? 'page-current' : '').'">
                                <a href="'.build_page_url($i).'" class="page-link">'.$i.'</a>
                              </li>';
                    }
                }
                if ($current_page < $total_pages-2) {
                    echo '<li class="pagination__item disabled"><span class="page-link">...</span></li>';
                }
            }
        }
        ?>

        <!-- Trang cuối -->
        <?php if ($total_pages > 1): ?>
            <li class="pagination__item <?= $current_page == $total_pages ? 'page-current' : '' ?>">
                <a href="<?= build_page_url($total_pages) ?>" class="page-link"><?= $total_pages ?></a>
            </li>
        <?php endif; ?>

        <!-- Nút >> -->
<?php if ($current_page < $total_pages): ?>
    <li class="pagination__arrow pagination__item">
        <a href="<?= build_page_url($current_page + 1) ?>" class="page-link">&gt;&gt;</a>
    </li>
<?php endif; ?>

<!-- Nút ^ dropdown chọn trang -->
<li class="pagination__item position-relative pagination__item--dropdown" style="margin-left: 5px;">
    <a href="javascript:void(0);" class="page-link" id="dropdownPageCaret" tabindex="0" style="font-size: 1.2rem; font-weight: bold; padding-bottom: 2px;">^</a>
    <ul class="dropdown-menu dropdown-menu-end"
        aria-labelledby="dropdownPageCaret"
        style="max-height: 320px; overflow-y: auto; top: auto; bottom: 110%; left: 0; right: auto; transform: none; display: none; min-width: 140px;">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li>
                <a class="dropdown-item<?= $i == $current_page ? ' active' : '' ?>"
                   href="<?= build_page_url($i) ?>"
                   style="text-align:center;<?= $i == $current_page ? 'background:#212529;color:#fff;border-radius:6px;' : '' ?>">
                    Trang <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</li>
    </ul>
</div>
                    <!-- BÌNH LUẬN -->
                    <div id="comment-section" class="mt-4">
                        
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
                </div>
            </div>
            <!-- Cột phải: Top đánh giá -->
            <div class="col-12 col-md-4 col-lg-4">
                <div class="col-12 top-ratings__tab mb-2">
                    <div class="list-group d-flex flex-row" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="top-all-time-list"
                            data-bs-toggle="list"
                            href="#top-all-time" role="tab"
                            aria-controls="top-all-time" aria-selected="true">Top đánh giá</a>
                    </div>
                </div>
                <div class="col-12 top-ratings__content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="top-all-time" role="tabpanel"
                            aria-labelledby="top-all-time-list">
                            <ul class="list-unstyled">
                                <?php foreach ($top_ratings as $i => $item): ?>
                                    <li class="mb-2">
                                        <div class="rating-item d-flex align-items-center">
                                            <div class="rating-item__number bg-<?= $i == 0 ? 'danger' : ($i == 1 ? 'success' : ($i == 2 ? 'info' : 'light')) ?> rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                                                <span class="<?= $i < 3 ? 'text-light' : 'text-dark' ?>"><?= $i+1 ?></span>
                                            </div>
                                            <div class="rating-item__story ms-2">
                                                <a href="story.php?id=<?= $item['id'] ?>"
                                                    class="text-decoration-none hover-title rating-item__story--name text-one-row"><?= htmlspecialchars($item['name']) ?></a>
                                                <div class="d-flex flex-wrap rating-item__story--categories">
                                                    <?php foreach (explode(',', $item['genres']) as $g): ?>
                                                        <span class="text-dark hover-title me-1"><?= htmlspecialchars(trim($g)) ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                                <span class="badge bg-warning text-dark ms-2"><?= htmlspecialchars($item['rating']) ?>/10</span>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút theme_mode (cả desktop và mobile)
    const themeSwitches = document.querySelectorAll('.theme_mode');
    // Kiểm tra trạng thái dark-mode từ localStorage
    const isDark = localStorage.getItem('dark-mode') === 'true';
    if (isDark) {
        document.body.classList.add('dark-mode');
        themeSwitches.forEach(sw => sw.checked = true);
    } else {
        document.body.classList.remove('dark-mode');
        themeSwitches.forEach(sw => sw.checked = false);
    }
    // Lắng nghe sự kiện thay đổi trên bất kỳ nút nào
    themeSwitches.forEach(sw => {
        sw.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('dark-mode', 'true');
                themeSwitches.forEach(s => s.checked = true);
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('dark-mode', 'false');
                themeSwitches.forEach(s => s.checked = false);
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const desc = document.querySelector('.story-detail__top--desc');
    const btnMore = document.querySelector('.info-more--more');
    const btnCollapse = document.querySelector('.info-more--collapse');

    btnCollapse.style.display = 'none';

    btnMore.addEventListener('click', function() {
        desc.style.removeProperty('max-height');
        desc.style.removeProperty('overflow');
        btnMore.classList.remove('active');
        btnMore.style.display = 'none';
        btnCollapse.style.display = 'flex';
    });

    btnCollapse.addEventListener('click', function(e) {
        e.preventDefault();
        desc.style.maxHeight = '120px';
        desc.style.overflow = 'hidden';
        btnMore.classList.add('active');
        btnMore.style.display = 'flex';
        btnCollapse.style.display = 'none';
        desc.scrollIntoView({behavior: "smooth", block: "center"});
    });
});
</script>
<script>
</script>
<script>

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
                            html += `<li class="list-group-item">
                                <a href="category.php?key_word=${encodeURIComponent(story.name)}" class="text-dark text-decoration-none">${story.name}</a>
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
<script src="./assets/comment.js"></script>
<link rel="stylesheet" href="./assets/comment.css">
<script>
window.currentTruyenId = <?= (int)$story['id'] ?>;
window.currentAccountId = <?= isset($_SESSION['accountid']) ? (int)$_SESSION['accountid'] : 'null' ?>;
window.currentAccountId = (window.currentAccountId === 'null') ? null : window.currentAccountId;
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const truyenID = window.currentTruyenId;
    const filter = document.getElementById('comment_filter_dropdown');
    filter.addEventListener('change', function() {
        if (filter.value === 'like') {
            loadAllCommentsByLike(truyenID);
        } else {
            loadAllCommentsByTime(truyenID, null, filter.value);
        }
    });
    // Gọi mặc định khi load trang
    loadAllCommentsByTime(truyenID, null, filter.value);
});
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-fav-index').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var storyid = this.getAttribute('data-storyid');
            var btnFav = this;
            fetch('fav_book_api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'action=toggle&truyenid=' + storyid + '&userid=<?= isset($_SESSION['accountid']) ? (int)$_SESSION['accountid'] : 0 ?>'
            })
            .then(res => res.json())
            .then(function(data) {
                var text = btnFav.querySelector('.fav-btn-text');
                if (data.status === 'added') {
                    btnFav.classList.add('active');
                    text.innerText = 'Đã thêm vào ưa thích';
                } else if (data.status === 'removed') {
                    btnFav.classList.remove('active');
                    text.innerText = 'Thêm vào ưa thích';
                }
            });
        });
    });
});
</script>
<script>
    window.currentTruyenId = <?= (int)$story['id'] ?>;
    window.currentAccountId = <?= isset($_SESSION['accountid']) ? (int)$_SESSION['accountid'] : 'null' ?>;
</script>
<script>
// Khi gửi bình luận ở story.php:
fetch('comment.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=add&AccountID=${account_id}&TruyenID=${truyen_id}&Comment=${encodeURIComponent(comment)}`
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.getElementById('dropdownPageCaret');
    if (dropdownBtn) {
        const dropdownMenu = dropdownBtn.nextElementSibling;
        dropdownMenu.style.display = 'none';

        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.dropdown-menu[aria-labelledby="dropdownPageCaret"]').forEach(function(menu) {
                if (menu !== dropdownMenu) menu.style.display = 'none';
            });
            dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
        });

        document.addEventListener('click', function() {
            dropdownMenu.style.display = 'none';
        });

        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
</body>
</html>