<?php

namespace App\Controller\Admin\GestionInvestissement;

use App\Entity\ContractantInvestissement;
use App\Entity\ContratInvestissement;
use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\ContractantInvestissementRepository;
use App\Repository\ContratInvestissementRepository;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-investissement/investissement")
 */
class InvestissementController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/{id<\d+>}/contractant", name="admin_gestion_investissement_index", methods={"GET"})
     */
    public function index(ContractantInvestissement $contractantInvestissement, InvestissementRepository $investissementRepository): Response
    {
        #recuperer le user connecté
        $user = $this->getUser();

        return $this->render('admin/gestion_investissement/investissement/index.html.twig', [
            //'investissements' => $investissementRepository->findAll(),
            'investissements' => $investissementRepository->findBy(
                ['contractantInvestissement' => $contractantInvestissement->getId()]
            ),
            'contractantInvestissement' => $contractantInvestissement
        ]);
    }

    /**
     * @Route("/{id<\d+>}/new", name="admin_gestion_investissement_new", methods={"GET","POST"})
     */
    public function new(Request $request, ContratInvestissementRepository $contratInvestissementRepository): Response
    {
        $investissement = new Investissement();
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            //dd($form['type']->getData());
            #on va remplir le contrat avec les infos de l'investissement
            $this->em->persist($investissement);

            foreach ($contratInvestissementRepository->lastInsertedIdDb() as  $value) {
                $last_id_contrat = $value['id'];
            }
            // dd($last_id_contrat);
            if (
                !empty($form['designation']->getData()) &&
                !empty($form['date_debut']->getData()) &&
                !empty($form['date_fin']->getData())
            ) {
                #pour le numero de contrat, je vais créer une fonction

                $contratInvestissement = new ContratInvestissement();
                $contratInvestissement->setDesignation($form['designation']->getData())
                    ->setDateDebut($form['date_debut']->getData())
                    ->setDateEcheance($form['date_fin']->getData());
                if ($last_id_contrat == null) {
                    #on demare à 1
                    $last_id_contrat = 1;
                    $contratInvestissement->setNumeroContrat('INVEST' . 'Num' . $last_id_contrat);
                } else {
                    #on ajoute + 1 pour avoir le meme id que le nouveau insert du contrat
                    $last_id_contrat = $last_id_contrat + 1;
                    $contratInvestissement->setNumeroContrat('INVEST' . 'Num' . $last_id_contrat);
                }

                #on insert le contrat
                $this->em->persist($contratInvestissement);

                $investissement->setContratInvestissement($contratInvestissement);
            }

            #valide l'insertion
            $this->em->flush();
            $this->addFlash(
                'success',
                'Investissement ajouté avec succès'
            );

            return $this->redirectToRoute('admin_gestion_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/investissement/new.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/contractant/{id_contractant<\d+>}", name="admin_gestion_investissement_show", methods={"GET"})
     */
    public function show(
        Investissement $investissement,
        $id_contractant,
        ContractantInvestissementRepository $contractantInvestissementRepository
    ): Response {
        $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);

        return $this->render('admin/gestion_investissement/investissement/show.html.twig', [
            'investissement' => $investissement,
            'contractantInvestissement' => $contractantInvestissement
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit/contractant/{id_contractant<\d+>}", name="admin_gestion_investissement_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Investissement $investissement,
        $id_contractant,
        ContractantInvestissementRepository $contractantInvestissementRepository
    ): Response {
        $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);

        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            #toutes modifications de l'investissement vas engendrer la modification du contrat de cet investissement
            $contratInvestissement = $investissement->getContratInvestissement();

            if (
                !empty($form['designation']->getData()) &&
                !empty($form['date_debut']->getData()) &&
                !empty($form['date_fin']->getData())
            ) {
                $contratInvestissement->setDesignation($form['designation']->getData())
                    ->setDateDebut($form['date_debut']->getData())
                    ->setDateEcheance($form['date_fin']->getData());

                #on met a jour le contrat
                $this->em->persist($contratInvestissement);

                #on met à jour l'investissement
                $this->em->persist($investissement);

                #on valide en base de donnees
                $this->em->flush();

                $this->addFlash(
                    'success',
                    'Investissement modifié avec succès'
                );
            }


            return $this->redirectToRoute(
                'admin_gestion_investissement_show',
                [
                    'id' => $investissement->getId(),
                    'id_contractant' => $contractantInvestissement->getId()
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/gestion_investissement/investissement/edit.html.twig', [
            'investissement' => $investissement,
            'contractantInvestissement' => $contractantInvestissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/contractant/{id_contractant<\d+>}/del", name="admin_gestion_investissement_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        Investissement $investissement,
        ContractantInvestissementRepository $contractantInvestissementRepository,
        $id_contractant
    ): Response {
        if (
            $contractantInvestissementRepository->find($id_contractant)

        ) {
            $contractantInvestissement = $contractantInvestissementRepository->find($id_contractant);
        }

        if (
            $request->request->get('supr_investis') &&
            $request->request->get('supr_investis') ==  $investissement->getId() &&
            $request->request->get('id_contractant') &&
            $request->request->get('id_contractant') == $contractantInvestissement->getId() &&
            $request->request->get('del_investi') &&
            $request->request->get('del_investi') == 'katoula_yawou'
        ) {
            $this->em->remove($investissement);
            $this->em->flush();

            $response = 'success';
        } else {
            $response = 'false';
        }
        return new JsonResponse($response);
        //return $this->redirectToRoute('admin_gestion_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
