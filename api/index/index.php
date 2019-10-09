<?php
require_once __DIR__ . "/../../base.php";

$sql = "select * from idx_user";
$res = sqlQuery($pdo, $sql);
var_dump($res);