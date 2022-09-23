<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion/projet/paiement")
 */
class PaiementController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_projet_paiement_index", methods={"GET"})
     */
    public function index(PaiementRepository $paiementRepository): Response
    {
        return $this->render('admin/gestion_projet/paiement/index.html.twig', [
            'paiements' => $paiementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestion_projet_paiement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paiement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_projet_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/paiement/new.html.twig', [
            'paiement' => $paiement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_projet_paiement_show", methods={"GET"})
     */
    public function show(Paiement $paiement): Response
    {
        return $this->render('admin/gestion_projet/paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestion_projet_paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paiement $paiement): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_projet_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_projet_paiement_delete", methods={"POST"})
     */
    public function delete(Request $request, Paiement $paiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_projet_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
}
