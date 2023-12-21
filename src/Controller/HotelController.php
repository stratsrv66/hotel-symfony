<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\HotelRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    //delete
    #[Route('/hotel/delete/{id}', name: 'app_hotel_delete')]
    public function delete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hotel = $entityManager->getRepository(Hotel::class)->find($id);
        $entityManager->remove($hotel);
        $entityManager->flush();
        return $this->redirectToRoute('app_hotel');
    }

    #[Route('/hotel/update/{id}', name: 'app_hotel_update')]
    public function updateHotel (Request $request, EntityManagerInterface $entityManager, HotelRepository $hotelRepository, int $id, CityRepository $cityRepository): Response{

        $hotel = $hotelRepository->find($id);

        if (!$hotel) {
            throw $this->createNotFoundException('No hotel found for id ' . $id);
        }

        $hotelData = $request->request->all()['hotel_update'];
        // Get other parameters from the request
        $name = $hotelData['name'];
        $address = $hotelData['address'];
        $city = $cityRepository->find($hotelData['city']);

        // Set the hotel info
        $hotel->setName($name);
        $hotel->setAddress($address);
        $hotel->setCity($city);

        // Save the hotel in the database
        $entityManager->persist($hotel);
        $entityManager->flush();

        // redirect to the hotel list
        return $this->redirectToRoute('app_admin_hotel');

    }


}
