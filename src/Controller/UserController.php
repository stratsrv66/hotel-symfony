<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/user/create', name: 'app_user_create')]
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

        dd($user);

        // save the user in the database
        $entityManager->persist($user);
        $entityManager->flush();

        // return the user as json
        return $this->json($user);
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

    #[Route('/user/login', name: 'app_user_login')]
    public function loginUser(Request $request, UserRepository $userRepository): JsonResponse
    {
        // get the post infos of the request
        $request = Request::createFromGlobals();

        // username, password
        $username = $request->get('username');
        $password = $request->get('password');

        // get the user that got the username $username
        $user = $userRepository->findBy(
            ['username' => $username, 'password' => $password]
        );

        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for username '.$username
            );
        }

        // if the password is not correct return a 404
        if ($user->getPassword() != $password) {
            throw $this->createNotFoundException(
                'Wrong password for username '.$username
            );
        }

        // return the user as json
        return $this->json($user);

    }

    #[Route('/user/logout', name: 'app_user_logout')]
    public function logoutUser(Request $request, UserRepository $userRepository): JsonResponse
    {
        // username
        $username = $request->get('username');

        // get the user that got the username $username
        $user = $userRepository->find($username);

        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for username '.$username
            );
        }

        // return the user as json
        return $this->json($user);

    }
}
