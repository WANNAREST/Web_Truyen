<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}
$admin_username = $_SESSION['admin_username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/app.css">
    <title>Thêm Truyện Mới</title>
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 shadow-lg">
                        <div class="card-header text-center bg-dark text-white">
                            <h3>Thêm Truyện Mới</h3>
                        </div>
                        <div class="card-body">
                            <form action="process_add_story.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Tên truyện</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên truyện" required>
                                </div>
<div class="mb-4">
    <label class="form-label">Thể loại</label>
    <div id="genres-group">
        <div class="input-group mb-2 genre-item">
            <select class="form-select" name="genres[]" required>
                <option value="" disabled selected>Chọn thể loại</option>
                <option value="Shounen">Shounen</option>
                <option value="Shoujo">Shoujo</option>
                <option value="Seinen">Seinen</option>
                <option value="Josei">Josei</option>
                <option value="Isekai">Isekai</option>
                <option value="Harem">Harem</option>
                <option value="Mecha">Mecha</option>
                <option value="Slice of Life">Slice of Life</option>
                <option value="Sports">Sports</option>
                <option value="Supernatural">Supernatural</option>
                <option value="Romance">Romance</option>
                <option value="Action">Action</option>
                <option value="Adventure">Adventure</option>
                <option value="Comedy">Comedy</option>
                <option value="Drama">Drama</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Mystery">Mystery</option>
                <option value="Psychological">Psychological</option>
                <option value="School Life">School Life</option>
                <option value="Tragedy">Tragedy</option>
            </select>
            <button type="button" class="btn btn-danger ms-2 remove-genre">Xóa thể loại</button>
        </div>
    </div>
    <button type="button" class="btn btn-secondary mt-2" id="add-genre">Thêm thể loại</button>
</div>
                                <div class="mb-4">
                                    <label for="chapter" class="form-label">Số chương</label>
                                    <input type="number" class="form-control" id="chapter" name="chapter" placeholder="Nhập số chương" required>
                                </div>
                                <div class="mb-4">
                                    <label for="rating" class="form-label">Đánh giá</label>
                                    <input type="number" step="0.1" class="form-control" id="rating" name="rating" placeholder="Nhập đánh giá (từ 0 đến 10)" required>
                                </div>
                                <div class="mb-4">
                                    <label for="author" class="form-label">Tác giả</label>
                                    <input type="text" class="form-control" id="author" name="author" placeholder="Nhập tên tác giả" required>
                                </div>
                                <div class="mb-4">
                                    <label for="state" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="Đang tiến hành">Đang tiến hành</option>
                                        <option value="Hoàn thành">Hoàn thành</option>
                                        <option value="Tạm ngưng">Tạm ngưng</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="image" class="form-label">Ảnh truyện</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="mb-4">
                                    <label for="content" class="form-label">Nội dung truyện</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" placeholder="Nhập nội dung truyện" required></textarea>
                                <div class="mb-4">
                                    <label for="chapters" class="form-label">Nội dung theo chương</label>
                                    <div id="chapters">
                                        <div class="chapter mb-3">
                                            <label for="chapter_title_1" class="form-label">Tiêu đề chương 1</label>
                                            <input type="text" class="form-control mb-2" id="chapter_title_1" name="chapter_titles[]" placeholder="Nhập tiêu đề chương" required>
                                            <textarea class="form-control" id="chapter_content_1" name="chapter_contents[]" rows="5" placeholder="Nhập nội dung chương" required></textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary mt-2" id="add-chapter">Thêm chương</button>
<button type="button" class="btn btn-danger mt-2 ms-2" id="remove-chapter">Xóa chương</button>
</div>
<button type="submit" class="btn btn-dark w-100 py-2" formaction="process_add_story.php?redirect=story_list.php">Thêm truyện</button>
                            </form>
                        </div>
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
document.getElementById('add-genre').addEventListener('click', function () {
    const genresGroup = document.getElementById('genres-group');
    // Tạo select mới
    const div = document.createElement('div');
    div.className = 'input-group mb-2 genre-item';
    div.innerHTML = `
        <select class="form-select" name="genres[]" required>
            <option value="" disabled selected>Chọn thể loại</option>
            <option value="Shounen">Shounen</option>
            <option value="Shoujo">Shoujo</option>
            <option value="Seinen">Seinen</option>
            <option value="Josei">Josei</option>
            <option value="Isekai">Isekai</option>
            <option value="Harem">Harem</option>
            <option value="Mecha">Mecha</option>
            <option value="Slice of Life">Slice of Life</option>
            <option value="Sports">Sports</option>
            <option value="Supernatural">Supernatural</option>
            <option value="Romance">Romance</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Mystery">Mystery</option>
            <option value="Psychological">Psychological</option>
            <option value="School Life">School Life</option>
            <option value="Tragedy">Tragedy</option>
        </select>
        <button type="button" class="btn btn-danger ms-2 remove-genre">Xóa thể loại</button>
    `;
    genresGroup.appendChild(div);
    addRemoveGenreEvent();
});

function addRemoveGenreEvent() {
    document.querySelectorAll('.remove-genre').forEach(function(btn) {
        btn.onclick = function() {
            const genresGroup = document.getElementById('genres-group');
            const genreItems = genresGroup.getElementsByClassName('genre-item');
            if (genreItems.length > 1) {
                this.parentElement.remove();
            }
        }
    });
}
addRemoveGenreEvent();
</script>
<script>
document.getElementById('add-chapter').addEventListener('click', function () {
    const chaptersDiv = document.getElementById('chapters');
    const chapterCount = chaptersDiv.getElementsByClassName('chapter').length + 1;

    // Thêm đúng 1 mục tiêu đề chương và nội dung chương mỗi lần bấm
    const newChapter = document.createElement('div');
    newChapter.classList.add('chapter', 'mb-3');
    newChapter.innerHTML = `
        <label for="chapter_title_${chapterCount}" class="form-label">Tiêu đề chương ${chapterCount}</label>
        <input type="text" class="form-control mb-2" id="chapter_title_${chapterCount}" name="chapter_titles[]" placeholder="Nhập tiêu đề chương" required>
        <textarea class="form-control" id="chapter_content_${chapterCount}" name="chapter_contents[]" rows="5" placeholder="Nhập nội dung chương" required></textarea>
    `;
    chaptersDiv.appendChild(newChapter);
});

document.getElementById('remove-chapter').addEventListener('click', function () {
    const chaptersDiv = document.getElementById('chapters');
    const chapterList = chaptersDiv.getElementsByClassName('chapter');
    if (chapterList.length > 1) {
        chaptersDiv.removeChild(chapterList[chapterList.length - 1]);
    }
});
</script>
</body>
  
</html>