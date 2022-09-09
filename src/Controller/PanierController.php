<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{

    public function Panier()
    {
        return $this->render("panier.html.twig");
    }
}