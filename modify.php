<?php
    require_once('conn.php');

    
    $stmt = $conn->prepare("UPDATE comments SET content = ? WHERE id = ?");
    // content與id的順序不可顛倒，否則數據庫會無反應
    $stmt->bind_param("si", $content, $id);
    $content = $_POST['content'];
    $id = $_POST['comment_id'];
    

    if ( $stmt->execute() ) {
        echo json_encode('modified');
    } else {
        echo json_encode('error');
    }
    
    $stmt->close();
    $conn->close();
?>