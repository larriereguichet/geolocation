<?php

namespace LAG\GeoLocation\Tests\Distance;

use Geokit\Position;
use LAG\GeoLocation\Contracts\Distance\DistanceContainerInterface;
use LAG\GeoLocation\Distance\DistanceContainerTrait;

class DistanceContainer implements DistanceContainerInterface
{
    use DistanceContainerTrait;

    public function getPosition(): Position
    {
        return Position::fromCoordinates([44.55, 66.77]);
    }
}
