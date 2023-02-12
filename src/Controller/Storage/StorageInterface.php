<?php

namespace App\Controller\Storage;

use App\Model\Ticket;

interface StorageInterface
{
    public function getAirport(string $icao): array;

    public function getRandomAirports(int $number = 10): array;

    public function createTicket(Ticket $ticket): Ticket;

    public function getTickets(): array;

    public function deleteTicket(string $id): bool;

    public function getTicket(string $reservationId): Ticket;

    public function updateTicket(Ticket $ticket): Ticket;
}