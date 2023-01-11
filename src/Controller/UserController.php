<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserInscriptionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription (ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $manager = $doctrine->getManager();
        $user = new User();
        $form = $this->createForm(UserInscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $hashedPassword = $passwordHasher->hashPassword($user,$user->getPassword());
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('user/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
