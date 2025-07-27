<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['accountid'])) {
    header("Location: login.php?error=chua_dang_nhap");
    exit;
}
$userid = (int)$_SESSION['accountid']; // Lấy ID người dùng

// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

// Thêm danh sách thể loại mặc định để tránh lỗi $genres_list
$genres_list = [
    'Shounen', 'Shoujo', 'Seinen', 'Josei', 'Isekai', 'Harem', 'Mecha', 'Slice of Life', 'Sports', 'Supernatural',
    'Romance', 'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Mystery', 'Psychological', 'School Life', 'Tragedy'
];

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Lấy danh sách truyện ưa thích của user từ fav_book
$sql = "SELECT t.id, t.name, t.genres, t.chapter, t.rating, t.state
        FROM fav_book fb
        JOIN truyen t ON fb.truyenid = t.id
        WHERE fb.userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
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



    <!-- Main Content -->
    <main>
<div class="container mt-5">
    <h3 class="text-center mb-4">Danh sách truyện ưa thích</h3>
    <table class="table table-bordered table-hover" id="story-table">
        <thead class="table-dark">
            <!-- Hàng lọc nằm TRÊN tiêu đề -->
            <tr>
                <th><input type="text" class="form-control form-control-sm" id="filter-id" placeholder="Lọc ID"></th>
                <th><input type="text" class="form-control form-control-sm" id="filter-name" placeholder="Lọc tên truyện"></th>
                <th><input type="text" class="form-control form-control-sm" id="filter-genre" placeholder="Lọc thể loại"></th>
                <th></th>
                <th></th>
                <th>
                    <select class="form-select form-select-sm" id="filter-state">
                        <option value="">Tất cả</option>
                        <option value="Hoàn thành">Hoàn thành</option>
                        <option value="Đang tiến hành">Đang tiến hành</option>
                        <option value="Tạm dừng">Tạm dừng</option>
                    </select>
                </th>
                <th></th>
            </tr>
            <!-- Tiêu đề bảng -->
            <tr>
                <th>ID</th>
                <th>Tên truyện</th>
                <th>Thể loại</th>
                <th>Số chương</th>
                <th>Đánh giá</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['genres']); ?></td>
                        <td><?php echo htmlspecialchars($row['chapter']); ?></td>
                        <td><?php echo number_format($row['rating'], 1); ?></td>
                        <td><?php echo htmlspecialchars($row['state']); ?></td>
                        <td>
                            <a href="story.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Xem</a>
                            <a href="remove_fav.php?truyenid=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa truyện này khỏi ưa thích?');">Xóa khỏi ưa thích</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Bạn chưa thêm truyện nào vào danh sách ưa thích.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    </main>



    <!-- Footer -->
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

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/popper.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
    <script src="./assets/app.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('story-table');
    const rows = table.querySelectorAll('tbody tr');
    const filterId = document.getElementById('filter-id');
    const filterName = document.getElementById('filter-name');
    const filterGenre = document.getElementById('filter-genre');
    const filterState = document.getElementById('filter-state');

    function filterTable() {
        const idVal = filterId.value.trim().toLowerCase();
        const nameVal = filterName.value.trim().toLowerCase();
        const genreVal = filterGenre.value.trim().toLowerCase();
        const stateVal = filterState.value.trim();

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length < 7) return;
            const id = cells[0].textContent.trim().toLowerCase();
            const name = cells[1].textContent.trim().toLowerCase();
            const genre = cells[2].textContent.trim().toLowerCase();
            const state = cells[5].textContent.trim();

            let show = true;
            if (idVal && !id.includes(idVal)) show = false;
            if (nameVal && !name.includes(nameVal)) show = false;
            if (genreVal && !genre.includes(genreVal)) show = false;
            if (stateVal && state !== stateVal) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    filterId.addEventListener('input', filterTable);
    filterName.addEventListener('input', filterTable);
    filterGenre.addEventListener('input', filterTable);
    filterState.addEventListener('change', filterTable);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('story-table');
    const rows = table.querySelectorAll('tbody tr');
    const filterId = document.getElementById('filter-id');
    const filterName = document.getElementById('filter-name');
    const filterGenre = document.getElementById('filter-genre');
    const filterState = document.getElementById('filter-state');

    function filterTable() {
        const idVal = filterId.value.trim().toLowerCase();
        const nameVal = filterName.value.trim().toLowerCase();
        const genreVal = filterGenre.value.trim().toLowerCase();
        const stateVal = filterState.value.trim();

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length < 7) return;
            const id = cells[0].textContent.trim().toLowerCase();
            const name = cells[1].textContent.trim().toLowerCase();
            const genre = cells[2].textContent.trim().toLowerCase();
            const state = cells[5].textContent.trim();

            let show = true;
            if (idVal && !id.includes(idVal)) show = false;
            if (nameVal && !name.includes(nameVal)) show = false;
            if (genreVal && !genre.includes(genreVal)) show = false;
            if (stateVal && state !== stateVal) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    filterId.addEventListener('input', filterTable);
    filterName.addEventListener('input', filterTable);
    filterGenre.addEventListener('input', filterTable);
    filterState.addEventListener('change', filterTable);
});
</script>
</body>

</html>
<!-- ...phần footer và script giữ nguyên... -->
<?php
$conn->close();
?>