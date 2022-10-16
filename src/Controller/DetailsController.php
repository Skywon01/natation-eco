<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function index(): Response
    {
        return $this->render('details/index.html.twig', [
            'controller_name' => 'DetailsController',
        ]);
    }
}
