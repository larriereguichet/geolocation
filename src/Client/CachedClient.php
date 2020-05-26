<?php

namespace LAG\GeoLocation\Client;

use LAG\GeoLocation\Contracts\Client\ClientInterface;
use LAG\GeoLocation\Result\Result;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class CachedClient implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function query(string $query): Result
    {
        $cache = new FilesystemAdapter();
        $cacheKey = $this->getCacheKey($query);
        $this->logger->debug(sprintf('Trying to find the query "%s" in the cache', $query));

        return $cache->get($cacheKey, function (ItemInterface $item) use ($query) {
            $item->expiresAfter(3600);
            $this->logger->debug(sprintf('Localisation query "%s" not found in the cache. A query to the API will be done', $query));

            return $this->client->query($query);
        });
    }

    private function getCacheKey(string $query): string
    {
        return 'location_iq_'.$query;
    }

}
