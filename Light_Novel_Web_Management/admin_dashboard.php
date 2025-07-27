<?php
session_start();

$admin_username = $_SESSION['admin_username']; // Lấy tên người dùng từ session
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
    <link rel="stylesheet" href="./assets/app.css">
    <title>Quản trị viên | Suu Truyện</title>
</head>

<body>
    <header class="header d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
            <div class="container">
                <a class="navbar-brand" href="admin_dashboard.php">
                    <img src="./assets/images/logo_text.png" alt="Logo Suu Truyen" class="img-fluid" style="width: 200px;">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="story_list.php">Quản lý truyện</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user_management.php">Quản lý người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_story.php">Thêm truyện</a>
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

    <main class="container mt-5">
        <h1 class="text-center mb-4">Quản lý truyện</h1>
        <!-- Danh sách truyện -->
        <div class="card">
            <div class="card-header bg-dark text-white">Danh sách truyện</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên truyện</th>
                            <th>Thể loại</th>
                            <th>Số chương</th>
                            <th>Trạng thái</th>
                            <th>Đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Kết nối cơ sở dữ liệu
                        $conn = new mysqli("localhost", "root", "", "user_accounts");
                        if ($conn->connect_error) {
                            die("Kết nối thất bại: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM truyen";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Giả sử cột đánh giá là 'rating', nếu không có thì thay thế bằng giá trị mặc định hoặc tính toán
                                $rating = isset($row['rating']) ? $row['rating'] : 'Chưa có';
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['genres']}</td>
                                    <td>{$row['chapter']}</td>
                                    <td>{$row['state']}</td>
                                    <td>{$rating}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Không có truyện nào</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="./assets/jquery.min.js">
    </script>

    <script src="./assets/popper.min.js">
    </script>

    <script src="./assets/bootstrap.min.js">
    </script>
    <script src="./assets/app.js">
    </script>
    <script src="./assets/common.js"></script>
</body>

</html>