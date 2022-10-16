<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FemmeController extends AbstractController
{

    #[Route('femmes/{id}', name: 'femme_show')]
    public function femme($id, ManagerRegistry $doctrine): Response
    {   
        $category = $doctrine->getRepository(Category::class)->find($id);
        $products = $category->getProducts();
        return $this->render("article_femme.html.twig", [

            'product' => $products,
            'category' => $category
        ]);
    }
}