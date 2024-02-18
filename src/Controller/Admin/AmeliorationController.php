<?php

namespace App\Controller\Admin;

use App\Entity\Amelioration;
use App\Form\AmeliorationType;
use App\Repository\AmeliorationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-account/amelioration')]
class AmeliorationController extends AbstractController
{
    #[Route('/', name: 'app_admin_amelioration_index', methods: ['GET'])]
    public function index(AmeliorationRepository $ameliorationRepository): Response
    {
        return $this->render('admin/amelioration/index.html.twig', [
            'ameliorations' => $ameliorationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_amelioration_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer une suggestion')]
    public function new(Request $request, AmeliorationRepository $ameliorationRepository): Response
    {
        $amelioration = new Amelioration();
        $form = $this->createForm(AmeliorationType::class, $amelioration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ameliorationRepository->add($amelioration);
            return $this->redirectToRoute('app_admin_amelioration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/amelioration/new.html.twig', [
            'amelioration' => $amelioration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_amelioration_show', methods: ['GET'])]
    public function show(Amelioration $amelioration): Response
    {
        return $this->render('admin/amelioration/show.html.twig', [
            'amelioration' => $amelioration,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_amelioration_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Amelioration $amelioration, AmeliorationRepository $ameliorationRepository): Response
    {
        $form = $this->createForm(AmeliorationType::class, $amelioration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ameliorationRepository->add($amelioration);
            return $this->redirectToRoute('app_admin_amelioration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/amelioration/edit.html.twig', [
            'amelioration' => $amelioration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_amelioration_delete', methods: ['POST'])]
    public function delete(Request $request, Amelioration $amelioration, AmeliorationRepository $ameliorationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$amelioration->getId(), $request->request->get('_token'))) {
            $ameliorationRepository->remove($amelioration);
        }

        return $this->redirectToRoute('app_admin_amelioration_index', [], Response::HTTP_SEE_OTHER);
    }
}
