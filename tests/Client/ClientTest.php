<?php

namespace LAG\GeoLocation\Tests\Client;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use LAG\GeoLocation\Client\Client;
use LAG\GeoLocation\Exception\APIException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ClientTest extends TestCase
{
    public function testQuery(): void
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode([
                ['lat' => 666.666, 'lon' => 666.666],
            ])),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects($this->exactly(3))
            ->method('debug')
        ;
        
        $client = new Client('my-key', $logger, $guzzleClient);
        $result = $client->query('my-city');
        
        $this->assertCount(1, $container);
        $this->assertArrayHasKey(0, $container);
        
        $testData = $container[0];
        /** @var Request $testRequest */
        $testRequest = $testData['request'];
        $this->assertEquals(
            'https://eu1.locationiq.com/v1/search.php?key=my-key&format=json&q=my-city',
            (string)$testRequest->getUri()
        );
        $this->assertEquals(666.666, $result->getLatitude());
        $this->assertEquals(666.666, $result->getLongitude());
        $this->assertEquals([666.666, 666.666], $result->toArray());
    }
    
    public function testInstanceClient(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        // THe client creation should work
        new Client('my-key', $logger);
        $this->assertTrue(true);
    }
    
    public function testException(): void
    {
        [$client, , $guzzleClient] = $this->createClient();
        $guzzleClient
            ->expects($this->once())
            ->method('__call')
            ->willThrowException(new Exception())
        ;
        $this->expectException(APIException::class);
        
        $client->query('my-city');
    }
    
    public function testWrongStatusCode(): void
    {
        [$client,, $guzzleClient] = $this->createClient();
        $guzzleClient
            ->expects($this->once())
            ->method('__call')
            ->willReturn(new Response(500))
        ;
        $this->expectException(APIException::class);
        
        $client->query('my-city');
    }
    
    public function testNoCompanyFound(): void
    {
        [$client, , $guzzleClient] = $this->createClient();
        
        $guzzleClient
            ->expects($this->once())
            ->method('__call')
            ->willReturn(new Response(200, [], json_encode([])))
        ;
        $this->expectException(APIException::class);
        
        $client->query('my-city');
    }
    
    /**
     * @return Client[]|MockObject[]
     */
    private function createClient(): array
    {
        $logger = $this->createMock(LoggerInterface::class);
        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $client = new Client('my-key', $logger, $guzzleClient);
        
        return [
            $client,
            $logger,
            $guzzleClient,
        ];
    }
}
