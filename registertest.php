<?php

    session_start();
    require_once('conn.php');
    
    if(isset($_POST['username']) && isset($_POST['nickname']) && isset($_POST['password'])) {
        $chk_sql =$conn->prepare("SELECT username FROM users WHERE username=?");
        $chk_sql->bind_param("s", $username);
        $username= $_POST['username'];
        $chk_sql->execute();
        $result_chk = $chk_sql->get_result();
        if($result_chk->num_rows === 0) {
            $sql = $conn->prepare("INSERT INTO users (username, nickname, password) VALUES (?, ?, ?)");
            $sql->bind_param("sss", $username, $nickname, $password);
            $username = $_POST['username'];
            $nickname= $_POST['nickname'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql->execute(); 
            
            //抓最新的Post，讓最新插入的id(insert_id)等於last_id
            if($sql->affected_rows > 0) {
                $last_id = $conn->insert_id;
                $_SESSION['user_id'] = $last_id;
                $chk_sql->close();
                $sql->close();
                $conn->close();
                echo json_encode('pass');
            } else {
                echo json_encode('error');
            }
        } else {
            echo json_encode('repeat');
        }
        
    } else {
        echo json_encode('error');
    }

?>


