<?php

namespace Sodigital\Services\Error;

use \Exception as Base;

class FileNotFound extends Base{
    protected $code = 10;
    protected $message = "No se encuentra el archivo %s";

    public function __construct($message = "" , $code = 10 , $previous = NULL)
    {
        $message = sprintf($this->message,strval($message));
        parent::__construct($message,$code,$previous);
    }
}