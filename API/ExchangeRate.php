<?php
/**
 * 汇率API
 */

class ExchangeRate
{
    public static $appkey = '';//聚合的APK

    /**
     * 初始化APK
     * exchangeRate constructor.
     */
    public function __construct($apk)
    {
        self::$appkey = $apk;
    }

    /**
     * 常用汇率查询
     */
    function commonExchangeRate()
    {
        $url = "http://op.juhe.cn/onebox/exchange/query";
        $params = array(
            "key" => self::$appkey,//应用APPKEY(应用详细页查询)
        );
        $paramstring = http_build_query($params);
        $content = $this->juhecurl($url,$paramstring);
        $result = json_decode($content,true);
        if($result){
            if($result['error_code']=='0'){
                return $result;
            }else{
                return $result['error_code'].":".$result['reason'];
            }
        }else{
            return "请求失败";
        }
    }

    /**
     * 货币列表
     */
    function coinTable()
    {
        $url = "http://op.juhe.cn/onebox/exchange/list";
        $params = array(
            "key" => self::$appkey,//应用APPKEY(应用详细页查询)
        );
        $paramstring = http_build_query($params);

        $content = $this->juhecurl($url,$paramstring);
        $result = json_decode($content,true);
        if($result){
            if($result['error_code']=='0'){
                return $result;
            }else{
                return $result['error_code'].":".$result['reason'];
            }
        }else{
            return "请求失败";
        }
    }

    /**
     * 实时汇率查询换算
     */
    function realTimeExchangeRate($from, $to)
    {
        $url = "http://op.juhe.cn/onebox/exchange/currency";
        $params = array(
            "from" => $from,//转换汇率前的货币代码
            "to" => $to,//转换汇率成的货币代码
            "key" => self::$appkey,//应用APPKEY(应用详细页查询)
        );
        $paramstring = http_build_query($params);
        $content = $this->juhecurl($url,$paramstring);
        $result = json_decode($content,true);
        if($result){
            if($result['error_code']=='0'){
                return $result;
            }else{
                return $result['error_code'].":".$result['reason'];
            }
        }else{
            return "请求失败";
        }
    }

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}

