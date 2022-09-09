<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompteController extends AbstractController
{

    public function compte()
    {
        return $this->render("compte.html.twig");
    }
}