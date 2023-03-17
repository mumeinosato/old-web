<?php

session_start();

require_once '../classes/UserLogic.php';

$result = UserLogic::checkLogin(); 
if($result){
    header('Location: ../admin/index.php');
    return;
}

$err = $_SESSION;   

$_SESSION = array();
session_destroy();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css"> 
        <link rel="icon" href="/image/icon.ico">
        <title>無名の里のサイト | ログイン</title>
        <link rel="icon" href="/image/icon.ico">
    </head>
    <body>
        <?php if(isset($err['msg'])) : ?>
            <p><?php echo $err['msg']; ?></p>
        <?php endif; ?>    
        <div class="center">
            <h1>Login</h1>
            <form method="post">
                <div class="txt_field">
                    <input id="floatingInput" type="email" required>
                    <span></span>
                    <label for="email">メールアドレス</label>
                    <?php if (isset($err['email'])) : ?>
                        <p><?php echo $err['email']; ?></p>
                    <?php endif; ?>    
                </div>
                <div class="txt_field">
                    <input type="password" id="floatingPassword" required>
                    <span></span>
                    <label for="password">パスワード:</label>
                    <?php if (isset($err['password'])) : ?>
                        <p><?php echo $err['password']; ?></p>
                    <?php endif; ?>  
                </div>
                <input type="submit" value="ログイン">
                <h3> </h3>
            </form>
        </div>
    </body>
</html>