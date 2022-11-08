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
    </div>          
</body>
</html>