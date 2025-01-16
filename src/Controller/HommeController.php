<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HommeController extends AbstractController
{

    #[Route('hommes/{id}', name: 'homme_show')]
    public function homme($id, ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Category::class)->find($id);
        $products = $category->getProducts();
        return $this->render("article_homme.html.twig", [

            'product' => $products,
            'category' => $category
        ]);
    }
}