<?php

namespace LAG\GeoLocation\Contracts\Distance\Calculator;

use Exception;
use Geokit\Position;
use LAG\GeoLocation\Contracts\Distance\DistanceContainerInterface;

interface DistanceCalculatorInterface
{
    /**
     * Define the distance from a given point for an array of distance containers, and optionally sort them by
     * distance.
     *
     * @param array    $distanceContainers
     * @param Position $from
     * @param bool     $sort
     *
     * @return array
     *
     * @throws Exception
     */
    public function define(array $distanceContainers, Position $from, bool $sort = true): array;
    
    /**
     * Return the distance in kilometers between two coordinates.
     *
     * @param Position $from
     * @param Position $to
     *
     * @return float
     */
    public function distance(Position $from, Position $to): float;
    
    /**
     * Calculate the distance between to points and set the result in the DistanceInterface element.
     *
     * @param Position                   $from
     * @param DistanceContainerInterface $to
     */
    public function defineDistance(Position $from, DistanceContainerInterface $to): void;
}
