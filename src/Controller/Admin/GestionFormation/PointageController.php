<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\FormationDispensee;
use App\Entity\Pointage;
use App\Form\PointageType;
use App\Repository\ClasseFormationRepository;
use App\Repository\FormationDispenseeRepository;
use App\Repository\PointageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/pointage")
 */
class PointageController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/{id<\d+>}/centre/{id_forma<\d+>}/class", name="pointage_index", methods={"GET"})
     */
    public function index(
        PointageRepository $pointageRepository,
        $id_forma,
        ClasseFormationRepository $classeFormationRepository,
        FormationDispenseeRepository $formationDispenseeRepository
    ): Response {
        $formation = $formationDispenseeRepository->find($id_forma);
        $classe = $classeFormationRepository->find($id_forma);
        return $this->render('admin/gestion_formation/pointage/index.html.twig', [
            'pointages' => $pointageRepository->findBy(['formationDispensee' => $formation->getId()]),
            'classe' => $classe,
            'formation' => $formation,
            'module' => $formation->getModule()
        ]);
    }

    /**
     * @Route("/{id<\d+>}/new", name="pointage_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        FormationDispensee $formationDispensee,
        ClasseFormationRepository $classeFormationRepository,
        PointageRepository $pointageRepository
    ): Response {
        #recuperons la classe, toute classe est l'obket d'une formationDispense
        $classe = $classeFormationRepository->find($formationDispensee->getId());
        $pointage = new Pointage();
        $form = $this->createForm(PointageType::class, $pointage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            //dd($form['nombreHeureDispense']->getData());

            #on fait une verification, si le taux horaire est atteint, pour que est supplementaire 
            #soit à vrai ou faux

            #on recupere la somme des taux horaire deja enseigné par classe

            foreach ($pointageRepository->sommeHeurePointageParClasse($formationDispensee->getId()) as $value) {
                $total_heure = $value['total_heure'];
            }
            if ($total_heure == null) { #donc c'est le premier pointage
                #on met es_supplementaire à faux
                $pointage->setEsSupplementaire(false);
            } else if ($total_heure > 0) { #c'est qu'il a deja un pointage et on renvoie la somme des heures pointés
                if ($formationDispensee->getVolumeHoraire() > $total_heure) {
                    #on met es_supplementaire à faux
                    $pointage->setEsSupplementaire(false);
                } else {
                    #on met es_supplementaire à faux
                    $pointage->setEsSupplementaire(true);
                }
            }
            //dd($total_heure);
            #on met la formationDispensee dans le pointage
            $pointage->setFormationDispensee($formationDispensee);

            #on persit et valide
            $this->em->persist($pointage);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Pointage ajouter avec succès'
            );
            return $this->redirectToRoute('pointage_index', [
                'id' => $classe->getCentreFormation()->getId(),
                'id_forma' => $classe->getFormationDispensee()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/pointage/new.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
            'classe' => $classe,
            'module' => $formationDispensee->getModule(),
            'formation' => $formationDispensee
        ]);
    }

    /**
     * @Route("/{id}", name="pointage_show", methods={"GET"})
     */
    public function show(Pointage $pointage): Response
    {
        return $this->render('admin/gestion_formation/pointage/show.html.twig', [
            'pointage' => $pointage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pointage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pointage $pointage): Response
    {
        $form = $this->createForm(PointageType::class, $pointage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pointage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/pointage/edit.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="pointage_delete", methods={"POST"})
     */
    public function delete(Request $request, Pointage $pointage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pointage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pointage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pointage_index', [], Response::HTTP_SEE_OTHER);
    }
}
