<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session, ProduitsRepository $produitsRepository): Response
    {
        $panier = $session->get('panier', []);
        $panierWithData = [];
        // $panierWithData pour stocker les données de chaque élément dans le panier
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'produits' =>$produitsRepository->find($id),
                'quantity' =>$quantity
            ];
        }
        $total = 0;
        foreach($panierWithData as $item){
            $totalItem = $item['produits']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }
        // dd($panierWithData); je peux voir l'objet en question avec la quantité
        return $this->render('front/panier.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
        ]);
    }

    #[Route('/panier/add/{id}', name: 'add_panier')]
    public function add($id,SessionInterface $session)
    { //le request dans hhtp funcdation recupere la session
        // $session = $request->getSession(); plus besoin de cela grace a SessionInterface dans le debug:autowiring session

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);
        // dd($session->get('panier'));
        return $this->redirectToRoute("app_panier");
    }

    #[Route('/panier/remove/{id}', name: 'remove_panier')]
    public function remove($id, SessionInterface $session){

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("app_panier");

    }
}
