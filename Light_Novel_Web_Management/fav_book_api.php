<?php
session_start();
header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['accountid'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Chưa đăng nhập']);
    exit;
}

$userid = (int)$_SESSION['accountid'];
$truyenid = isset($_POST['truyenid']) ? (int)$_POST['truyenid'] : 0;
$action = $_POST['action'] ?? '';

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'msg' => 'DB error']);
    exit;
}

if ($action === 'toggle' && $truyenid > 0) {
    // Kiểm tra đã có chưa
    $stmt = $conn->prepare("SELECT 1 FROM fav_book WHERE userid=? AND truyenid=?");
    $stmt->bind_param("ii", $userid, $truyenid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Xóa khỏi ưa thích
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM fav_book WHERE userid=? AND truyenid=?");
        $stmt->bind_param("ii", $userid, $truyenid);
        $stmt->execute();
        echo json_encode(['status' => 'removed']);
    } else {
        // Thêm vào ưa thích
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO fav_book(userid, truyenid) VALUES (?, ?)");
        $stmt->bind_param("ii", $userid, $truyenid);
        $stmt->execute();
        echo json_encode(['status' => 'added']);
    }
    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode(['status' => 'error', 'msg' => 'Thao tác không hợp lệ']);