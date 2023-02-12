<?php

namespace App\Controller\Storage;

use App\Model\Ticket;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\CacheInterface;

class SimpleFileStorage implements StorageInterface
{
    private array $airports;

    public function __construct(private CacheInterface $cache) {
        $this->airports = json_decode(file_get_contents(__DIR__ . '/../../airports.json'), true);
    }

    public function getAirport(string $icao): array
    {
        return $this->airports[$icao];
    }

    public function getRandomAirports(int $number = 10): array
    {
        shuffle($this->airports);
        return array_slice($this->airports, 0, $number);
    }

    public function createTicket(Ticket $ticket): Ticket
    {
        /** @var CacheItem $ticketCache */
        $ticketCache = $this->cache->getItem('tickets');
        $tickets = $ticketCache->get();
        if (!is_array($tickets)) {
            $tickets = [];
        }

        $ticketId = uniqid('ticket');
        $ticket->id = $ticketId;
        $tickets[$ticketId] = $ticket;

        $ticketCache->set($tickets);
        $this->cache->save($ticketCache);

        return $ticket;
    }

    /**
     * @return Ticket[]
     */
    public function getTickets(): array
    {
        /** @var CacheItem $ticketCache */
        $ticketCache = $this->cache->getItem('tickets');
        $tickets = $ticketCache->get();
        return is_array($tickets) ? $tickets : [];
    }

    public function deleteTicket(string $id): bool
    {
        $tickets = $this->getTickets();
        unset($tickets[$id]);

        $this->saveTickets($tickets);

        return true;
    }

    public function getTicket(string $reservationId): Ticket
    {
        return $this->getTickets()[$reservationId];
    }

    public function updateTicket(Ticket $ticket): Ticket
    {
        $tickets = $this->getTickets();
        $tickets[$ticket->id] = $ticket;

        $this->saveTickets($tickets);

        return $ticket;
    }

    private function saveTickets(array $tickets): void
    {
        $ticketCache = $this->cache->getItem('tickets');
        $ticketCache->set($tickets);
        $this->cache->save($ticketCache);
    }
}