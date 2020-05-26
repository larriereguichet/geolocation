<?php

namespace LAG\GeoLocation\Contracts\Locator;

use Geokit\Position;

interface LocatorInterface
{
    /**
     * Return true if the given position is in a circle with a range radius from the given center.
     *
     * @param Position $position The position to test
     * @param Position $center   The start of the search
     * @param float    $range    The search range in km
     *
     * @return bool True if the position is in the given range
     */
    public function isInRange(Position $position, Position $center, float $range): bool;
}
