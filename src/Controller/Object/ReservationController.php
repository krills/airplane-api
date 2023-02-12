<?php

namespace App\Controller\Object;

use App\Controller\Storage\StorageInterface;
use App\Model\Airport;
use App\Model\Flight;
use App\Model\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    public function __construct(private StorageInterface $storage)
    {

    }

    private static function getRandomSeat(): string
    {
        return ['A','B','C','D','E','F'][random_int(0, 5)] . random_int(1, 32);
    }

    public function createReservation(
        Airport $source,
        Airport $destination,
        \DateTime $departure,
        string $passportNumber
    ): Ticket
    {
        return $this->storage->createTicket(new Ticket(
            flight: new Flight($source, $destination, $departure),
            seat: self::getRandomSeat(),
            passportId: $passportNumber
        ));
    }

    /**
     * @return Ticket[]
     */
    public function getReservations(): array
    {
        return $this->storage->getTickets();
    }

    public function cancelReservation(string $reservation): bool
    {
        return $this->storage->deleteTicket($reservation);
    }

    public function changeSeat(string $reservationId, string $seat): Ticket
    {
        $reservation = $this->storage->getTicket($reservationId);
        $reservation->seat = $seat;
        return $this->storage->updateTicket($reservation);
    }
}
