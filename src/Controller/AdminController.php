<?php

namespace App\Controller;

use App\Repository\BedroomRepository;
use App\Repository\HotelRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Reservation;
use App\Entity\Bedroom;
use App\Entity\Hotel;
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository, ReservationRepository $reservationRepository, BedroomRepository $bedroomRepository, HotelRepository $hotelRepository): Response
    {
        $user_size = count($userRepository->findAll());
        $reservation_size = count($reservationRepository->findAll());
        $bedroom_size = count($bedroomRepository->findAll());
        $hotel_size = count($hotelRepository->findAll());
        return $this->render('admin/index.html.twig', [
            'user_size' => $user_size,
            'reservation_size' => $reservation_size,
            'bedroom_size' => $bedroom_size,
            'hotel_size' => $hotel_size,
        ]);
    }

    // app_admin_hotel, app_admin_reservation, app_admin_bedroom, app_admin_user
    #[Route('/admin/hotel', name: 'app_admin_hotel')]
    public function hotel(HotelRepository $hotelRepository): Response
    {
        $hotels = $hotelRepository->findAll();
        return $this->render('admin/hotel.html.twig', [
            'hotels' => $hotels,
        ]);
    }
    #[Route('/admin/reservation', name: 'app_admin_reservation')]
    public function reservation(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        return $this->render('admin/reservation.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    #[Route('/admin/bedroom', name: 'app_admin_bedroom')]
    public function bedroom(BedroomRepository $bedroomRepository): Response
    {
        $bedrooms = $bedroomRepository->findAll();
        return $this->render('admin/bedroom.html.twig', [
            'bedrooms' => $bedrooms,
        ]);
    }
    #[Route('/admin/user', name: 'app_admin_user')]
    public function user(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user.html.twig', [
            'users' => $users,
        ]);
    }
}
