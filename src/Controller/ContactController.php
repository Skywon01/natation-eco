<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response
    {

        $formContact = $this->createFormBuilder()
        ->add('email', EmailType::class)
        ->add('objet', TextType::class)
        ->add('message', TextareaType::class)
        ->getForm()
        ;

        $formContact->handleRequest($request);

        if($formContact->isSubmitted() && $formContact->isValid())
        {
            # Envoi de l'email
            $email = (new TemplatedEmail())
            ->from("to@example.com")
            ->to('contact@monsite.com')
            ->subject('Demande de contact !')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => "mail"
            ]);

        $mailer->send($email);

        // $this->addFlash('email_sent', "L'email a bien été envoyé !");

        }

        return $this->render('contact/index.html.twig', [
            'formContact' => $formContact->createView(),
        ]);
    }
}
