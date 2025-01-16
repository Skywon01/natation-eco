<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EquipementController extends AbstractController
{

    #[Route('equipement/{id}', name: 'equipement_show')]
    public function equipement($id, ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Category::class)->find($id);
        $products = $category->getProducts();
        return $this->render("equipement.html.twig", [

            'product' => $products,
            'category' => $category
        ]);
    }
}