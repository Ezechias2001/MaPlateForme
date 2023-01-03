<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{   
    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('admin/profil.html.twig');
    }

    #[Route('/modifier', name: 'app_modifier')]
    public function modifier(): Response
    {
        return $this->render('admin/modifierAuth.html.twig');
    }
}
