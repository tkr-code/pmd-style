<?php

namespace App\Controller\Admin\GestionInvestissement;

use App\Entity\TemoinInvestissement;
use App\Form\TemoinInvestissementType;
use App\Repository\ContractantInvestissementRepository;
use App\Repository\InvestissementRepository;
use App\Repository\TemoinInvestissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-investissement/temoin/investissement")
 */
class TemoinInvestissementController extends AbstractController
{
    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}", name="admin_gestion_temoin_investissement_index", methods={"GET"})
     */
    public function index(
        TemoinInvestissementRepository $temoinInvestissementRepository,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository
    ): Response {
        if (
            $contractantInvestissementRepository->find($id_contractant)
            &&
            $investissementRepository->find($id_invest)
        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
            $investissement = $investissementRepository->find($id_invest);
        }

        return $this->render('admin/gestion_investissement/temoin_investissement/index.html.twig', [
            //'temoin_investissements' => $temoinInvestissementRepository->findAll(),
            'temoin_investissements' => $temoinInvestissementRepository->findBy(['investissement' => $investissement]),
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/new", name="admin_gestion_temoin_investissement_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository
    ): Response {
        if (
            $contractantInvestissementRepository->find($id_contractant)
            &&
            $investissementRepository->find($id_invest)
        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
            $investissement = $investissementRepository->find($id_invest);
        }
        $temoinInvestissement = new TemoinInvestissement();
        $form = $this->createForm(TemoinInvestissementType::class, $temoinInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            #je met l'investissement
            $temoinInvestissement->setInvestissement($investissement);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($temoinInvestissement);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Un Témoins a été ajouté avec succès'
            );

            return $this->redirectToRoute(
                'admin_gestion_temoin_investissement_index',
                [
                    'id_contractant' => $contractantInvestissement->getId(),
                    'id_invest' => $investissement->getId()
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/gestion_investissement/temoin_investissement/new.html.twig', [
            'temoin_investissement' => $temoinInvestissement,
            'form' => $form,
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/show/{id<\d+>}", name="admin_gestion_temoin_investissement_show", methods={"GET"})
     */
    public function show(
        TemoinInvestissement $temoinInvestissement,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository
    ): Response {
        if (
            $contractantInvestissementRepository->find($id_contractant)
            &&
            $investissementRepository->find($id_invest)
        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
            $investissement = $investissementRepository->find($id_invest);
        }

        return $this->render('admin/gestion_investissement/temoin_investissement/show.html.twig', [
            'temoin_investissement' => $temoinInvestissement,
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/edit/{id<\d+>}", name="admin_gestion_temoin_investissement_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        TemoinInvestissement $temoinInvestissement,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository
    ): Response {
        if (
            $contractantInvestissementRepository->find($id_contractant)
            &&
            $investissementRepository->find($id_invest)
        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
            $investissement = $investissementRepository->find($id_invest);
        }

        $form = $this->createForm(TemoinInvestissementType::class, $temoinInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Temoin modifié avec succès'
            );

            return $this->redirectToRoute(
                'admin_gestion_temoin_investissement_show',
                [
                    'id_contractant' => $contractantInvestissement->getId(),
                    'id_invest' => $investissement->getId(),
                    'id' => $temoinInvestissement->getId()
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/gestion_investissement/temoin_investissement/edit.html.twig', [
            'temoin_investissement' => $temoinInvestissement,
            'form' => $form,
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/del/{id<\d+>}", name="admin_gestion_temoin_investissement_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository,
        TemoinInvestissement $temoinInvestissement
    ): Response {
        if (
            $contractantInvestissementRepository->find($id_contractant)
            &&
            $investissementRepository->find($id_invest)
        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
            $investissement = $investissementRepository->find($id_invest);
        }

        #verifications des element à supprimer
        if (
            $request->request->get('del_temoin') &&
            $request->request->get('del_temoin') == 'katoula_yawou' &&
            $request->request->get('supr_temoin') &&
            $request->request->get('supr_temoin')  ==  $temoinInvestissement->getId() &&
            $request->request->get('id_contractant') &&
            $request->request->get('id_contractant') == $contractantInvestissement->getId() &&
            $request->request->get('id_ivesti') &&
            $request->request->get('id_ivesti') == $investissement->getId()
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($temoinInvestissement);

            $entityManager->flush();
            $response = 'success';
        } else {
            $response = 'false';
        }

        return new JsonResponse($response);
        //return $this->redirectToRoute('admin_gestion_investissement_temoin_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
