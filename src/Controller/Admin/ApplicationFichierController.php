<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\ApplicationFichier;
use App\Form\ApplicationFichierType;
use App\Repository\ApplicationFichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-account/application/fichier')]
class ApplicationFichierController extends AbstractController
{
    #[Route('/', name: 'app_admin_application_fichier_index', methods: ['GET'])]
    public function index(ApplicationFichierRepository $applicationFichierRepository): Response
    {
        return $this->render('admin/application_fichier/index.html.twig', [
            'application_fichiers' => $applicationFichierRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_admin_application_fichier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Application $application, ApplicationFichierRepository $applicationFichierRepository): Response
    {
        $applicationFichier = new ApplicationFichier();
        $applicationFichier->setApplication($application);
        // $applicationFichier->setNom($application->getNom());
        $form = $this->createForm(ApplicationFichierType::class, $applicationFichier);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            $fichier = $form->get('fichier')->getData();
            $nom_fichier = $applicationFichier->getNom() . '.' . $fichier->getClientOriginalExtension();

            //on copie le fichier dans le dosiier uploads
            $fichier->move($this->getParameter('application_fichiers_directory'), $nom_fichier);
            //on stocke l'image dans la base de donnees 
            $applicationFichier->setFichier($nom_fichier);            
            $applicationFichierRepository->add($applicationFichier);
            $this->addFlash('success','Fichier ajouté');
            return $this->redirectToRoute('app_admin_application_edit', ['id'=>$application->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application_fichier/new.html.twig', [
            'application_fichier' => $applicationFichier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_fichier_show', methods: ['GET'])]
    public function show(ApplicationFichier $applicationFichier): Response
    {
        return $this->render('admin/application_fichier/show.html.twig', [
            'application_fichier' => $applicationFichier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_application_fichier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApplicationFichier $applicationFichier, ApplicationFichierRepository $applicationFichierRepository): Response
    {
        $form = $this->createForm(ApplicationFichierType::class, $applicationFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applicationFichierRepository->add($applicationFichier);
            return $this->redirectToRoute('app_admin_application_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application_fichier/edit.html.twig', [
            'application_fichier' => $applicationFichier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_fichier_delete', methods: ['POST'])]
    public function delete(Request $request, ApplicationFichier $applicationFichier, ApplicationFichierRepository $applicationFichierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $applicationFichier->getId(), $request->request->get('_token'))) {
            $path = $this->getParameter('application_fichiers_directory').'/'.$applicationFichier->getNom();
            if(file_exists($path)){
                unlink($path);
            }
            $applicationFichierRepository->remove($applicationFichier);
            $this->addFlash('success',"Le fichier a été supprimé avec succès");
        }

        return $this->redirectToRoute('app_admin_application_edit', ['id'=>$applicationFichier->getApplication()->getId()], Response::HTTP_SEE_OTHER);
    }
}
