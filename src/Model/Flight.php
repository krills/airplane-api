<?php

namespace App\Model;

class Flight
{
    public function __construct(
        public Airport $source,
        public Airport $destination,
        public \DateTime $departure
    )
    {

    }
}