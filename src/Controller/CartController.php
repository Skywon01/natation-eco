<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'cart_index')]

    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        // On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);

      
         // j'ajoute mon tableau panier
         $panier = $session->get('panier', []);


         $total = 0;
 
         $totalqte = 0;
 
         if(!empty($panier)){
             foreach ($panier as  $value) {
                 $total += $value['article']->getPrice() * $value['qte'];
                 $totalqte += $value['qte'];
             }
         }
 
        // On envoie à la vue le panier enrichi avec les informations + le total du panier
        return $this->render('cart/index.html.twig', [
            'total' => $total,
            'panier' => $panier,
            'totalQuantity' => $totalqte
        ]);

    }


    #[Route('/panier/add/{id}/{origin}', name: 'cart_add')]

    public function cartAdd(Products $article, $origin, SessionInterface $session, ManagerRegistry $doctrine): RedirectResponse
    {

        #ETAPE 1 : on récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);


        #ETAPE 2 : On vérifie si l'élément de session d'id $id existe, si oui on incrémente de 1 la quantité
        if(empty($panier[$article->getId()])){
            $panier[$article->getId()] = [
                'article' => $article,
                'qte' => 1,
                
            ];
            
        }else{
            $panier[$article->getId()]=[
                'article' => $article,
                'qte' => ++$panier[$article->getId()]['qte']
            ];
            
        }

        #ETAPE 3 : On remplace la variable de session panier par le nouveau tableau $panier
        $session->set('panier', $panier);

        if ($origin == "products_show"){
            $this->addFlash('cart_add_success', "Votre produit a bien été ajouté au panier !");

            return $this->redirectToRoute($origin,['id' => $article->getId()]);
        }else{
            return $this->redirectToRoute($origin);
        }

        
        

    }


    #[Route('/panier/delete/{id}', name: 'cart_delete')]

    public function delete($id, SessionInterface $session)
    {
        #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        
        #On supprime de la session celui dont on a passé l'id
        if(!empty($panier[$id]))
        {
            unset($panier[$id]); //unset pour dépiler de la session
        }

        #On réaffecte le nouveau panier à la session
        $session->set('panier', $panier);

        #On redirige vers le panier
        return $this->redirectToRoute('cart_index');
    }
}
