<?php

namespace App\Controller;

use App\Entity\Single;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SinglesController extends AbstractController
{   

    #[Route('/singles', name: 'singles')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Single::class);
        $singles = $repository->findAll();
        return $this->render('accueil/singles.html.twig',[
            'singles'=>$singles
        ]);
    }
    #[Route('/single/{id}', name: 'single')]
    public function creerVueSingle(EntityManagerInterface $manager, $id): Response
    {
        $single = $manager->getRepository(Single::class)->findOneById($id);
        if (!$single){
            $this->redirectToRoute('singles');
        }
        return $this->render('accueil/singleVue.html.twig',[
            'single'=> $single
        ]);
    }
}
