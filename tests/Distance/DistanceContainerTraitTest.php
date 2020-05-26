<?php

namespace LAG\GeoLocation\Tests\Distance;

use PHPUnit\Framework\TestCase;

class DistanceContainerTraitTest extends TestCase
{
    public function testContainer()
    {
        $container = new DistanceContainer();
        $container->setDistance(666.0);

        $this->assertEquals(666.0, $container->getDistance());
    }
}
