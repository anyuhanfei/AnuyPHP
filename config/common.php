<?php

/**
 * sql多条查询简单处理
 * 只获取关联索引
 */
function sqlQuery($pdo, $sql)
{
    $res = $pdo->query($sql);
    $array = array();
    if($res == array()){
        return $array;
    }
    $res->setFetchMode(PDO::FETCH_ASSOC);
    foreach($res as $v){
        $array[] = $v;
    }
    return $array;
}