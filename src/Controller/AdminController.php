<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Service;
use App\Form\BedroomType;
use App\Form\CategoryType;
use App\Form\HotelType;
use App\Form\HotelUpdateType;
use App\Form\ReservationType;
use App\Form\ServiceType;
use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Repository\BedroomRepository;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\HotelRepository;
use App\Repository\ReservationRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Reservation;
use App\Entity\Bedroom;
use App\Entity\Hotel;
use App\Entity\City;
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
    public function hotel(HotelRepository $hotelRepository, CityRepository $cityRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $cities = $cityRepository->findAll();
        $hotels = $hotelRepository->findAll();
        $hotel = new Hotel();

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_hotel');
        }

        $form_update = $this->createForm(HotelUpdateType::class, $hotel);
        $form_update->handleRequest($request);

        if ($form_update->isSubmitted() && $form_update->isValid()) {

            $user = $form_update->getData();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_hotel');
        }

        return $this->render('admin/hotel.html.twig', [
            'form' => $form->createView(),
            'form_update' => $form_update->createView(),
            'hotels' => $hotels,
            'cities' => $cities,
        ]);
    }
    #[Route('/admin/reservation', name: 'app_admin_reservation')]
    public function reservation(ReservationRepository $reservationRepository, EntityManagerInterface $entityManager, Request $request): Response
    {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_reservation');
        }

        $reservations = $reservationRepository->findAll();
        return $this->render('admin/reservation.html.twig', [
            'reservations' => $reservations,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/bedroom', name: 'app_admin_bedroom')]
    public function bedroom(BedroomRepository $bedroomRepository, EntityManagerInterface $entityManager, Request $request): Response
    {

        $bedroom = new Bedroom();

        $form = $this->createForm(BedroomType::class, $bedroom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bedroom);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bedroom');
        }

        $bedrooms = $bedroomRepository->findAll();
        return $this->render('admin/bedroom.html.twig', [
            'bedrooms' => $bedrooms,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/user', name: 'app_admin_user')]
    public function user(UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user');
        }

        $form_update = $this->createForm(UserUpdateType::class, $user);
        $form_update->handleRequest($request);

        if ($form_update->isSubmitted() && $form_update->isValid()) {

            $user = $form_update->getData();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user');
        }

        $users = $userRepository->findAll();
        return $this->render('admin/user.html.twig', [
            'form' => $form->createView(),
            'form_update' => $form_update->createView(),
            'users' => $users,
        ]);

    }

    //category
    #[Route('/admin/category', name: 'app_admin_category')]
    public function category(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category');
        }

        $categories = $categoryRepository->findAll();
        return $this->render('admin/category.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);

    }


    // services
    #[Route('/admin/services', name: 'app_admin_services')]
    public function services(ServiceRepository $serviceRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $service = new Service();
        $services = $serviceRepository->findALl();

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_services');
        }

        return $this->render('admin/services.html.twig', [
            "services" => $services,
            "form" => $form
        ]);
    }

}
