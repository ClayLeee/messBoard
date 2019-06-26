<?php
    session_start();
    require_once('conn.php');
?>

<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        
        <!--  Bootstrap StyleSheet by BootWatch  -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/registerfinal.css">
        
        <!-- jQuery -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/registerfinalwork.js"></script>

        <title>註冊</title>
		
    </head>
    <body>
        <div class="background-img"></div>
        <div class="register jumbotron">
            <div class="register__title">註冊會員</div>
            <div class="alert alert-dismissible alert-danger" id="register__alert">
                <p class="warning"></p>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <form>
                <fieldset>
                    <div class="form-group first">
                        <label class="col-form-label" for="username">請輸入您的Username:</label>
                        <input type="text" class="form-control" name="username" placeholder="Username" id="register__username">
                    </div>
                    <div class="form-group second">
                        <label for="password">請輸入您的Password:</label>
                        <input type="password" class="form-control" name="password" id="register__password" placeholder="Password">
                    </div>
                    <div class="form-group third">
                        <label class="col-form-label" for="nickname">請輸入您的Nickname:</label>
                        <input type="text" class="form-control" name="nickname" placeholder="Nickname" id="register__nickname">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-info" id="register__submit">註冊</button>
                        <button type="button" class="btn btn-info" onclick="location.href='index.php'">返回留言板</button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-link" onclick="location.href='login.php'">已有帳號? 請按此登入</button>
                    </div>
                </fieldset>
            </form>
        </div>    
    </body>
</html>

