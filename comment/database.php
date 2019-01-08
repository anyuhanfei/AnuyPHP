<?php
/**
 * 连接数据库
 */
header("Content-type: text/html; charset=utf-8");
$dsn='mysql:host=127.0.0.1;dbname=test';//host是连接主机；dbname是连接的数据库
$username = 'root';
$password = '123456';
$pdo = new PDO($dsn,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));




// <?php
// /**
//  * 连接数据库
//  */
// header("Content-type: text/html; charset=utf-8");

// $con = array(
//     'sql_type' => 'mysql',
//     'ip' => '127.0.0.1',
//     'dbname' => 'test',
//     'username' => 'root',
//     'password' => '123456',
//     'set' => 'set names utf8'
// );
// $pdo = connect($con);

// function connect($con){
//     $dsn=$con['sql_type'].':host='.$con['ip'].';dbname='.$con['dbname'];//host是连接主机；dbname是连接的数据库
//     $pdo = new PDO($dsn,$con['username'],$con['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => $con['set']));
//     return $pdo;
// }