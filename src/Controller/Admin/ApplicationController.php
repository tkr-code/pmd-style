<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\ApplicationImage;
use App\Form\ApplicationLogoType;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'parent_page' => $this->parent_page
        ]);
    }

    #[Route('/new', name: 'app_admin_application_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApplicationRepository $applicationRepository): Response
    {
        $application = new Application();
        $application->setNombreTelechargement(0);
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setSlug($application->getNom());

            //on recupere les images transmise
            $logo = $form->get('logo')->getData();
            if ($logo) {
                $fichier = md5(uniqid()) . '.' . $logo->getClientOriginalExtension();
                //on copie le fichier dans le dosiier uploads
                $logo->move(
                    $this->getParameter('application_images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donnees 
                $application->setLogo($fichier);
            }

            //on recupere les images transmise
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                //om gener un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                //on copie le fichier dans le dosiier uploads
                $image->move(
                    $this->getParameter('application_images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donnees 
                $img = new ApplicationImage();
                $img->setNom($fichier);
                $application->addImage($img);
            }
            $applicationRepository->add($application);
            $this->addFlash('success', 'L\'application a été créé avec succès.');
            return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/application/new.html.twig', [
            'application' => $application,
            'form' => $form,
            'parent_page' => $this->parent_page
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('admin/application/show.html.twig', [
            'application' => $application,
            'parent_page' => $this->parent_page
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_application_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        if(isset($_POST['delete']))
        {
            dd($_POST);
        }
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $application->setSlug($application->getNom());
            //on recupere les images transmise
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                //om gener un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                //on copie le fichier dans le dosiier uploads
                $image->move(
                    $this->getParameter('application_images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donnees 
                $img = new ApplicationImage();
                $img->setNom($fichier);
                $application->addImage($img);
            }
            $this->addFlash('success', "L'application a été modifié avec succès");
            $applicationRepository->add($application);
            return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
        }

        //formulaire pour le logo
        $form2 = $this->createForm(ApplicationLogoType::class, $application);
        $form2->handleRequest($request);

        $ancien_logo = $application->getLogo();

        if ($form2->isSubmitted() && $form2->isValid()) {
            //on recupere les images transmise
            $logo = $form2->get('logo')->getData();
            // dd($logo);
            if ($logo) {
                $fichier = md5(uniqid()) . '.' . $logo->getClientOriginalExtension();
                //on copie le fichier dans le dosiier uploads
                $logo->move(
                    $this->getParameter('application_images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donnees 
                $application->setLogo($fichier);
                //on supprimer l'ancienne image
                if(!empty($ancien_logo)){
                    $path = $this->getParameter('application_images_directory') . '/' . $ancien_logo;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
            // dd($application);
            $this->addFlash('success', "Le logo a été modifié avec succès");
            $applicationRepository->add($application);
            return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/application/edit.html.twig', [
            'application' => $application,
            'form' => $form,
            'form2' => $form2,
            'parent_page' => $this->parent_page
        ]);
    }

    #[Route('/{id}', name: 'app_admin_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application, ApplicationRepository $applicationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $application->getId(), $request->request->get('_token'))) {
            foreach ($application->getImages() as $key => $image) {
                $path = $this->getParameter('application_images_directory') . '/' . $image->getNom();
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            foreach ($application->getFichiers() as $key => $applicationFichier) {
                $path = $this->getParameter('application_fichiers_directory') . '/' . $applicationFichier->getNom();
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $applicationRepository->remove($application);
            $this->addFlash('success', "L'application a été supprimé avec succès");
        }

        return $this->redirectToRoute('app_admin_application_index', [], Response::HTTP_SEE_OTHER);
    }

    

    /**
     * @Route("/delete/image/{id}", name="application_delete_image", methods={"DELETE"})
     */
    public function deleteImage(ApplicationImage $image, Request $request, EntityManagerInterface $entityManager)
    {
        //om verifi si le token est valide         
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $path = $this->getParameter('application_images_directory') . '/' . $image->getNom();
            if (file_exists($path)) {
                unlink($path);
            }
            $entityManager->remove($image);
            $entityManager->flush();
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
}
