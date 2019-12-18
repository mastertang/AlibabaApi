<?php

namespace AlibabaApi\src\ossDriver;

use OSS\Core\OssException;
use OSS\OssClient;

/**
 * Class Sms
 * @package AlibabaApi\client
 */
class Sms
{
    /**
     * @var string accessKeyId
     */
    protected $accessKeyId = "";

    /**
     * @var string accessKeySecret
     */
    protected $accessKeySecret = "";

    /**
     * @var string 手机号码
     */
    protected $phone = "";

    /**
     * @var string 签名
     */
    protected $signName = "";

    /**
     * @var string 消息模版id
     */
    protected $templateCode = "";

    /**
     * @var string 错误消息
     */
    public $errorMessage = "";

    /**
     * @var null
     */
    protected $templateParam = [];

    /**
     * 设置访问accesskey
     *
     * @param $accessKeyId
     * @return $this
     */
    public function accessKeyId($accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
        return $this;
    }

    /**
     * 设置访问accessSecret
     *
     * @param $accessKeySecret
     * @return $this
     */
    public function accessKeySecret($accessKeySecret)
    {
        $this->accessKeySecret = $accessKeySecret;
        return $this;
    }

    /**
     * 电话号码
     *
     * @param $phone
     * @return $this
     */
    public function phone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * 模版签名
     *
     * @param $signName
     * @return $this
     */
    public function signName($signName)
    {
        $this->signName = $signName;
        return $this;
    }

    /**
     * 短信模版id
     *
     * @param $templateCode
     * @return $this
     */
    public function templateCode($templateCode)
    {
        $this->templateCode = $templateCode;
        return $this;
    }

    /**
     * 模版参数
     *
     * @param $templateParam
     * @return $this
     */
    public function templateParam($templateParam)
    {
        if (is_array($templateParam)) {
            $this->templateParam = $templateParam;
        }
        return $this;
    }

    /**
     * 发送短信
     *
     * @return bool|\stdClass
     */
    public function sendSms()
    {
        $params                  = [];
        $security                = true;
        $params["PhoneNumbers"]  = $this->phone;
        $params["SignName"]      = $this->signName;
        $params["TemplateCode"]  = $this->templateCode;
        $params['TemplateParam'] = $this->templateParam;

        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        $helper  = new self();
        $content = $helper->request(
            $this->accessKeyId,
            $this->accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action"   => "SendSms",
                "Version"  => "2017-05-25",
            )),
            $security
        );
        if (empty($result) || !is_array($result) || $result['Code'] != 'OK') {
            $this->errorMessage = json_encode($result);
            return false;
        }
        return $content;
    }

    /**
     * 生成签名并发起请求
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $domain
     * @param $params
     * @param bool $security
     * @param string $method
     * @return bool|mixed
     */
    protected function request(
        $accessKeyId,
        $accessKeySecret,
        $domain,
        $params,
        $security = false,
        $method = 'POST'
    )
    {
        $apiParams = array_merge(array(
                                     "SignatureMethod"  => "HMAC-SHA1",
                                     "SignatureNonce"   => uniqid(mt_rand(0, 0xffff), true),
                                     "SignatureVersion" => "1.0",
                                     "AccessKeyId"      => $accessKeyId,
                                     "Timestamp"        => gmdate("Y-m-d\TH:i:s\Z"),
                                     "Format"           => "JSON",
                                 ), $params);
        ksort($apiParams);
        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->smsEncode($key) . "=" . $this->smsEncode($value);
        }
        $stringToSign = "${method}&%2F&" . $this->smsEncode(substr($sortedQueryStringTmp, 1));
        $sign         = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&", true));
        $signature    = $this->smsEncode($sign);
        $url          = ($security ? 'https' : 'http') . "://{$domain}/";
        try {
            $content = $this->smsFetchContent($url, $method, "Signature={$signature}{$sortedQueryStringTmp}");
            return json_decode($content, true);
        } catch (\Exception $exception) {
            $this->errorMessage = $exception->getMessage();
            return false;
        }
    }

    /**
     * smsEncode
     *
     * @param $str
     * @return null|string|string[]
     */
    protected function smsEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    /**
     * 请求
     *
     * @param $url
     * @param $method
     * @param $body
     * @return mixed
     */
    protected function smsFetchContent($url, $method, $body)
    {
        $ch = curl_init();
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        } else {
            $url .= '?' . $body;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-sdk-client" => "php/2.0.0"
        ));
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $rtn = curl_exec($ch);
        if ($rtn === false) {
            $this->errorMessage = "请求失败!";
        }
        curl_close($ch);
        return $rtn;
    }
}