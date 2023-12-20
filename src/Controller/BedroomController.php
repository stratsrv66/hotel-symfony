<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BedroomController extends AbstractController
{
    #[Route('/bedroom', name: 'app_bedroom')]
    public function index(): Response
    {
        return $this->render('bedroom/index.html.twig', [
            'controller_name' => 'BedroomController',
        ]);
    }
}
