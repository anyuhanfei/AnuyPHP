<?php
require_once __DIR__ . "/anuy/start.php";

header(sprintf("Content-type: text/html; charset=%s", $databases['charset']));
$dsn=sprintf('mysql:host=%s;port=%s;dbname=%s', $databases['hostname'], $databases['hostport'], $databases['database']);
$pdo = new PDO($dsn,$databases['username'],$databases['password'],array(
    PDO::MYSQL_ATTR_INIT_COMMAND => sprintf("set names %s", $databases['charset']),
    PDO::ATTR_PERSISTENT => true,
));
