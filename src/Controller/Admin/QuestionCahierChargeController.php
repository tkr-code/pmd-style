<?php

namespace App\Controller\Admin;

use App\Entity\QuestionCahierCharge;
use App\Form\QuestionCahierChargeType;
use App\Repository\QuestionCahierChargeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/question/cahier-de-charge")
 */
class QuestionCahierChargeController extends AbstractController
{
    /**
     * @Route("/", name="admin_question_cahier_charge_index", methods={"GET"})
     */
    public function index(QuestionCahierChargeRepository $questionCahierChargeRepository): Response
    {
        return $this->render('admin/question_cahier_charge/index.html.twig', [
            'question_cahier_charges' => $questionCahierChargeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_question_cahier_charge_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $questionCahierCharge = new QuestionCahierCharge();
        $form = $this->createForm(QuestionCahierChargeType::class, $questionCahierCharge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($questionCahierCharge);
            $entityManager->flush();

            return $this->redirectToRoute('admin_question_cahier_charge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/question_cahier_charge/new.html.twig', [
            'question_cahier_charge' => $questionCahierCharge,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_question_cahier_charge_show", methods={"GET"})
     */
    public function show(QuestionCahierCharge $questionCahierCharge): Response
    {
        return $this->render('admin/question_cahier_charge/show.html.twig', [
            'question_cahier_charge' => $questionCahierCharge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_question_cahier_charge_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, QuestionCahierCharge $questionCahierCharge): Response
    {
        $form = $this->createForm(QuestionCahierChargeType::class, $questionCahierCharge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_question_cahier_charge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/question_cahier_charge/edit.html.twig', [
            'question_cahier_charge' => $questionCahierCharge,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_question_cahier_charge_delete", methods={"POST"})
     */
    public function delete(Request $request, QuestionCahierCharge $questionCahierCharge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionCahierCharge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($questionCahierCharge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_question_cahier_charge_index', [], Response::HTTP_SEE_OTHER);
    }
}
