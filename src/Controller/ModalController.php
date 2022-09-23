<?php

namespace App\Controller;

use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModalController extends AbstractController
{
    /**
     * @Route("/modal/avance-paiement/{id<\d+>}/", name="modal_show_avance_paiement", methods={"GET","POST"})
     */
    public function show_formulaire_avance(Request $request, Projet $projet): Response
    {
        //renvoie uniquement les données demandées
        if (
            $request->request->get('modal') &&
            $request->request->get('modal') == 'affiche_paiement' &&
            $request->request->get('id_projet') == $projet->getId()
        ) {
            return new JsonResponse(
                [
                    'response' => true,
                    'content' => $this->render(
                        'modal/avance-paiement.html.twig',
                        ['projet' => $projet]
                    )->getContent()
                ]
            );
        } else {
            return new JsonResponse(
                [
                    'response' => false
                ]
            );
        }
    }
}
