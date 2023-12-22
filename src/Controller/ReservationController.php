<?php

namespace App\Controller;

use App\Repository\BedroomRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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

    // delete
    #[Route('/reservation/delete/{id}', name: 'app_reservation_delete')]
    public function deleteReservation(Reservation $reservation, Request $request, EntityManagerInterface $entityManager): Response
    {

        // if the reservation does not exist return a 404
        if (!$reservation) {
            throw $this->createNotFoundException(
                'No reservation found for id ' . $request->get('id')
            );
        }

        // delete the reservation
        $entityManager->remove($reservation);
        $entityManager->flush();

        // return the reservation as json
        return $this->redirectToRoute('app_admin_reservation');

    }
    #[Route('/reservation/create', name: 'app_reservation_create', methods: ['POST'])]
    public function createReservation(Request $request, Session $session, UserRepository $userRepository, EntityManagerInterface $entityManager, BedroomRepository $bedroomRepository): Response
    {

        // create a new user
        $reservation = new Reservation();

        // get the user id from the session
        $userId = $session->get('user_id');

        // get the user from the database
        $user = $userRepository->find($userId);

        // get the reservation infos
        $startDate = $request->request->get('startDate');
        $endDate = $request->request->get('endDate');
        $bedroom = $bedroomRepository->find($request->request->get('bedroom_id'));

        // set the reservation infos
        $reservation->setStartDate(new DateTime($startDate));
        $reservation->setEndDate(new DateTime($endDate));
        $reservation->setBedroomId($bedroom);
        $reservation->setUserId($user);

        // save the reservation in the database
        $entityManager->persist($reservation);
        $entityManager->flush();

        // redirect to the user list
        return $this->redirectToRoute('app_user_side', [
            'message' => 'Reservation created successfully'
        ]);

    }

}
