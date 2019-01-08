<?php
/**
 * 公共函数
 */
// define("WXFILE",'http://houtai.shangquduo.com/public/');
// define("SHOPFILE",'http://shop.shangquduo.com/public/');
// define('GOODSIMG','http://goodsimg.shangquduo.com/');
// define('DYNAMICIMG','http://dynamicimg.shangquduo.com/');
// define('SERVER','http://server.shangquduo.com/');
// define('SHOPLOGO','http://shoplogo.shangquduo.com/');

/**
 * sql多条查询简单处理
 * 只获取关联索引
 */
function sqlQuery($pdo,$sql)
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

/**
 * 判断是否登录
 */
function loginJudge()
{
    Session::start();
    return isset($_SESSION['openid']) ? true : false;
}

/**
 * 密码加密
 * @param $admin_pass
 * @return string
 */
function pass($admin_pass) {
    $md5Pass = md5($admin_pass);
    $strPass = substr($md5Pass,1,10);
    $md5PassTwo = md5($strPass);
    $strPassTwo = substr($md5PassTwo,1,10);
    $md5PassThree = md5($strPassTwo);
    return $md5PassThree;
}

//获取用户真实IP 
function getIp() { 
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
        $ip = getenv("HTTP_CLIENT_IP"); 
    else 
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
            $ip = getenv("HTTP_X_FORWARDED_FOR"); 
        else 
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
                $ip = getenv("REMOTE_ADDR"); 
            else 
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
                    $ip = $_SERVER['REMOTE_ADDR']; 
                else 
                    $ip = "unknown"; 
    return ($ip); 
}

//生成随机字符串
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
    for ($i = 0; $i < $length; $i++) { 
        $randomString .= $characters[rand(0, strlen($characters) - 1)]; 
    } 
    return $randomString; 
}

/* 利用淘宝的ip地址库获获取ip + 地址*/   
function _get_ip_dizhi(){   
    $opts = array(    
        'http'=>array(   
        'method'=>"GET",   
        'timeout'=>5,)   
    );        
    $context = stream_context_create($opts);    
    $ipmac=getIp();  
    if(strpos($ipmac,"127.0.0.") === true)return '1';  
    $url_ip='http://ip.taobao.com/service/getIpInfo.php?ip='.$ipmac;  
    do{
        $str = @file_get_contents($url_ip, false, $context);
    }while($str == false);
    if(!$str) return "2";  
    $json=json_decode($str,true);  
    if($json['code']==0){  
        //省市
        //$ipcity= $json['data']['region'].$json['data']['city'];  
        //省市，ip
        //$ip= $ipcity.','.$ipmac;  
        $ip = $json['data']['city'];
    }else{  
        $ip = "3";  
    }  
    return $ip;  
}  

//获取一个随机且唯一的订单号；
 function getordcode(){
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $ordersn= $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 6) . sprintf('%03d', rand(0,999));
    return $ordersn;
 }

//随机数字
function randNumber(){
    $ordersn=strtoupper(dechex(date('m'))) . date('d') . substr(time(), -2). sprintf('%03d', rand(0,999));
    return $ordersn;
}

/**
 * 二维数组排序
 * @param $arr 需要排序的二维数组
 * @param $shortKey 排序条件的键
 * @param $short  排序顺序
 * @param $shortType 排序类型
 */
function multi_array_sort($arr,$shortKey,$short=SORT_DESC,$shortType=SORT_REGULAR)
{
    foreach ($arr as $key => $data){
        $name[$key] = $data[$shortKey];
    }
    array_multisort($name,$shortType,$short,$arr);
    return $arr;
}

/**
 * 二维码生成
 * @param $orderSn 文件名称
 * @param $url 内容
 * @param $path 保存路径
 * @return string
 */
function renewal($orderSn,$url,$path) {
    include_once('../../API/phpqrcode/phpqrcode.php');
    $errorCorrectionLevel = 'L';//容错级别
    $matrixPointSize = 9;//生成图片大小
    $fileName = $path.$orderSn.'.png';
    \QRcode::png($url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);
    return $fileName;
}

/**
 * 递归
 * 无限级下级的遍历
 * @param $arrayAll 所有的数据
 * @param $arrTree 保存选中数据的数组
 * @param $parentId 上级id
 * @param $pdiName 上级id对应的键名
 * @param $userIdName 自己user_id对应的键名
 * @param $topLevel 最大等级
 * @param $level 对应等级
 */
function getMenuTree($arrayAll, &$arrTree, $parentId, $pidName, $userIdName, $topLevel = 999, $level = 0){
    if(empty($arrayAll)) return FALSE;
    $level++;
    if($level > $topLevel){
        return FALSE;
    }
    foreach($arrayAll as $key => $value)
    {
        if($value[$pidName] == $parentId)
        {
            $value['level'] = $level;
            $arrTree[] = $value;
            unset($arrayAll[$key]); //注销当前节点数据，减少已无用的遍历
            getMenuTree($arrayAll, $arrTree, $value[$userIdName], $pidName, $userIdName, $topLevel, $level);
        }
    }
}