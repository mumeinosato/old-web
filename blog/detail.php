<?php

require_once('blog.php');
require_once 'Michelf/MarkdownExtra.inc.php';

use Michelf\Markdown;
use Michelf\MarkdownExtra;

$blog = new Blog();
$result = $blog->getById($_GET['id']);
$text = MarkdownExtra::defaultTransform($result['content']);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ詳細</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="icon" href="/image/icon.ico">
</head>
<body>
    <div>
        <header class="p-3 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
                    </a>  
                    <ui class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="#" class="nav-link px-2 text-secondary">トップページ</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">お知らせ</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">ルール</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">新規の方へ</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">MAP</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">ツール</a></li>                        
                        <li><a href="#" class="nav-link px-2 text-white">お問い合わせ</a></li>
                        <li><a href="#" class="nav-link px-2 text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">その他</a>
                            <ul class="bg-dark dropdown-menu">
                                <li><a href="blog" class="nav-link px-2 text-white dropdown-item">ブログ</a></li>
                                <li><a href="wiki" class="nav-link px-2 text-white dropdown-item">Wiki</a></li>
                                <li><a href="board" class="nav-link px-2 text-white dropdown-item">掲示板?</a></li>
                            </ul>
                        </li>
                    </ui> 
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                        <input type="search" class="form-control form-control-dark" placeholder="検索" aria-label="Search">
                    </form>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-light me-2">管理ページへ</button>
                    </div>                 
                </div>
            </div>
        </header>     
    </div>      
    <h2>ブログ詳細</h2>
    <h3>タイトル:<?php echo $result['title'] ?></h3>
    <p>投稿日時:<?php echo $result['post_at'] ?></p>
    <p>カテゴリ:<?php echo $blog->setCategoryName($result['category']) ?></p>
    <hr>
    <p><?php echo $text ?></p>
    <p><a href="/blog">戻る</p>
</body>
</html>