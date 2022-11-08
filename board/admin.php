<?php

session_start();
require_once '../classes/UserLogic.php';
require_once '../login/functions.php';

$result = UserLogic::checkLogin(); 

if (!$result) {
    $_SESSION['login_err'] = 'ログインしてください';
    header('Location: ../login/');
    return; 
}
$login_user = $_SESSION['login_user'];

// データベースの接続情報
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'board');
define( 'DB_PASS', 'password');
define( 'DB_NAME', 'board');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$current_date = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

// データベースに接続
try {

	$option = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
	);
	$pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST , DB_USER, DB_PASS, $option);

} catch(PDOException $e) {

	// 接続エラーのときエラー内容を取得する
	$error_message[] = $e->getMessage();
}

if( !empty($_POST['btn_submit']) ) {

	if( !empty($_POST['admin_password']) && $_POST['admin_password'] === PASSWORD ) {
		$_SESSION['admin_login'] = true;
	} else {
		$error_message[] = 'ログインに失敗しました。';
	}
}

if( !empty($pdo) ) {

    // メッセージのデータを取得する
    $sql = "SELECT * FROM message ORDER BY post_date DESC";
    $message_array = $pdo->query($sql);
}

// データベースの接続を閉じる
$pdo = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>掲示板 管理ページ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/features/">
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
<link href="../css/dashboard.css" rel="stylesheet">    
<link href="admin.css" rel="stylesheet">    
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">管理パネル</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <form action="../login/logout.php" method="POST">
                <input class="px-3" type="submit" name="logout" value="ログアウト"> 
            </form>
        </div>
    </div>
    </header>    
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../index.php">
                            <span data-feather="home"></span>
                            ← 戻る
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../admin/index.php">
                            <span data-feather="home"></span>
                            管理パネル
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">
                            <span data-feather="home"></span>
                            お知らせを送信
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../blog/admin.php">
                            <span data-feather="file"></span>
                            ブログ
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                            <span data-feather="file"></span>
                            掲示板
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span data-feather="file"></span>
                            Discordに送信
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span data-feather="file"></span>
                            アカウント追加
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <p class="sp"></p>
            <h1>掲示板 管理ページ</h1>
            <?php if( !empty($error_message) ): ?>
                <ul class="error_message">
                    <?php foreach( $error_message as $value ): ?>
                        <li>・<?php echo $value; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <section>


            <form method="get" action="download.php">
                <select name="limit">
                    <option value="">全て</option>
                    <option value="10">10件</option>
                    <option value="30">30件</option>
                </select>
                <input type="submit" name="btn_download" value="ダウンロード">
            </form>

            <?php if( !empty($message_array) ){ ?>
            <?php foreach( $message_array as $value ){ ?>
            <article>
                <div class="info">
                    <h2><?php echo htmlspecialchars( $value['view_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
                            <p><a href="edit.php?message_id=<?php echo $value['id']; ?>">編集</a>  <a href="delete.php?message_id=<?php echo $value['id']; ?>">削除</a></p>
                </div>
                <p><?php echo nl2br( htmlspecialchars( $value['message'], ENT_QUOTES, 'UTF-8') ); ?></p>
            </article>
            <?php } ?>
            <?php } ?>
            </section>
            </main>
        </div>    
    </div>  
</body>
</html>