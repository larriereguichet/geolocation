<?php

namespace LAG\GeoLocation\Tests\Distance;

use Exception;
use Geokit\Position;
use LAG\GeoLocation\Contracts\Distance\DistanceContainerInterface;
use LAG\GeoLocation\Distance\Calculator\DistanceCalculator;
use PHPUnit\Framework\TestCase;
use stdClass;

class DistanceCalculatorTest extends TestCase
{
    public function testDefineDistance(): void
    {
        $distanceItem = $this->createMock(DistanceContainerInterface::class);
        $distanceItem
            ->expects($this->once())
            ->method('getPosition')
            ->willReturn(Position::fromCoordinates([77.77, 77.77]))
        ;
        $distanceItem
            ->expects($this->once())
            ->method('setDistance')
            ->with(1286.3434618739273)
        ;
        
        $calculator = new DistanceCalculator();
        $calculator->defineDistance(Position::fromCoordinates([66.66, 66.66]), $distanceItem);
    }

    public function testDefine(): void
    {
        $distanceContainer = $this->createMock(DistanceContainerInterface::class);
        $otherDistanceContainer = $this->createMock(DistanceContainerInterface::class);

        $distanceContainer
            ->expects($this->once())
            ->method('getPosition')
            ->willReturn(Position::fromCoordinates([99.99, 88.88]))
        ;
        $otherDistanceContainer
            ->expects($this->once())
            ->method('getPosition')
            ->willReturn(Position::fromCoordinates([00.00, 11.11]))
        ;

        $calculator = new DistanceCalculator();
        $calculator->define([
            $distanceContainer,
            $otherDistanceContainer,
        ], Position::fromCoordinates([66.66, 77.77]));
    }

    public function testDefineWithWrongElementType(): void
    {
        $distanceContainer = new stdClass();

        $this->expectException(Exception::class);
        $calculator = new DistanceCalculator();
        $calculator->define([
            $distanceContainer,
        ], Position::fromCoordinates([66.66, 77.77]));
    }
}
