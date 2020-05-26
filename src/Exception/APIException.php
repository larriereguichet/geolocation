<?php

namespace LAG\GeoLocation\Exception;

use Exception;
use Throwable;

class APIException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'An error has occurred during the call of the LocationIQ API : '.$message;

        parent::__construct($message, $code, $previous);
    }
}
