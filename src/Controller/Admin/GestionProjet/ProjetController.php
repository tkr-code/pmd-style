<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\AvancePaiement;
use App\Entity\Paiement;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gestion_projet_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="projet_delete", methods={"POST"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
