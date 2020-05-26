<?php

namespace LAG\GeoLocation\Tests\Client;

use LAG\GeoLocation\Client\CachedClient;
use LAG\GeoLocation\Contracts\Client\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class CachedClientTest extends TestCase
{
    public function testQuery(): void
    {
        $locationIQClient = $this->createMock(ClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $logger
            ->expects($this->exactly(2))
            ->method('debug')
        ;
        $locationIQClient
            ->expects($this->once())
            ->method('query')
            ->with('random-city')
        ;
    
        $client = new CachedClient($locationIQClient, $logger);
        $client->query('random-city');
    }
}
