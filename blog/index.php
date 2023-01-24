<?php

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>ブログ一覧</title>
</head>

<body>
    <?php include '../top.php'; ?>
    <div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
        </script>
    </div>
    <h2>ブログ一覧</h2>
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
        </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../footer.php'; ?>
</body>

</html>