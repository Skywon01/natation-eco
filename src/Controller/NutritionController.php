<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class NutritionController extends AbstractController
{

    #[Route('nutrition/{id}', name: 'nutrition_show')]
    public function nutrition($id, ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Category::class)->find($id);
        $products = $category->getProducts();
        return $this->render("nutrition.html.twig", [

            'product' => $products,
            'category' => $category
        ]);
    }
}