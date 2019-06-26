<?php
    require_once('conn.php');

    $stmt = $conn->prepare("DELETE FROM comments WHERE id= ? OR parent_id = ?");
    $stmt->bind_param('ii', $id, $parent_id);
    $id = $_POST['comment_id'];
    $parent_id = $_POST['comment_id'];
    
    if( $stmt->execute() ) {
        echo 'deleted';
    } else {
        echo 'error';
    }

    $stmt->close();
?>