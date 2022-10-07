<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/entreprise")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="formation_entreprise_index", methods={"GET"})
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        return $this->render('admin/gestion_formation/entreprise/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="formation_entreprise_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('formation_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('admin/gestion_formation/entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_entreprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entreprise $entreprise): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_entreprise_delete", methods={"POST"})
     */
    public function delete(Request $request, Entreprise $entreprise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_entreprise_index', [], Response::HTTP_SEE_OTHER);
    }
}
