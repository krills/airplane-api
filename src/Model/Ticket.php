<?php

namespace App\Model;

class Ticket
{
    public function __construct(
        public Flight $flight,
        public string $seat,
        public string $passportId,
        public ?string $id = null,
    )
    {

    }
}