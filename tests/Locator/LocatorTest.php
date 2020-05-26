<?php

namespace LAG\GeoLocation\Tests\Locator;

use LAG\GeoLocation\Locator\Locator;
use Geokit\Position;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    public function testInRange(): void
    {
        $locator = $this->createLocator();
        
        // Assert that Tassin-la-demi-lune is at max 50km from Lyon
        $this->assertTrue($locator->isInRange(
            Position::fromCoordinates([45.7555, 4.7573]), Position::fromCoordinates([45.7475, 4.8218]), 50.0)
        );
        
        // Assert than Paris is not 50km far from Lyon but at max 500km far
        $this->assertFalse($locator->isInRange(
            Position::fromCoordinates([48.8669, 2.3488]), Position::fromCoordinates([45.7475, 4.8218]), 50.0)
        );
        $this->assertTrue($locator->isInRange(
            Position::fromCoordinates([48.8669, 2.3488]), Position::fromCoordinates([45.7475, 4.8218]), 500.0)
        );
    }
    
    private function createLocator(): Locator
    {
        return new Locator();
    }
}
