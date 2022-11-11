<?php

namespace App\Controller\Admin\GestionInvestissement;

use App\Entity\RetourInvestissement;
use App\Form\RetourInvestissementType;
use App\Repository\RetourInvestissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-investissement/retour/investissement")
 */
class RetourInvestissementController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_retour_investissement_index", methods={"GET"})
     */
    public function index(RetourInvestissementRepository $retourInvestissementRepository): Response
    {
        return $this->render('admin/gestion_investissement/retour_investissement/index.html.twig', [
            'retour_investissements' => $retourInvestissementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestion_retour_investissement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $retourInvestissement = new RetourInvestissement();
        $form = $this->createForm(RetourInvestissementType::class, $retourInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($retourInvestissement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_retour_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/retour_investissement/new.html.twig', [
            'retour_investissement' => $retourInvestissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_retour_investissement_show", methods={"GET"})
     */
    public function show(RetourInvestissement $retourInvestissement): Response
    {
        return $this->render('admin/gestion_investissement/retour_investissement/show.html.twig', [
            'retour_investissement' => $retourInvestissement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestion_retour_investissement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RetourInvestissement $retourInvestissement): Response
    {
        $form = $this->createForm(RetourInvestissementType::class, $retourInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_retour_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/retour_investissement/edit.html.twig', [
            'retour_investissement' => $retourInvestissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_retour_investissement_delete", methods={"POST"})
     */
    public function delete(Request $request, RetourInvestissement $retourInvestissement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$retourInvestissement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($retourInvestissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_investissement_retour_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
