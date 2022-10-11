<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\ClasseFormation;
use App\Form\ClasseFormationType;
use App\Repository\ClasseFormationRepository;
use App\Repository\PointageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/classe")
 */
class ClasseFormationController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em  = $entityManager;
    }
    /**
     * @Route("/", name="classe_formation_index", methods={"GET"})
     */
    public function index(ClasseFormationRepository $classeFormationRepository): Response
    {
        return $this->render('admin/gestion_formation/classe_formation/index.html.twig', [
            'classe_formations' => $classeFormationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="classe_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $classeFormation = new ClasseFormation();
        $form = $this->createForm(ClasseFormationType::class, $classeFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classeFormation);
            $entityManager->flush();

            return $this->redirectToRoute('classe_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/classe_formation/new.html.twig', [
            'classe_formation' => $classeFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/centre/{id_cla<\d+>}/show", name="classe_formation_show", methods={"GET"})
     */
    public function show(ClasseFormationRepository $classeFormationRepository, $id_cla, PointageRepository $pointageRepository): Response
    {
        $classeFormation = $classeFormationRepository->find($id_cla);

        foreach ($pointageRepository->sommeHeurePointageParClasse($classeFormation->getFormationDispensee()->getId()) as  $value) {
            $heure_effectuee = $value['total_heure'];
            $heure_restant = $classeFormation->getFormationDispensee()->getVolumeHoraire() - $heure_effectuee;
        }
        return $this->render('admin/gestion_formation/classe_formation/show.html.twig', [
            'classe_formation' => $classeFormation,
            'heure_effectuee' => $heure_effectuee,
            'heure_restant' => $heure_restant
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="classe_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClasseFormation $classeFormation): Response
    {
        $formation = $classeFormation->getFormationDispensee();
        $centre = $classeFormation->getCentreFormation();

        $form = $this->createForm(ClasseFormationType::class, $classeFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->persist($classeFormation);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Classe Modifiée avec succès'
            );
            return $this->redirectToRoute('classe_formation_show', [
                'id' => $centre->getId(),
                'id_cla' => $classeFormation->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/classe_formation/edit.html.twig', [
            'classe_formation' => $classeFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/del", name="classe_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, ClasseFormation $classeFormation): Response
    {
        if(
            $request->request->get('classe_suppr') &&
            $request->request->get('classe_suppr') == 'zimibssa_yawou' &&
            $request->request->get('id_del') &&
            !empty($request->request->get('id_del')) &&
            $request->request->get('id_del') == $classeFormation->getId()
        
        ){
            $this->em->remove($classeFormation);
            $this->em->flush();

            $response = 'success';
        }else{
            $response = 'failed';
        }

        return new JsonResponse($response);

        //return $this->redirectToRoute('classe_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
