<?php
// Kết nối cơ sở dữ liệu
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";

// Khởi tạo kết nối
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy thể loại từ URL
$genre = isset($_GET['genres']) ? $_GET['genres'] : '';

// Kiểm tra nếu thể loại không tồn tại
if (empty($genre)) {
    echo "<h3>Không tìm thấy thể loại!</h3>";
    exit;
}

// Truy vấn danh sách truyện theo thể loại
$sql = "SELECT * FROM truyen WHERE genres LIKE ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Lỗi SQL: ' . $conn->error);
}
$like_genre = '%' . $genre . '%';
$stmt->bind_param("s", $like_genre);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu không có truyện nào
if ($result->num_rows === 0) {
    echo "<h3>Không có truyện nào thuộc thể loại này!</h3>";
    exit;
}

// Lưu danh sách truyện vào mảng
$stories = [];
while ($row = $result->fetch_assoc()) {
    $stories[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách truyện - <?php echo ucfirst(str_replace('_', ' ', $genre)); ?></title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/app.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách truyện thuộc thể loại: <?php echo ucfirst(str_replace('_', ' ', $genre)); ?></h1>
        <div class="row">
            <?php foreach ($stories as $story): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./images/<?php echo $story['id']; ?>.jpg" class="card-img-top" alt="<?php echo $story['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $story['name']; ?></h5>
                            <p class="card-text">Chương: <?php echo $story['chapter']; ?></p>
                            <p class="card-text">Đánh giá: <?php echo $story['rating']; ?></p>
                            <p class="card-text">Trạng thái: <?php echo $story['state']; ?></p>
                            <a href="story.php?id=<?php echo $story['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>