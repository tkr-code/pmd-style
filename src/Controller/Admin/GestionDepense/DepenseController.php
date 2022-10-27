<?php

namespace App\Controller\Admin\GestionDepense;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/gestion-depense")
 */
class DepenseController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="gestion_depense_index", methods={"GET"})
     */
    public function index(DepenseRepository $depenseRepository): Response
    {
        #dans twig, on passera par app.user
        #on affiche le curent user si y en a directement depuis le controler
        $user = $this->getUser();

        return $this->render('admin/gestion_depense/depense/index.html.twig', [
            'depenses' => $depenseRepository->findBy(['user'=>$user->getId()]),
            //'user'=>$user->getId().' est '.$user->getEmail()
        ]);
    }

    /**
     * @Route("/new", name="gestion_depense_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        #le user actuel est : $user = $this->getUser();
        $user = $this->getUser();

        $depense = new Depense();
        $form = $this->createForm(DepenseType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on met le user
            $depense->setUser($user);

            $this->em->persist($depense);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Nouvelle dépense ajoutée'
            );
            return $this->redirectToRoute('gestion_depense_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_depense/depense/new.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="gestion_depense_show", methods={"GET"})
     */
    public function show(Depense $depense): Response
    {
        return $this->render('admin/gestion_depense/depense/show.html.twig', [
            'depense' => $depense,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="gestion_depense_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Depense $depense): Response
    {
        #on peut ne pas mettre le user
        #le user actuel est : $user = $this->getUser();
        $user = $this->getUser();

        $form = $this->createForm(DepenseType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash(
                'success',
                'Dépense modifiée avec succès'
            );
            return $this->redirectToRoute('gestion_depense_show', ['id' => $depense->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('admin/gestion_depense/depense/edit.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="gestion_depense_delete", methods={"POST"})
     */
    public function delete(Request $request, Depense $depense): Response
    {

        if (
            $request->request->get('suppr_depense') &&
            $request->request->get('suppr_depense') == 'zimbissa_yawou' &&
            $request->request->get('id_supr') &&
            !empty($request->request->get('id_supr')) &&
            $request->request->get('id_supr') == $depense->getId()
        ) {
            $this->em->remove($depense);
            #je valide
            $this->em->flush();

            $response = 'success';
        } else {
            $response = 'failed';
        }
        return new JsonResponse($response);
        // return $this->redirectToRoute('admin_gestion_depense_depense_index', [], Response::HTTP_SEE_OTHER);
    }
}
