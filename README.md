#阿里接口调用方法(PHP版)

#### 说明：
* 异常 AliApiException.php
```
    异常抛出原因
    1.curl请求超时
    2.url异常
    3.请求返还空
    4.传入的参数为空
```
#### 接口
appCode用户可以在阿里Api接口处查看，需要购买才能使用
* 1 . getAddressFromIp($ip, $appCode)  静态方法,根据Ip地址获取用户地址
```
    $ip = 用户ip地址
    $appCode = 用户appCode
```
* 2 . getIpAddrFromPhoneNumber($phone, $appCode)  静态方法,根据Ip地址获取用户地址
```
    $phone = 用户电话号码
    $appCode = 用户appCode
```
* 3 . checkPeopleFace($host, $path, $appCode,$imageData)  静态方法,根据Ip地址获取用户地址
```
    $host = 人脸识别有年龄识别,人脸特征识别,性别识别，它们的host都不同,具体请在阿里Api查看
    $path = 与$host一样，请具体到阿里Api查看
    $appCode = 用户appCode
    $imageData = 图片数据，字符串，可以是Base64字符串
```
* 4 . smsSend($data, $appCode)  静态方法,发送短信
```
    $data = 对应阿里发送短信接口的$querys,详细查看接口文档
        例子:[
            'ParamString'=>变量字符串,
            'RecNum'=>电话号码,
            'SignName'=>签名名字,
            'TemplateCode'=>模板代码
        ]
    $appCode = 用户appCode
```    