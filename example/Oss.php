<?php
include "../AlibabaApi.php";
include "../client/AliOss.php";
include "../client/AliSms.php";
include "../client/AliPay.php";

include "../src/ossDriver/Oss.php";
include "../src/smsDriver/Sms.php";

// oss上传文件
$result = (new \AlibabaApi\AlibabaApi())->aliOssClient()
    ->uploadFileToOss(
        "TEST_TEST_TEST",
        "TEST_TEST_TEST_TEST",
        "test",
        "https://oss-xxx-xxx.net",
        "test.txt",
        "test/",
        $errorMessage,
        "test.txt"
    );
var_dump(($result === false ? $errorMessage : $result));

// oss上传内容
$result = (new \AlibabaApi\AlibabaApi())->aliOssClient()
    ->uploadFileToOss(
        "TEST_TEST_TEST",
        "TEST_TEST_TEST_TEST",
        "test",
        "https://oss-xxx-xxx.net",
        "test.txt",
        "test/",
        $errorMessage,
        "",
        "Hello World!"
    );
var_dump(($result === false ? $errorMessage : $result));

// oss删除文件
$result = (new \AlibabaApi\AlibabaApi())->aliOssClient()
    ->deleteFileFromOss(
        "TEST_TEST_TEST",
        "TEST_TEST_TEST_TEST",
        "test",
        "https://oss-xxx-xxx.net",
        "test.txt",
        "test/",
        $errorMessage
    );
var_dump(($result === false ? $errorMessage : $result));

// 发送短信
$result = (new \AlibabaApi\AlibabaApi())->aliSmsClient()
    ->sendSms(
        "TEST_TEST_TEST",
        "TEST_TEST_TEST_TEST",
        "159143xxxxz",
        "测试",
        "CODE_CODE_CODE",
        $errorMessage,
        [
            "code" => "123456"
        ]
    );
var_dump(($result === false ? $errorMessage : $result));
