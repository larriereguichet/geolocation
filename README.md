# GeoLocation

## Install
```bash
composer require lag/geolocation
```

## Usage

### Calculate distance between two points

```php

use LAG\GeoLocation\Distance\Calculator\DistanceCalculator;
use Geokit\Position;

$position1 = Position::fromXY(45.25, 65.23); 
$position2 = Position::fromXY(23.94, 55.12); 

$calculator = new DistanceCalculator();
$distance = $calculator->distance($position1, $position2);

// Distance are returned in kilometers
// $distance = 45.23

```

### Check if a position is in a circle

```php

use LAG\GeoLocation\Locator\Locator;
use Geokit\Position;

$position1 = Position::fromXY(45.25, 65.23); 
$center = Position::fromXY(23.94, 55.12);

$locator = new Locator();
// will return true if the position is in the circle with center $center and radius 45km 
$locator->isInRange($position1, $center, 45.0);

```
