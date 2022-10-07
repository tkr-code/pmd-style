<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\PaiementFormationDispensee;
use App\Form\PaiementFormationDispenseeType;
use App\Repository\PaiementFormationDispenseeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/paiement")
 */
class PaiementFormationDispenseeController extends AbstractController
{
    /**
     * @Route("/", name="paiement_formation_index", methods={"GET"})
     */
    public function index(PaiementFormationDispenseeRepository $paiementFormationDispenseeRepository): Response
    {
        return $this->render('admin/gestion_formation/paiement_formation_dispensee/index.html.twig', [
            'paiement_formation_dispensees' => $paiementFormationDispenseeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="paiement_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paiementFormationDispensee = new PaiementFormationDispensee();
        $form = $this->createForm(PaiementFormationDispenseeType::class, $paiementFormationDispensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paiementFormationDispensee);
            $entityManager->flush();

            return $this->redirectToRoute('paiement_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/paiement_formation_dispensee/new.html.twig', [
            'paiement_formation_dispensee' => $paiementFormationDispensee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="paiement_formation_show", methods={"GET"})
     */
    public function show(PaiementFormationDispensee $paiementFormationDispensee): Response
    {
        return $this->render('admin/gestion_formation/paiement_formation_dispensee/show.html.twig', [
            'paiement_formation_dispensee' => $paiementFormationDispensee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paiement_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PaiementFormationDispensee $paiementFormationDispensee): Response
    {
        $form = $this->createForm(PaiementFormationDispenseeType::class, $paiementFormationDispensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/paiement_formation_dispensee/edit.html.twig', [
            'paiement_formation_dispensee' => $paiementFormationDispensee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="paiement_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, PaiementFormationDispensee $paiementFormationDispensee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiementFormationDispensee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paiementFormationDispensee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('paiement_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
