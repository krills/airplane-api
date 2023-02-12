<?php

namespace App\Controller\Object;

use App\Controller\Storage\StorageInterface;
use App\Model\Airport;

class AirportController
{
    public function __construct(private StorageInterface $storage) {

    }

    public function getAirport(string $icao): Airport
    {
        return new Airport(...$this->storage->getAirport($icao));
    }

    /**
     * @return Airport[]
     */
    public function getRandomAirports(): array
    {
        return array_map(
            fn($airport) => new Airport(...$airport),
            $this->storage->getRandomAirports()
        );
    }
}