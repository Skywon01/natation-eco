<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClubController extends AbstractController
{

    public function club()
    {
        return $this->render("index.html.twig");
    }
}