<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
        ]);
    }


    #[Route('/products/add', name: 'app_products_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
{   
    $products = new Products;

    $formProducts = $this->createForm(ProductsType::class, $products);
    $formProducts->handleRequest($request);

    if($formProducts->isSubmitted() && $formProducts->isValid())
    {
        $em = $doctrine->getManager();
        $em->persist($products);
        $em->flush();

        $this->addFlash('products_add_success', "Votre produit a bien été ajouté !");

        return $this->redirectToRoute('index');
    }

    return $this->render('products/index.html.twig', [
        'formProducts' => $formProducts->createView()
    ]);
}


}
