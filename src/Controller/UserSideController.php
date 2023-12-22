<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\BedroomRepository;
use App\Repository\CategoryRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class UserSideController extends AbstractController
{
    #[Route('/', name: 'app_user_side')]
    public function index(CategoryRepository $categoryRepository, BedroomRepository $bedroomRepository, ReservationRepository $reservationRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $bedrooms = $bedroomRepository->findAll();
        $reservations = $reservationRepository->findAll();
        return $this->render('user_side/index.html.twig', [
            'categories' => $categories,
            'bedrooms' => $bedrooms,
            'reservations' => $reservations

        ]);
    }

    // /gallery, /contact, /blog, /about, /room
    #[Route('/gallery', name: 'app_user_side_gallery')]
    public function page(): Response
    {
        return $this->render('user_side/gallery.html.twig', [
            'controller_name' => 'UserSideController',
        ]);
    }

    #[Route('/contact', name: 'app_user_side_contact')]
    public function contact(): Response
    {
        return $this->render('user_side/contact.html.twig', [
            'controller_name' => 'UserSideController',
        ]);
    }

    #[Route('/blog', name: 'app_user_side_blog')]
    public function blog(): Response
    {
        return $this->render('user_side/blog.html.twig', [
            'controller_name' => 'UserSideController',
        ]);
    }

    #[Route('/about', name: 'app_user_side_about')]
    public function about(): Response
    {
        return $this->render('user_side/about.html.twig', [
            'controller_name' => 'UserSideController',
        ]);
    }

    #[Route('/room', name: 'app_user_side_room')]
    public function room(BedroomRepository $bedroomRepository): Response
    {

        $bedrooms = $bedroomRepository->findAll();

        return $this->render('user_side/room.html.twig', [
            'controller_name' => 'UserSideController',
            'bedrooms' => $bedrooms
        ]);
    }


        #[Route('/searchRoom', name: 'app_user_side_room_date')]
        public function roomDate(BedroomRepository $bedroomRepository, $startDate, $endDate, ReservationRepository $reservationRepository): Response
        {
            $bedrooms = $bedroomRepository->findAll();

            // Convert 'null' strings to actual null values
            $startDate = ($startDate === 'null') ? null : $startDate;
            $endDate = ($endDate === 'null') ? null : $endDate;

            $filteredBedrooms = [];

            dd($bedrooms, $startDate, $endDate);

            // for all bedrooms, check if there is no reservation between start and end date
            foreach ($bedrooms as $bedroom) {
                $reservations = $reservationRepository->findByBedroomId($bedroom);
                $isAvailable = true;
                foreach ($reservations as $reservation) {
                    $reservationStartDate = $reservation->getStartDate();
                    $reservationEndDate = $reservation->getEndDate();
                    if ($startDate !== null && $endDate !== null) {
                        if ($startDate >= $reservationStartDate && $startDate <= $reservationEndDate) {
                            $isAvailable = false;
                            break;
                        }
                        if ($endDate >= $reservationStartDate && $endDate <= $reservationEndDate) {
                            $isAvailable = false;
                            break;
                        }
                    }
                }
                if ($isAvailable) {
                    array_push($filteredBedrooms, $bedroom);
                }
            }

            // Now $filteredBedrooms contains the bedrooms that passed the filter
            // Use $filteredBedrooms as needed in your code

            return $this->render('user_side/room.html.twig', [
                'bedrooms' => $filteredBedrooms,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }
    function doDateRangesOverlap($startDate1, $endDate1, $startDate2, $endDate2) {
        // Create DateTime objects for the start and end dates of both ranges
        $startDateTime1 = new DateTime($startDate1);
        $endDateTime1 = new DateTime($endDate1);
        $startDateTime2 = $startDate2;
        $endDateTime2 = $endDate2;

        // Create DatePeriod objects for both date ranges
        $datePeriod1 = new DatePeriod($startDateTime1, new DateInterval('P1D'), $endDateTime1);
        $datePeriod2 = new DatePeriod($startDateTime2, new DateInterval('P1D'), $endDateTime2);

        // Check if there is at least one common date in the two date ranges
        foreach ($datePeriod1 as $date1) {
            foreach ($datePeriod2 as $date2) {
                if ($date1->format('Y-m-d') == $date2->format('Y-m-d')) {
                    return true;
                }
            }
        }

        return false;
    }

        // room_category
        #[Route('/room_category', name: 'app_user_side_room_category', methods: ['POST'])]
        public function roomCategory(BedroomRepository $bedroomRepository, CategoryRepository $categoryRepository, Request $request, ReservationRepository $reservationRepository): Response
        {

            $id = $request->request->get('category');
            $startDate = $request->request->get('startDate');
            $endDate = $request->request->get('endDate');

            $category = $categoryRepository->find(intval($id));
            $bedrooms = $bedroomRepository->findAll();
            foreach ($bedrooms as $bedroom) {
                if (!$bedroom->containsCategory($category)) {
                    array_splice($bedrooms, array_search($bedroom, $bedrooms), 1);
                }

                $reservations = $reservationRepository->findBy(['bedroom_id' => $bedroom->getId()]);
                foreach ($reservations as $reservation) {
                    if ($this->doDateRangesOverlap($startDate, $endDate, $reservation->getStartDate(), $reservation->getEndDate())) {
                        array_splice($bedrooms, array_search($bedroom, $bedrooms), 1);
                        break;
                    }
                }

            }

            return $this->render('user_side/room.html.twig', [
                'bedrooms' => $bedrooms,
                'category' => $category,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }

}
