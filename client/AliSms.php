<?php

namespace AlibabaApi\client;

use AlibabaApi\src\ossDriver\Sms;

/**
 * Class AliSms
 * @package AlibabaApi\client
 */
class AliSms
{
    /**
     * 发送sms
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $phone
     * @param $signName
     * @param $templateCode
     * @param string $errorMessage
     * @param array $templateParam
     * @return bool|\stdClass
     */
    public function sendSms(
        $accessKeyId,
        $accessKeySecret,
        $phone,
        $signName,
        $templateCode,
        &$errorMessage = "message",
        $templateParam = []
    )
    {
        $sms    = new Sms();
        $result = $sms->accessKeyId($accessKeyId)
            ->accessKeySecret($accessKeySecret)
            ->phone($phone)
            ->signName($signName)
            ->templateCode($templateCode)
            ->templateParam($templateParam)
            ->sendSms();
        if ($result === false) {
            $errorMessage = $sms->errorMessage;
            return false;
        }
        return $result;
    }
}