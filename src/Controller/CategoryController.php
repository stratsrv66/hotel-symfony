<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show($id): Response
    {
        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    // create / delete
    #[Route('/category/create', name: 'app_category_create')]
    public function create(): Response
    {
        return $this->render('category/create.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/delete/{id}', name: 'app_category_delete')]
    public function delete($id): Response
    {
        return $this->render('category/delete.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

}
