<?php
namespace AliApiPHP\Exception;
class AliApiException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }

    public function __toString()
    {
        return __CLASS__ . ":[{Line:$this->line}]: {$this->message}\n";
    }
}
