<?php
// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID truyện từ URL
$story_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$story_id) {
    die("ID truyện không hợp lệ.");
}

// Lấy thông tin truyện
$sql_story = "SELECT * FROM truyen WHERE id = ?";
$stmt_story = $conn->prepare($sql_story);
$stmt_story->bind_param("i", $story_id);
$stmt_story->execute();
$result_story = $stmt_story->get_result();
$story = $result_story->fetch_assoc();

// Lấy danh sách chương
// Bảng chapters thường có các thuộc tính như sau:
// id (int, khóa chính), story_id (int, khóa ngoại liên kết với bảng truyen), title (varchar, tiêu đề chương), content (text, nội dung chương), created_at (datetime, ngày tạo), updated_at (datetime, ngày cập nhật)
$sql_chapters = "SELECT * FROM chapters WHERE story_id = ?";
$stmt_chapters = $conn->prepare($sql_chapters);
$stmt_chapters->bind_param("i", $story_id);
$stmt_chapters->execute();
$result_chapters = $stmt_chapters->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($story['name']) ?> - Chi tiết truyện</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/app.css">
</head>

<body>
    <header class="header d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Trang chủ</a>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <div class="row">
            <!-- Ảnh bìa và thông tin truyện -->
            <div class="col-md-4">
                <img src="uploads/<?= htmlspecialchars($story['image']) ?>" alt="<?= htmlspecialchars($story['name']) ?>" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h1><?= htmlspecialchars($story['name']) ?></h1>
                <p><strong>Thể loại:</strong> <?= htmlspecialchars($story['genres']) ?></p>
                <p><strong>Số chương:</strong> <?= htmlspecialchars($story['chapter']) ?></p>
                <p><strong>Đánh giá:</strong> <?= htmlspecialchars($story['rating']) ?>/10</p>
                <p><strong>Trạng thái:</strong> <?= htmlspecialchars($story['state']) ?></p>
            </div>
        </div>

        <!-- Nội dung truyện -->
        <div class="mt-5">
            <h3>Nội dung</h3>
            <p><?= nl2br(htmlspecialchars($story['content'])) ?></p>
        </div>

        <!-- Danh sách chương -->
        <div class="mt-5">
            <h3>Danh sách chương</h3>
            <ul class="list-group">
                <?php while ($chapter = $result_chapters->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <h5><?= htmlspecialchars($chapter['title']) ?></h5>
                        <p><?= nl2br(htmlspecialchars($chapter['content'])) ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Suu Truyện. All rights reserved.</p>
    </footer>
</body>

</html>
<?php
$stmt_story->close();
$stmt_chapters->close();
$conn->close();
?>