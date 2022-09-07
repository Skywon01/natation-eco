<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EquipementController extends AbstractController
{

    public function equipement()
    {
        return $this->render("equipement.html.twig");
    }
}