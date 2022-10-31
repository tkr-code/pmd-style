<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\CentreFormation;
use App\Form\CentreFormationType;
use App\Repository\PointageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CentreFormationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $user = $this->getUser();
        return $this->render('admin/gestion_formation/centre_formation/index.html.twig', [
            //'centre_formations' => $centreFormationRepository->findAll(),
            'centre_formations' => $centreFormationRepository->findBy(['user' => $user->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="centre_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();

        $centreFormation = new CentreFormation();
        $form = $this->createForm(CentreFormationType::class, $centreFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $centreFormation->setUser($user);
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
     * @Route("/{id}/show", name="centre_formation_show", methods={"GET"})
     */
    public function show(CentreFormation $centreFormation, PointageRepository $pointageRepository): Response
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
            $user = $this->getUser();
            $centreFormation->setUser($user);
            $this->em->persist($centreFormation);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Informations du centre Mises à jour'
            );
            return $this->redirectToRoute('centre_formation_edit', ['id' => $centreFormation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/centre_formation/edit.html.twig', [
            'centre_formation' => $centreFormation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/del", name="centre_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, CentreFormation $centreFormation): Response
    {
        if (
            $request->request->get('centre_suppr') &&
            $request->request->get('centre_suppr') == 'zimibssa_yawou' &&
            $request->request->get('id_del') &&
            !empty($request->request->get('id_del')) &&
            $request->request->get('id_del') == $centreFormation->getId()

        ) {
            $this->em->remove($centreFormation);
            $this->em->flush();

            $response = 'success';
        } else {
            $response = 'failed';
        }

        return new JsonResponse($response);

        //return $this->redirectToRoute('centre_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
