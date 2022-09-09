<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HommeController extends AbstractController
{

    public function homme()
    {
        return $this->render("article_homme.html.twig");
    }
}