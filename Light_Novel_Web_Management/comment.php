<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $account_id = (int)$_POST['AccountID'];
    $truyen_id = (int)$_POST['TruyenID'];
    $comment = trim($_POST['Comment']);
    $chapter_id = isset($_POST['ChapterID']) && $_POST['ChapterID'] !== '' ? (int)$_POST['ChapterID'] : null;
    $parent_id = isset($_POST['ParentID']) ? (int)$_POST['ParentID'] : null;
    $date_time = date('Y-m-d H:i:s');
    if ($account_id && $truyen_id && $comment) {
        $conn = new mysqli("localhost", "root", "", "user_accounts");
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'error' => 'DB connect error']);
            exit;
        }
        if (empty($chapter_id)) {
            // Bình luận cho truyện, truyền NULL cho ChapterID
            $stmt = $conn->prepare("INSERT INTO user_comment (AccountID, TruyenID, Comment, Date_Time_Post, ParentID, ChapterID) VALUES (?, ?, ?, ?, ?, NULL)");
            $stmt->bind_param("iissi", $account_id, $truyen_id, $comment, $date_time, $parent_id);
        } else {
            // Bình luận cho chương
            $stmt = $conn->prepare("INSERT INTO user_comment (AccountID, TruyenID, Comment, Date_Time_Post, ParentID, ChapterID) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissii", $account_id, $truyen_id, $comment, $date_time, $parent_id, $chapter_id);
        }
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing data']);
    }
    exit;
}

// Lấy tất cả bình luận theo truyện (cho JS loadAllCommentsByTime)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_all_comments_by_time') {
    $truyen_id = (int)$_GET['truyen_id'];
    $chapter_id = isset($_GET['chapter_id']) ? (int)$_GET['chapter_id'] : null;
    $order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC'; // Mặc định DESC (mới nhất)
    $conn = new mysqli("localhost", "root", "", "user_accounts");
    $sql = "SELECT uc.*, dk.username 
            FROM user_comment uc 
            JOIN dang_ky dk ON uc.AccountID = dk.id 
            WHERE uc.TruyenID = $truyen_id";
    if ($chapter_id) {
        $sql .= " AND uc.ChapterID = $chapter_id";
    }
    $sql .= " ORDER BY uc.Date_Time_Post $order";
    $result = $conn->query($sql);
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    $conn->close();
    echo json_encode($comments);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'like_comment') {
    $comment_id = (int)$_POST['comment_id'];
    $user_id = (int)$_POST['user_id'];
    $conn = new mysqli("localhost", "root", "", "user_accounts");
    // Kiểm tra đã like chưa
    $check = $conn->query("SELECT id FROM user_comment_like WHERE comment_id=$comment_id AND user_id=$user_id AND type='like'");
    if ($check->num_rows > 0) {
        // Đã like, xóa like
        $conn->query("DELETE FROM user_comment_like WHERE comment_id=$comment_id AND user_id=$user_id AND type='like'");
        $conn->query("UPDATE user_comment SET LikeCount = GREATEST(LikeCount - 1, 0) WHERE CommentID = $comment_id");
        $status = 'unliked';
    } else {
        // Chưa like, thêm like
        $conn->query("INSERT IGNORE INTO user_comment_like (comment_id, user_id, type) VALUES ($comment_id, $user_id, 'like')");
        $conn->query("UPDATE user_comment SET LikeCount = LikeCount + 1 WHERE CommentID = $comment_id");
        $status = 'liked';
    }
    $conn->close();
    echo json_encode(['success' => true, 'status' => $status]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'dislike_comment') {
    $comment_id = (int)$_POST['comment_id'];
    $user_id = (int)$_POST['user_id'];
    $conn = new mysqli("localhost", "root", "", "user_accounts");
    // Kiểm tra đã dislike chưa
    $check = $conn->query("SELECT id FROM user_comment_like WHERE comment_id=$comment_id AND user_id=$user_id AND type='dislike'");
    if ($check->num_rows > 0) {
        // Đã dislike, xóa dislike
        $conn->query("DELETE FROM user_comment_like WHERE comment_id=$comment_id AND user_id=$user_id AND type='dislike'");
        $conn->query("UPDATE user_comment SET DislikeCount = GREATEST(DislikeCount - 1, 0) WHERE CommentID = $comment_id");
        $status = 'undisliked';
    } else {
        // Chưa dislike, thêm dislike
        $conn->query("INSERT IGNORE INTO user_comment_like (comment_id, user_id, type) VALUES ($comment_id, $user_id, 'dislike')");
        $conn->query("UPDATE user_comment SET DislikeCount = DislikeCount + 1 WHERE CommentID = $comment_id");
        $status = 'disliked';
    }
    $conn->close();
    echo json_encode(['success' => true, 'status' => $status]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_all_comments_by_like') {
    $truyen_id = (int)$_GET['truyen_id'];
    $chapter_id = isset($_GET['chapter_id']) ? (int)$_GET['chapter_id'] : null;
    $conn = new mysqli("localhost", "root", "", "user_accounts");
    $sql = "SELECT uc.*, dk.username 
            FROM user_comment uc 
            JOIN dang_ky dk ON uc.AccountID = dk.id 
            WHERE uc.TruyenID = $truyen_id";
    if ($chapter_id) {
        $sql .= " AND uc.ChapterID = $chapter_id";
    }
    $sql .= " ORDER BY uc.LikeCount DESC, uc.Date_Time_Post DESC";
    $result = $conn->query($sql);
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    $conn->close();
    echo json_encode($comments);
    exit;
}
?>