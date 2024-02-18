<?php

namespace App\Controller\Admin;

use App\Entity\FormationOption;
use App\Entity\Formations;
use App\Form\FormationOptionType;
use App\Form\FormationsType;
use App\Repository\FormationOptionRepository;
use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-account/formations')]
class FormationsController extends AbstractController
{
    private $parent_page = 'Formation';
    #[Route('/', name: 'app_admin_formations_index', methods: ['GET'])]
    public function index(FormationsRepository $formationsRepository): Response
    {
        return $this->render('admin/formations/index.html.twig', [
            'formations' => $formationsRepository->findAll(),
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/new', name: 'app_admin_formations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormationsRepository $formationsRepository): Response
    {
        $formation = new Formations();
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationsRepository->add($formation);
            $this->addFlash('success','Formation créer.');
            return $this->redirectToRoute('app_admin_formations_new_options', ['id'=>$formation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/formations/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/new/options/{id}', name: 'app_admin_formations_new_options', methods: ['GET', 'POST'])]
    public function newOptions(Request $request,Formations $formation, FormationOptionRepository $formationOptionRepository): Response
    {
        $formationOption = new FormationOption();
        $formationOption->setTitre('test 1');
        $formationOption->setContenu('contenu de test');
        $form = $this->createForm(FormationOptionType::class, $formationOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationOption->setFormations($formation);
            $formationOptionRepository->add($formationOption);
            if(isset($request->request->all()['end'])){
                // retourne sur la liste des formations
                $this->addFlash('success','Formation enregistrée.');
                return $this->redirectToRoute('app_admin_formations_index', [], Response::HTTP_SEE_OTHER);
            }else{
                // retourne sur ajouter une option de la meme formation
                $this->addFlash('success','Option Enregistrée.');
                return $this->redirectToRoute('app_admin_formations_new_options', ['id'=>$formation->getId()], Response::HTTP_SEE_OTHER);
            } 
        }

        return $this->renderForm('admin/formations/new_options.html.twig', [
            'formation_option' => $formationOption,
            'formation'=>$formation,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formations_show', methods: ['GET'])]
    public function show(Formations $formation): Response
    {
        return $this->render('admin/formations/show.html.twig', [
            'formation' => $formation,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_formations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formations $formation, FormationsRepository $formationsRepository): Response
    {
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $description =  $request->request->all()['formations']['description'];
            // trunc
            $formationsRepository->add($formation);
            $this->addFlash('success','Modification réussie.');
            return $this->redirectToRoute('app_admin_formations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/formations/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formations_delete', methods: ['POST'])]
    public function delete(Request $request, Formations $formation, FormationsRepository $formationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $formationsRepository->remove($formation);
            $this->addFlash('success','Suppression réussie.');
        }

        return $this->redirectToRoute('app_admin_formations_index', [], Response::HTTP_SEE_OTHER);
    }
}
