<?php

namespace App\Controller;

use App\Entity\Single;
use App\Form\SingleFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CreerSingleController extends AbstractController
{
    #[Route('/creer/single', name: 'app_creer_single')]
    public function index(SluggerInterface $slugger, Request $request, ManagerRegistry $doctrine): Response
    {
        $single = new Single();
        $form = $this->createForm(SingleFormType::class, $single);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $SingleImage = $form->get('uploadPhoto')->getData();
            if ($SingleImage){
                $originalFilename = pathinfo($SingleImage->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$SingleImage->guessExtension();

                try {
                    $SingleImage->move(
                        $this->getParameter('single_image'),
                        $newFilename
                    );
                } catch (FileException $e){

                }
                $single->setImg($newFilename);
            }
            $SingleAudioFile = $form->get('uploadSon')->getData();
            if ($SingleAudioFile){
                $originalFilename = pathinfo($SingleAudioFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$SingleAudioFile->guessExtension();

                try {
                    $SingleAudioFile->move(
                        $this->getParameter('single_audio'),
                        $newFilename
                    );
                } catch (FileException $e){

                }
                $single->setSon($newFilename);
            }
            $manager = $doctrine->getManager();
            $manager->persist($single);
            $manager->flush();
            return $this->redirectToRoute('singles');
        }
        return $this->render('creer_single/creer_single.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
