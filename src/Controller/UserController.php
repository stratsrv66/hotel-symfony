<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\UserType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user_list')]
    public function index(UserRepository $repository): JsonResponse
    {
        // get all the users
        $users = $repository->findAll();

        // return the users as json
        return $this->json($users);
    }

    #[Route('/user/{id}', name: 'app_user_id')]
    public function getUserById(User $user, Request $request): JsonResponse
    {

        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $request->get('id')
            );
        }

        // return the user as json
        return $this->json($user);

    }

    #[Route('/user/{name}', name: 'app_user_name')]
    public function getUserByName(User $user, Request $request): JsonResponse
    {
        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for name '. $request->get('name')
            );
        }

        // return the user as json
        return $this->json($user);

    }

    #[Route('/user/{email}', name: 'app_user_email')]
    public function getUserByEmail(User $user, Request $request): JsonResponse
    {

        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for email '.$request->get('email')
            );
        }

        // return the user as json
        return $this->json($user);

    }

    #[NoReturn] #[Route('/user/create', name: 'app_user_create')]
    public function createUser(EntityManagerInterface $entityManager, Request $request): Response
    {
        // create a new user
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_list');
        }

        // username, password, email, phone
        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');
        $phone = $request->get('phone');

        // set the user infos
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setPhone($phone);


        // save the user in the database
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_side');
    }

    // create user no form
    #[Route('/user/create/noform', name: 'app_user_create_noform', methods: ['POST'])]
    public function createUserNoForm(EntityManagerInterface $entityManager, Request $request): Response
    {

        // create a new user
        $user = new User();

        // username, password, email, phone
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');

        // set the user infos
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setPhone($phone);

        // save the user in the database
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_side', [
            'message' => 'User created successfully'
        ]);

    }


    #[Route('/user/update/{id}', name: 'app_user_update')]
    public function updateUser(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        // If the user does not exist, return a 404
        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        $userData = $request->request->all()['user_update'];
        // Get other parameters from the request
        $username = $userData['username'];
        $password = $userData['password'];
        $email = $userData['email'];
        $phone = $userData['phone'];

        // Set the user info
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setPhone($phone);

        // Save the user in the database
        $entityManager->persist($user);
        $entityManager->flush();

        // redirect to the user list
        return $this->redirectToRoute('app_admin_user');
    }


    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $interface): Response
    {

        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$request->get('id')
            );
        }

        // delete the user in the database
        $interface->remove($user);
        $interface->flush();

        // return pass app_user_list;
        return $this->redirectToRoute('app_admin_user');

    }

    // login
    #[Route('/login', name: 'app_user_login')]
    public function login(Request $request, UserRepository $userRepository, Session $session): Response
    {

        // username, password
        $username = $request->request->get('loginUsername');
        $password = $request->request->get('loginPassword');

        // get the user that got the username $username
        $user = $userRepository->findBy(
            ['username' => $username, 'password' => $password]
        );

        // if the user does not exist return a 404
        if (!$user) {
            // display an error message
            return $this->redirectToRoute('app_user_side', [
                'error' => 'User not found or password incorrect'
            ]);
        }

        // open session
        $session->start();
        $session->set('user_id', $user[0]->getId());

        // redirect to the user list
        return $this->redirectToRoute('app_user_side', [
            'message' => 'User logged in successfully'
        ]);
    }

    // logout
    #[Route('/logout', name: 'app_user_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('user_id');

        // redirect to the user list
        return $this->redirectToRoute('app_user_side');
    }

    // create reservation
    #[Route('/reservation/createee', name: 'app_reservation_createee', methods: ['POST'])]
    public function createReservation(): Response
    {

        // redirect to the user list
        return $this->redirectToRoute('app_user_side', [
            'message' => 'Reservation created successfully'
        ]);

    }


}
