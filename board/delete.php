<?php
require_once "../env.php";
// データベースの接続情報
$host = DB_HOST;
$db = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$view_name = null;
$message = array();
$message_data = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

session_start();

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

if( !empty($_GET['message_id']) && empty($_POST['message_id']) ) {

	// SQL作成
	$stmt = $pdo->prepare("SELECT * FROM message WHERE id = :id");

	// 値をセット
	$stmt->bindValue( ':id', $_GET['message_id'], PDO::PARAM_INT);

	// SQLクエリの実行
	$stmt->execute();

	// 表示するデータを取得
	$message_data = $stmt->fetch();

	// 投稿データが取得できないときは管理ページに戻る
	if( empty($message_data) ) {
		header("Location: ./admin.php");
		exit;
	}

} elseif( !empty($_POST['message_id']) ) {

    // トランザクション開始
    $pdo->beginTransaction();

    try {

        // SQL作成
        $stmt = $pdo->prepare("DELETE FROM message WHERE id = :id");

        // 値をセット
        $stmt->bindValue( ':id', $_POST['message_id'], PDO::PARAM_INT);

        // SQLクエリの実行
        $stmt->execute();

        // コミット
        $res = $pdo->commit();

    } catch(Exception $e) {

        // エラーが発生した時はロールバック
        $pdo->rollBack();
    }

    // 削除に成功したら一覧に戻る
    if( $res ) {
        header("Location: ./admin.php");
        exit;
    }
}

// データベースの接続を閉じる
$stmt = null;
$pdo = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>掲示板 管理ページ（投稿の削除）</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/features/">
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
<link href="../css/dashboard.css" rel="stylesheet">   
<link href="../css/style.css" rel="stylesheet">
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
                            <a class="nav-link active" href="../blog/admin.php">
                            <span data-feather="file"></span>
                            ブログ
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../board/admin.php">
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
                <h1>掲示板 管理ページ（投稿の削除）</h1>
                <?php if( !empty($error_message) ): ?>
                    <ul class="error_message">
                        <?php foreach( $error_message as $value ): ?>
                            <li>・<?php echo $value; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p class="text-confirm">以下の投稿を削除します。<br>よろしければ「削除」ボタンを押してください。</p>
                <form method="post">
                    <div>
                        <label for="view_name">表示名</label>
                        <input id="view_name" type="text" name="view_name" value="<?php if( !empty($message_data['view_name']) ){ echo $message_data['view_name']; } elseif( !empty($view_name) ){ echo htmlspecialchars( $view_name, ENT_QUOTES, 'UTF-8'); } ?>" disabled>
                    </div>
                    <div>
                        <label for="message">ひと言メッセージ</label>
                        <textarea id="message" name="message" disabled><?php if( !empty($message_data['message']) ){ echo $message_data['message']; } elseif( !empty($message) ){ echo htmlspecialchars( $_message, ENT_QUOTES, 'UTF-8'); } ?></textarea>
                    </div>
                    <a class="btn_cancel" href="admin.php">キャンセル</a>
                    <input type="submit" name="btn_submit" value="削除">
                    <input type="hidden" name="message_id" value="<?php if( !empty($message_data['id']) ){ echo $message_data['id']; } elseif( !empty($_POST['message_id']) ){ echo htmlspecialchars( $_POST['message_id'], ENT_QUOTES, 'UTF-8'); } ?>">
            </form>
            </main>
        </div>    
    </div>              
</body>
</html>