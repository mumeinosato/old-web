<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ひと言掲示板</title>
<link href="style.css" rel="stylesheet">
</head>
<body>
<h1>掲示板 工事中(卒業式までに作る 多分)</h1>
<form method="post">
    <div>
        <label for="view_name">表示名</label>
        <input id="view_name" type="view_name" value="">
    </div>
    <div>
        <label for="message">メッセージ</label>
        <textarea id="message" name="message"></textarea>
    </div>
    <input type="submit" name="btn_submit" value="書き込む">
</form>
<hr>
<section>
<!-- ここに投稿されたメッセージを表示 -->
</section>
</body>
</html>