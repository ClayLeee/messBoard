<?php

    session_start();
    require_once('conn.php');


    if(isset($_POST['username']) && isset($_POST['password'])) {
        /* 防止SQL Injection，使用prepare statement寫法*/
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $username = $_POST['username'];
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if(password_verify($_POST['password'], $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                echo 'pass';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }

        $conn->close();
        $stmt->close();
        
    } else {
        echo 'error';
    }

?>
