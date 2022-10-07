<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\ClasseFormation;
use App\Form\ClasseFormationType;
use App\Repository\ClasseFormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/classe")
 */
class ClasseFormationController extends AbstractController
{
    /**
     * @Route("/", name="classe_formation_index", methods={"GET"})
     */
    public function index(ClasseFormationRepository $classeFormationRepository): Response
    {
        return $this->render('admin/gestion_formation/classe_formation/index.html.twig', [
            'classe_formations' => $classeFormationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="classe_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $classeFormation = new ClasseFormation();
        $form = $this->createForm(ClasseFormationType::class, $classeFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classeFormation);
            $entityManager->flush();

            return $this->redirectToRoute('classe_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/classe_formation/new.html.twig', [
            'classe_formation' => $classeFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="classe_formation_show", methods={"GET"})
     */
    public function show(ClasseFormation $classeFormation): Response
    {
        return $this->render('admin/gestion_formation/classe_formation/show.html.twig', [
            'classe_formation' => $classeFormation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classe_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClasseFormation $classeFormation): Response
    {
        $form = $this->createForm(ClasseFormationType::class, $classeFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/classe_formation/edit.html.twig', [
            'classe_formation' => $classeFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="classe_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, ClasseFormation $classeFormation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeFormation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classeFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
