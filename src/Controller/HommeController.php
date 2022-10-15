<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HommeController extends AbstractController
{

    public function homme(ManagerRegistry $doctrine)
    {
        
        $product = $doctrine->getRepository(Products::class)->findAll();

        return $this->render("article_homme.html.twig", [

            'product' => $product
        ]);
    }
}