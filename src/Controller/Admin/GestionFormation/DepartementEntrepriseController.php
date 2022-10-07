<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\DepartementEntreprise;
use App\Form\DepartementEntrepriseType;
use App\Repository\DepartementEntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/departement")
 */
class DepartementEntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="formation_departement_entreprise_index", methods={"GET"})
     */
    public function index(DepartementEntrepriseRepository $departementEntrepriseRepository): Response
    {
        return $this->render('admin/gestion_formation/departement_entreprise/index.html.twig', [
            'departement_entreprises' => $departementEntrepriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="formation_departement_entreprise_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $departementEntreprise = new DepartementEntreprise();
        $form = $this->createForm(DepartementEntrepriseType::class, $departementEntreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($departementEntreprise);
            $entityManager->flush();

            return $this->redirectToRoute('formation_departement_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/departement_entreprise/new.html.twig', [
            'departement_entreprise' => $departementEntreprise,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_departement_entreprise_show", methods={"GET"})
     */
    public function show(DepartementEntreprise $departementEntreprise): Response
    {
        return $this->render('admin/gestion_formation/departement_entreprise/show.html.twig', [
            'departement_entreprise' => $departementEntreprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_departement_entreprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DepartementEntreprise $departementEntreprise): Response
    {
        $form = $this->createForm(DepartementEntrepriseType::class, $departementEntreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_departement_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/departement_entreprise/edit.html.twig', [
            'departement_entreprise' => $departementEntreprise,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_departement_entreprise_delete", methods={"POST"})
     */
    public function delete(Request $request, DepartementEntreprise $departementEntreprise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departementEntreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($departementEntreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_departement_entreprise_index', [], Response::HTTP_SEE_OTHER);
    }
}
