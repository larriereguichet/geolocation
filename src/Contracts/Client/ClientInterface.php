<?php

namespace LAG\GeoLocation\Contracts\Client;

use LAG\GeoLocation\Exception\AddressNotFoundException;
use LAG\GeoLocation\Exception\APIException;
use LAG\GeoLocation\Result\Result;

/**
 * Handles connection with LocationIQ api.
 */
interface ClientInterface
{
    /**
     * Query the API with a query string, it could an address, a post code or a city, or a combination of those
     * parameters.
     *
     * @param string $query The query string used in the API call. It could be a full address, a post code, a city...
     *
     * @return Result An object containing the matching results
     *
     * @throws APIException
     * @throws AddressNotFoundException
     */
    public function query(string $query): Result;
}
