<?php
namespace AliApiPHP;

use AliApiPHP\Exception\AliApiException;

class AliApiPHP
{
    /**
     * 根据IP地址获取用户所有的地理地址
     */
    public static function getAddressFromIp($ip, $appCode)
    {
        if (empty($ip) || empty($appCode))
            throw new AliApiException('ip和appCode不能空');
        else {
            $host = "https://dm-81.data.aliyun.com";
            $path = "/rest/160601/ip/getIpInfo.json";
            $querys = "ip=" . $ip;
            $headers = [];
            array_push($headers, "Authorization:APPCODE " . $appCode);
            return self::aliApiResquestModule($host, $path, "GET", $querys, "", $headers);
        }
    }

    /**
     * 短信发送
     */
    public static function smsSend($data, $appCode)
    {
        if (empty($data) || empty($appCode))
            throw new AliApiException('ip和appCode不能空');
        $host = "http://sms.market.alicloudapi.com";
        $path = "/singleSendSms";
        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $appCode);
        $keys = array_keys($data);
        $values = array_values($data);
        foreach ($keys as $key => $value)
            $keys[$key] = '#' . $key;
        $querys = "ParamString=#ParamString&RecNum=#RecNum&SignName=#SignName&TemplateCode=#TemplateCode";
        $querys = str_replace($keys, $values, $querys);
        return self::aliApiResquestModule($host, $path, "GET", $querys, "", $headers);
    }

    /**
     * 根据电话号码获取ip地址
     */
    public static function getIpAddrFromPhoneNumber($phone, $appCode)
    {
        if (empty($phone) || empty($appCode))
            throw new AliApiException('phone和appCode不能空');
        else {
            $host = "http://jisushouji.market.alicloudapi.com";
            $path = "/shouji/query";
            $querys = "shouji=" . $phone;
            $headers = [];
            array_push($headers, "Authorization:APPCODE " . $appCode);
            return self::aliApiResquestModule($host, $path, "GET", $querys, "", $headers);
        }
    }

    /**
     * 人脸识别
     */
    public static function checkPeopleFace($host, $path, $appCode, $imageData)
    {
        if (empty($host) || empty($path) || empty($appCode))
            throw new AliApiException('host、path、appCode不能空');
        else {
            $method = "POST";
            $headers = [];
            array_push($headers, "Authorization:APPCODE " . $appCode);
            array_push($headers, "Content-Type" . ":" . "application/json; charset=UTF-8");
            $bodys = [
                "inputs" => [[
                    "image" => [
                        "dataType" => 50,
                        "dataValue" => $imageData
                    ]]
                ]
            ];
            return self::aliApiResquestModule($host, $path, "POST", "", $bodys, $headers);
        }
    }

    /**
     * curl请求模板
     */
    public static function aliApiResquestModule($host, $path, $method, $querys, $bodys, $headers)
    {
        $url = $host . $path . "?" . $querys;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $ipDataString = curl_exec($curl);
        $errorCode = curl_errno($curl);
        $result = false;
        if (empty($ipDataString))
            throw new AliApiException('curl请求获取的数据为空');
        else {
            if ($errorCode === 0) {
                $ipData = json_decode($ipDataString, true);
                $result = !empty($ipData) ? $ipData : $result;
                return $result;
            }
            if ($errorCode === CURLE_OPERATION_TIMEOUTED)
                throw new AliApiException('curl请求超时');
            else
                throw new AliApiException('curl请求错误');
        }
    }
}
