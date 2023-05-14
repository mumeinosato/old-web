<?php
// GitHubからのPOSTリクエストを受け取る
$payload = json_decode(file_get_contents('php://input'));

// リポジトリのURLを取得する
$repo_url = $payload->repository->html_url;

// clone先のディレクトリパスを指定する
$docroot = '/var/www/html/web';

// Gitコマンドを実行する
exec("cd {$docroot} && git pull origin main 2>&1", $output, $return_var);

// エラーが発生した場合はログに出力する
if ($return_var !== 0) {
    error_log("Git pull failed: " . implode("\n", $output));
    http_response_code(500);
    exit();
}

// Apache2を再起動する
exec('sudo systemctl restart apache2');

// 正常終了
http_response_code(200);
exit();
