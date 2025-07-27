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

// Xóa truyện khỏi cơ sở dữ liệu
$sql_del_chapters = "DELETE FROM chapters WHERE story_id = ?";
$stmt_del_chapters = $conn->prepare($sql_del_chapters);
if ($stmt_del_chapters === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt_del_chapters->bind_param("i", $story_id);
$stmt_del_chapters->execute();
$stmt_del_chapters->close();

// Sau đó mới xóa truyện
$sql = "DELETE FROM truyen WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$stmt->bind_param("i", $story_id);

if ($stmt->execute()) {
    header("Location: story_list.php?success=xoa_truyen_thanh_cong");
    exit;
} else {
    header("Location: story_list.php?error=loi_xoa_truyen");
    exit;
}

$stmt->close();
$conn->close();
?>