<?php

namespace App\Controller;


use App\Entity\Trophees;
use App\Form\TropheesType;
use App\Repository\ParticipantsRepository;
use App\Repository\TropheesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/trophees')]
class TropheesController extends AbstractController
{
    #[Route('/', name: 'app_trophees_index', methods: ['GET'])]
    public function index(ParticipantsRepository $participantsRepository,TropheesRepository $tropheesRepository): Response
    {
        return $this->render('trophees/index.html.twig', [
            'trophees' => $tropheesRepository->findAll(),
            'participants' => $participantsRepository,
        ]);
    }

    #[Route('/new', name: 'app_trophees_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TropheesRepository $tropheesRepository): Response
    {
        $trophee = new Trophees();
        $form = $this->createForm(TropheesType::class, $trophee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tropheesRepository->save($trophee, true);
            $this->addFlash('success', 'Le trophée aux participants a bien été ajouté');
            return $this->redirectToRoute('app_trophees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trophees/new.html.twig', [
            'trophee' => $trophee,
            'form' => $form,
            
        ]);
    }

    #[Route('/{id}', name: 'app_trophees_show', methods: ['GET'])]
    public function show(Trophees $trophee): Response
    {
        return $this->render('trophees/show.html.twig', [
            'trophee' => $trophee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trophees_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trophees $trophee, TropheesRepository $tropheesRepository): Response
    {
        $form = $this->createForm(TropheesType::class, $trophee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tropheesRepository->save($trophee, true);

            return $this->redirectToRoute('app_trophees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trophees/edit.html.twig', [
            'trophee' => $trophee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trophees_delete', methods: ['POST'])]
    public function delete(Request $request, Trophees $trophee, TropheesRepository $tropheesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trophee->getId(), $request->request->get('_token'))) {
            $tropheesRepository->remove($trophee, true);
        }

        return $this->redirectToRoute('app_trophees_index', [], Response::HTTP_SEE_OTHER);
    }


    

}
