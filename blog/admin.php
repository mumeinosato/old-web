<?php

session_start();

require_once '../classes/UserLogic.php';

$result = UserLogic::checkLogin(); 

if (!$result) {
    $_SESSION['login_err'] = 'ログインしてください';
    header('Location: /login/');
    return; 
}
$login_user = $_SESSION['login_user'];

require_once('blog.php');

$blog = new Blog();
$blogData = $blog->getAll();

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "utf-8");
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/features/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="../css/dashboard.css" rel="stylesheet">  
    <link rel="icon" href="/image/icon.ico">  
</head>
<body>
<?php include '../admin/side.php'; ?>
    <div>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <p class="sp2"></p>
            <h2>ブログ一覧</h2>
            <p><a href="form.php">新規作成</a></p>
            <table>
                <tr>
                    <th>タイトル</th>
                    <th>カテゴリ</th>
                    <th>投稿日時</th>
                </tr>
                <?php foreach($blogData as $column): ?>
                <tr>
                    <td><?php echo h($column['title']) ?></td>
                    <td><?php echo h($blog->setCategoryName($column['category'])) ?></td>
                    <td><?php echo h($column['post_at']) ?></td>
                    <td><a href="/blog/detail.php?id=<?php echo $column['id'] ?>">詳細</a></td>
                    <td><a href="/blog/update_form.php?id=<?php echo $column['id'] ?>">編集</a></td>
                    <td><a href="/blog/blog_delete.php?id=<?php echo $column['id'] ?>">削除</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </main>
    </div>
</body>
</html>