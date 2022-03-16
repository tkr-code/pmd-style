<?php

namespace App\Controller\Admin;

use App\Entity\CahierCharge;
use App\Form\CahierChargeType;
use App\Repository\CahierChargeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cahier-de-charge")
 */
class CahierChargeController extends AbstractController
{
    /**
     * @Route("/", name="admin_cahier_charge_index", methods={"GET"})
     */
    public function index(CahierChargeRepository $cahierChargeRepository): Response
    {
        return $this->render('admin/cahier_charge/index.html.twig', [
            'cahier_charges' => $cahierChargeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_cahier_charge_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cahierCharge = new CahierCharge();
        $form = $this->createForm(CahierChargeType::class, $cahierCharge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cahierCharge);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cahier_charge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cahier_charge/new.html.twig', [
            'cahier_charge' => $cahierCharge,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cahier_charge_show", methods={"GET"})
     */
    public function show(CahierCharge $cahierCharge): Response
    {
        return $this->render('admin/cahier_charge/show.html.twig', [
            'cahier_charge' => $cahierCharge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_cahier_charge_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CahierCharge $cahierCharge): Response
    {
        $form = $this->createForm(CahierChargeType::class, $cahierCharge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_cahier_charge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cahier_charge/edit.html.twig', [
            'cahier_charge' => $cahierCharge,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cahier_charge_delete", methods={"POST"})
     */
    public function delete(Request $request, CahierCharge $cahierCharge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cahierCharge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cahierCharge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_cahier_charge_index', [], Response::HTTP_SEE_OTHER);
    }
}
