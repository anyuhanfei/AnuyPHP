<?php
/**
 * 启瑞云短信接口Demo(utf-8)
 */
class SendDemo
{
    const SENDURL = 'http://api.qirui.com:7891/mt';

    private $apiKey;
    private $apiSecret;

    /**
     * 构造方法
     * @param string $apiKey    接口账号
     * @param string $apiSecret 接口密码
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey    = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * 短信发送
     * @param string $phone   	手机号码
     * @param string $content 	短信内容
     * @param integer $isreport	是否需要状态报告
     * @return void
     */
    public function send($phone, $content, $isreport = 1)
    {
        $requestData = array(
            'un' => $this->apiKey,
            'pw' => $this->apiSecret,
            'sm' => $content,
            'da' => $phone,
            'rd' => $isreport,
            'dc' => 15,
            'rf' => 2,
            'tf' => 3,
            );

        $url = self::SENDURL . '?' . http_build_query($requestData);
        return $this->request($url);
    }

    /**
     * 请求发送
     * @return string 返回发送状态
     */
    private function request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
//end

/*//实例化类，测试发送

//接口账号
$apiKey    = '1775960010';
//接口密码
$apiSecret = 'b7cc3e0a05e8edffc4f4';
//接受短信的手机号码
$phone     = '13669808154';
//短信内容(【签名】+短信内容)，系统提供的测试签名和内容，如需要发送自己的短信内容请在启瑞云平台申请签名和模板
$content   = '【金桑农业】您的验证码是:4852';

$sms    = new SendDemo($apiKey, $apiSecret);
$result = $sms->send($phone, $content);

print_r($result ); */


