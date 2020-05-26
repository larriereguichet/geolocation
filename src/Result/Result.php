<?php

namespace LAG\GeoLocation\Result;

use Geokit\Position;

/**
 * Represents an API result after a query to the LocationIQ API.
 */
class Result
{
    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var array
     */
    private $data;

    public function __construct(float $latitude, float $longitude, array $data = [])
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->data = $data;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function toArray(): array
    {
        return [$this->getLatitude(), $this->getLongitude()];
    }

    public function getPosition(): Position
    {
        return Position::fromCoordinates($this->toArray());
    }

    public function getData(): array
    {
        return $this->data;
    }
}

