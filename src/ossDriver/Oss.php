<?php

namespace AlibabaApi\src\ossDriver;

use OSS\Core\OssException;
use OSS\OssClient;

/**
 * Class Oss
 * @package AlibabaApi\client
 */
class Oss
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
     * @var string 终端
     */
    protected $endPoint = "";

    /**
     * @var string 存储桶名
     */
    protected $bucket = "";

    /**
     * @var string 文件路径
     */
    protected $filePath = "";

    /**
     * @var string 文件内容
     */
    protected $fileContent = "";

    /**
     * @var string 存储桶文件夹路径
     */
    protected $ossFileDir = "";

    /**
     * @var string 文件名
     */
    protected $fileName = "";

    /**
     * 设置accesskey
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
     * 设置accessKeySecret
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
     * 设置point
     *
     * @param $endPoint
     * @return $this
     */
    public function endPoint($endPoint)
    {
        $this->endPoint = $endPoint;
        return $this;
    }

    /**
     * 设置bucket
     *
     * @param $bucket
     * @return $this
     */
    public function bucket($bucket)
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * 设置文件路径
     *
     * @param $filePath
     * @return $this
     */
    public function filePath($filePath)
    {
        if (is_file($filePath)) {
            $this->filePath    = $filePath;
            $this->fileContent = "";
        }
        return $this;
    }

    /**
     * 设置文件内容
     *
     * @param $fileContent
     * @return $this
     */
    public function fileContent($fileContent)
    {
        $this->fileContent = $fileContent;
        $this->filePath    = "";
        return $this;
    }

    /**
     * 错误信息
     *
     * @var string
     */
    public $errorMessage = "";

    /**
     * 设置oss保存文件的文件夹路径
     *
     * @param $ossFileDir
     * @return $this
     */
    public function ossFileDir($ossFileDir)
    {
        if ($ossFileDir !== "") {
            if ($ossFileDir{0} === "/") {
                $ossFileDir = substr($ossFileDir, 1);
            }
            if ($ossFileDir{(strlen($ossFileDir) - 1)} != "/") {
                $ossFileDir .= "/";
            }
        }
        $this->ossFileDir = $ossFileDir;
        return $this;
    }

    /**
     * 文件名字
     *
     * @param $fileName
     * @return $this
     */
    public function fileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * 上传文件到OSS
     *
     * @return bool
     */
    public function uploadFile()
    {
        $object = $this->ossFileDir . $this->fileName;
        try {
            $ossClient = new OssClient(
                $this->accessKeyId,
                $this->accessKeySecret,
                $this->endPoint
            );
            if (!empty($this->filePath)) {
                $ossClient->uploadFile($this->bucket, $object, $this->filePath);
            } else {
                $ossClient->putObject($this->bucket, $object, $this->fileContent);
            }
        } catch (OssException $exception) {
            $this->errorMessage = $exception->getMessage();
            return false;
        }
        return true;
    }

    /**
     * 从oss删除文件
     *
     */
    public function deleteFile()
    {
        $object = $this->ossFileDir . $this->fileName;
        try {
            $ossClient = new OssClient(
                $this->accessKeyId,
                $this->accessKeySecret,
                $this->endPoint
            );
            $ossClient->deleteObject($this->bucket, $object);
        } catch (OssException $exception) {
            $this->errorMessage = $exception->getMessage();
            return false;
        }
        return true;
    }
}