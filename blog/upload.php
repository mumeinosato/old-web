<?php

require_once '../env.php';
require_once 'parsedown/Parsedown.php';

$host = DB_host;
$db = DB_name;
$user = DB_user;
$pass = DB_pass;

$secret = "mmeei9n2o4";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_GITHUB_EVENT']) && $_SERVER['HTTP_X_GITHUB_EVENT'] == 'push') {
    $body = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
    $payload_hash = hash_hmac('sha1', $body, $secret);
    if ($payload_hash !== substr($signature, 5)) {
        header("HTTP/1.1 401 Unauthorized");
        exit("Invalid signature");
    }

    $payload = json_decode($body, true);
    $repository_name = $payload['repository']['name'];
    $owner_name = $payload['repository']['name'];
    $ref = $payload['ref'];
    $commits = $payload['commits'];

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection Failed:" . $conn->connect_error);
    }

    foreach ($commits as $commit) {
        $title = $commit['message'];
        $files = $commit['modified'];
        foreach ($files as $file) {
            if (preg_match('/\.md$/', $file)) {
                $url = "https://raw.githubusercontent.com/mumeinosato/blog/master/{$file}";
                $contents = file_get_contents($url);
    
                $html = markdown_to_html($contents);
    
                $filename = basename($file, ".md") . ".php";
                $path = "data/{$filename}";
                file_put_contents($path, $html);
    
                $sql = "INSERT INTO blog (title, file_path) VALUES ('{$title}', '{$path}')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error:" . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

    $conn->close();
}

function markdown_to_html($markdown) {
    $parsedown = new Parsedown();
    return $parsedown->text($markdown);
}