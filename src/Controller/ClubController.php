<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClubController extends AbstractController
{

    #[Route('/club', name: 'club')]
    public function club():Response
    {
        return $this->render("club.html.twig");
    }
}