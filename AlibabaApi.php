<?php

namespace AlibabaApi;

use AlibabaApi\client\AliOss;
use AlibabaApi\client\AliSms;

/**
 * Class AlibabaApi
 * @package AlibabaApi
 */
class AlibabaApi
{
    /**
     * oss客户端
     *
     * @var AliOss null
     */
    public $aliOssClient = null;

    /**
     * sms客户端
     *
     * @var null
     */
    public $aliSmsClient = null;

    /**
     * 创建阿里云oss客户端
     *
     * @return AliOss|null
     */
    public function aliOssClient()
    {
        if ($this->aliOssClient instanceof AliOss) {
            return $this->aliOssClient;
        }
        $this->aliOssClient = new AliOss();
        return $this->aliOssClient;
    }

    /**
     * 创建阿里云sms客户端
     *
     * @return AliSms|null
     */
    public function aliSmsClient()
    {
        if ($this->aliSmsClient instanceof AliSms) {
            return $this->aliSmsClient;
        }
        $this->aliSmsClient = new AliSms();
        return $this->aliSmsClient;
    }

    /**
     * 上传文件到oss
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $bucket
     * @param $endPoint
     * @param $fileName
     * @param $ossFileDir
     * @param string $errorMessage
     * @param string $filePath
     * @param string $fileContent
     * @return bool
     */
    public function uploadFileToOss(
        $accessKeyId,
        $accessKeySecret,
        $bucket,
        $endPoint,
        $fileName,
        $ossFileDir,
        &$errorMessage = "success",
        $filePath = "",
        $fileContent = ""
    )
    {
        return $this->aliOssClient()->uploadFileToOss(
            $accessKeyId,
            $accessKeySecret,
            $bucket,
            $endPoint,
            $fileName,
            $ossFileDir,
            $errorMessage,
            $filePath,
            $fileContent
        );
    }

    /**
     * 从oss删除文件
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $bucket
     * @param $endPoint
     * @param $fileName
     * @param $ossFileDir
     * @param string $errorMessage
     * @return bool
     */
    public function deleteFileFromOss(
        $accessKeyId,
        $accessKeySecret,
        $bucket,
        $endPoint,
        $fileName,
        $ossFileDir,
        &$errorMessage = "success"
    )
    {
        return $this->aliOssClient()->deleteFileFromOss(
            $accessKeyId,
            $accessKeySecret,
            $bucket,
            $endPoint,
            $fileName,
            $ossFileDir,
            $errorMessage
        );
    }

    /**
     * 发送短信
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
    public function sendSmsMessage(
        $accessKeyId,
        $accessKeySecret,
        $phone,
        $signName,
        $templateCode,
        &$errorMessage = "message",
        $templateParam = []
    )
    {
        return $this->aliSmsClient()
            ->sendSms(
                $accessKeyId,
                $accessKeySecret,
                $phone,
                $signName,
                $templateCode,
                $errorMessage = "message",
                $templateParam = []
            );
    }
}
