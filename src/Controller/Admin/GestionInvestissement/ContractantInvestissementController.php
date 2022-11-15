<?php

namespace App\Controller\Admin\GestionInvestissement;

use App\Entity\Investissement;
use App\Entity\PersonneGestion;
use App\Entity\ContratInvestissement;
use App\Entity\MonContratInvestissement;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ContractantInvestissement;
use App\Form\ContractantInvestissementType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MonContractantInvestissementType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ContratInvestissementRepository;
use App\Repository\ContractantInvestissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/gestion-investissement/contractant/investissement")
 */
class ContractantInvestissementController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="admin_gestion_contractant_investissement_index", methods={"GET"})
     */
    public function index(ContractantInvestissementRepository $contractantInvestissementRepository): Response
    {
        $user = $this->getUser();

        return $this->render('admin/gestion_investissement/contractant_investissement/index.html.twig', [
            //'contractant_investissements' => $contractantInvestissementRepository->findAll(),
            'contractant_investissements' => $contractantInvestissementRepository->findBy(['user' => $user->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestion_contractant_investissement_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        ContratInvestissementRepository $contratInvestissementRepository
    ): Response {
        #ajout de l'utilisateur courant
        $user = $this->getUser();

        $MonContratInvestissement = new MonContratInvestissement();
        $form = $this->createForm(MonContractantInvestissementType::class, $MonContratInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($contratInvestissementRepository->lastInsertedIdDb() as  $value) {
                $last_id_contrat = $value['id'];
            }

            //dd($form['phone']->getData());
            //dd($request->request->get('personneGestion'));
            #verifions les champs si c'est bien remplis
            if (
                !empty($form['type']->getData()) &&
                !empty($form['date_debut']->getData()) &&
                !empty($form['dateFin']->getData()) &&
                !empty($form['designation']->getData()) &&
                !empty($form['description']->getData()) &&
                !empty($form['montantInvestissement']->getData()) &&
                !empty($form['ville']->getData()) &&
                !empty($form['pays']->getData()) &&
                !empty($form['codePostal']->getData()) &&
                !empty($form['nom']->getData()) &&
                !empty($form['prenom']->getData()) &&
                !empty($form['adresse']->getData()) &&
                !empty($form['phone']->getData()) &&
                !empty($form['titre']->getData()) &&
                !empty($form['email']->getData())

            ) {
                #on insert d'abord le contrat
                $contratInvestissement = new ContratInvestissement();
                $contratInvestissement->setDesignation($form['designation']->getData())
                    ->setDateDebut($form['date_debut']->getData())
                    ->setDateEcheance($form['dateFin']->getData());
                if ($last_id_contrat == null) {
                    #on demare à 1
                    $last_id_contrat = 1;
                    $contratInvestissement->setNumeroContrat('INVEST_' . 'Num_' . $last_id_contrat);
                } else {
                    #on ajoute + 1 pour avoir le meme id que le nouveau insert du contrat
                    $last_id_contrat = $last_id_contrat + 1;
                    $contratInvestissement->setNumeroContrat('INVEST_' . 'Num_' . $last_id_contrat);
                }
                $this->em->persist($contratInvestissement);

                #on cree la personne Gestion
                $personeGestion = new PersonneGestion();
                $personeGestion->setNom($form['nom']->getData())
                    ->setPrenom($form['prenom']->getData())
                    ->setAdresse($form['adresse']->getData())
                    ->setTitre($form['titre']->getData())
                    ->setEmail($form['email']->getData())
                    ->setPhone($form['phone']->getData())
                    ->setAvatar($form['avatar']->getData());


                #on insert le contractant (le partenaire)
                $contractantInvestissement = new ContractantInvestissement();
                $contractantInvestissement->setVille($form['ville']->getData())
                    ->setPays($form['pays']->getData())
                    ->setCodePostal($form['codePostal']->getData())
                    ->setPersonneGestion($personeGestion)
                    ->setUser($user);

                $this->em->persist($contractantInvestissement);

                #on créé l'investissement
                $investissement = new Investissement();
                $investissement->setType($form['type']->getData())
                    ->setDesignation($form['designation']->getData())
                    ->setDescription($form['description']->getData())
                    ->setMontantInvestissement($form['montantInvestissement']->getData())
                    ->setDateDebut($form['date_debut']->getData())
                    ->setDateFin($form['dateFin']->getData())
                    ->setContratInvestissement($contratInvestissement)
                    ->setContractantInvestissement($contractantInvestissement);

                $this->em->persist($investissement);

                $this->em->flush();
            } else {
                dd('erreur');
            }


            $this->addFlash(
                'success',
                'Un nouveau partenaire d\'investissement a été ajouté'
            );

            return $this->redirectToRoute('admin_gestion_contractant_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/contractant_investissement/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestion_contractant_investissement_show", methods={"GET"})
     */
    public function show(ContractantInvestissement $contractantInvestissement): Response
    {
        return $this->render('admin/gestion_investissement/contractant_investissement/show.html.twig', [
            'contractant_investissement' => $contractantInvestissement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestion_contractant_investissement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContractantInvestissement $contractantInvestissement): Response
    {
        $form = $this->createForm(ContractantInvestissementType::class, $contractantInvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Informations du partenaire modifiées avec succès'
            );

            return $this->redirectToRoute('admin_gestion_contractant_investissement_show', [
                'id' => $contractantInvestissement->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_investissement/contractant_investissement/edit.html.twig', [
            'contractant_investissement' => $contractantInvestissement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="admin_gestion_contractant_investissement_delete", methods={"POST"})
     */
    public function delete(Request $request, ContractantInvestissement $contractantInvestissement): Response
    {

        if (
            $request->request->get('supr_contractant') &&
            $request->request->get('supr_contractant') ==  $contractantInvestissement->getId() &&
            $request->request->get('del_contractant') &&
            $request->request->get('del_contractant') == 'zimbissa_yawou'
        ) {
            $this->em->remove($contractantInvestissement);
            $this->em->flush();

            $response = 'success';
        } else {
            $response = 'false';
        }
        return new JsonResponse($response);

        //return $this->redirectToRoute('admin_gestion_investissement_contractant_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
