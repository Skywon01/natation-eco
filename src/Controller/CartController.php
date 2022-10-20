<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        #Variable tableau
        $panierData = [];

        foreach($panier as $id => $quantity)
        {
            #On enrichi le tableau avec l'objet (qui contient toutes les informations du produit) + la quantité
            $panierData[] = [
                "products" => $doctrine->getRepository(Products::class)->find($id),
                "quantity" => $quantity
            ];
        }
        //dd($panierData);

        #On calcule le total du panier ici, afin de ne pas a avoir a le faire dans la vue Twig
        $total = 0;
        foreach($panierData as $id => $value)
        {
            $total += $value['products']->getPrice() * $value['quantity'];
        }
        //dd($total);

        #On calcule le total des quantités ici, afin de ne pas a avoir a le faire dans la vue Twig
        $totalQuantity = 0;
        foreach($panierData as $id => $value)
        {
            $totalQuantity +=  $value['quantity'];
        }        

        #On envoie a la vue le panier enrichi avec les informations + le total du panier
        return $this->render('cart/index.html.twig', [
            'items' => $panierData,
            'total' => $total,
            'totalQuantity' => $totalQuantity
        ]);
    }

    /**
     * @Route("panier/add/{id}/{origin}", name="cart_add")
     */
    public function cartAdd($id, $origin, SessionInterface $session, ManagerRegistry $doctrine)
    {
        #ETAPE 1 : on récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);

        #ETAPE 2 : On vérifie si l'élément de session d'id $id existe, si oui on incrémente de 1 la quantité
        if(!empty($panier[$id])) 
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1; //Si non on initialise la quantité a 1.
        }

        #ETAPE 3 : On remplace la variable de session panier par le nouveau tableau $panier
        $session->set('panier', $panier);

        //dd($session->get('panier', []));

        # FAIRE CE QUE VOUS VOULEZ ICI : Redirigé vers votre page boutique par exemple.
        return $this->redirectToRoute($origin, ['id' => $id]);
    }

    /**
     * @Route("/panier/delete/{id}", name="cart_delete")
     */
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
