<?php
namespace AliApiPHP\Exception;
class AliApiException extends \Exception
{
    const CURL_TIMEOUT = 0x1000;
    const CURL_ERROR = 0x1001;
    const REMODE_RETURN_NULL = 0x1002;
    const REMODE_RETURN_JSON_ERROR = 0x1003;
    const PARAMS_NULL = 0x1004;

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{Line:$this->line}]: {$this->message}\n";
    }
}
