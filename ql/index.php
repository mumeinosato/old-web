<?php
ob_start();

// データベースの接続情報
define( 'DB_HOST', 'localhost:3306');
define( 'DB_USER', 'web');
define( 'DB_PASS', 'Me92452315@');
define( 'DB_NAME', 'mumei_web');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$current_date = null;
$message = array();
$message_array = array();
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

if( !empty($_POST['btn_submit']) ) {

    // 空白除去
	$view_name = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['view_name']);
	$message = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['message']);

	// 表示名の入力チェック
	if( empty($view_name) ) {
		$error_message[] = '表示名を入力してください。';
	} else {

        // セッションに表示名を保存
		$_SESSION['view_name'] = $view_name;
    }

	// メッセージの入力チェック
	if( empty($message) ) {
		$error_message[] = 'メッセージを入力してください。';
	} else {

        // 文字数を確認
        if( 100 < mb_strlen($message, 'UTF-8') ) {
			$error_message[] = 'メッセージは100文字以内で入力してください。';
		}
    }

	if( empty($error_message) ) {
		
		// 書き込み日時を取得
        $current_date = date("Y-m-d H:i:s");

        // トランザクション開始
        $pdo->beginTransaction();

        try {

            // SQL作成
            $stmt = $pdo->prepare("INSERT INTO chomessage (view_name, message, post_date) VALUES ( :view_name, :message, :current_date)");

            // 値をセット
            $stmt->bindParam( ':view_name', $view_name, PDO::PARAM_STR);
            $stmt->bindParam( ':message', $message, PDO::PARAM_STR);
            $stmt->bindParam( ':current_date', $current_date, PDO::PARAM_STR);

            // SQLクエリの実行
            $res = $stmt->execute();

            // コミット
            $res = $pdo->commit();

        } catch(Exception $e) {

            // エラーが発生した時はロールバック
            $pdo->rollBack();
        }

        if( $res ) {
            $_SESSION['success_message'] = 'メッセージを書き込みました。';
        } else {
            $error_message[] = '書き込みに失敗しました。';
        }

        // プリペアドステートメントを削除
        $stmt = null;

        header('Location: ./');
        exit;
	}
}

if( !empty($pdo) ) {

    // メッセージのデータを取得する
    $sql = "SELECT view_name,message,post_date FROM chomessage ORDER BY post_date DESC";
    $message_array = $pdo->query($sql);
    foreach( $pdo->query($sql) as $row) {
        $message[] = array(
            'view_name' => $row['view_name'],
            'message' => $row['message'],
            'post_date' => $row['post_date']
        );
    
        if(preg_match('/https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+(png|jpeg|jpg|gif)/', $row['message'], $matches)) {
            // 画像URLを取得する
            $image_url = $matches[0];
        
            // 画像のタグを生成する
            $row['message'] = preg_replace('/' . preg_quote($image_url, '/') . '/', '<img src="' . $image_url . '">', $row['message']);
        }        
    }    
}

// データベースの接続を閉じる
$pdo = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>掲示板(笑)</title>
<link href="index.css" rel="stylesheet">
</head>
<body>
<h1>掲示板</h1>
<?php if( empty($_POST['btn_submit']) && !empty($_SESSION['success_message']) ): ?>
    <p class="success_message"><?php echo htmlspecialchars( $_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if( !empty($error_message) ): ?>
    <ul class="error_message">
		<?php foreach( $error_message as $value ): ?>
            <li>・<?php echo $value; ?></li>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
<form method="post">
	<div>
		<label for="view_name">表示名</label>
		<input id="view_name" type="text" name="view_name" value="<?php if( !empty($_SESSION['view_name']) ){ echo htmlspecialchars( $_SESSION['view_name'], ENT_QUOTES, 'UTF-8'); } ?>">
	</div>
	<div>
		<label for="message">メッセージ</label>
		<textarea id="message" name="message"><?php if( !empty($message) ){ echo htmlspecialchars( $message, ENT_QUOTES, 'UTF-8'); } ?></textarea>
	</div>
	<input type="submit" name="btn_submit" value="書き込む">
</form>
<hr>
<section>
<?php if( !empty($message_array) ){ ?>
<?php foreach( $message_array as $value ){ ?>
	<article>
		<div class="info">
			<h2><?php echo htmlspecialchars( $value['view_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
			<time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
			<?php
			// もし画像のリンクがある場合は、imgタグを作成して表示する
			if (isset($value['image'])) {
				echo '<img src="'.$value['image'].'" alt="image">';
			} 
			?>
		</div>
		<p><?php echo nl2br(htmlspecialchars( $value['message'], ENT_QUOTES, 'UTF-8')); ?></p>
	</article>
<?php } ?>
<?php } ?>
</section>
<hr>
<?php include 'footer.php' ?>
</body>
</html>