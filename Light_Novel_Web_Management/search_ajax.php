<?php
// filepath: c:\Users\PC\Downloads\Template_Web_update\Template_Web\Template-Web\search_ajax.php
header('Content-Type: application/json');
$keyword = isset($_GET['key_word']) ? trim($_GET['key_word']) : '';
if ($keyword === '') {
    echo json_encode([]);
    exit;
}
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "user_accounts";
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}
$stmt = $conn->prepare("SELECT id, name, image, genres, chapter FROM truyen WHERE name LIKE CONCAT('%', ?, '%') ORDER BY id DESC LIMIT 15");
$stmt->bind_param("s", $keyword);
$stmt->execute();
$result = $stmt->get_result();
$stories = [];
while ($row = $result->fetch_assoc()) {
    $stories[] = $row;
}
echo json_encode($stories);
$stmt->close();
$conn->close();