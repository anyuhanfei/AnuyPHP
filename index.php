<?php
include_once('comment/database.php');
include_once('comment/comment.php');

$insertSql = "INSERT INTO test_user ('name') VALUES ('我是第一个会员')";
$insertRes = $pdo->exec($insertSql);