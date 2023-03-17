<?php

session_start();
require_once '../classes/UserLogic.php';

if (!$logout = filter_input(INPUT_POST, 'logout'))
{
    exit('不正なリクエスト');
}

$result = UserLogic::checkLogin(); 

if (!$result) {
    exit('セッションが切れました。再度ログインしてください');
}
UserLogic::logout();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="icon" href="/image/icon.ico">
</head>
<body>  
    <?php header('Location: ../index.php'); ?>
</body>
</html>