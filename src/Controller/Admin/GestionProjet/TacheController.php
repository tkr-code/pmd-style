<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion/projet/tache")
 */
class TacheController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_projet_tache_index", methods={"GET"})
     */
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('admin/gestion_projet/tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestion_projet_tache_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_projet_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_projet_tache_show", methods={"GET"})
     */
    public function show(Tache $tache): Response
    {
        return $this->render('admin/gestion_projet/tache/show.html.twig', [
            'tache' => $tache,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestion_projet_tache_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tache $tache): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_projet_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_projet_tache_delete", methods={"POST"})
     */
    public function delete(Request $request, Tache $tache): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_projet_tache_index', [], Response::HTTP_SEE_OTHER);
    }
}
