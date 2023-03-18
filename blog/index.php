<?php
require_once '../env.php'

$host = DB_host;
$db = DB_name;
$user = DB_user;
$pass = DB_pass;
$conn = new mysqli($host, $user, $pass, $db);
