<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Single;
use App\Form\RemovePisteType;
use App\Form\PlaylistFullType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AddPisteController extends AbstractController
{
    #[Route('/playlists/{id}/ajouterPiste', name: 'papa')]
    public function ajouterPiste (Request $request,ManagerRegistry $doctrine,  Playlist $playlist): Response
    {
        $form = $this->createForm(PlaylistFullType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            foreach ($form->get('piste')->getData() as $piste){
                //Si cette piste existe déjà dans cette playlist, rediriger vers l'accueil
                $playlist->addPiste($piste);
            }
            $manager->persist($playlist);
            $manager->flush();
            return $this->redirectToRoute('playlist', ['id' => $playlist->getId()]);
        }
        $formRemove = $this->createForm(RemovePisteType::class, $playlist);
        return $this->render('playlist/add_song.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView(),
            'formRemove' => $formRemove->createView()
        ]);
    }
    #[Route('/playlists/{id}/retirer/{idPiste}', 'retirerPiste')]
    public function retirerPiste( Playlist $playlist,$id, EntityManagerInterface $manager,$idPiste)
    {
       $piste = $manager->getRepository(Single::class)->findOneById($idPiste);
       $playlist->removePiste($piste);
       $manager->persist($playlist);
       $manager->flush();
       return $this->redirectToRoute('playlist', ['id' => $playlist->getId()]);
    }

    #[Route('/playlists/{id}/viderPiste', 'viderPiste')]
     public function viderPiste( Playlist $playlist,ManagerRegistry $doctrine ,$id){
        $manager = $doctrine->getManager();
        $pistes = $playlist->getPiste();
     foreach ($pistes  as  $piste ) {
        $playlist->removePiste($piste);
     }
      $manager->persist($playlist);
      $manager->flush();
        return $this->redirectToRoute('playlist', ['id' => $playlist->getId()]);
     }
}
