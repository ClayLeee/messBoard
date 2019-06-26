<?php

session_start();

require_once('conn.php');

$stmt = $conn->prepare("INSERT INTO comments (user_id, parent_id, content) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $parent_id, $content);
$user_id = $_SESSION['user_id'];
$parent_id = $_POST['parent_id'];
$content = $_POST['content'];
$stmt->execute();


$comment_id = $conn->insert_id;

$stmt = "SELECT username, nickname, created_at FROM comments INNER JOIN users ON comments.id = $comment_id AND users.id = comments.user_id";
$result = $conn->query($stmt) or die($conn->error);
$row = $result->fetch_assoc();

$arr = array(
    'username' => $row['username'],
    'nickname' => $row['nickname'],
    'comment_id' => $comment_id,
    'created_at' => $row['created_at']
);

echo json_encode($arr);


?>