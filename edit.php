<?php
    require_once('conn.php');

    $stmt = $conn->prepare("UPDATE comments SET content=? WHERE id=?");
    $stmt->bind_param('is', $id, $content);
    $id = $_POST['id'];
    $content = $_POST['content'];

    if( $stmt->execute() ) {
        echo 'Success edit';
    } else {
        echo 'Error';
    }

    $stmt->close();
    $conn->close();
?>