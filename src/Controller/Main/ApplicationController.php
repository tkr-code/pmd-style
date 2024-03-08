<?php

namespace App\Controller\Main;

use App\Entity\Application;
use App\Entity\ApplicationFichier;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ApplicationTelechargementUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ApplicationTelechargementUserType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApplicationFichierRepository;
use App\Repository\ApplicationTelechargementUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;

class ApplicationController extends AbstractController
{
    #[Route('/applications', name: 'app_applications')]
    public function index(): Response
    {
        return $this->render('main/application/index.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }

    #[Route('/applications/{slug}/{id}', name: 'app_main_application', methods: ['GET','POST'])]
    public function show(EntityManagerInterface $entityManager, Application $application,Request $request,ApplicationTelechargementUserRepository $applicationTelechargementUserRepository, ApplicationFichierRepository $applicationFichierRepository): Response
    {
        if($application){
            $applicationFichier = $applicationFichierRepository->findOneBy([
                'version'=>$application->getVersion(),
                'application'=>$application->getId()
            ]);
            if($applicationFichier){
                $fichier = $this->getParameter('application_fichiers_directory').'/'.$applicationFichier->getFichier();
                $taille_octets = filesize($fichier);
                $taille_mb = $taille_octets / (1024 * 1024);
            }
        }

        $applicationTelechargementUser = new ApplicationTelechargementUser();
        $form = $this->createForm(ApplicationTelechargementUserType::class, $applicationTelechargementUser);
        $form->handleRequest($request);
        // $this->setcookie('');

        if ($form->isSubmitted() && $form->isValid()) {
            $applicationTelechargementUser->setApplication($application);
            $applicationTelechargementUserRepository->add($applicationTelechargementUser);

            $fichier = $this->getParameter('application_fichiers_directory').'/'.$applicationFichier->getFichier();

        // Vérifier si le fichier existe
        if (file_exists($fichier)) {
            $compteur = $application->getNombreTelechargement();
            $compteur++;
            $application->setNombreTelechargement($compteur);
            $entityManager->flush();

            // Envoyer le fichier au navigateur
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $application->getNom().' '.$application->getVersion() . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fichier));
            readfile($fichier);

            $expiration = new \DateTime();
            $expiration->modify('+1 year');
    
            $cookie = Cookie::create('application_telecharger',true,$expiration);
    
            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->send();

            // Mettre à jour le nombre de téléchargements dans une base de données ou un fichier
            // par exemple, vous pouvez ajouter un enregistrement dans une base de données avec le compteur de téléchargement
            // ou vous pouvez simplement enregistrer le compteur dans un fichier texte ou un fichier de base de données
            exit;
            // return $this->redirect($request->headers->get('referer'));
        } else {
            $this->addFlash('error','Le fichier demandé n\'existe pas.');
            return $this->redirect($request->headers->get('referer'));
        }
            return $this->redirectToRoute('app_main_application', ['id'=>$application->getId(),'slug'=>$application->getSlug()], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('main/application/show.html.twig', [
            'application' => $application,
            'fichier'=>$applicationFichier,
            'file_size'=>number_format($taille_mb, 2, ',', ' ') .' MB',
            'form'=>$form
        ]);
    }

    #[Route("/download-fichier/{id}", name:"download_application_fichier")]
    public function downloadApplicationFichier(Request $request, EntityManagerInterface $entityManager, ApplicationFichier $applicationFichier)
    {
        $application = $applicationFichier->getApplication();
        // Chemin vers le fichier à télécharger
        $fichier = $this->getParameter('application_fichiers_directory').'/'.$applicationFichier->getFichier();
        // dd($applicationFichier);

        // Vérifier si le fichier existe
        if (file_exists($fichier)) {
            $compteur = $application->getNombreTelechargement();
            $compteur++;
            $application->setNombreTelechargement($compteur);
            $entityManager->flush();

            // Envoyer le fichier au navigateur
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $application->getNom().' '.$application->getVersion() . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fichier));
            readfile($fichier);

            // Mettre à jour le nombre de téléchargements dans une base de données ou un fichier
            // par exemple, vous pouvez ajouter un enregistrement dans une base de données avec le compteur de téléchargement
            // ou vous pouvez simplement enregistrer le compteur dans un fichier texte ou un fichier de base de données
            exit;
            // return $this->redirect($request->headers->get('referer'));
        } else {
            $this->addFlash('error','Le fichier demandé n\'existe pas.');
            return $this->redirect($request->headers->get('referer'));
        }
           
    }
}
