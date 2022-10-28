<?php

namespace App\Controller\Admin\GestionRendezVous;

use App\Entity\ClientRDV;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion/rendez-vous")
 */
class RendezVousController extends AbstractController
{
    /**
     * @Route("/", name="gestion_rendez_vous_index", methods={"GET"})
     */
    public function index(RendezVousRepository $rendezVousRepository): Response
    {   
        #on recupere le user
        $user = $this->getUser();
        return $this->render('admin/gestion_rendez_vous/rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findBy(['user'=>$user->getId()]),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/new", name="gestion_rendez_vous_new", methods={"GET","POST"})
     */
    public function new(ClientRDV $clientRDV,Request $request): Response
    {   
        $user = $this->getUser();

        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            #on met le client
            $rendezVous->setClientRDV($clientRDV);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezVous);
            
            $entityManager->flush();
            $this->addFlash(
               'success',
               'rendez-vous ajouter avec succès'
            );
            return $this->redirectToRoute('gestion_rendez_vous_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_rendez_vous/rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVous,
            'form' => $form,
            'client' => $clientRDV,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="gestion_rendez_vous_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVous): Response
    {
        #recuperons le client 
        $client = $rendezVous->getClientRDV();

        return $this->render('admin/gestion_rendez_vous/rendez_vous/show.html.twig', [
            'rendez_vous' => $rendezVous,
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="gestion_rendez_vous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RendezVous $rendezVous): Response
    {
        #recuperons le client 
        $client = $rendezVous->getClientRDV();

        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Rendez-vous modifié avec succès'
            );
            return $this->redirectToRoute('gestion_rendez_vous_show', ['id' => $rendezVous->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_rendez_vous/rendez_vous/edit.html.twig', [
            'rendez_vous' => $rendezVous,
            'form' => $form,
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="gestion_rendez_vous_delete", methods={"POST"})
     */
    public function delete(Request $request, RendezVous $rendezVous): Response
    {
        if(
            $request->request->get('suppr_rdv') &&
            $request->request->get('suppr_rdv') == 'katoula_yawou' &&
            $request->request->get('id_supr') &&
            !empty($request->request->get('id_supr')) &&
            $request->request->get('id_supr') == $rendezVous->getId()
        ){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezVous);
            #je valide
            $entityManager->flush();

            $response='success';
        }else{
            $response = 'failed';
        }
        return new JsonResponse($response);

        //return $this->redirectToRoute('admin_gestion_rendez_vous_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
