<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FemmeController extends AbstractController
{

    public function femme()
    {
        return $this->render("article_femme.html.twig");
    }
}