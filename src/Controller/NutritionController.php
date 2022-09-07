<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NutritionController extends AbstractController
{

    public function nutrition()
    {
        return $this->render("nutrition.html.twig");
    }
}