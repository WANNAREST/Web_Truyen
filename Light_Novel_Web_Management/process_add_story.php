<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php?error=chua_dang_nhap");
    exit;
}

// Lấy dữ liệu từ form
$name = filter_input(INPUT_POST, 'name');
$genres = isset($_POST['genres']) ? implode(', ', $_POST['genres']) : '';
$chapter = filter_input(INPUT_POST, 'chapter', FILTER_VALIDATE_INT);
$rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_FLOAT);
$state = filter_input(INPUT_POST, 'state');
$chapter_titles = $_POST['chapter_titles'] ?? [];
$chapter_contents = $_POST['chapter_contents'] ?? [];
$story_content = $_POST['content'] ?? [];
$author = $_POST['author'] ?? '';

// Kiểm tra dữ liệu nhập vào
if (
    !$name || !$genres || !$chapter || !$rating || !$state || !$story_content || !$author ||
    empty($chapter_titles) || empty($chapter_contents) || count($chapter_titles) !== count($chapter_contents)
) {
    header("Location: add_story.php?error=thieu_du_lieu");
    exit;
}

// Xử lý upload ảnh
$image = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowed_types)) {
        $image = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        header("Location: add_story.php?error=loai_anh_khong_hop_le");
        exit;
    }
} else {
    header("Location: add_story.php?error=chua_chon_anh");
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

// Thêm truyện mới vào cơ sở dữ liệu
$sql = "INSERT INTO truyen (name, genres, chapter, rating, state, image, content, author) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssidssss", $name, $genres, $chapter, $rating, $state, $image, $story_content, $author);

if ($stmt->execute()) {
    $new_story_id = $stmt->insert_id;

    // Thêm các chương vào bảng chapters
    $sql_chapter = "INSERT INTO chapters (story_id, title, content, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
    $stmt_chapter = $conn->prepare($sql_chapter);

    foreach ($chapter_titles as $index => $title) {
        $content = $chapter_contents[$index];
        $stmt_chapter->bind_param("iss", $new_story_id, $title, $content);
        $stmt_chapter->execute();
    }

    $stmt_chapter->close();

    // Chuyển hướng về story_list.php nếu thành công
    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
    header("Location: $redirect?success=them_truyen_thanh_cong");
    exit;
} else {
    header("Location: add_story.php?error=them_truyen_that_bai");
    exit;
}

$stmt->close();
$conn->close();
?>