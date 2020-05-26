<?php

namespace LAG\GeoLocation\Tests\Result;

use Geokit\Position;
use LAG\GeoLocation\Result\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testResult(): void
    {
        $result = new Result(66.66, 99.99, [
            'my-custom-data',
        ]);
        
        $this->assertEquals(66.66, $result->getLatitude());
        $this->assertEquals(99.99, $result->getLongitude());
        $this->assertEquals([
            'my-custom-data',
        ], $result->getData());
        $this->assertEquals([66.66, 99.99], $result->toArray());
        $this->assertEquals(Position::fromCoordinates([66.66, 99.99]), $result->getPosition());
    }
}
