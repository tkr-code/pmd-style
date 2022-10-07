<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\CentreFormation;
use App\Form\CentreFormationType;
use App\Repository\CentreFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/centre")
 */
class CentreFormationController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="centre_formation_index", methods={"GET"})
     */
    public function index(CentreFormationRepository $centreFormationRepository): Response
    {
        return $this->render('admin/gestion_formation/centre_formation/index.html.twig', [
            'centre_formations' => $centreFormationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="centre_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centreFormation = new CentreFormation();
        $form = $this->createForm(CentreFormationType::class, $centreFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $this->em->persist($centreFormation);
            $this->em->flush();

            return $this->redirectToRoute('centre_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/centre_formation/new.html.twig', [
            'centre_formation' => $centreFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centre_formation_show", methods={"GET"})
     */
    public function show(CentreFormation $centreFormation): Response
    {
        return $this->render('admin/gestion_formation/centre_formation/show.html.twig', [
            'centre_formation' => $centreFormation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centre_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CentreFormation $centreFormation): Response
    {
        $form = $this->createForm(CentreFormationType::class, $centreFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('centre_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/centre_formation/edit.html.twig', [
            'centre_formation' => $centreFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centre_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, CentreFormation $centreFormation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centreFormation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($centreFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centre_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
