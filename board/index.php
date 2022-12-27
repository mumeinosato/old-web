<?php
require_once '../env.php';
// データベースの接続情報
$host = DB_HOST;
$db = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;

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

