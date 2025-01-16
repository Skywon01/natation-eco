<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CompteController extends AbstractController
{

    public function compte(): Response
    {
        return $this->render("compte.html.twig");
    }
}