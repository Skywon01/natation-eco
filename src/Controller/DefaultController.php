<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Products::class)->findAll();

        return $this->render("index.html.twig",[
            'products' => $products
        ]);
    }
}