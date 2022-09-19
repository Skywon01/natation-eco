<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Maker\MakeRegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_index")
     */
public function index(ManagerRegistry $doctrine)
{
    $user = $doctrine->getRepository(User::class)->findAll();

    return $this->render('user/index.html.twig', [
        'user' => $user,
    ]);
}

/**
 * @Route("user/show/{id}", name="user_show")
 */
public function show($id, ManagerRegistry $doctrine)
{
    $user = $doctrine->getRepository(User::class)->find($id);

    if($user)
    {
        throw new \Exception($id." : Utilisateur inconnu");
    }

    return $this->render('user/show.html.twig',[
        'user' => $user
    ]);
}

/**
 * @Route("/user/add", name="user_add")
 */
public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
{
    $user = new User;
    $user->setCreatedAt(new \DateTimeImmutable());
    $user->setUpdatedAt(new \DateTimeImmutable());


    $formUser = $this->createForm(UserType::class, $user);
    $formUser->handleRequest($request);

    if($formUser->isSubmitted() && $formUser->isValid())
    {
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $formUser->get('plainPassword')->getData()
            )
        );
        $entityManager = $doctrine->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('user_add_success', "L'utilisateur ".$user->getName()." a bien été ajouté.");
        
        return $this->redirectToRoute('user_index');
    }

    return $this->render('form-add.html.twig', [
        'formUser' => $formUser->createView()
    ]);

}


}