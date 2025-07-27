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
$sql = "SELECT id, name, genres, chapter, rating, state, image FROM truyen ORDER BY id DESC";
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

$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';
$state = isset($_GET['state']) ? trim($_GET['state']) : '';
$chapter_range = isset($_GET['chapter_range']) ? trim($_GET['chapter_range']) : '';
$key_word = isset($_GET['key_word']) ? trim($_GET['key_word']) : '';

$stories = [];
$title = '';

$where = [];
$params = [];
$types = '';

// XỬ LÝ LỌC THEO TỪ KHÓA TRƯỚC KHI TẠO SQL
if ($key_word !== '') {
    if ($key_word === 'Truyện Hot') {
        $where[] = "rating >= 8";
        $title = "Truyện Hot";
    } elseif ($key_word === 'Truyện đã hoàn thành') {
        $where[] = "state = 'Hoàn thành'";
        $title = "Truyện đã hoàn thành";
    } elseif ($key_word === 'Truyện Mới') {
        // Không cần where, chỉ đổi title
        $title = "Truyện Mới";
    } else {
        $where[] = "name LIKE ?";
        $params[] = '%' . $key_word . '%';
        $types .= 's';
        $title = $key_word;
    }
}
if ($genre !== '') {
    // Loại bỏ dấu cách trong genres và genre_search để so sánh chính xác
    $genre_search = strtolower(str_replace('_', '', $genre)); // slice_of_life -> sliceoflife
    $where[] = "(LOWER(CONCAT(',', REPLACE(genres, ' ', ''), ',')) LIKE ?)";
    $params[] = "%," . $genre_search . ",%";
    $types .= 's';
    $title = ucwords(str_replace('_', ' ', $genre));
}
if ($state !== '') {
    $where[] = "state = ?";
    $params[] = $state;
    $types .= 's';
    $title = $state;
}
if ($chapter_range !== '') {
    if ($chapter_range == 'under_50') {
        $where[] = "chapter < 50";
        $title = "Dưới 50 chương";
    } elseif ($chapter_range == '50_100') {
        $where[] = "chapter >= 50 AND chapter <= 100";
        $title = "50 - 100 chương";
    } elseif ($chapter_range == '100_500') {
        $where[] = "chapter > 100 AND chapter <= 500";
        $title = "100 - 500 chương";
    } elseif ($chapter_range == '500_1000') {
        $where[] = "chapter > 500 AND chapter <= 1000";
        $title = "500 - 1000 chương";
    } elseif ($chapter_range == 'over_1000') {
        $where[] = "chapter > 1000";
        $title = "Trên 1000 chương";
    }
}

$sql = "SELECT id, name, image, state, rating, chapter FROM truyen";
if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $stories[] = $row;
}
if ($title == '') $title = 'Tất cả truyện';
$stories_per_page = 24;
$total_stories = count($stories);
$total_pages = ceil($total_stories / $stories_per_page);
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
if ($current_page > $total_pages) $current_page = $total_pages;
$start = ($current_page - 1) * $stories_per_page;
$stories_on_page = array_slice($stories, $start, $stories_per_page);

// Hàm tạo URL phân trang cho category
function build_category_page_url($page) {
    $params = $_GET;
    $params['page'] = $page;
    return basename($_SERVER['PHP_SELF']) . '?' . http_build_query($params);
}

$key_word = isset($_GET['key_word']) ? trim($_GET['key_word']) : '';
if ($key_word !== '') {
    if ($key_word === 'Truyện Hot') {
        $where[] = "rating >= 8";
        $title = "Truyện Hot";
    } elseif ($key_word === 'Truyện đã hoàn thành') {
        $where[] = "state = 'Hoàn thành'";
        $title = "Truyện đã hoàn thành";
    } elseif ($key_word === 'Truyện Mới') {
        // Không cần where, chỉ đổi title
        $title = "Truyện Mới";
    } else {
        $where[] = "name LIKE ?";
        $params[] = '%' . $key_word . '%';
        $types .= 's';
        $title = $key_word;
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



    <script>
        window.SuuTruyen = {
            baseUrl: 'https://suustore.com',
            urlCurrent: 'https://suustore.com',
            csrfToken: '4EebYu2rWivdRk1ET12dyuY0CJjpRERhJynPtvUy'
        }
    </script>

    <title>Database Project</title> <!--Chú thích 5: Đổi tên web-->
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
    </div>    
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
                        <div class="me-auto">
                        <form class="d-flex justify-content-start header__form-search" action="" method="GET">
                            <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word"
                                value="">
                            <div class="col-12 search-result shadow no-result d-none">
                                <div class="card text-white bg-light">
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush d-none">
                                            <li class="list-group-item">
                                                <a href="#" class="text-dark hover-title">Tự cẩm</a>
                                            </li>
                                        </ul>
                                    </div>
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
    <div class="container">
    <div class="row align-items-start">
        <div class="col-12 col-md-8 col-lg-9 mb-3">
            <div class="head-title-global d-flex justify-content-between mb-2">
                <div class="col-12 col-md-12 col-lg-12 head-title-global__left d-flex">
                    <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                        <span class="d-block text-decoration-none text-dark fs-4 category-name"
                            title="<?= htmlspecialchars($title) ?>">
                            <?= htmlspecialchars($title) ?>
                        </span>
                    </h2>
                </div>
            </div>
            <div class="list-story-in-category section-stories-hot__list">
    <?php if (!empty($stories_on_page)): ?>
        <?php foreach ($stories_on_page as $story): ?>
            <div class="story-item position-relative">
    <a href="story.php?id=<?= $story['id'] ?>" class="d-block text-decoration-none">
        <div class="story-item__image position-relative">
            <img src="uploads/<?= htmlspecialchars($story['image']) ?>"
                 alt="<?= htmlspecialchars($story['name']) ?>"
                 class="img-fluid" width="150" height="260" loading="lazy">
            <?php if (empty($genre) && !empty($chapter_range || $state)): ?>
                <span class="badge bg-primary position-absolute top-0 end-0 m-1">
                    <?= (int)$story['chapter'] ?> chương
                </span>
            <?php elseif (empty($chapter_range) && empty($state)): ?>
                <span class="badge bg-primary position-absolute top-0 end-0 m-1 d-none"></span>
            <?php endif; ?>
        </div>
        <h3 class="story-item__name text-one-row story-name"><?= htmlspecialchars($story['name']) ?></h3>
        <?php if (empty($chapter_range) && empty($state)): ?>
        <div class="list-badge">
            <span class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>
            <?php if (isset($story['rating']) && $story['rating'] >= 8): ?>
                <span class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>
            <?php endif; ?>
            <?php if ($story['state'] === 'Hoàn thành'): ?>
                <span class="story-item__badge badge text-bg-success">Full</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </a>
</div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>Chưa có truyện phù hợp.</div>
    <?php endif; ?>
</div>

<!-- PHÂN TRANG -->
<div class="pagination" style="justify-content: center;">
    <ul class="pagination align-items-center">
        <?php if ($total_pages > 1): ?>
            <?php if ($current_page > 1): ?>
                <li class="pagination__arrow pagination__item">
                    <a href="<?= build_category_page_url($current_page - 1) ?>" class="page-link">&lt;&lt;</a>
                </li>
            <?php endif; ?>

            <li class="pagination__item <?= $current_page == 1 ? 'page-current' : '' ?>">
                <a href="<?= build_category_page_url(1) ?>" class="page-link">1</a>
            </li>

            <?php
            if ($current_page > 3 && $total_pages > 4) {
                echo '<li class="pagination__item disabled"><span class="page-link">...</span></li>';
            }
            $start_page = max(2, $current_page - 1);
            $end_page = min($total_pages - 1, $current_page + 1);
            if ($current_page <= 3) $end_page = min(3, $total_pages - 1);
            if ($current_page >= $total_pages - 2) $start_page = max(2, $total_pages - 2);
            for ($i = $start_page; $i <= $end_page; $i++) {
                ?>
                <li class="pagination__item <?= $current_page == $i ? 'page-current' : '' ?>">
                    <a href="<?= build_category_page_url($i) ?>" class="page-link"><?= $i ?></a>
                </li>
            <?php } ?>
            <?php if ($end_page < $total_pages - 1) : ?>
                <li class="pagination__item dropdown position-relative" style="vertical-align: middle;">
                    <button class="btn btn-light btn-sm px-2 py-1" type="button" id="dropdownPageList"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="border-radius: 6px; font-weight: bold; width: 36px; height: 36px; padding: 0;">
                        ...
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="dropdownPageList"
                        style="max-height: 300px; overflow-y: auto; bottom: 100%; top: auto; transform: translateY(-8px);">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li>
                                <a class="dropdown-item<?= $i == $current_page ? ' active' : '' ?>" href="<?= build_category_page_url($i) ?>">
                                    Trang <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($total_pages > 1): ?>
                <li class="pagination__item <?= $current_page == $total_pages ? 'page-current' : '' ?>">
                    <a href="<?= build_category_page_url($total_pages) ?>" class="page-link"><?= $total_pages ?></a>
                </li>
            <?php endif; ?>

            <?php if ($current_page < $total_pages): ?>
                <li class="pagination__arrow pagination__item">
                    <a href="<?= build_category_page_url($current_page + 1) ?>" class="page-link">&gt;&gt;</a>
                </li>
            <?php endif; ?>
        <?php else: ?>
            <li class="pagination__item page-current">
                <a href="<?= build_category_page_url(1) ?>" class="page-link">1</a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<!-- END PHÂN TRANG -->

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

</body>

</html>