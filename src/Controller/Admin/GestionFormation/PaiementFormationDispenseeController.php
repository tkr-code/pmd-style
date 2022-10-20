<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\Formation;
use App\Entity\FormationDispensee;
use App\Entity\PaiementFormationDispensee;
use App\Form\PaiementFormationDispenseeType;
use App\Repository\ClasseFormationRepository;
use App\Repository\PaiementFormationDispenseeRepository;
use App\Repository\PointageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/paiement")
 */
class PaiementFormationDispenseeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="paiement_formation_index", methods={"GET"})
     */
    public function index(PaiementFormationDispenseeRepository $paiementFormationDispenseeRepository): Response
    {
        return $this->render('admin/gestion_formation/paiement_formation_dispensee/index.html.twig', [
            'paiement_formation_dispensees' => $paiementFormationDispenseeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/new", name="paiement_formation_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        FormationDispensee $formationDispensee,
        ClasseFormationRepository $classeFormationRepository,
        PointageRepository $pointageRepository
    ): Response {
        #formation et classe se cree au meme moment,
        $classe = $classeFormationRepository->find($formationDispensee->getId());
        $centre = $classe->getCentreFormation();

        #pointage pour savoir le nombre heure supplementaire
        foreach ($pointageRepository->sommeHeurePointageParClasse($formationDispensee->getId()) as $value) {
            $total_heure = $value['total_heure'];
        }

        if ($total_heure == null) { #donc il n'y a pas de pointage
            $heure_supplemenataire = 0;
        } else {
            if ($formationDispensee->getVolumeHoraire() - $total_heure > 0) {
                #tant que le volume horaire est >  la somme des heures, il n'y apas d'heure supplementaire
                $heure_supplemenataire = 0;

                #heure effectuée
                $heure_effectuee = $total_heure;
            } else if ($formationDispensee->getVolumeHoraire() - $total_heure == 0) {
                $heure_supplemenataire = 0;
                $heure_effectuee = $formationDispensee->getVolumeHoraire();

            } else {
                #je multiplie par -1 pour enlever la negation
                #afin d'eviter de le gérer dans le template twig
                $heure_supplemenataire = (-1) * ($formationDispensee->getVolumeHoraire() - $total_heure);
            }
        }

        $paiementFormationDispensee = new PaiementFormationDispensee();
        $form = $this->createForm(PaiementFormationDispenseeType::class, $paiementFormationDispensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            #on change l'etat de la formation à :  achevée
            $formationDispensee->setEtat('Achevée');

            $paiementFormationDispensee->setFormationDispensee($formationDispensee);

            $this->em->persist($paiementFormationDispensee);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Paiement Effecuté correctement'
            );
            return $this->redirectToRoute('centre_formation_show', ['id' => $centre->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/paiement_formation_dispensee/new.html.twig', [
            'paiement_formation_dispensee' => $paiementFormationDispensee,
            'form' => $form,
            'centre_formation' => $centre,
            'classe' => $classe,
            'formation' => $formationDispensee,
            'heure_supplemenataire' => $heure_supplemenataire,
            'heure_effectuee'=>$heure_effectuee
        ]);
    }

    /**
     * @Route("/{id}/show", name="paiement_formation_show", methods={"GET"})
     */
    public function show(
        PaiementFormationDispensee $paiementFormationDispensee,
        ClasseFormationRepository $classeFormationRepository,
        PointageRepository $pointageRepository

    ): Response {
        $formationDispensee = $paiementFormationDispensee->getFormationDispensee();

        $classe = $classeFormationRepository->find($formationDispensee->getId());

        $centre = $classe->getCentreFormation();

        #pointage pour savoir le nombre heure supplementaire
        foreach ($pointageRepository->sommeHeurePointageParClasse($formationDispensee->getId()) as $value) {
            $total_heure = $value['total_heure'];
        }

        if ($total_heure == null) { #donc il n'y a pas de pointage
            $heure_supplemenataire = 0;
            $heure_effectuee = 0;
        } else {
            if ($formationDispensee->getVolumeHoraire() - $total_heure > 0) {
                #tant que le volume horaire est >  la somme des heures, il n'y apas d'heure supplementaire
                $heure_supplemenataire = 0;
                $heure_effectuee = $total_heure;
            } else if ($formationDispensee->getVolumeHoraire() - $total_heure == 0) {
                $heure_supplemenataire = 0;
                $heure_effectuee = $formationDispensee->getVolumeHoraire();
            } else {
                #je multiplie par -1 pour enlever la negation
                #afin d'eviter de le gérer dans le template twig
                $heure_supplemenataire = (-1) * ($formationDispensee->getVolumeHoraire() - $total_heure);
            }
        }

        return $this->render('admin/gestion_formation/paiement_formation_dispensee/show.html.twig', [
            'paiement_formation_dispensee' => $paiementFormationDispensee,
            'centre_formation' => $centre,
            'classe' => $classe,
            'formation_dispensee' => $formationDispensee,
            'heure_supplemenataire' => $heure_supplemenataire,
            'heure_effectuee'=>$heure_effectuee
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paiement_formation_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        PaiementFormationDispensee $paiementFormationDispensee,
        ClasseFormationRepository $classeFormationRepository,
        PointageRepository $pointageRepository
    ): Response {
        $formationDispensee = $paiementFormationDispensee->getFormationDispensee();

        $classe = $classeFormationRepository->find($formationDispensee->getId());

        $centre = $classe->getCentreFormation();

        #pointage pour savoir le nombre heure supplementaire
        foreach ($pointageRepository->sommeHeurePointageParClasse($formationDispensee->getId()) as $value) {
            $total_heure = $value['total_heure'];
        }

        if ($total_heure == null) { #donc il n'y a pas de pointage
            $heure_supplemenataire = 0;
        } else {
            if ($formationDispensee->getVolumeHoraire() - $total_heure > 0) {
                #tant que le volume horaire est >  la somme des heures, il n'y apas d'heure supplementaire
                $heure_supplemenataire = 0;
            } else if ($formationDispensee->getVolumeHoraire() - $total_heure == 0) {
                $heure_supplemenataire = 0;
            } else {
                #je multiplie par -1 pour enlever la negation
                #afin d'eviter de le gérer dans le template twig
                $heure_supplemenataire = (-1) * ($formationDispensee->getVolumeHoraire() - $total_heure);
            }
        }

        $form = $this->createForm(PaiementFormationDispenseeType::class, $paiementFormationDispensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Paiement Modifié avec succès'
            );
            return $this->redirectToRoute('paiement_formation_show', ['id' => $paiementFormationDispensee->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/paiement_formation_dispensee/edit.html.twig', [
            'paiement_formation_dispensee' => $paiementFormationDispensee,
            'form' => $form,
            'centre_formation' => $centre,
            'classe' => $classe,
            'formation_dispensee' => $formationDispensee,
            'heure_supplemenataire' => $heure_supplemenataire
        ]);
    }

    /**
     * @Route("/{id<\d+>}/del", name="paiement_formation_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        PaiementFormationDispensee $paiementFormationDispensee,
        ClasseFormationRepository $classeFormationRepository,
        PointageRepository $pointageRepository

    ): Response {
        $formationDispensee = $paiementFormationDispensee->getFormationDispensee();

        $classe = $classeFormationRepository->find($formationDispensee->getId());

        $centre = $classe->getCentreFormation();


        if (
            $request->request->get('paiement_suppr') &&
            $request->request->get('paiement_suppr') == 'katoula_yaou' &&
            $request->request->get('id_paie') &&
            !empty($request->request->get('id_paie')) &&
            $request->request->get('id_paie') == $paiementFormationDispensee->getId()

        ) {

            $response = 'success';
            $centre_id = $centre->getId();

            #supprimer le paiement, il faut verifier une chose
            #description: est ce que le volume horaire est atteint c'est a dire
            #que le nombre heure enseigné est egal au volume ?

            #s'il n'y a aucun pointage, la formation reste en cour

            #pointage pour savoir le nombre heure, afin de bien gerer l'etat de la formation
            foreach ($pointageRepository->sommeHeurePointageParClasse($formationDispensee->getId()) as $value) {
                $total_heure = $value['total_heure'];
            }

            if ($total_heure == null) { #donc il n'y a pas de pointage
                $formationDispensee->setEtat('En Cour');
            } else {
                if (($formationDispensee->getVolumeHoraire() - $total_heure) > 0) {
                    $formationDispensee->setEtat('En Cour');
                } else if (($formationDispensee->getVolumeHoraire() - $total_heure) == 0) {
                    #si le total heure est egal au volume horaire, on dit que la formation est achevée
                    $formationDispensee->setEtat('Achevée');
                } else {
                    #si le total heure est superieur au volume horaire, la formation est Achevée
                    $formationDispensee->setEtat('Achevée');
                }
            }

            #on modifie la formation
            $this->em->persist($formationDispensee);

            #on supprime alors le paiement
            $this->em->remove($paiementFormationDispensee);

            #on valide
            $this->em->flush();
            $chemin = '/admin/gestion-formation/centre/' . $centre_id . '/show';
            return new JsonResponse(
                [
                    'response' => $response,
                    'redirecte' => $chemin
                ]
            );
        } else {
            $response = 'failed';
            return new JsonResponse(
                [
                    'response' => $response,
                ]
            );
        }
        // return $this->redirectToRoute('paiement_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
