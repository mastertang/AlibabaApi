#阿里接口调用方法(PHP版)

#### 说明：
* 异常错误码
```
    const CURL_TIMEOUT = 0x1000                 //curl请求超时
    const CURL_ERROR = 0x1001                   //curl异常
    const REMODE_RETURN_NULL = 0x1002           //请求返还空
    const REMODE_RETURN_JSON_ERROR = 0x1003     //解析返还的json失败
    const PARAMS_NULL = 0x1004                  //传入的参数为空
```
* 如何查看运行后的异常码和异常消息
```
    异常码: AliApiPHP::$exceptionCode;
    异常消息: AliApiPHP::$exceptionMsg;
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
    