<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\FormationDispensee;
use App\Entity\Pointage;
use App\Form\PointageType;
use App\Repository\CentreFormationRepository;
use App\Repository\ClasseFormationRepository;
use App\Repository\FormationDispenseeRepository;
use App\Repository\PointageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        #renvoyer la somme des heures deja pointees
        foreach ($pointageRepository->sommeHeurePointageParClasse($formation->getId()) as $value) {
            $total_heure = $value['total_heure'];
        }
        #afin de savoir le nombre d'heure restant
        $heure_restant = $formation->getVolumeHoraire() - $total_heure;
        return $this->render('admin/gestion_formation/pointage/index.html.twig', [
            'pointages' => $pointageRepository->findBy(['formationDispensee' => $formation->getId()]),
            'classe' => $classe,
            'formation' => $formation,
            'module' => $formation->getModule(),
            'heure_restant' => $heure_restant,
            'heure_effectue' => $total_heure,
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
                if ($formationDispensee->getVolumeHoraire() > ( $total_heure + $form['nombreHeureDispense']->getData()) ) {
                    #on met es_supplementaire à faux
                    $pointage->setEsSupplementaire(false);
                } else {
                    #on met es_supplementaire à vrai
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
     * @Route("/{id}/show", name="pointage_show", methods={"GET"})
     */
    public function show(
        Pointage $pointage,
        ClasseFormationRepository $classeFormationRepository,
        CentreFormationRepository $centreFormationRepository
    ): Response {
        #on recupere la formation, qui correspond aussi à la classe
        $formation = $pointage->getFormationDispensee();

        #recuperons la classe, car chaque classe se trouve dans un centre
        $classe = $classeFormationRepository->find($formation->getId());

        $centre = $classe->getCentreFormation();
        return $this->render('admin/gestion_formation/pointage/show.html.twig', [
            'pointage' => $pointage,
            'centre' => $centre,
            'formation' => $formation
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pointage_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Pointage $pointage,
        ClasseFormationRepository $classeFormationRepository
    ): Response {
        #on recupere la formation, qui correspond aussi à la classe
        $formation = $pointage->getFormationDispensee();

        #recuperons la classe, car chaque classe se trouve dans un centre
        $classe = $classeFormationRepository->find($formation->getId());

        $centre = $classe->getCentreFormation();

        $form = $this->createForm(PointageType::class, $pointage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            #on met a jour la formation dediée
            $pointage->setFormationDispensee($formation);

            #on valide les modiifications
            $this->em->persist($pointage);
            $this->em->flush();

            return $this->redirectToRoute('pointage_index', [
                'id' => $centre->getId(),
                'id_forma' => $formation->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/pointage/edit.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
            'centre' => $centre,
            'formation' => $formation
        ]);
    }

    /**
     * @Route("/{id}/del", name="pointage_delete", methods={"POST"})
     */
    public function delete(Request $request, Pointage $pointage, ClasseFormationRepository $classeFormationRepository): Response
    {
        #on recupere la formation, qui correspond aussi à la classe
        $formation = $pointage->getFormationDispensee();

        #recuperons la classe, car chaque classe se trouve dans un centre
        $classe = $classeFormationRepository->find($formation->getId());

        $centre = $classe->getCentreFormation();

        if (
            $request->request->get('pointage_suppr') &&
            $request->request->get('pointage_suppr') == 'katoula' &&
            $request->request->get('id_pointage') &&
            !empty($request->request->get('id_pointage')) &&
            $request->request->get('id_pointage') == $pointage->getId()

        ) {
            $this->em->remove($pointage);
            $this->em->flush();
            $response = 'success';
        } else {
            $response = 'failed';
        }

        return new JsonResponse($response);
        /* return $this->redirectToRoute('pointage_index', [
            'id' => $centre->getId(),
            'id_forma' => $formation->getId()
        ], Response::HTTP_SEE_OTHER); */
    }
}
