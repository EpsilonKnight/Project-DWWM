<?php

namespace App\Controller;

use App\Entity\Positions;
use App\Form\PositionsType;
use App\Repository\ParticipantsRepository;
use App\Repository\PositionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/positions')]
class PositionsController extends AbstractController
{
    #[Route('/', name: 'app_positions_index', methods: ['GET'])]
    public function index(PositionsRepository $positionsRepository, ParticipantsRepository $participantsRepository): Response
    {   
        $participants = $participantsRepository->findAll();
        return $this->render('positions/index.html.twig', [
            'positions' => $positionsRepository->findAll(),
            'participants' => $participants,
        ]);
    }

    #[Route('/new', name: 'app_positions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PositionsRepository $positionsRepository): Response
    {
        $position = new Positions();
        $form = $this->createForm(PositionsType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $positionsRepository->save($position, true);

            return $this->redirectToRoute('app_positions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('positions/new.html.twig', [
            'position' => $position,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_positions_show', methods: ['GET'])]
    public function show(Positions $position): Response
    {
        return $this->render('positions/show.html.twig', [
            'position' => $position,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_positions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Positions $position, PositionsRepository $positionsRepository): Response
    {
        $form = $this->createForm(PositionsType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $positionsRepository->save($position, true);

            return $this->redirectToRoute('app_positions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('positions/edit.html.twig', [
            'position' => $position,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_positions_delete', methods: ['POST'])]
    public function delete(Request $request, Positions $position, PositionsRepository $positionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$position->getId(), $request->request->get('_token'))) {
            $positionsRepository->remove($position, true);
        }

        return $this->redirectToRoute('app_positions_index', [], Response::HTTP_SEE_OTHER);
    }
}
