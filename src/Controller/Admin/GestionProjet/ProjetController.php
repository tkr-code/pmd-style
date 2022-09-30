<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\AvancePaiement;
use App\Entity\EditProjet;
use App\Entity\Paiement;
use App\Entity\Projet;
use App\Form\EditProjetType;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-projet/projet")
 */
class ProjetController extends AbstractController
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
     * @Route("/", name="projet_index", methods={"GET"})
     */
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('admin/gestion_projet/projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="projet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperons la valeur du paiement saisi
            $montant_verse = $projet->getPaiement()->getMontantVerse();
            $montant_du = $projet->getPaiement()->getMontantVerse();
            $date_paiement_avance = $projet->getPaiement()->getDatePaiement();
            $date_creation_avance = $projet->getPaiement()->getDatePaiement();
            //dd($request->request);
            //dd($montant_du);

            if ($montant_du > 0) {
                //on insert directement ce montant comme premier avance
                $avance = new AvancePaiement();
                $avance->setPaiement($projet->getPaiement())
                    ->setDateCreation($projet->getPaiement()->getDatePaiement())
                    ->setDateAvance($projet->getPaiement()->getDatePaiement())
                    ->setMontantAvance($projet->getPaiement()->getMontantVerse())
                    ->setMontantDu($projet->getPaiement()->getMontantDu())
                    ->setModePaiementAvance($projet->getPaiement()->getModePaiement())
                    ->setEstAtteint(false);
                $paiement = $projet->getPaiement();
                $paiement->setEstAcheve(false);
                $this->em->persist($avance);
            } else if ($montant_du == 0) {
                $paiement = $projet->getPaiement();
                $paiement->setEstAcheve(true);
            }
            $this->em->persist($projet);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Projet créé'
            );
            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="projet_show", methods={"GET"})
     */
    public function show(Projet $projet): Response
    {
        return $this->render('admin/gestion_projet/projet/show.html.twig', [
            'projet' => $projet,
            'client' => $projet->getClient(),
            'paiement' => $projet->getPaiement(),
            'collaborateurs' => $projet->getCollaborateur(),
            'avance_paiements' => $projet->getPaiement()->getAvance(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $editProjet = new EditProjet();
        #on remplit les champs a editer avant de le rendre
        $editProjet->setDesignation($projet->getDesignation())
            ->setDescription($projet->getDescription())
            ->setType($projet->getType())
            ->setEtat($projet->getEtat())
            ->setDateDebut($projet->getDateDebut())
            ->setDateFinPrevu($projet->getDateFinPrevu())
            ->setDateFinRealisation($projet->getDateFinRealisation());

        $form = $this->createForm(EditProjetType::class, $editProjet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            //dd($form['dateFinRealisation']->getData());

            if (
                !empty($form['designation']->getData()) &&
                !empty($form['description']->getData()) &&
                !empty($form['type']->getData()) &&
                !empty($form['dateDebut']->getData()) &&
                !empty($form['dateFinPrevu']->getData()) &&
                //!empty($form['dateFinRealisation']->getData()) &&
                !empty($form['etat']->getData())
            ) {
                $projet->setDesignation($form['designation']->getData())
                    ->setDescription($form['description']->getData())
                    ->setType($form['type']->getData())
                    ->setDateDebut($form['dateDebut']->getData())
                    ->setDateFinPrevu($form['dateFinPrevu']->getData())
                    ->setDateFinRealisation($form['dateFinRealisation']->getData())
                    ->setEtat($form['etat']->getData());
                $this->em->persist($projet);
                $this->em->flush();
                $this->addFlash(
                    'success',
                    'Les Informations du projet ont bien été mise à jour !'
                );

                return $this->redirectToRoute('projet_show', ['id' => $projet->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/gestion_projet/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/del", name="projet_delete", methods={"POST"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if (
            $request->request->get('projet_supr') &&
            $request->request->get('projet_supr') == 'katoula_projet' &&
            $request->request->get('id_projet') &&
            !empty($request->request->get('id_projet')) &&
            $request->request->get('id_projet') == $projet->getId()
        ) {
            $this->em->remove($projet);
            $this->em->flush();
            $response = 'success';
        } else {
            $response = 'failed';
        }
        return new JsonResponse($response);

        //return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
