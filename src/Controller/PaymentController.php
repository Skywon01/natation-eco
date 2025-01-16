<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{

    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }


    /**
     * @throws ApiErrorException
     */
    #[Route('/payment/checkout', name: 'checkout')]
    public function checkout($stripeSK, SessionInterface $session, ManagerRegistry $doctrine): RedirectResponse
    {
        //Clé API Stripe à paramétrer dans le fichier .env et security.yaml
        Stripe::setApiKey($stripeSK);

        #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        #Variable tableau


        //On construit le line_items pour envoyer ce format à Stripe, afin qu'il puisse afficher correctement dans le module de paiement Stripe.
        foreach ($panier as $id => $value) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $value['article']->getName(),
                    ],
                    'unit_amount' => $value['article']->getPrice() * 100, //Attention: bien mettre le format sans virgule et collé avec les centimes => dans notre cas, le prix est un entier donc ici on multiplie simplement par 100 (exemple 20€ donne 2000)
                ],
                'quantity' => $value['qte'],
            ];
        }

        $session = Session::create([
            'line_items' => [
                $line_items
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    #[Route('/payment/success', name: 'success_url')]
    public function successUrl(SessionInterface $session): Response
    {
        //Une fois le paiement effectué, on vide le panier
        $session->set("panier", []);
        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/cancel', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
