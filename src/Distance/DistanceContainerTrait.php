<?php

namespace LAG\GeoLocation\Distance;

trait DistanceContainerTrait
{
    protected $distance = 0.0;

    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }
}
