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


    // Create
    
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

        return $this->redirectToRoute('app_products_add');
    }

    return $this->render('products/products_add.html.twig', [
        'formProducts' => $formProducts->createView()
    ]);
}


// Read

/**
 * @Route("products/show/{id}", name="products_show")
 */
public function show($id, ManagerRegistry $doctrine)
{
    $products = $doctrine->getRepository(Products::class)->find($id);

    return $this->render('details/details.html.twig',[
        'products' => $products
    ]);
}


//Read All

/**
 * @Route("products/show_all", name="products_show_all")
 */
public function showAll(ManagerRegistry $doctrine)
{
    $products = $doctrine->getRepository(Products::class)->findAll();

    return $this->render('products/products_admin.html.twig',[
        'products' => $products
    ]);
}



// Update

/**
 * @Route("/product/edit/{id} ", name="app_products_edit")
 */
public function edit($id, ManagerRegistry $doctrine, Request $request): Response
{
    $product = $doctrine->getRepository(Products::class)->find($id);
    $product->setUpdatedAt(new \DateTimeImmutable());


    
    $formProducts = $this->createForm(ProductsType::class, $product);
    $formProducts->handleRequest($request);

    if($formProducts->isSubmitted() && $formProducts->isValid())
    {
        $em = $doctrine->getManager();
        $em->flush();

        $this->addFlash("product_edit_success", "Votre produit a bien été modifié!");

        return $this->redirectToRoute('index');
    }

    return $this->render('products/products_edit.html.twig', [
        'formProducts' => $formProducts->createView(),
        'product' => $product
    ]);
}

// Delete

    /**
     * @Route("user/delete/{id}", name="user_delete")
     */
    public function delete($id, ManagerRegistry $doctrine)
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if(!$user)
        {
            throw new \Exception("Aucun utilisateur pour l'id : $id");
        }

        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash("user_delete_ok", "L'utilisateur ".$user->getName()." a bien été supprimé !");

        return $this->redirectToRoute('index');
    }

}
