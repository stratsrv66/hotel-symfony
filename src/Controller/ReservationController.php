<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;

class ReservationController extends AbstractController
{

    #[Route('/reservations', name: 'app_reservation_list')]
    public function index(ReservationRepository $repository): Response
    {

        // get all the reservations
        $reservation = $repository->findAll();

        // return the reservations as json
        return $this->json($reservation);

    }

    #[Route('/reservation/{id}', name: 'app_reservation_id')]
    public function getReservationById(Reservation $reservation, Request $request): Response
    {

        // if the reservation does not exist return a 404
        if (!$reservation) {
            throw $this->createNotFoundException(
                'No reservation found for id ' . $request->get('id')
            );
        }

        // return the reservation as json
        return $this->json($reservation);

    }

    #[Route('/reservation/{bedroom_id}', name: 'app_reservation_bedroom_id')]
    public function getReservationByBedroomId(Reservation $reservation, Request $request): Response
    {

        // if the reservation does not exist return a 404
        if (!$reservation) {
            throw $this->createNotFoundException(
                'No reservation found for bedroom_id ' . $request->get('bedroom_id')
            );
        }

        // return the reservation as json
        return $this->json($reservation);

    }

    #[Route('/reservation/{hotel_id}', name: 'app_reservation_hotel_id')]
    public function getReservationByHotelId(Reservation $reservation, Request $request): Response
    {

        // if the reservation does not exist return a 404
        if (!$reservation) {
            throw $this->createNotFoundException(
                'No reservation found for hotel_id ' . $request->get('hotel_id')
            );
        }

        // return the reservation as json
        return $this->json($reservation);

    }

}
