<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}
$admin_username = $_SESSION['admin_username'];
// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Lấy danh sách truyện từ bảng `truyen`
$sql = "SELECT id, name, genres, chapter, rating, state FROM truyen";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/app.css">
    <title>Danh sách truyện</title>
</head>

<body>
    <!-- Header -->
    <header class="header d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
            <div class="container">
                <a class="navbar-brand" href="admin_dashboard.php">
                    <img src="./assets/images/logo_text.png" alt="Logo" class="img-fluid" style="width: 200px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="admin_dashboard.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_story.php">Thêm truyện mới</a>
                        </li>
                    </ul>
                    <div class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Icon hình người -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z"/>
                            </svg>
                            <?= htmlspecialchars($admin_username) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="admin_profile.php">Thông tin tài khoản</a></li>
                            <li><a class="dropdown-item" href="index.php">Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
<div class="container mt-5">
    <h3 class="text-center mb-4">Danh sách truyện</h3>
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
                            <a href="edit_story.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="delete_story.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa truyện này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Không có truyện nào trong danh sách.</td>
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
                    <strong>Quản lý truyện</strong> - Hệ thống quản lý truyện online.
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
</body>

</html>
<?php
$conn->close();
?>