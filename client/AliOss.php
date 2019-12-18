<?php
namespace AlibabaApi\client;

use AlibabaApi\src\ossDriver\Oss;

/**
 * Class AliOss
 * @package AlibabaApi\client
 */
class AliOss
{
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
        if ((empty($filePath) && empty($fileContent)) || (!empty($filePath) && !is_file($filePath))) {
            $errorMessage = "文件路径或文件内容错误或为空!";
            return false;
        }
        $oss = new Oss();
        $oss->accessKeyId($accessKeyId)
            ->accessKeySecret($accessKeySecret)
            ->bucket($bucket)
            ->endPoint($endPoint)
            ->fileName($fileName)
            ->ossFileDir($ossFileDir);
        if (!empty($filePath)) {
            $oss->filePath($filePath);
        } else {
            $oss->fileContent($fileContent);
        }
        $result = $oss->uploadFile();
        if ($result === false) {
            $errorMessage = $oss->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 从OSS删除文件
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
        $oss    = new Oss();
        $result = $oss->accessKeyId($accessKeyId)
            ->accessKeySecret($accessKeySecret)
            ->bucket($bucket)
            ->endPoint($endPoint)
            ->fileName($fileName)
            ->ossFileDir($ossFileDir)
            ->deleteFile();
        if ($result === false) {
            $errorMessage = $oss->errorMessage;
            return false;
        }
        return $result;
    }
}