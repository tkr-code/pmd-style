<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\CentreFormation;
use App\Entity\ClasseFormation;
use App\Entity\FormationDispensee;
use App\Form\FormationDispenseeType;
use App\Repository\FormationDispenseeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/formation")
 */
class FormationDispenseeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="formation_dispensee_index", methods={"GET"})
     */
    public function index(FormationDispenseeRepository $formationDispenseeRepository): Response
    {
        return $this->render('admin/gestion_formation/formation_dispensee/index.html.twig', [
            'formation_dispensees' => $formationDispenseeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id<\d+>}/centre", name="formation_dispensee_new", methods={"GET","POST"})
     */
    public function new(Request $request, CentreFormation $centreFormation): Response
    {
        $formationDispensee = new FormationDispensee();
        $form = $this->createForm(FormationDispenseeType::class, $formationDispensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationDispensee->setEtat('En Cour');

            // dd($form->getData());
            //dd($request);
            // dd($request->request->get('formation_dispensee')['classe']['designation']);

            #recuperons la classe dont concerne le taux horaire
            if (
                $request->request->get('formation_dispensee')['classe']['designation'] &&
                $request->request->get('formation_dispensee')['classe']['niveauEtude'] &&
                $request->request->get('formation_dispensee')['classe']['nombreEtudiant'] &&
                !empty($request->request->get('formation_dispensee')['classe']['designation']) &&
                !empty($request->request->get('formation_dispensee')['classe']['niveauEtude']) &&
                !empty($request->request->get('formation_dispensee')['classe']['nombreEtudiant'])


            ) {
                #on persit la formation dispensee qui contient le taux hiraire
                $this->em->persist($formationDispensee);

                #on creer la classe
                $classe = new ClasseFormation();
                $classe->setFormationDispensee($formationDispensee)
                    ->setDesignation($request->request->get('formation_dispensee')['classe']['designation'])
                    ->setNiveauEtude($request->request->get('formation_dispensee')['classe']['niveauEtude'])
                    ->setNombreEtudiant($request->request->get('formation_dispensee')['classe']['nombreEtudiant'])
                    ->setAbreviation($request->request->get('formation_dispensee')['classe']['abreviation'])
                    ->setCentreFormation($centreFormation);
                #on persist la classe
                $this->em->persist($classe);
            }

            #on envoie dans la base de données
            $this->em->flush();

            return $this->redirectToRoute('centre_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/formation_dispensee/new.html.twig', [
            'formation_dispensee' => $formationDispensee,
            'form' => $form,
            'centre_formation' => $centreFormation
        ]);
    }

    /**
     * @Route("/{id}", name="formation_dispensee_show", methods={"GET"})
     */
    public function show(FormationDispensee $formationDispensee): Response
    {
        return $this->render('admin/gestion_formation/formation_dispensee/show.html.twig', [
            'formation_dispensee' => $formationDispensee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_dispensee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FormationDispensee $formationDispensee): Response
    {
        $form = $this->createForm(FormationDispenseeType::class, $formationDispensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_dispensee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/formation_dispensee/edit.html.twig', [
            'formation_dispensee' => $formationDispensee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_dispensee_delete", methods={"POST"})
     */
    public function delete(Request $request, FormationDispensee $formationDispensee): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formationDispensee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formationDispensee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_dispensee_index', [], Response::HTTP_SEE_OTHER);
    }
}
