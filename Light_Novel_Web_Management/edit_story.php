<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

// Lấy ID truyện từ URL
$story_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$story_id) {
    header("Location: story_list.php?error=id_khong_hop_le");
    exit;
}

// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Lấy thông tin truyện từ cơ sở dữ liệu
$sql = "SELECT name, genres, chapter, rating, state, content, author, image FROM truyen WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("i", $story_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: story_list.php?error=truyen_khong_ton_tai");
    exit;
}

$story = $result->fetch_assoc();
$stmt->close();
$chapters = [];
$sql_chapters = "SELECT id, title, content FROM chapters WHERE story_id = ? ORDER BY id ASC";
$stmt_chapters = $conn->prepare($sql_chapters);
$stmt_chapters->bind_param("i", $story_id);
$stmt_chapters->execute();
$result_chapters = $stmt_chapters->get_result();
while ($chapter = $result_chapters->fetch_assoc()) {
    $chapters[] = $chapter;
}
$stmt_chapters->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/app.css">
    <title>Chỉnh sửa truyện</title>
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
                            <a class="nav-link" href="story_list.php">Danh sách truyện</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 shadow-lg">
                        <div class="card-header text-center bg-dark text-white">
                            <h3>Chỉnh sửa truyện</h3>
                        </div>
                        <div class="card-body">
                            <form action="process_edit_story.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($story_id); ?>">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Tên truyện</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($story['name']); ?>" required>
                                </div>
<div class="mb-4">
    <label for="genres" class="form-label">Thể loại</label>
    <div id="genres-list">
        <?php
        $all_genres = [
            'Shounen', 'Shoujo', 'Seinen', 'Josei', 'Isekai', 'Harem', 'Mecha', 'Slice of Life',
            'Sports', 'Supernatural', 'Romance', 'Action', 'Adventure', 'Comedy', 'Drama',
            'Fantasy', 'Mystery', 'Psychological', 'School Life', 'Tragedy'
        ];
        $selected_genres = array_map('trim', explode(',', $story['genres']));
        foreach ($selected_genres as $i => $genre) {
            if ($genre !== '') {
                echo '<div class="input-group mb-2 genre-item">';
                echo '<select class="form-select" name="genres[]">';
                foreach ($all_genres as $g) {
                    $selected = ($g === $genre) ? 'selected' : '';
                    echo "<option value=\"$g\" $selected>$g</option>";
                }
                echo '</select>';
                echo '<button type="button" class="btn btn-danger ms-2 remove-genre">Xóa thể loại</button>';
                echo '</div>';
            }
        }
        ?>
        <button type="button" class="btn btn-secondary mt-2" id="add-genre">Thêm thể loại</button>
    </div>
    
         <div class="mb-4">
    <label for="image" class="form-label">Ảnh bìa truyện</label>
    <?php if (!empty($story['image'])): ?>
        <div class="mb-2">
            <img src="uploads/<?= htmlspecialchars($story['image']) ?>" alt="Ảnh bìa" style="max-width: 150px; border-radius: 8px;">
        </div>
    <?php endif; ?>
    <input type="file" class="form-control" id="image" name="image" accept="image/*">
    <input type="hidden" name="old_image" value="<?= htmlspecialchars($story['image'] ?? '') ?>">
<!-- </div>
    <button type="button" class="btn btn-secondary mt-2" id="add-genre">Thêm thể loại</button>
</div> -->
                                <div class="mb-4">
                                    <label for="content" class="form-label">Nội dung truyện</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($story['content']); ?></textarea>
                                    </div> 
                                 
                                <div class="mb-4">
                                    <label for="chapter" class="form-label">Số chương</label>
                                    <input type="number" class="form-control" id="chapter" name="chapter" value="<?php echo htmlspecialchars($story['chapter']); ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label for="rating" class="form-label">Đánh giá</label>
                                    <input type="number" step="0.1" class="form-control" id="rating" name="rating" value="<?php echo htmlspecialchars($story['rating']); ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label for="author" class="form-label">Tác giả</label>
<input type="text" class="form-control" id="author" name="author"
    value="<?= isset($story['author']) ? htmlspecialchars($story['author']) : '' ?>" required>                                
</div>
                                <div class="mb-4">
                                    <label for="state" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="Đang tiến hành" <?php echo $story['state'] === 'Đang tiến hành' ? 'selected' : ''; ?>>Đang tiến hành</option>
                                        <option value="Hoàn thành" <?php echo $story['state'] === 'Hoàn thành' ? 'selected' : ''; ?>>Hoàn thành</option>
                                        <option value="Tạm ngưng" <?php echo $story['state'] === 'Tạm ngưng' ? 'selected' : ''; ?>>Tạm ngưng</option>
                                    </select>
                                </div>
<div class="mb-4">
    <label class="form-label">Nội dung theo chương</label>
    <div id="chapters">
        <?php if (count($chapters) > 0): ?>
            <?php foreach ($chapters as $index => $chapter): ?>
                <div class="chapter mb-3">
                    <label for="chapter_title_<?= $index + 1 ?>" class="form-label">Tiêu đề chương <?= $index + 1 ?></label>
                    <input type="text" class="form-control mb-2" id="chapter_title_<?= $index + 1 ?>" name="chapter_titles[]" value="<?= htmlspecialchars($chapter['title']) ?>" required>
                    <textarea class="form-control" id="chapter_content_<?= $index + 1 ?>" name="chapter_contents[]" rows="5" placeholder="Nhập nội dung chương" required><?php
                        // Lấy nội dung chương từ DB nếu có cột content, nếu không thì để trống
                        // Bạn cần sửa lại truy vấn $sql_chapters để lấy cả content nếu muốn
                        if (isset($chapter['content'])) echo htmlspecialchars($chapter['content']);
                    ?></textarea>
                    <button type="button" class="btn btn-danger mt-2 remove-chapter">Xóa chương</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="chapter mb-3">
                <label for="chapter_title_1" class="form-label">Tiêu đề chương 1</label>
                <input type="text" class="form-control mb-2" id="chapter_title_1" name="chapter_titles[]" placeholder="Nhập tiêu đề chương" required>
                <textarea class="form-control" id="chapter_content_1" name="chapter_contents[]" rows="5" placeholder="Nhập nội dung chương" required></textarea>
                <button type="button" class="btn btn-danger mt-2 remove-chapter">Xóa chương</button>
            </div>
        <?php endif; ?>
    </div>
    <button type="button" class="btn btn-secondary mt-2" id="add-chapter">Thêm chương</button>
</div>
                           
                                <!-- Hiển thị thông báo lỗi -->
                                <?php if (isset($_GET['error']) && $_GET['error'] === 'loi_cap_nhat'): ?>
                                    <div class="text-danger mb-3">Lỗi khi cập nhật truyện. Vui lòng thử lại!</div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-dark w-100 py-2">Cập nhật</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <a href="story_list.php" class="text-decoration-none text-dark">Quay lại danh sách truyện</a>
                        </div>
                    </div>
                </div>
            </div>
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
document.getElementById('add-chapter').addEventListener('click', function () {
    const chaptersDiv = document.getElementById('chapters');
    const chapterCount = chaptersDiv.getElementsByClassName('chapter').length + 1;

    const newChapter = document.createElement('div');
    newChapter.classList.add('chapter', 'mb-3');
    newChapter.innerHTML = `
        <label for="chapter_title_${chapterCount}" class="form-label">Tiêu đề chương ${chapterCount}</label>
        <input type="text" class="form-control mb-2" id="chapter_title_${chapterCount}" name="chapter_titles[]" placeholder="Nhập tiêu đề chương" required>
        <textarea class="form-control" id="chapter_content_${chapterCount}" name="chapter_contents[]" rows="5" placeholder="Nhập nội dung chương" required></textarea>
        <button type="button" class="btn btn-danger mt-2 remove-chapter">Xóa chương</button>
    `;
    chaptersDiv.appendChild(newChapter);
    addRemoveEvent();
});

function addRemoveEvent() {
    document.querySelectorAll('.remove-chapter').forEach(function(btn) {
        btn.onclick = function() {
            const chaptersDiv = document.getElementById('chapters');
            const chapterList = chaptersDiv.getElementsByClassName('chapter');
            if (chapterList.length > 1) {
                this.parentElement.remove();
            }
        }
    });
}
addRemoveEvent();
</script>
<script>
const allGenres = [
    'Shounen', 'Shoujo', 'Seinen', 'Josei', 'Isekai', 'Harem', 'Mecha', 'Slice of Life',
    'Sports', 'Supernatural', 'Romance', 'Action', 'Adventure', 'Comedy', 'Drama',
    'Fantasy', 'Mystery', 'Psychological', 'School Life', 'Tragedy'
];

document.getElementById('add-genre').addEventListener('click', function () {
    const genresList = document.getElementById('genres-list');
    const genreCount = genresList.getElementsByClassName('genre-item').length + 1;

    // Tạo select mới
    let selectHtml = '<select class="form-select" name="genres[]">';
    allGenres.forEach(function(g) {
        selectHtml += `<option value="${g}">${g}</option>`;
    });
    selectHtml += '</select>';

    const div = document.createElement('div');
    div.className = 'input-group mb-2 genre-item';
    div.innerHTML = selectHtml + '<button type="button" class="btn btn-danger ms-2 remove-genre">Xóa thể loại</button>';
    genresList.appendChild(div);
    addRemoveGenreEvent();
});

function addRemoveGenreEvent() {
    document.querySelectorAll('.remove-genre').forEach(function(btn) {
        btn.onclick = function() {
            const genresList = document.getElementById('genres-list');
            const genreItems = genresList.getElementsByClassName('genre-item');
            if (genreItems.length > 1) {
                this.parentElement.remove();
            }
        }
    });
}
addRemoveGenreEvent();
</script>
</body>

</html>