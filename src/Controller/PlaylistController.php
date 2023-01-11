<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Single;
use App\Form\PlaylistFullType;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/playlists')]
class PlaylistController extends AbstractController
{
    #[Route('/', name: 'playlists', methods: ['GET'])]
    public function index(PlaylistRepository $playlistRepository): Response
    {
        return $this->render('playlist/inscription.html.twig', [
            'playlists' => $playlistRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'creerPlaylist', methods: ['GET', 'POST'])]
    public function new(Request $request, PlaylistRepository $playlistRepository, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->isSubmitted() && $form->isValid()) {
                $PlaylistImage = $form->get('uploadPlaylistImage')->getData();
                if ( $PlaylistImage){
                    $originalFilename = pathinfo( $PlaylistImage->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'. $PlaylistImage->guessExtension();
                    try {
                        $PlaylistImage->move(
                            $this->getParameter('playlist_image'),
                            $newFilename
                        );
                    } catch (FileException $e){

                    }
                    $playlist->setImagePlaylist($newFilename);
                }
                $manager = $doctrine->getManager();
                $manager->persist($playlist);
                $manager->flush();
                $playlistRepository->save($playlist, true);
            }
            return $this->redirectToRoute('playlists');
        }

        return $this->renderForm('playlist/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'playlist', methods: ['GET'])]
    public function show($id, EntityManagerInterface $manager): Response
    {
         $playlist = $manager->getRepository(Playlist::class)->findOneById($id);
         if (!$playlist){
             return $this->redirectToRoute('playlists');
         }
        return $this->render('playlist/show.html.twig', [
            'playlist' => $playlist,
            'id' => $id
        ]);
    }

    #[Route('/{id}/edit', name: 'modifierPlaylist', methods: ['GET', 'POST'])]
    public function edit($id, SluggerInterface $slugger,Request $request, Playlist $playlist, PlaylistRepository $playlistRepository, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->isSubmitted() && $form->isValid()) {
                $PlaylistImage = $form->get('uploadPlaylistImage')->getData();
                if ( $PlaylistImage){
                    $originalFilename = pathinfo( $PlaylistImage->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'. $PlaylistImage->guessExtension();
                    try {
                        $PlaylistImage->move(
                            $this->getParameter('playlist_image'),
                            $newFilename
                        );
                    } catch (FileException $e){

                    }
                    $playlist->setImagePlaylist($newFilename);
                }
                $manager = $doctrine->getManager();
                $manager->persist($playlist);
                $manager->flush();
                $playlistRepository->save($playlist, true);
            }
            return $this->redirectToRoute('playlist', ['id' => $playlist->getId()]);
        }

        return $this->renderForm('playlist/edit.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'supprimerPlaylist', methods: ['POST'])]
    public function delete(Request $request, Playlist $playlist, PlaylistRepository $playlistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$playlist->getId(), $request->request->get('_token'))) {
            $playlistRepository->remove($playlist, true);
        }
        return $this->redirectToRoute('playlists', [], Response::HTTP_SEE_OTHER);
    }
}
