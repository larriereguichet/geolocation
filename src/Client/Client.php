<?php

namespace LAG\GeoLocation\Client;

use Exception;
use LAG\GeoLocation\Contracts\Client\ClientInterface;
use LAG\GeoLocation\Exception\AddressNotFoundException;
use LAG\GeoLocation\Exception\APIException;
use LAG\GeoLocation\Result\Result;
use Psr\Log\LoggerInterface;

class Client implements ClientInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \GuzzleHttp\Client|\GuzzleHttp\ClientInterface
     */
    private $client;

    private $endpoint = 'https://eu1.locationiq.com/v1/search.php';

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(string $apiKey, LoggerInterface $logger, \GuzzleHttp\ClientInterface $client = null)
    {
        $this->apiKey = $apiKey;

        if ($client === null) {
            $client = new \GuzzleHttp\Client();
        }
        $this->client = $client;
        $this->logger = $logger;
    }

    public function query(string $query): Result
    {
        try {
            $this->logger->debug(sprintf('Run localisation query with data "%s"', $query));
            $response = $this->client->get($this->endpoint, [
                'query' => [
                    'key' => $this->apiKey,
                    'format' => 'json',
                    'q' => $query,
                ],
            ]);
        } catch (Exception $exception) {
            throw new APIException($exception->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new APIException($response->getReasonPhrase());
        }
        $json = $response->getBody()->getContents();
        $this->logger->debug('Localisation query return with json results '.$json);
        $data = json_decode($json, JSON_OBJECT_AS_ARRAY);

        if (count($data) === 0) {
            throw new AddressNotFoundException($query);
        }
        // Find the most matching results
        $data = $data[0];
        $this->logger->debug(sprintf('Selecting first result for localisation : lat: %s, lon: %s', $data['lat'], $data['lon']));

        return new Result($data['lat'], $data['lon'], $data);
    }

}
