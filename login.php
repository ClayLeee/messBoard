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
    <link rel="stylesheet" type="text/css" media="screen" href="css/loginfinal.css">

    <!-- jQuery -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/loginfinalwork.js"></script>

    <title>登入</title>

  </head>
  <body>
        <div class="background-img"></div>
        <div class="login jumbotron">
            <div class="login__title">登入</div>
            <div class="alert alert-dismissible alert-danger" id="login__alert">
                <p class="warning"></p>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <form>
                <fieldset>
                    <div class="form-group">
                        <label class="col-form-label" for="username">您的帳號:</label>
                        <input type="text" class="form-control" name="username" placeholder="Username" id="login__username">
                    </div>
                    <div class="form-group">
                        <label for="password">您的密碼:</label>
                        <input type="password" class="form-control" name="password" id="login__password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-info" id="login__submit">登入</button>
                        <button type="button" class="btn btn-info" onclick="location.href='index.php'">返回留言板</button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-link" onclick="location.href='register.php'">還沒有帳號? 請按此註冊</button>
                    </div>
                </fieldset>
            </form>
        </div>
  </body>
</html>