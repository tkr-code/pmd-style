<?php

namespace App\Controller\Admin;

use App\Entity\FormationOption;
use App\Form\FormationOptionType;
use App\Repository\FormationOptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formation/option')]
class FormationOptionController extends AbstractController
{
    #[Route('/', name: 'app_admin_formation_option_index', methods: ['GET'])]
    public function index(FormationOptionRepository $formationOptionRepository): Response
    {
        return $this->render('admin/formation_option/index.html.twig', [
            'formation_options' => $formationOptionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_formation_option_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormationOptionRepository $formationOptionRepository): Response
    {
        $formationOption = new FormationOption();
        $form = $this->createForm(FormationOptionType::class, $formationOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationOptionRepository->add($formationOption);
            return $this->redirectToRoute('app_admin_formation_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/formation_option/new.html.twig', [
            'formation_option' => $formationOption,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formation_option_show', methods: ['GET'])]
    public function show(FormationOption $formationOption): Response
    {
        return $this->render('admin/formation_option/show.html.twig', [
            'formation_option' => $formationOption,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_formation_option_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormationOption $formationOption, FormationOptionRepository $formationOptionRepository): Response
    {
        $form = $this->createForm(FormationOptionType::class, $formationOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationOptionRepository->add($formationOption);
            return $this->redirectToRoute('app_admin_formations_edit', ['id'=>$formationOption->getFormations()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/formation_option/edit.html.twig', [
            'formation_option' => $formationOption,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formation_option_delete', methods: ['POST'])]
    public function delete(Request $request, FormationOption $formationOption, FormationOptionRepository $formationOptionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formationOption->getId(), $request->request->get('_token'))) {
            $formationOptionRepository->remove($formationOption);
        }

        return $this->redirectToRoute('app_admin_formation_option_index', [], Response::HTTP_SEE_OTHER);
    }
}
