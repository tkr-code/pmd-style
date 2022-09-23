<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion/projet/participation")
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_projet_participation_index", methods={"GET"})
     */
    public function index(ParticipationRepository $participationRepository): Response
    {
        return $this->render('admin/gestion_projet/participation/index.html.twig', [
            'participations' => $participationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestion_projet_participation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_projet_participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/participation/new.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_projet_participation_show", methods={"GET"})
     */
    public function show(Participation $participation): Response
    {
        return $this->render('admin/gestion_projet/participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestion_projet_participation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Participation $participation): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_projet_participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/participation/edit.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_projet_participation_delete", methods={"POST"})
     */
    public function delete(Request $request, Participation $participation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_projet_participation_index', [], Response::HTTP_SEE_OTHER);
    }
}
