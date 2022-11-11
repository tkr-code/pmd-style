<?php

namespace App\Controller\Admin\GestionInvestissement;

use App\Entity\ContratInvestissement;
use App\Form\ContratInvestissementType;
use App\Repository\ContratInvestissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-investissement/contrat/investissement")
 */
class ContratInvestissementController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_contrat_investissement_index", methods={"GET"})
     */
    public function index(ContratInvestissementRepository $contratInvestissementRepository): Response
    {
        return $this->render('admin/gestion_investissement/contrat_investissement/index.html.twig', [
            'contrat_investissements' => $contratInvestissementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestion_contrat_investissement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contratInvestissement = new ContratInvestissement();
        $form = $this->createForm(ContratInvestissementType::class, $contratInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contratInvestissement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_contrat_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/contrat_investissement/new.html.twig', [
            'contrat_investissement' => $contratInvestissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_contrat_investissement_show", methods={"GET"})
     */
    public function show(ContratInvestissement $contratInvestissement): Response
    {
        return $this->render('admin/gestion_investissement/contrat_investissement/show.html.twig', [
            'contrat_investissement' => $contratInvestissement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestion_contrat_investissement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContratInvestissement $contratInvestissement): Response
    {
        $form = $this->createForm(ContratInvestissementType::class, $contratInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_contrat_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/contrat_investissement/edit.html.twig', [
            'contrat_investissement' => $contratInvestissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_contrat_investissement_delete", methods={"POST"})
     */
    public function delete(Request $request, ContratInvestissement $contratInvestissement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contratInvestissement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contratInvestissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_investissement_contrat_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
