<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function createUser(EntityManagerInterface $interface): JsonResponse
    {
        // create a new user
        $user = new User();

        // get the post infos of the request
        $request = Request::createFromGlobals();

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
        $interface->persist($user);
        $interface->flush();

        // return the user as json
        return $this->json($user);

    }

    #[Route('/user/update/{id}', name: 'app_user_update')]
    public function updateUser(User $user, Request $request, EntityManagerInterface $interface): JsonResponse
    {

        // if the user does not exist return a 404
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$request->get('id')
            );
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
        $interface->persist($user);
        $interface->flush();

        // return the user as json
        return $this->json($user);

    }

    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $interface): JsonResponse
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

        // return the user as json
        return $this->json($user);

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
