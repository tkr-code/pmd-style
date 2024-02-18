<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-account/application')]
class ApplicationController extends AbstractController
{
    private $parent_page = 'Application';
    #[Route('/', name: 'app_admin_application_index', methods: ['GET'])]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        return $this->render('admin/application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/new', name: 'app_admin_application_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApplicationRepository $applicationRepository): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applicationRepository->add($application);
            $this->addFlash('success','Application créer.');
            return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application/new.html.twig', [
            'application' => $application,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('admin/application/show.html.twig', [
            'application' => $application,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_application_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applicationRepository->add($application);
            return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application/edit.html.twig', [
            'application' => $application,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {
            $applicationRepository->remove($application);
        }

        return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
    }
}
