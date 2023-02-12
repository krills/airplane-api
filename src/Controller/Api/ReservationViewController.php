<?php

namespace App\Controller\Api;

use App\Controller\Object\AirportController;
use App\Controller\Object\ReservationController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationViewController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        ReservationController $reservationController,
        AirportController $airportController
    ): Response
    {
        return $this->render(
            'form.html.twig', [
                'reservations' => $reservationController->getReservations(),
                'homePort' => $airportController->getAirport('ESSA'),
                'randomDestinations' => $airportController->getRandomAirports()
            ]
        );
    }

    #[Route('/api/reservation', methods: ['POST'], name: 'makeReservation')]
    public function makeReservation(
        Request $request,
        AirportController $airportController,
        ReservationController $reservationController
    ): RedirectResponse
    {
        $reservationController->createReservation(
            $airportController->getAirport($request->request->get('from')),
            $airportController->getAirport($request->request->get('to')),
            new \DateTime($request->request->get('departure')),
            $request->request->get('passport')
        );
        return $this->redirect('/');
    }

    #[Route('/api/reservation/{reservationId}/cancel', methods: ['GET'], name: 'cancelReservation')]
    public function cancelReservation(
        string $reservationId,
        ReservationController $reservationController
    ): RedirectResponse
    {
        $reservationController->cancelReservation($reservationId);
        return $this->redirect('/');
    }

    #[Route('/api/reservation/{reservationId}/seat', methods: ['POST'], name: 'changeSeat')]
    public function changeSeat(
        string $reservationId,
        Request $request,
        ReservationController $reservationController
    ): RedirectResponse
    {
        $reservationController->changeSeat($reservationId, $request->get('seat'));
        return $this->redirect('/');
    }
}
