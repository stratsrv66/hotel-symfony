<?php

namespace App\Controller;

use App\Entity\Bedroom;
use App\Form\BedroomType;
use App\Repository\BedroomRepository;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BedroomController extends AbstractController
{
    #[Route('/bedroom', name: 'app_bedroom')]
    public function index(): Response
    {
        return $this->render('bedroom/index.html.twig.twig', [
            'controller_name' => 'BedroomController',
        ]);
    }

    // create
    #[Route('/bedroom/create', name: 'app_bedroom_create')]
    public function createBedroom(Request $request, EntityManagerInterface $entityManager, BedroomRepository $bedroomRepository): Response
    {
        $bedroom = new Bedroom();
        $bedroomData = $request->request->all()['bedroom'];
        // Get other parameters from the request
        $hotelId = $bedroomData['hotelId'];
        $number = $bedroomData['number'];
        $type = $bedroomData['type'];

        // Set the hotel info
        $bedroom->setHotelId($hotelId);
        $bedroom->setNumber($number);
        $bedroom->setType($type);

        // Save the hotel in the database
        $entityManager->persist($bedroom);
        $entityManager->flush();

        // redirect to the hotel list
        return $this->redirectToRoute('app_admin_bedroom');
    }

    #[Route('/bedroom/delete/{id}', name: 'app_bedroom_delete')]
    public function deleteBedroom($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $bedroom = $entityManager->getRepository(Bedroom::class)->find($id);
        if (!$bedroom) {
            throw $this->createNotFoundException(
                'No bedroom found for id ' . $id
            );
        }
        $entityManager->remove($bedroom);
        $entityManager->flush();
        return $this->redirectToRoute('app_bedroom');
    }

    #[Route('/bedroom/update/{id}', name: 'app_bedroom_update')] #[Route('/hotel/update/{id}', name: 'app_hotel_update')]
    public function updateBedroom (Request $request, EntityManagerInterface $entityManager, int $id, BedroomRepository $bedroomRepository, HotelRepository $hotelRepository, CategoryRepository $categoryRepository): Response{

        $bedroom = $bedroomRepository->find($id);

        if (!$bedroom) {
            throw $this->createNotFoundException('No bedroom found for id ' . $id);
        }

        $bedroomData = $request->request->all()['bedroom_update'];
        // Get other parameters from the request
        $number = $bedroomData['number'];
        $hotel_id = $bedroomData['hotel_id'];
        $categorie = $bedroomData['categories'];
        $type = $bedroomData['type'];

        $hotel = $hotelRepository->find($hotel_id);
        $categorie = $categoryRepository->find($categorie);

        // Set the hotel info
        $bedroom->setHotelId($hotel);
        $bedroom->setNumber($number);
        $bedroom->addCategory($categorie);
        $bedroom->setType($type);


        // Save the hotel in the database
        $entityManager->persist($bedroom);
        $entityManager->flush();

        // redirect to the hotel list
        return $this->redirectToRoute('app_admin_bedroom');

    }
}
