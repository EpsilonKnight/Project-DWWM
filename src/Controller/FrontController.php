<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Photos;
use App\Entity\Sports;
use App\Form\UserType;
use DateTimeImmutable;
use App\Form\PhotosType;
use App\Entity\Commentaires;
use App\Entity\Participants;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\PhotosRepository;
use App\Repository\SportsRepository;
use App\Repository\ProduitsRepository;
use App\Repository\TournoisRepository;
use App\Repository\TropheesRepository;
use App\Repository\PositionsRepository;
use App\Repository\ClassementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use App\Repository\ParticipantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Definir une route au dessus de la classe permets que ce soit
// gérale au toute les route du controllelr
#[Route('/profil')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function page_principal(): Response
    {

        return $this->render('front/page_principal.html.twig', []);
    }

    #[Route('/tournois/{id}', name: 'app_classement_index', methods: ['GET'])]
    public function classement(PositionsRepository $positionsRepository, $id, TournoisRepository $tournoisRepository, ClassementRepository $classementRepository): Response
    {
        // dd($tournoisRepository->findByAnnee('2016'));
        // dd($tournoisRepository->find($id)->getSports()->toArray());
        $tournoi =  $tournoisRepository->find($id);
        $positions = $positionsRepository->findBy(['tournois' => $tournoi]);
        $finalArray = [];
        // dd($tournoi->getClassements()->toArray());
        if ($tournoi !== null) {
            foreach ($tournoi->getParticipants() as $key => $participant) {
                $finalArray[$participant->getNom()] =  $classementRepository->findByTournoisAndParticipants($tournoi, $participant);
            }
        }
        // dd($finalArray);
        return $this->render('classement/index.html.twig', [
            // 'classements' => $classementRepository->findAll(),
            'finalArray' => $finalArray,
            'tournois' => $tournoisRepository->find($id),
            'positions' => $positions
        ]);
    }

    #[Route('/les_tournois', name: 'page_principale')]
    public function index(TournoisRepository $tournoisRepository): Response
    {
        $tournois = $tournoisRepository->findAll();
        return $this->render('front/index.html.twig', [
            'tournois' => $tournois
        ]);
    }

    #[Route('/detail_tournoi', name: 'detail_tournoi')]
    public function liste(TournoisRepository $tournoisRepositery, SportsRepository $sportsRepository, ParticipantsRepository $participantsRepository, TropheesRepository $tropheesRepository): Response
    {
        $tournois = $tournoisRepositery->findAll();
        $trophees = $tropheesRepository->findAll();
        $sports = $sportsRepository->findAll();
        return $this->render('front/detail_tournoi.html.twig', [
            'trophees' => $trophees,
            'participants' => $participantsRepository,
            'tournois' => $tournois,
            'sports' => $sports,
        ]);
    }

    #[Route('/epreuve_liste', name: 'epreuve_liste')] //ca rend tout les classement des epreuves années confondues
    public function ListeEpreuve(SportsRepository $sportsRepository): Response
    {
        $sports = $sportsRepository->findAll();
        //deuxieme syntax
        // $sport = $classementRepository->findBy(['sports' => $id])
        return $this->render('front/epreuve_liste.html.twig', [
            'sports' => $sports
        ]);
    }

    #[Route('/epreuve_classement/{id}', name: 'classement_epreuve')] //ca rend tout les classement des epreuves années confondues
    public function classementEpreuve($id, TournoisRepository $tournoisRepositery, Request $request, Sports $sports, SportsRepository $sportsRepository, CommentairesRepository $commentairesRepository, ClassementRepository $classementRepository): Response
    {   //Recupère les commentaires en fonction du sport et aussi si le tatut est a true ('validée')
        $commentaire = $commentairesRepository->findBy(['sport' => $sports, 'statut' => true]);
        $classements = $classementRepository->findBySports($id);
        $tournois = $tournoisRepositery->findAll();
        $user = $this->getUser();
        $commentaires = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaires);
        //dd($commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            // dump($commentaire);
            $commentaires->setUser($user);
            $commentaires->setSport($sports);
            // $commentaire->setCreatedAt(new DateTimeImmutable('now'));
            //dd($commentaire);
            $commentairesRepository->save($commentaires, true);
            $this->addFlash('success', 'Ce commentaire sera pris en charge par Grador dans les plus brefs délais.');
            return $this->redirectToRoute('classement_epreuve', ['id' => $sports->getId()]);
        }
        //deuxieme syntax
        // $sport = $classementRepository->findBy(['sports' => $id])

        return $this->render('front/classement_epreuve.html.twig', [
            'classements' => $classements,
            'sports' => $sportsRepository,
            'formCommentaire' => $form->createView(),
            'commentaires' => $commentaire,
            'tournois' => $tournois
        ]);
    }

    // #[Route('/epreuve_classement/{sport}/{tournoi}', name: 'classement_epreuve')] //ca rend tout les classement des epreuves années confondues
    // public function classementEpreuveTournoi($sport, $tournoi, ClassementRepository $classementRepository): Response
    // {
    //     $classements = $classementRepository->findBySports($id);
    //     //deuxieme syntax
    //     // $sport = $classementRepository->findBy(['sports' => $sport, 'tournois'=> $tournois]) soit
    //     return $this->render('front/classement_epreuve.html.twig', [
    //         'classements' => $classements,
    //     ]);
    // }

    #[Route('/participant_liste', name: 'participant_liste')] //ca rend tout les classement des epreuves années confondues
    public function participant_liste(ParticipantsRepository $participantsRepository): Response
    {

        // dd($participantsRepository);
        return $this->render('front/participant_liste.html.twig', [
            'participants' => $participantsRepository->findAll()

        ]);
    }

    #[Route('/participant/{id}', name: 'app_participants_show', methods: ['GET'])]
    public function voir_participant(Participants $participant): Response
    {
        return $this->render('participants/show.html.twig', [
            'participant' => $participant,
        ]);
    }


    #[Route('/les_trophees', name: 'affichage_trophees', methods: ['GET'])]
    public function affichage_trophees(ParticipantsRepository $participantsRepository, TropheesRepository $tropheesRepository, SportsRepository $sportsRepository): Response
    {
        $trophees = $tropheesRepository->findAll();
        $participants = $participantsRepository->findAll();
        $sports = $sportsRepository->findAll();


        return $this->render('front/affichage_trophees.html.twig', [
            'trophees' => $trophees,
            'participants' => $participants,
            'sports' => $sports,
        ]);
    }

    #[Route('/fiche_participant/{id}', name: 'fiche_participant', methods: ['GET'])]
    public function fiche_technique($id, ClassementRepository $classementRepository, PositionsRepository $positionsRepository, ParticipantsRepository $participantsRepository, TournoisRepository $tournoisRepositery, TropheesRepository $tropheesRepository, SportsRepository $sportsRepository)
    {

        $trophees = $tropheesRepository->findAll();
        $tournois = $tournoisRepositery->findAll();
        $participants = $participantsRepository->findBy(['id' => $id]);
        $positions = $positionsRepository->find($id);
        $sports = $sportsRepository->findAll();
        $classement = $classementRepository->findAll();

        return $this->render('front/fiche_participant.html.twig', [
            'tournois' => $tournois,
            'trophees' => $trophees,
            'participants' => $participants,
            'positions' => $positions,
            'sports' => $sports,
            "classement" => $classement,


        ]);
    }

    #[Route('/galerie_photos', name: 'app_galerie_photos', methods: ['GET', 'POST'])]
    public function galerie_photos(TournoisRepository $tournoisRepositery, Request $request, UserRepository $userRepository, PhotosRepository $photosRepository): Response
    {
        $tournois = $tournoisRepositery->findAll();
        $users = $userRepository->findAll();
        $photo = new Photos();
        $form = $this->createForm(PhotosType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $photo->setUsers($user);
            $photosRepository->save($photo, true);

            return $this->redirectToRoute('app_galerie_photos', [], Response::HTTP_SEE_OTHER);
        }

        $formView = $form->createView();

        return $this->render('front/galerie_photos.html.twig', [
            'photos' => $photosRepository->findAll(),
            'users' => $users,
            'photo' => $photo,
            'form' => $formView,
            'tournois' => $tournois,
        ]);
    }


    #[Route('/liste_produits', name: 'liste_produits')]
    public function afficher_produits(ProduitsRepository $produitsRepository)
    {

        return $this->render('front/liste_produit.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }

    #[Route('/profil-user', name: 'profil_user', methods: ['GET'])]
    public function profil(Security $security)
    {
        $user = $security->getUser();

        return $this->render('front/profilUser.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profil-user-update', name: 'profil_user_update', methods: ['GET', 'POST'])]
    public function profilUpdate(Request $request, Security $security, UserRepository $userRepository): Response
    {
        $user = $security->getUser(); // Obtient l'utilisateur connecté

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les modifications de l'utilisateur dans la base de données
            $userRepository->save($user, true); // Permet de mettre à jour en base de données

            // Redirigez l'utilisateur vers la page de profil mise à jour ou une autre page appropriée
            return $this->redirectToRoute('profil_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/profilUserUpdate.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
