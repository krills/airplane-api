<?php

namespace App\Model;

class Airport
{
    public function __construct(
        public string $icao,
        public string $iata,
        public string $name,
        public string $city,
        public string $state,
        public string $country,
        public int $elevation,
        public float $lat,
        public float $lon,
        public string $tz
    )
    {

    }
}