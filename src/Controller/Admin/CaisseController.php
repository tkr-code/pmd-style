<?php

namespace App\Controller\Admin;

use App\Entity\Caisse;
use App\Form\CaisseType;
use App\Repository\CaisseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/caisse")
 */
class CaisseController extends AbstractController
{
    /**
     * @Route("/", name="admin_caisse_index", methods={"GET"})
     */
    public function index(CaisseRepository $caisseRepository): Response
    {
        // dd($caisseRepository->findGroupByAllCode());
        $montantTotal = 0;
        foreach ($caisseRepository->findGroupByAllCode() as $value) {
            $montantTotal += $value['total'];
        }
        
        return $this->render('admin/caisse/index.html.twig', [
            'caisses' => $caisseRepository->findGroupByAllCode(),
            'montantTotal'=>$montantTotal
        ]);
    }

    /**
     * @Route("/new", name="admin_caisse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $caisse = new Caisse();
        $form = $this->createForm(CaisseType::class, $caisse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caisse);
            $entityManager->flush();

            return $this->redirectToRoute('admin_caisse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/caisse/new.html.twig', [
            'caisse' => $caisse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_caisse_show", methods={"GET"})
     */
    public function show(Caisse $caisse): Response
    {
        return $this->render('admin/caisse/show.html.twig', [
            'caisse' => $caisse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_caisse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caisse $caisse): Response
    {
        $form = $this->createForm(CaisseType::class, $caisse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_caisse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/caisse/edit.html.twig', [
            'caisse' => $caisse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_caisse_delete", methods={"POST"})
     */
    public function delete(Request $request, Caisse $caisse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caisse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caisse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_caisse_index', [], Response::HTTP_SEE_OTHER);
    }
}
