<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PanierController extends AbstractController
{

    public function Panier():Response
    {
        return $this->render("panier.html.twig");
    }
}