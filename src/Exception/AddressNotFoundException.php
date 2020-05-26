<?php

namespace LAG\GeoLocation\Exception;

use Throwable;

class AddressNotFoundException extends APIException
{
    public function __construct(string $query, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('The provided address "%s" is not found in the API', $query);

        parent::__construct($message, $code, $previous);
    }
}
