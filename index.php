<?php
// ファイルに書き込むテキスト
$content = "改行を含む
テキストを書き込む\n\n";
$content2 = "テストテキスト";


// ディレクトリに書き込み可能か確認
if( is_writable($path) ) {

	// ファイルを書き込みモードで開く
	$file_handle = fopen("httpdocs/data.txt", "w");

	// ファイルへデータを書き込み
	fwrite( $file_handle, $content);
	fwrite( $file_handle, $content2);

	// ファイルを閉じる
	fclose($file_handle);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>トップページ - NationMC!</title>
    <link rel="icon" href="/image/icon.ico">
</head>

<body>
    <?php include 'top.php'; ?>
    <div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>