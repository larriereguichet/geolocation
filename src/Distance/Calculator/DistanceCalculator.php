<?php

namespace LAG\GeoLocation\Distance\Calculator;

use Exception;
use Geokit\Position;
use LAG\GeoLocation\Contracts\Distance\Calculator\DistanceCalculatorInterface;
use LAG\GeoLocation\Contracts\Distance\DistanceContainerInterface;
use function Geokit\distanceHaversine;

class DistanceCalculator implements DistanceCalculatorInterface
{
    public function define(array $distanceContainers, Position $from, bool $sort = true): array
    {
        foreach ($distanceContainers as $container) {
            if (!$container instanceof DistanceContainerInterface) {
                throw new Exception(sprintf(
                    'Invalid type provided. Expected "%s", got "%s"',
                    DistanceContainerInterface::class,
                    is_object($container) ? get_class($container) : gettype($container)
                ));
            }
            $this->defineDistance($from, $container);
        }

        if ($sort) {
            usort(
                $distanceContainers,
                function (DistanceContainerInterface $container1, DistanceContainerInterface $container2) {
                    return $container1->getDistance() > $container2->getDistance();
                }
            );
        }

        return $distanceContainers;
    }

    public function defineDistance(Position $from, DistanceContainerInterface $to): void
    {
        $distance = $this->distance($from, $to->getPosition());
        $to->setDistance($distance);
    }

    public function distance(Position $from, Position $to): float
    {
        $distance = distanceHaversine($from, $to);

        return $distance->kilometers();
    }
}
