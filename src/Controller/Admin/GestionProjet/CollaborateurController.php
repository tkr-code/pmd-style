<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\Collaborateur;
use App\Form\CollaborateurType;
use App\Repository\CollaborateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-projet/collaborateur")
 */
class CollaborateurController extends AbstractController
{
    /**
     * @Route("/", name="collaborateur_index", methods={"GET"})
     */
    public function index(CollaborateurRepository $collaborateurRepository): Response
    {
        return $this->render('admin/gestion_projet/collaborateur/index.html.twig', [
            'collaborateurs' => $collaborateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collaborateur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $collaborateur = new Collaborateur();
        $form = $this->createForm(CollaborateurType::class, $collaborateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collaborateur);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_projet_collaborateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/collaborateur/new.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="collaborateur_show", methods={"GET"})
     */
    public function show(Collaborateur $collaborateur): Response
    {
        return $this->render('admin/gestion_projet/collaborateur/show.html.twig', [
            'collaborateur' => $collaborateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collaborateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Collaborateur $collaborateur): Response
    {
        $form = $this->createForm(CollaborateurType::class, $collaborateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_projet_collaborateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/collaborateur/edit.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="collaborateur_delete", methods={"POST"})
     */
    public function delete(Request $request, Collaborateur $collaborateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collaborateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($collaborateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_projet_collaborateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
