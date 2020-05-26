<?php

namespace LAG\GeoLocation\Contracts\Distance;

use Geokit\Position;

interface DistanceContainerInterface
{
    public function getPosition(): Position;
    
    public function setDistance(float $distance): void;

    public function getDistance(): float;
}
