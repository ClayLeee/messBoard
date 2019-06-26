<?php
	session_start();
	require_once('conn.php');
?>
<!DOCTYPE html>
<html lang="zh-TW">
  	<head>
  		<meta charset="UTF-8">
	  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>留言板</title>

		<!--  Bootstrap StyleSheet by BootWatch  -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/mainfinal.css" charset="utf-8">

		<!-- jquery -->
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/mainfinalwork.js"></script>

	</head>

  	<body>
		<div class="background-img"></div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-secondary mt-0">
			<a class="navbar-brand" href="index.php">MESSAGE BOARD</a>
			<div id="navbar__list">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link text-light" href="index.php">主頁<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="register.php">註冊帳號</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="#">關於</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="container-fluid">
<!-- 如果session id是undefined index，加上isset確認是否存在，就可以debug -->
<?php
		if(isset($_SESSION['user_id'])) {
			$stmt_name = $conn->prepare("SELECT nickname, username, id FROM users WHERE id = ?");
			$stmt_name->bind_param("i", $id);
			$id = $_SESSION['user_id'];
			$stmt_name->execute();
			$result_name = $stmt_name->get_result();
			$row_name = $result_name->fetch_assoc();
		}
?>
			<h1 class="board__title display-5 col-sm-10 col-lg-6 mx-auto mt-5">MESSAGE BOARD</h1>
<?php

	if(isset($_SESSION['user_id']) && $row_name['id'] === $_SESSION['user_id']) {

?>
<!-- 登入與主要留言撰寫框 start -->
			<div class="board__form col-lg-6 col-sm-10 mx-auto mb-2 p-4 bg-secondary jumbotron">
				<div class="comment__header">
					<span class="comment__author text-light"><?php echo htmlspecialchars($row_name['username'] . '(' . $row_name['nickname'] .')', ENT_QUOTES, 'utf-8') ?> 您好,在想什麼嗎?</span>
					<button type="button" class="hyperlink__logout btn btn-info">登出</button>
				</div>
				<div>
					<div class="board__form-textarea">
						<textarea name="content" placeholder="留言內容"></textarea>
					</div>
					<input type="hidden" name="parent_id" value="0" />
<?php
	if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
		echo "<button type='button' name='submit' class='board__form-submit main_button btn btn-info'>送出</button>";
	} else {
		echo "<button type='button' name='submit' class='board__form-submit btn btn-info' disabled>請先登入</button>";
	}
?>

				</div>
			</div>
<!-- 登入與主要留言撰寫框 end -->

<?php } else {
?>
<!-- 登入與主要留言撰寫框 start -->
			<div class="board__form col-lg-6 col-sm-10 mx-auto mb-2 p-4 bg-secondary jumbotron">
				<button type="button" onclick="location.href='login.php'" class="hyperlink__login btn btn-info">欲留言請按此登入</button>
			</div>
<!-- 登入與主要留言撰寫框 end -->
<?php }
?>

  			<div class="board__comments bt-1">
<?php
	//查詢留言數量
	$stmt_page = $conn->prepare("SELECT COUNT(parent_id) AS datanum FROM comments WHERE parent_id = ?");
	$stmt_page->bind_param("i", $parent_id);
	$parent_id = 0;
	$stmt_page->execute();
	$result_page = $stmt_page->get_result();
	$row_page = $result_page->fetch_assoc();

	//總頁數，(int)把ceil那串轉成數字
	$pagesnum = (int)ceil( $row_page['datanum'] / 5 );

	//$page 目前頁碼，如果沒有$_GET，或是$_GET非數字，則$page=1
	if( !isset($_GET['page']) OR !intval($_GET['page'])) $page=1;
	else $page = intval($_GET['page']);

	//計算本頁顯示的第一筆留言起始值
	$cmmt_start_num = ($page-1)*5;

	// $out = implode(",", $page_row);
	// echo $cmmt_start_num . $page . $pagesnum . $out;

	//查詢最後五筆留言
	$stmt = $conn->prepare("SELECT c.id AS id, user_id, nickname, username, created_at, content FROM comments AS c INNER JOIN users ON parent_id = ? AND user_id = users.id ORDER BY created_at DESC LIMIT $cmmt_start_num, 5");
	$stmt->bind_param("i", $parent_id);
	$parent_id = 0;
	$stmt->execute();
	$result = $stmt->get_result();

	// $sql = "SELECT c.id AS id, user_id, nickname, username, created_at, content FROM comments AS c INNER JOIN users ON parent_id = 0 AND user_id = users.id ORDER BY created_at DESC LIMIT $cmmt_start_num, 5";
	// $result = $conn->query($sql);
	while ($row = $result->fetch_assoc()) {
?>
<!-- 主流言外框 start -->
				<div class="comment col-lg-6 col-sm-10 mx-auto mb-2 bg-secondary jumbotron">
<!-- 顯示主流言 -->
					<div class="comment__header">
						<div class="comment__author text-light"><?php echo htmlspecialchars($row['username'] . '(' . $row['nickname'] .')', ENT_QUOTES, 'utf-8') ?></div>
						<div class="comment__timestamp text-light"><?php echo $row['created_at'] ?></div>
						<div class="comment__edit-delete">
<?php
	if(isset($_SESSION['user_id']) && $row['user_id'] == $_SESSION['user_id']) {
		echo '<button type="button" class="comment__edit btn btn-outline-info">編輯</button><span>   </span><button type="button" class="comment__delete btn btn-outline-info">刪除</button>';
	}
?>
						</div>
					</div>
					<div class="comment__content text-light"><?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'utf-8') ?></div>
					<div class="comment__id"><?php echo $row['id'] ?></div>

					<div class="board__subcomments">
<?php
	//查詢子留言
	$stmt_child = $conn->prepare("SELECT * FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE parent_id = ? ORDER BY created_at ASC");
	$stmt_child->bind_param("i", $parent_id);
	$parent_id = $row['id'];
	$stmt_child->execute();
	$result_child = $stmt_child->get_result();
	// $parent_id = $row['id'];
	// $sql_child = "SELECT comments.*, users.nickname, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE parent_id = $parent_id ORDER BY created_at ASC";
	// $result_child = $conn->query($sql_child) or die($conn->error);

	while ($row_child = $result_child->fetch_assoc()) {
?>
						<div class="comment">
							<div class="comment__header">
								<div class="comment__author text-light"><?php echo htmlspecialchars($row_child['username'] . '(' . $row_child['nickname'] . ')', ENT_QUOTES, 'utf-8') ?></div>
								<div class="comment__timestamp text-light"><?php echo $row_child['created_at'] ?></div>
								<div class="comment__edit-delete">
<?php
	if(isset($_SESSION['user_id']) && $row_child['user_id'] == $_SESSION['user_id']) {
		echo '<button type="button" class="comment__edit btn btn-outline-info">編輯</button><span>   </span><button type="button" class="comment__delete btn btn-outline-info">刪除</button>';
	}
?>
								</div>
							</div>
							<div class="comment__content text-light"><?php echo htmlspecialchars($row_child['content'], ENT_QUOTES, 'utf-8') ?></div>
							<div class="comment__id"><?php echo $row_child['id'] ?></div>
						</div>
<?php
	}
?>
<!-- 主留言撰寫框 start -->
						<div class="board__form">
<?php
	if(isset($_SESSION['user_id'])) {
?>
							<div class="board__form-author text-info"><?php echo $row_name['username'] . '(' . $row_name['nickname'] . ')' .'，在底下發表您的意見' ?></div>
<?php
	}
	if(empty($_SESSION['user_id'])){
?>
							<div class="board__form-author">
								<button type="button" onclick="location.href='login.php'" class="hyperlink__login btn btn-info">登入以發表回應</button>
							</div>
<?php
	}
?>

							<div class="board__form-textarea">
								<textarea name="content" placeholder="留言內容" required></textarea>
							</div>
							<input type="hidden" name="parent_id" value="<?php echo $row['id'] ?>" />
<?php
	if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
		echo "<button type='button' name='button' class='board__form-submit sub_button btn btn-info'>送出</button>";
	} else {
		echo "<button type='button' name='button' class='board__form-submit btn btn-danger' disabled>請先登入</button>";
	}
?>


						</div>
					</div>
				</div>
<?php
	}
?>
			</div>
			<!-- 分頁部分 -->
			<div class="my-3">
				<ul class="pagination justify-content-center">
<?php
    if( $page === 1 ) {
		echo '<li class="page-item disabled">';
		echo '<a class="page-link" href="#">';
	} else {
		//目前頁碼前一頁顯示
		echo '<li class="page-item">';
		echo '<a class="page-link" href="index.php?page='. ($page-1) .'">';
	}
?>
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
<?php
    for( $i=1; $i<=$pagesnum; $i++ ){
		if( $i === $page ){
			//目前頁面的頁碼 active
			echo '<li class="page-item active"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
		}else{
			//非目前頁面的頁碼連結正常顯示
			echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
		}

	}
	//如果目前在最後一頁，後一頁連結失效
	if( $page === $pagesnum ){
		echo '<li class="page-item disabled">';
		echo '<a class="page-link" href="#">';
	}else{
		echo '<li class="page-item">';
		echo '<a class="page-link" href="index.php?page='. ($page+1) .'">';
	}
?>

							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>