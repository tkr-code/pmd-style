<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\AvancePaiement;
use App\Entity\Paiement;
use App\Entity\Projet;
use App\Form\AvancePaiementType;
use App\Repository\AvancePaiementRepository;
use App\Repository\ProjetRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-projet/avance-paiement")
 */
class AvancePaiementController extends AbstractController
{
    /**
     * le constructeur 
     */
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/projet/{id<\d+>}/", name="avance_paiement_index", methods={"GET","POST"})
     */
    public function index(AvancePaiementRepository $avancePaiementRepository, Projet $projet): Response
    {   
        /*
        #je testais juste pour voir le comportemen
        $les_avances_recus = $avancePaiementRepository->allAvanceForPaiement($projet->getPaiement()->getId());
        $avant_derniere_avance = array_slice($les_avances_recus, count($les_avances_recus) - 2, 1);

        foreach ($avant_derniere_avance as $avance) {
            $last_id = $avance->getid();

            $avant_dernier_montant_du = $avance->getMontantDu();
        }
        $derniere_avance_inserere = end($les_avances_recus);
        dump('Avant dernier montant du ' . $avant_dernier_montant_du);
        dump('Dernier montant du' . $derniere_avance_inserere->getMontantDu());
        dump('Dernier montant du ID ' . $derniere_avance_inserere->getId());
        // dump($les_avances_recus);
        dump(

            array_slice($les_avances_recus, count($les_avances_recus) - 2, 1)
        );
        //recuperons l'avant dernier element

        // dump($avancePaiementRepository->allAvanceForPaiement($projet->getPaiement()->getId())); 
        */
        return $this->render(
            'admin/gestion_projet/avance_paiement/index.html.twig',
            [
                'avance_paiements' => $avancePaiementRepository->findBy(['paiement' => $projet->getPaiement()]),
                'id_projet' => $projet->getId(),
                'projet' => $projet
            ]
        );
    }

    /**
     * @Route("/projet/{id<\d+>}/new/", name="avance_paiement_new", methods={"GET","POST"})
     */
    public function new(Request $request, Projet $projet): Response
    {
        if (
            $request->get('avance') &&
            $request->get('avance') == 'avance'
        ) {
            if (
                !empty($request->get('date_avance')) &&
                !empty($request->get('montant_avance')) &&

                !empty($request->get('mode_paiement'))

            ) {
                // dd($request->request);
                // On recupere le paiement deja
                $paiement = $projet->getPaiement();

                $avancePaiement = new AvancePaiement();
                $avancePaiement->setDateAvance(new DateTime($request->get('date_avance')));
                $avancePaiement->setMontantAvance($request->get('montant_avance'));
                $avancePaiement->setMontantDu($request->get('montant_du'));
                $avancePaiement->setModePaiementAvance($request->get('mode_paiement'));
                $avancePaiement->setPaiement($projet->getPaiement());

                //si le montant avance est inferieur au montant du, on met est est_atteint à 0
                if ($request->get('montant_du') > 0) {
                    $avancePaiement->setEstAtteint(false);

                    //on met aussi le est_atteint à false car il reste encore des sous a payer
                    $paiement->setEstAcheve(false);
                } else if ($request->get('montant_du') == 0) {
                    $avancePaiement->setEstAtteint(true);
                    //On change l'etat du paiement, il est atteint et plus besoin des avances
                    $paiement->setEstAcheve(true);
                }

                //on met à jour le montant du (devoir) dans paiement
                //car c'est lui que nous utilisons pour le remplissage de l'avance
                $paiement->setProjet($projet)
                    ->setMontantDu($request->get('montant_du'));

                #validons l'insertion et la modiification#
                //Inserons l'avance
                $this->em->persist($avancePaiement);
                //modifions le montant du de table paiement
                $this->em->persist($paiement);
                //validons le commit
                $this->em->flush();

                $response = 'success';
            } else {
                $response = 'failed';
            }
            return new JsonResponse($response);
        }
        /* $form = $this->createForm(AvancePaiementType::class, $avancePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avancePaiement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestion_projet_avance_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/avance_paiement/new.html.twig', [
            'avance_paiement' => $avancePaiement,
            'form' => $form,
        ]);
 */
    }

    /**
     * @Route("/{id}", name="avance_paiement_show", methods={"GET"})
     */
    public function show(AvancePaiement $avancePaiement): Response
    {
        return $this->render('admin/gestion_projet/avance_paiement/show.html.twig', [
            'avance_paiement' => $avancePaiement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="avance_paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AvancePaiement $avancePaiement): Response
    {
        $form = $this->createForm(AvancePaiementType::class, $avancePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_projet_avance_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/avance_paiement/edit.html.twig', [
            'avance_paiement' => $avancePaiement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/avance/{id<\d+>}/projet/{id_projet<\d+>}", name="avance_paiement_delete", methods={"GET","POST"})
     */
    public function delete(
        Request $request,
        AvancePaiement $avancePaiement,
        AvancePaiementRepository $avancePaiementRepository,
        ProjetRepository $projetRepository
    ): Response {
        if (
            $request->request->get('del_avance') &&
            $request->request->get('del_avance') == 'del_avance' &&
            $request->request->get('id_avance') &&
            !empty($request->request->get('id_avance')) &&
            $request->request->get('id_projet') &&
            !empty($request->request->get('id_projet'))

        ) {

            #trouvons le projet avec son repo
            $projet = $projetRepository->find($request->request->get('id_projet'));

            #toutes les avances du paiemnt actuel 
            $les_avances_recus = $avancePaiementRepository->allAvanceForPaiement($projet->getPaiement()->getId());

            #recuperons la dernière avance inseree pour ce projet,
            #la fonction end() permet de le faire
            $derniere_avance_inserere = end($les_avances_recus);
            $derniere_avance_inserere->getMontantDu();
            $derniere_avance_inserere->getId();


            #recuperons la valeur du montant avance de l'element à supprimer
            $m_avance_supprimer = $avancePaiement->getMontantAvance();

            #SI l'element à supprimer est la dernbiere avance de ce projet
            #alors, le montant du de l'avant derniere avance de ce projet sera 
            #mise à jour dans montant du de paiment et apres on supprimer 
            #l'avance dont il est question

            #si c'est une avance quelconque de ce projet, on recupere simplement le montant qui etait
            #avncé (montant_avance) on l'ajoute au montant du de la dernière avance de ce projet
            #on met à jour aussi ce montant du dans la table paiement

            if ($request->request->get('id_avance') == $derniere_avance_inserere->getId()) {
                #dans la liste des avances de ce paiement, on va prendre l'avant dernière avance

                #nous allons utiliser array_slice pour avoir l'avant dernier element du tableaux des avances
                $avant_derniere_avance =  array_slice($les_avances_recus, count($les_avances_recus) - 2, 1);
                foreach ($avant_derniere_avance as $avance) {
                    $last_id = $avance->getId();

                    $avant_dernier_montant_du = $avance->getMontantDu();
                }

                #on met à jour le montant du de la table paiement

                $paiement = $projet->getPaiement();
                $paiement->setMontantDu($avant_dernier_montant_du);

                #on persist
                $this->em->persist($paiement);
            } else { #si c'est n'importe quelle ligne selectionner sauf la derniere avance
                #on met à jour la valeur de la derniere avance
                $derniere_avance_inserere = end($les_avances_recus);
                $derniere_avance_inserere->setMontantDu($derniere_avance_inserere->getMontantDu() +  $m_avance_supprimer);

                #on met aussi a jour le montant du de la table paiement car c'est lui que nous utilisons
                $paiement = $projet->getPaiement();
                $paiement->setMontantDu($derniere_avance_inserere->getMontantDu() +  $m_avance_supprimer);

                #on persit la mise a jour des deux montants du (paiement et avance paiement)
                $this->em->persist($derniere_avance_inserere);
                $this->em->persist($paiement);
            }

            #on supprime maintenant l'avance en question
            #quel que soit sa position
            $this->em->remove($avancePaiement);

            //dump('Apres insertion, derniere avance update '.$derniere_avance_inserere->getMontantDu());
            //dump('Apres insertion, Paiement montant du update '.$paiement->getMontantDu());
            #on valide les commit en base de données
            $this->em->flush();

            $response = 'success';
        } else {
            $response = 'failed';
        }
        return new JsonResponse($response);

        /* if ($this->isCsrfTokenValid('delete' . $avancePaiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($avancePaiement);
            $entityManager->flush();
        } */

        return $this->redirectToRoute('avance_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
}
