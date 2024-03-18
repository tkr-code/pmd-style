<?php

namespace App\Controller\Main;

use App\Entity\Application;
use App\Entity\ApplicationTelechargementUser;
use App\Form\ApplicationTelechargementUserType;
use App\Repository\ApplicationTelechargementUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/main/application/telechargement')]
class ApplicationTelechargementController extends AbstractController
{
    #[Route('/', name: 'app_admin_application_telechargement_index', methods: ['GET'])]
    public function index(ApplicationTelechargementUserRepository $applicationTelechargementUserRepository): Response
    {
        return $this->render('admin/application_telechargement/index.html.twig', [
            'application_telechargement_users' => $applicationTelechargementUserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_application_telechargement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApplicationTelechargementUserRepository $applicationTelechargementUserRepository): Response
    {
        $applicationTelechargementUser = new ApplicationTelechargementUser();
        $form = $this->createForm(ApplicationTelechargementUserType::class, $applicationTelechargementUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applicationTelechargementUserRepository->add($applicationTelechargementUser);
            return $this->redirectToRoute('app_admin_application_telechargement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application_telechargement/new.html.twig', [
            'application_telechargement_user' => $applicationTelechargementUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_telechargement_show', methods: ['GET'])]
    public function show(ApplicationTelechargementUser $applicationTelechargementUser): Response
    {
        return $this->render('admin/application_telechargement/show.html.twig', [
            'application_telechargement_user' => $applicationTelechargementUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_application_telechargement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApplicationTelechargementUser $applicationTelechargementUser, ApplicationTelechargementUserRepository $applicationTelechargementUserRepository): Response
    {
        $form = $this->createForm(ApplicationTelechargementUserType::class, $applicationTelechargementUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applicationTelechargementUserRepository->add($applicationTelechargementUser);
            return $this->redirectToRoute('app_admin_application_telechargement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application_telechargement/edit.html.twig', [
            'application_telechargement_user' => $applicationTelechargementUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_telechargement__list_delete', methods: ['POST'])]
    public function deleteList(Request $request, Application $application, ApplicationTelechargementUserRepository $applicationTelechargementUserRepository): Response
    {
        
        if ($this->isCsrfTokenValid('delete_list'.$application->getId(), $request->request->get('_token'))) {
            $seletedData = $request->request->all()['selectedIds'];
            foreach ($seletedData as $key => $value) {
               $applicationUser =  $applicationTelechargementUserRepository->findOneBy([
                    'id'=>$value
                ]);
                $applicationTelechargementUserRepository->remove($applicationUser);
            }
            $this->addFlash('success',"La selection a été supprimé avec succès");
        }

        return $this->redirectToRoute('app_admin_application_edit', ['id'=>$application->getId()], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}', name: 'app_admin_application_telechargement_delete', methods: ['POST'])]
    public function delete(Request $request, ApplicationTelechargementUser $applicationTelechargementUser, ApplicationTelechargementUserRepository $applicationTelechargementUserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$applicationTelechargementUser->getId(), $request->request->get('_token'))) {
            $applicationTelechargementUserRepository->remove($applicationTelechargementUser);
            $this->addFlash('success',"L'utilisateur a été supprimé avec succès");
        }

        return $this->redirectToRoute('app_admin_application_edit', ['id'=>$applicationTelechargementUser->getApplication()->getId()], Response::HTTP_SEE_OTHER);
    }

}
