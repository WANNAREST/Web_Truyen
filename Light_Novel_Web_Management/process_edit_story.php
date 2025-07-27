<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

// Lấy dữ liệu từ form
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$name = trim($_POST['name']);
$genres = isset($_POST['genres']) ? implode(', ', $_POST['genres']) : '';
$chapter = filter_input(INPUT_POST, 'chapter', FILTER_VALIDATE_INT);
$rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_FLOAT);
$state = trim($_POST['state']);
$content = trim($_POST['content']);
$author = $_POST['author'] ?? '';

$image = $_FILES['image'] ?? null;
$old_image = $_POST['old_image'] ?? '';

$image_name = $old_image; // Mặc định giữ ảnh cũ

if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $new_name = uniqid('story_', true) . '.' . $ext;
    $upload_path = __DIR__ . '/uploads/' . $new_name;
    if (move_uploaded_file($image['tmp_name'], $upload_path)) {
        $image_name = $new_name;
        // Xóa ảnh cũ nếu có và khác mặc định
        if ($old_image && file_exists(__DIR__ . '/uploads/' . $old_image)) {
            @unlink(__DIR__ . '/uploads/' . $old_image);
        }
    }
}

// Kiểm tra dữ liệu nhập vào
if (!$id || !$name || !$genres || !$chapter || !$rating || !$state || !$content) {
    header("Location: edit_story.php?id=$id&error=thieu_du_lieu");
    exit;
}

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "user_accounts");
if ($conn->connect_error) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error);
}

// Cập nhật thông tin truyện
$sql = "UPDATE truyen SET name=?, genres=?, chapter=?, rating=?, state=?, content=?, author=?, image=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssidssssi", $name, $genres, $chapter, $rating, $state, $content, $author, $image_name, $id);
$stmt->execute();
$stmt->close();

// ====== XỬ LÝ CẬP NHẬT CHƯƠNG ======
if (isset($_POST['chapter_titles'], $_POST['chapter_contents'])) {
    $titles = $_POST['chapter_titles'];
    $contents = $_POST['chapter_contents'];

    // Xóa hết chương cũ của truyện này
    $stmt_del = $conn->prepare("DELETE FROM chapters WHERE story_id = ?");
    $stmt_del->bind_param("i", $id);
    $stmt_del->execute();
    $stmt_del->close();

    // Thêm lại các chương mới
    $stmt_ins = $conn->prepare("INSERT INTO chapters (story_id, title, content) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($titles); $i++) {
        $title = trim($titles[$i]);
        $content = trim($contents[$i]);
        if ($title !== '' && $content !== '') {
            $stmt_ins->bind_param("iss", $id, $title, $content);
            $stmt_ins->execute();
        }
    }
    $stmt_ins->close();
}

$conn->close();

header("Location: story_list.php?success=cap_nhat_thanh_cong");
exit;
?>