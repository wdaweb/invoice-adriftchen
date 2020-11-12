<?php

//base.php需建置在當前目錄

$dsn="mysql:host=localhost;dbname=invoice;charset=utf8";
$pdo=new PDO($dsn,'root','');

date_default_timezone_get("Asia/Taipei");
session_start();

?>