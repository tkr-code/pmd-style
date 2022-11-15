<?php

namespace App\Controller\Admin\GestionInvestissement;

use App\Entity\RetourInvestissement;
use App\Form\RetourInvestissementType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InvestissementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RetourInvestissementRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ContractantInvestissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/gestion-investissement/retour/investissement")
 */
class RetourInvestissementController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}", name="admin_gestion_retour_investissement_index", methods={"GET"})
     */
    public function index(
        RetourInvestissementRepository $retourInvestissementRepository,
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

        #recuperer la sommes des retour inestissement d ' un investissement
        foreach ($retourInvestissementRepository->sommmeRetourInvestissement($investissement->getId()) as  $value) {
            if ($value['total_retour'] == null) {
                $somme_investissement = 0;
            } else {
                $somme_investissement = $value['total_retour'];
            }
        }

        #calcul pour savoir si vous avez fait du benefices sur cet investissement
        if (
            $investissement->getMontantInvestissement() == $somme_investissement

        ) {
            #on aura deja recuperer la somme investie
            $benefice = 0;
        } else if (
            $investissement->getMontantInvestissement() < $somme_investissement
        ) {
            #on a recuperer la somme investie et on fait un benefice
            $benefice = $somme_investissement - $investissement->getMontantInvestissement();
        } else {
            #on a pas encore recuperer le montant investi et pas de benefice
            $benefice = 0;
        }

        return $this->render('admin/gestion_investissement/retour_investissement/index.html.twig', [
            //'retour_investissements' => $retourInvestissementRepository->findAll(),
            'retour_investissements' => $retourInvestissementRepository->findBy(['investissement' => $investissement->getId()]),
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement,
            'benefice' => $benefice,
            'somme_investissement' => $somme_investissement

        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/new", name="admin_gestion_retour_investissement_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository,
        RetourInvestissementRepository $retourInvestissementRepository
    ): Response {

        if (
            $contractantInvestissementRepository->find($id_contractant)
            &&
            $investissementRepository->find($id_invest)
        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
            $investissement = $investissementRepository->find($id_invest);
        }

        #recuperer la sommes des retour inestissement d ' un investissement
        foreach ($retourInvestissementRepository->sommmeRetourInvestissement($investissement->getId()) as  $value) {
            if ($value['total_retour'] == null) {
                $somme_investissement = 0;
            } else {
                $somme_investissement = $value['total_retour'];
            }
        }

        $retourInvestissement = new RetourInvestissement();
        $form = $this->createForm(RetourInvestissementType::class, $retourInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($investissement->getMontantInvestissement() == $somme_investissement) {
                $retourInvestissement->setEstRecuperer(true);
            } else {
                $retourInvestissement->setEstRecuperer(false);
            }
            #on ajoute l'investissement
            $retourInvestissement->setInvestissement($investissement);

            $this->em->persist($retourInvestissement);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Un Retour sur investissement a été enregistré avec succès !'
            );

            return $this->redirectToRoute(
                'admin_gestion_retour_investissement_index',
                [
                    'id_contractant' => $contractantInvestissement->getId(),
                    'id_invest' => $investissement->getId()
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/gestion_investissement/retour_investissement/new.html.twig', [
            'retour_investissement' => $retourInvestissement,
            'form' => $form,
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/show/{id<\d+>}", name="admin_gestion_retour_investissement_show", methods={"GET"})
     */
    public function show(
        RetourInvestissement $retourInvestissement,
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

        return $this->render('admin/gestion_investissement/retour_investissement/show.html.twig', [
            'retour_investissement' => $retourInvestissement,
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/edit/{id<\d+>}", name="admin_gestion_retour_investissement_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        RetourInvestissement $retourInvestissement,
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

        $form = $this->createForm(RetourInvestissementType::class, $retourInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $retourInvestissement->setInvestissement($investissement);
            $this->em->persist($retourInvestissement);
            $this->em->flush();

            $this->addFlash(
                'success',
                'modification reussie, retour investissement mis à jour'
            );
            return $this->redirectToRoute('admin_gestion_retour_investissement_index', [
                'id_contractant' => $contractantInvestissement->getId(),
                'id_invest' => $investissement->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/retour_investissement/edit.html.twig', [
            'retour_investissement' => $retourInvestissement,
            'form' => $form,
            'contractantInvestissement' => $contractantInvestissement,
            'investissement' => $investissement
        ]);
    }

    /**
     * @Route("/{id_contractant<\d+>}/invest/{id_invest<\d+>}/del/{id<\d+>}", name="admin_gestion_retour_investissement_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        $id_contractant,
        $id_invest,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        InvestissementRepository $investissementRepository,
        RetourInvestissement $retourInvestissement
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
            $request->request->get('del_retour_invest') &&
            $request->request->get('del_retour_invest') == 'zimbissa_yawou' &&
            $request->request->get('supr_retour_investi') &&
            $request->request->get('supr_retour_investi')  ==  $retourInvestissement->getId() &&
            $request->request->get('id_contractant') &&
            $request->request->get('id_contractant') == $contractantInvestissement->getId() &&
            $request->request->get('id_investi') &&
            $request->request->get('id_investi') == $investissement->getId()
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($retourInvestissement);

            $entityManager->flush();
            $response = 'success';
        } else {
            $response = 'false';
        }

        return new JsonResponse($response);

        //return $this->redirectToRoute('admin_gestion_investissement_retour_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
