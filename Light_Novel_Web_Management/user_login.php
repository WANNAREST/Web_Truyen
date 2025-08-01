<?php
session_start();
$username = $_SESSION['username']; // Lấy tên người dùng từ session, nếu không có thì mặc định là 'Khách'
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
                <a class="navbar-brand" href="user_login.php">
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
                                <li><a class="dropdown-item" href="#">Dưới 50</a>
                                </li>
                                <li><a class="dropdown-item" href="#">50 - 100</a>
                                </li>
                                <li><a class="dropdown-item" href="#">100 - 500</a>
                                </li>
                                <li><a class="dropdown-item" href="#">500 - 1000</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Trên 1000</a>
                                </li>
                            </ul>
                        </li>
    <!-- Thêm mục Xếp hạng -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        Xếp hạng
    </a>
    <ul class="dropdown-menu dropdown-menu-custom">
        <li><a class="dropdown-item" href="#">Top ngày</a></li>
        <li><a class="dropdown-item" href="#">Top tuần</a></li>
        <li><a class="dropdown-item" href="#">Top tháng</a></li>
        <li><a class="dropdown-item" href="#">Top all time</a></li>
        <li><a class="dropdown-item" href="#">Top đánh giá</a></li>
    </ul>
</li>
<!-- Thêm mục Trạng thái -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Trạng thái
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item" href="#">Đang phát hành</a></li>
                                <li><a class="dropdown-item" href="#">Đã hoàn thành</a></li>
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
                    <form class="d-flex align-items-center header__form-search" action="" method="GET"> <!--Chỉnh kích cỡ hộp tìm kiếm-->
                        <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word"
                            value="" style="height: 35px;"> 
                        <button class="btn" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                <path
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                </path>
                            </svg>
                        </button>
                        </div>
                        <!--Chú thích 4: Thêm icon hình người và menu Tài khoản-->
                        <div class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- Icon hình người -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z"/>
                                </svg>
                                <?= htmlspecialchars($username) ?> <!-- Biến này sẽ được thay thế bằng tên người dùng thực tế -->
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile.php">Thông tin tài khoản</a></li>
                                <li><a class="dropdown-item" href="index.php">Đăng xuất</a></li>
                            </ul>
                        </div>
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
                                                <a href="#" class="text-dark hover-title">Tự
                                                    cẩm</a>
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
        <div class="section-stories-hot mb-3">
            <div class="container">
                <div class="row">
                    <div class="head-title-global d-flex justify-content-between mb-2">
                        <div class="col-6 col-md-4 col-lg-4 head-title-global__left d-flex align-items-center">
                            <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                <a href="#" class="d-block text-decoration-none text-dark fs-4 story-name"
                                    title="Truyện Hot">Truyện Hot</a>
                            </h2>
                            <i class="fa-solid fa-fire-flame-curved"></i>
                        </div>

                        <div class="col-4 col-md-3 col-lg-2">
                            <select class="form-select select-stories-hot" aria-label="Truyen hot">
                                <option selected="">Tất cả</option>
                                <option value="1">Ngôn Tình</option>
                                <option value="2">Trọng Sinh</option>
                                <option value="3">Cổ Đại</option>
                                <option value="4">Tiên Hiệp</option>
                                <option value="5">Ngược</option>
                                <option value="6">Khác</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="section-stories-hot__list">
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/tu_cam.jpg" alt="Tự Cẩm" class="img-fluid" width="150"
                                            height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Tự Cẩm</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/ngao_the_dan_than.jpg" alt="Ngạo Thế Đan Thần"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Ngạo Thế Đan Thần</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/nang_khong_muon_lam_hoang_hau.jpg"
                                            alt="Nàng Không Muốn Làm Hoàng Hậu" class="img-fluid" width="150"
                                            height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Nàng Không Muốn Làm Hoàng Hậu
                                    </h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/kieu_sung_vi_thuong.jpg" alt="Kiều Sủng Vi Thượng"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Kiều Sủng Vi Thượng</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/linh_vu_thien_ha.jpg" alt="Linh Vũ Thiên Hạ"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Linh Vũ Thiên Hạ</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/anh_dao_ho_phach.jpg" alt="Anh Đào Hổ Phách"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Anh Đào Hổ Phách</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/than_dao_dan_ton.jpg" alt="Thần Đạo Đan Tôn"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Thần Đạo Đan Tôn</h3>

                                    <div class="list-badge">

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/cuoi_truoc_yeu_sau_mong_tieu_nhi.jpg"
                                            alt="Cưới Trước Yêu Sau - Mộng Tiêu Nhị" class="img-fluid" width="150"
                                            height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Cưới Trước Yêu Sau - Mộng Tiêu
                                        Nhị</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="story.php" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/me_dam.jpg" alt="Mê Đắm" class="img-fluid" width="150"
                                            height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Mê Đắm</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/khong_phu_the_duyen.jpg" alt="Không Phụ Thê Duyên"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Không Phụ Thê Duyên</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/diu_dang_tan_xuong.jpg" alt="Dịu Dàng Tận Xương"
                                            class="img-fluid" width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Dịu Dàng Tận Xương</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/vo_chong_sieu_sao_hoi_ngot.jpg"
                                            alt="Vợ Chồng Siêu Sao Hơi Ngọt" class="img-fluid" width="150" height="230"
                                            loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Vợ Chồng Siêu Sao Hơi Ngọt</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/that_u_that_u_phai_la_hong_phai_xanh_tham.jpg"
                                            alt="Thật Ư? Thật Ư? Phải Là Hồng Phai Xanh Thắm" class="img-fluid"
                                            width="150" height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Thật Ư? Thật Ư? Phải Là Hồng
                                        Phai Xanh Thắm</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/thieu_tuong_vo_ngai_noi_gian_roi.jpg"
                                            alt="Thiếu Tướng, Vợ Ngài Nổi Giận Rồi" class="img-fluid" width="150"
                                            height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Thiếu Tướng, Vợ Ngài Nổi Giận
                                        Rồi</h3>

                                    <div class="list-badge">

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/cung_chieu_vo_nho_troi_ban.jpg"
                                            alt="Cưng Chiều Vợ Nhỏ Trời Ban" class="img-fluid" width="150" height="230"
                                            loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Cưng Chiều Vợ Nhỏ Trời Ban</h3>

                                    <div class="list-badge">

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                            <div class="story-item">
                                <a href="#" class="d-block text-decoration-none">
                                    <div class="story-item__image">
                                        <img src="./assets/images/thien_huong_nguoi_mu_liec_mat_dua_tinh.jpg"
                                            alt="Thiên Hướng Người Mù, Liếc Mắt Đưa Tình" class="img-fluid" width="150"
                                            height="230" loading="lazy">
                                    </div>
                                    <h3 class="story-item__name text-one-row story-name">Thiên Hướng Người Mù, Liếc Mắt
                                        Đưa Tình</h3>

                                    <div class="list-badge">
                                        <span class="story-item__badge badge text-bg-success">Full</span>

                                        <span
                                            class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>

                                        <span
                                            class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>

                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="section-stories-hot__list wrapper-skeleton d-none">
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                            <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
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
                                        <a href="https://suustore.com/#"
                                            class="d-block text-decoration-none text-dark fs-4 story-name"
                                            title="Truyện Mới">Truyện Mới</a>
                                    </h2>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="section-stories-new__list">
                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Kiếm
                                                    Động Cửu Thiên</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                1149</a>
                                        </div>


                                    </div>
                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Tinh
                                                    Thần Biến</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                671</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Linh
                                                    Vũ Thiên Hạ</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Huyền
                                                    Huyễn, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                5024</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Kiếm
                                                    Động Cửu Thiên</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                1149</a>
                                        </div>


                                    </div>
                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Tinh
                                                    Thần Biến</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                671</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Linh
                                                    Vũ Thiên Hạ</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Huyền
                                                    Huyễn, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                5024</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Kiếm
                                                    Động Cửu Thiên</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                1149</a>
                                        </div>


                                    </div>
                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Tinh
                                                    Thần Biến</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                671</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Linh
                                                    Vũ Thiên Hạ</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Huyền
                                                    Huyễn, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                5024</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Kiếm
                                                    Động Cửu Thiên</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                1149</a>
                                        </div>


                                    </div>
                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Tinh
                                                    Thần Biến</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                671</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Linh
                                                    Vũ Thiên Hạ</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Huyền
                                                    Huyễn, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                5024</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Kiếm
                                                    Động Cửu Thiên</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                1149</a>
                                        </div>


                                    </div>
                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Tinh
                                                    Thần Biến</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Kiếm
                                                    Hiệp </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                671</a>
                                        </div>


                                    </div>

                                    <div class="story-item-no-image">
                                        <div class="story-item-no-image__name d-flex align-items-center">
                                            <h3 class="me-1 mb-0 d-flex align-items-center">

                                                <svg style="width: 10px; margin-right: 5px;"
                                                    xmlns="http://www.w3.org/2000/svg" height="1em"
                                                    viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                    </path>
                                                </svg>
                                                <a href="#"
                                                    class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">Linh
                                                    Vũ Thiên Hạ</a>
                                            </h3>
                                            <span class="badge text-bg-info text-light me-1">New</span>

                                            <span class="badge text-bg-success text-light me-1">Full</span>

                                            <span class="badge text-bg-danger text-light">Hot</span>
                                        </div>

                                        <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                            <p class="mb-0">
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Tiên
                                                    Hiệp, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Dị
                                                    Giới, </a>
                                                <a href="#"
                                                    class="hover-title text-decoration-none text-dark category-name">Huyền
                                                    Huyễn, </a>
                                            </p>
                                        </div>

                                        <div class="story-item-no-image__chapters ms-2">
                                            <a href="#" class="hover-title text-decoration-none text-info">Chương
                                                5024</a>
                                        </div>


                                    </div>
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
                                <div class="row">
                                    <!-- Horizontal under breakpoint -->
                                    <ul class="list-category">
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Ngôn Tình</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Trọng
                                                Sinh</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Cổ Đại</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Tiên Hiệp</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Ngược</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Khác</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Dị Giới</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Huyền
                                                Huyễn</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Xuyên
                                                Không</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Sủng</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Cung Đấu</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Gia Đấu</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Điền Văn</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Đô Thị</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Truyện
                                                Teen</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Hài Hước</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Kiếm Hiệp</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Đông
                                                Phương</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Trinh
                                                Thám</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Quan
                                                Trường</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Linh Dị</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Đam Mỹ</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Quân Sự</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Khoa
                                                Huyễn</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Mạt Thế</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Xuyên
                                                Nhanh</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Hệ Thống</a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="text-decoration-none text-dark hover-title">Nữ Cường</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-stories-full mb-3 mt-3">
            <div class="container">
                <div class="row">
                    <div class="head-title-global d-flex justify-content-between mb-2">
                        <div class="col-12 col-md-4 head-title-global__left d-flex">
                            <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                <span class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                    title="Truyện đã hoàn thành">Truyện đã hoàn thành</span>
                            </h2>
                            <!-- <i class="fa-solid fa-fire-flame-curved"></i> -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="section-stories-full__list">
                            <div class="story-item-full text-center">
                                <a href="#" class="d-block story-item-full__image">
                                    <img src="./assets/images/tu_cam.jpg" alt="Tự Cẩm" class="img-fluid w-100"
                                        width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Tự Cẩm
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 836 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/ngao_the_dan_than.jpg" alt="Ngạo Thế Đan Thần"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Ngạo Thế Đan Thần
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 3808 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/nang_khong_muon_lam_hoang_hau.jpg"
                                        alt="Nàng Không Muốn Làm Hoàng Hậu" class="img-fluid w-100" width="150"
                                        height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Nàng Không Muốn Làm Hoàng Hậu
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 80 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/kieu_sung_vi_thuong.jpg" alt="Kiều Sủng Vi Thượng"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Kiều Sủng Vi Thượng
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 81 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/linh_vu_thien_ha.jpg" alt="Linh Vũ Thiên Hạ"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Linh Vũ Thiên Hạ
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 5024 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/anh_dao_ho_phach.jpg" alt="Anh Đào Hổ Phách"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Anh Đào Hổ Phách
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 93 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/cuoi_truoc_yeu_sau_mong_tieu_nhi.jpg"
                                        alt="Cưới Trước Yêu Sau - Mộng Tiêu Nhị" class="img-fluid w-100" width="150"
                                        height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Cưới Trước Yêu Sau - Mộng Tiêu Nhị
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 96 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#" class="d-block story-item-full__image">
                                    <img src="./assets/images/me_dam.jpg" alt="Mê Đắm" class="img-fluid w-100"
                                        width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Mê Đắm
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 118 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/khong_phu_the_duyen.jpg" alt="Không Phụ Thê Duyên"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Không Phụ Thê Duyên
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 177 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/diu_dang_tan_xuong.jpg" alt="Dịu Dàng Tận Xương"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Dịu Dàng Tận Xương
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 108 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/vo_chong_sieu_sao_hoi_ngot.jpg"
                                        alt="Vợ Chồng Siêu Sao Hơi Ngọt" class="img-fluid w-100" width="150"
                                        height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Vợ Chồng Siêu Sao Hơi Ngọt
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 100 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/that_u_that_u_phai_la_hong_phai_xanh_tham.jpg"
                                        alt="Thật Ư? Thật Ư? Phải Là Hồng Phai Xanh Thắm" class="img-fluid w-100"
                                        width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Thật Ư? Thật Ư? Phải Là Hồng Phai Xanh Thắm
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 229 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/thien_huong_nguoi_mu_liec_mat_dua_tinh.jpg"
                                        alt="Thiên Hướng Người Mù, Liếc Mắt Đưa Tình" class="img-fluid w-100"
                                        width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Thiên Hướng Người Mù, Liếc Mắt Đưa Tình
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 70 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/hat_de_va_chanel.jpg" alt="Hạt Dẻ Và Chanel"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Hạt Dẻ Và Chanel
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 6 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/em_anh_va_chung_ta.jpg" alt="Em, Anh Và Chúng Ta"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Em, Anh Và Chúng Ta
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 105 chương</span>
                            </div>
                            <div class="story-item-full text-center">
                                <a href="#"
                                    class="d-block story-item-full__image">
                                    <img src="./assets/images/me_vo_khong_loi_ve.jpg" alt="Mê Vợ Không Lối Về"
                                        class="img-fluid w-100" width="150" height="230" loading="lazy">
                                </a>
                                <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                    <a href="#"
                                        class="text-decoration-none text-one-row story-name">
                                        Mê Vợ Không Lối Về
                                    </a>
                                </h3>
                                <span class="story-item-full__badge badge text-bg-success">Full - 1845 chương</span>
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
                    <li class="me-1">
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="đam mỹ hài">đam mỹ
                                hài</a></span>
                    </li>
                    <li>
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="truyện xuyên nhanh">truyện
                                xuyên
                                nhanh</a></span>
                    </li>
                    <li class="me-1">
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="đam mỹ hài">đam mỹ
                                hài</a></span>
                    </li>
                    <li>
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="truyện xuyên nhanh">truyện
                                xuyên
                                nhanh</a></span>
                    </li>
                    <li class="me-1">
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="đam mỹ hài">đam mỹ
                                hài</a></span>
                    </li>
                    <li>
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="truyện xuyên nhanh">truyện
                                xuyên
                                nhanh</a></span>
                    </li>
                    <li class="me-1">
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="đam mỹ hài">đam mỹ
                                hài</a></span>
                    </li>
                    <li>
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="truyện xuyên nhanh">truyện
                                xuyên
                                nhanh</a></span>
                    </li>
                    <li class="me-1">
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="đam mỹ hài">đam mỹ
                                hài</a></span>
                    </li>
                    <li>
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="truyện xuyên nhanh">truyện
                                xuyên
                                nhanh</a></span>
                    </li>
                    <li class="me-1">
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="đam mỹ hài">đam mỹ
                                hài</a></span>
                    </li>
                    <li>
                        <span class="badge text-bg-light"><a class="text-dark text-decoration-none"
                                href="#" title="truyện xuyên nhanh">truyện
                                xuyên
                                nhanh</a></span>
                    </li>
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



</body>

</html>