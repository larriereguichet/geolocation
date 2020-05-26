<?php

namespace LAG\GeoLocation\Locator;

use Geokit\Distance;
use Geokit\Position;
use LAG\GeoLocation\Contracts\Locator\LocatorInterface;
use function Geokit\circle;

class Locator implements LocatorInterface
{
    public function isInRange(Position $position, Position $center, float $range): bool
    {
        $polygon = circle(
            $center,
            Distance::fromString($range.'km'),
            32
        );
        
        return $polygon->contains($position);
    }
}
