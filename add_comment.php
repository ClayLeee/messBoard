<?php

	session_start();
	require_once('conn.php');
	/*可以把post去資料庫的東西列出來看
	print_r($_POST);
	*/

	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
		//php preparestatement insert method("addc" means add comments)
		$addc = $conn->prepare("INSERT INTO comments (user_id, parent_id, content) VALUES (?, ?, ?)");
        $addc->bind_param("iis", $user_id, $parent_id, $content);
        $nickname = $_POST['nickname'];
		$content = $_POST['content'];
		$parent_id = $_POST['parent_id'];
		$user_id = $_SESSION['user_id'];
		$addc->execute();
		
	}
	

	$addc->close();
	$conn->close();
	
	header('Location: index.php');

?>


