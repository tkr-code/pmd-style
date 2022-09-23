<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\AvancePaiement;
use App\Entity\Paiement;
use App\Entity\Projet;
use App\Form\AvancePaiementType;
use App\Repository\AvancePaiementRepository;
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
        return $this->render(
            'admin/gestion_projet/avance_paiement/index.html.twig',
            [
                'avance_paiements' => $avancePaiementRepository->findBy(['paiement'=>$projet->getPaiement()]),
                'id_projet' => $projet->getId()
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
     * @Route("/{id}", name="avance_paiement_delete", methods={"POST"})
     */
    public function delete(Request $request, AvancePaiement $avancePaiement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $avancePaiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($avancePaiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestion_projet_avance_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
}
