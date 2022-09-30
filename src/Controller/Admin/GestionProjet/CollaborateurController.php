<?php

namespace App\Controller\Admin\GestionProjet;

use App\Entity\AddTacheCollection;
use App\Entity\Projet;
use App\Entity\Collaborateur;
use App\Entity\EditCollaborateur;
use App\Entity\Tache;
use App\Form\AddTacheCollectionType;
use App\Form\CollaborateurType;
use App\Form\EditCollaborateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CollaborateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/gestion-projet/collaborateur")
 */
class CollaborateurController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/projet/{id<\d+>}/col", name="collaborateur_index", methods={"GET","POST"})
     */
    public function index(CollaborateurRepository $collaborateurRepository, Projet $projet): Response
    {
        return $this->render('admin/gestion_projet/collaborateur/index.html.twig', [
            'collaborateurs' => $collaborateurRepository->findBy(['projet' => $projet->getId()]),
            'projet' => $projet
        ]);
    }

    /**
     * @Route("/new/{id<\d+>}/col", name="collaborateur_new", methods={"GET","POST"})
     */
    public function new(Request $request, Projet $projet): Response
    {
        $collaborateur = new Collaborateur();
        $form = $this->createForm(CollaborateurType::class, $collaborateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on definit le projet sur lequel il travail
            $collaborateur->setProjet($projet);

            $this->em->persist($collaborateur);
            $this->em->flush();

            return $this->redirectToRoute('collaborateur_index', ['id' => $projet->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/collaborateur/new.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
            'projet' => $projet
        ]);
    }

    /**
     * @Route("/{id}", name="collaborateur_show", methods={"GET"})
     */
    public function show(Collaborateur $collaborateur): Response
    {
        return $this->render('admin/gestion_projet/collaborateur/show.html.twig', [
            'collaborateur' => $collaborateur,
            'projet' => $collaborateur->getProjet(),
            'taches' => $collaborateur->getTache(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collaborateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Collaborateur $collaborateur): Response
    {
        #recuperosn le projet, il esr dans collaborateur
        $projet = $collaborateur->getProjet();

        #creons un objet pour modifier uniquement les infos du collaborateur sauf les taches
        $monCollaborateur = new EditCollaborateur();
        $monCollaborateur->setNom($collaborateur->getPersonneGestion()->getNom());
        $monCollaborateur->setPrenom($collaborateur->getPersonneGestion()->getPrenom());
        $monCollaborateur->setAdresse($collaborateur->getPersonneGestion()->getAdresse());
        $monCollaborateur->setPhone($collaborateur->getPersonneGestion()->getPhone());
        $monCollaborateur->setTitre($collaborateur->getPersonneGestion()->getTitre());
        $monCollaborateur->setEmail($collaborateur->getPersonneGestion()->getEmail());
        $monCollaborateur->setAvatar($collaborateur->getPersonneGestion()->getAvatar());
        $monCollaborateur->setApport($collaborateur->getApport());
        $monCollaborateur->setNiveauExcellence($collaborateur->getNiveauExcellence());

        $formCollaborateur = $this->createForm(EditCollaborateurType::class, $monCollaborateur);
        $formCollaborateur->handleRequest($request);

        if ($formCollaborateur->isSubmitted() && $formCollaborateur->isValid()) {

            if (
                !empty($request->request->get('edit_collaborateur')['nom']) &&
                !empty($request->request->get('edit_collaborateur')['prenom']) &&
                !empty($request->request->get('edit_collaborateur')['phone']) &&
                !empty($request->request->get('edit_collaborateur')['adresse']) &&
                !empty($request->request->get('edit_collaborateur')['Titre']) &&
                !empty($request->request->get('edit_collaborateur')['email']) &&
                !empty($request->request->get('edit_collaborateur')['apport']) &&
                !empty($request->request->get('edit_collaborateur')['niveauExcellence'])
            ) {
                #on fait la modification
                $collaborateur->getPersonneGestion()->setNom($formCollaborateur["nom"]->getData());
                $collaborateur->getPersonneGestion()->setPrenom($formCollaborateur["prenom"]->getData());
                $collaborateur->getPersonneGestion()->setPhone($formCollaborateur["phone"]->getData());
                $collaborateur->getPersonneGestion()->setAdresse($formCollaborateur["adresse"]->getData());
                $collaborateur->getPersonneGestion()->setTitre($formCollaborateur["Titre"]->getData());
                $collaborateur->getPersonneGestion()->setEmail($formCollaborateur["email"]->getData());
                //$collaborateur->getPersonneGestion()->setAvatar($formCollaborateur["avatar"]->getData());
                #je vais mettre l'image à null je les gerererai à la fin
                $collaborateur->getPersonneGestion()->setAvatar(null);

                $collaborateur->setApport($formCollaborateur["apport"]->getData());
                $collaborateur->setNiveauExcellence($formCollaborateur["niveauExcellence"]->getData());

                #je persist et valide la modification
                $this->em->persist($collaborateur);
                $this->em->flush();

                $this->addFlash(
                    'success',
                    'Modification reussie !'
                );
                return $this->redirectToRoute('collaborateur_index', ['id' => $collaborateur->getProjet()->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        #l'ajout d'une ou plusieurs taches pendant la modification
        #en utilisant la collection
        $tacheCollection = new AddTacheCollection();
        $formTacheCollection = $this->createForm(AddTacheCollectionType::class, $tacheCollection);
        $formTacheCollection->handleRequest($request);

        if ($formTacheCollection->isSubmitted() && $formTacheCollection->isValid()) {
            //dd($formTacheCollection['tache'][0]->getData());
            //dd($formTacheCollection['tache'][0]->getData());
            //$tache = $formTacheCollection['tache'][0]->getData();
            //dd($tache->getDesignation());
            // dd($formTacheCollection['tache']->getData());
            //dd($formTacheCollection->getData());

            foreach ($formTacheCollection['tache']->getData() as  $Matache) {

                $tache = new Tache();
                $tache->setDesignation($Matache->getDesignation())
                    ->setDescription($Matache->getDescription())
                    ->setEtat($Matache->getEtat())
                    ->setDateAchevement($Matache->getDateAchevement())
                    ->setCollaborateur($collaborateur);
                $this->em->persist($tache);
                $this->em->flush();
            }

            $this->addFlash(
                'success',
                'Nouvelle (s) Tache (s) ajoutée avec succès !'
            );
            return $this->redirectToRoute('collaborateur_edit', ['id' => $collaborateur->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_projet/collaborateur/edit.html.twig', [
            'collaborateur' => $collaborateur,
            'taches' => $collaborateur->getTache(), #renvoie les taches du collaborateur
            'formCollaborateur' => $formCollaborateur,
            'formTacheCollection' => $formTacheCollection,
            'projet'=>$projet
        ]);
    }

    /**
     * @Route("/{id}/del", name="collaborateur_delete", methods={"POST","GET"})
     */
    public function delete(Request $request, Collaborateur $collaborateur): Response
    {
        if (
            $request->request->get('suppr_col') &&
            $request->request->get('suppr_col') == 'zimbissa' &&
            $request->request->get('suppr_id') &&
            !empty($request->request->get('suppr_id')) &&
            $request->request->get('suppr_id') == $collaborateur->getId()
        ) {
            $this->em->remove($collaborateur);
            $this->em->flush();
            $response = 'success';
        } else {
            $response = 'failed';
        }
        return new JsonResponse($response);
        //return $this->redirectToRoute('collaborateur_index', ['id' => $collaborateur->getProjet()->getId()], Response::HTTP_SEE_OTHER);
    }
}
