<?php

namespace App\Controller\Admin;

use App\Entity\Cv;
use App\Form\CvType;
use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cv")
 */
class CvController extends AbstractController
{
    /**
     * @Route("/", name="admin_cv_index", methods={"GET"})
     */
    public function index(CvRepository $cvRepository): Response
    {
        return $this->render('admin/cv/index.html.twig', [
            'cvs' => $cvRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_cv_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cv = new Cv();
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cv);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cv/new.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cv_show", methods={"GET"})
     */
    public function show(Cv $cv): Response
    {
        return $this->render('admin/cv/show.html.twig', [
            'cv' => $cv,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_cv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cv $cv): Response
    {
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cv/edit.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cv_delete", methods={"POST"})
     */
    public function delete(Request $request, Cv $cv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_cv_index', [], Response::HTTP_SEE_OTHER);
    }
}
