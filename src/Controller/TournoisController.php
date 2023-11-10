<?php

namespace App\Controller;

use App\Entity\Sports;
use App\Entity\Tournois;
use App\Form\TournoisType;
use App\Entity\Participants;
use App\Repository\TournoisRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/tournois')]
class TournoisController extends AbstractController
{
    #[Route('/', name: 'app_tournois_index', methods: ['GET'])]
    public function index(TournoisRepository $tournoisRepository): Response
    {
        return $this->render('tournois/index.html.twig', [
            'tournois' => $tournoisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tournois_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TournoisRepository $tournoisRepository, SluggerInterface $slugger): Response
    {
        $tournoi = new Tournois();
        $form = $this->createForm(TournoisType::class, $tournoi);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            // Il faut boucler sur les newParticipants
            // $form->all()["newParticipants];
            // Pour chaque newParticpant tu crée un new Particapant
            // Tu ajoutes les new Particpant dans le tournois

            $newSports = $form->get('newSports')->getData();
            foreach ($newSports as $newSport) {
                $sport = new Sports();
                $sport->setNom($newSport->getNom());
                $tournoi->addSport($sport);
            }

            $newParticipants = $form->get('newParticipants')->getData();
            foreach ($newParticipants as $newParticipant) {
                $participant = new Participants();
                $participant->setNom($newParticipant->getNom()); // Remplace "nom" par le nom du champ correspondant dans le formulaire ParticipantsType
                $tournoi->addParticipant($participant); // Ajoute le participant au tournoi  
            }
            $tournoisRepository->save($tournoi, true);
            //       // Enregistrer le tournoi en base de données
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($tournoi);
            // $entityManager->flush();


            return $this->redirectToRoute('app_tournois_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournois/new.html.twig', [
            'tournoi' => $tournoi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tournois_show', methods: ['GET'])]
    public function show(Tournois $tournoi): Response
    {
        return $this->render('tournois/show.html.twig', [
            'tournoi' => $tournoi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tournois_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tournois $tournoi, TournoisRepository $tournoisRepository): Response
    {
        $form = $this->createForm(TournoisType::class, $tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newSports = $form->get('newSports')->getData();
            foreach ($newSports as $newSport) {
                $sport = new Sports();
                $sport->setNom($newSport->getNom());
                $tournoi->addSport($sport);
            }

            $newParticipants = $form->get('newParticipants')->getData();
            foreach ($newParticipants as $newParticipant) {
                $participant = new Participants();
                $participant->setNom($newParticipant->getNom()); // Remplace "nom" par le nom du champ correspondant dans le formulaire ParticipantsType
                $tournoi->addParticipant($participant); // Ajoute le participant au tournoi  
            }
            
            $tournoisRepository->save($tournoi, true);

            return $this->redirectToRoute('app_tournois_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournois/edit.html.twig', [
            'tournoi' => $tournoi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tournois_delete', methods: ['POST'])]
    public function delete(Request $request, Tournois $tournoi, TournoisRepository $tournoisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tournoi->getId(), $request->request->get('_token'))) {
            $tournoisRepository->remove($tournoi, true);
        }

        return $this->redirectToRoute('app_tournois_index', [], Response::HTTP_SEE_OTHER);
    }
}
