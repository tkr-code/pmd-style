<?php

namespace App\Controller\Admin\GestionRendezVous;

use App\Entity\ClientRDV;
use App\Entity\EditClientRDV;
use App\Form\ClientRDVType;
use App\Form\EditClientRDVType;
use App\Repository\ClientRDVRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/gestion/rdv/client")
 */
class ClientRDVController extends AbstractController
{
    /**
     * @Route("/", name="gestion_rendez_vous_client_index", methods={"GET"})
     */
    public function index(ClientRDVRepository $clientRDVRepository): Response
    {
        return $this->render('admin/gestion_rendez_vous/client_rdv/index.html.twig', [
            'client_r_d_vs' => $clientRDVRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="gestion_rendez_vous_client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $clientRDV = new ClientRDV();
        $form = $this->createForm(ClientRDVType::class, $clientRDV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clientRDV);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Rendez-vous créé avec succès !'
            );
            return $this->redirectToRoute('gestion_rendez_vous_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_rendez_vous/client_rdv/new.html.twig', [
            'client_r_d_v' => $clientRDV,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="gestion_rendez_vous_client_show", methods={"GET"})
     */
    public function show(ClientRDV $clientRDV): Response
    {
        return $this->render('admin/gestion_rendez_vous/client_rdv/show.html.twig', [
            'client_r_d_v' => $clientRDV,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="gestion_rendez_vous_client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClientRDV $clientRDV): Response
    {
        $monClient = new EditClientRDV();
        $monClient->setNom($clientRDV->getPersonneGestion()->getNom())
            ->setPrenom($clientRDV->getPersonneGestion()->getPrenom())
            ->setAdresse($clientRDV->getPersonneGestion()->getAdresse())
            ->setPhone($clientRDV->getPersonneGestion()->getPhone())
            ->setTitre($clientRDV->getPersonneGestion()->getTitre())
            ->setEmail($clientRDV->getPersonneGestion()->getEmail())
            ->setVille($clientRDV->getVille())
            ->setPays($clientRDV->getPays())
            ->setSociete($clientRDV->getSociete());
        $form = $this->createForm(EditClientRDVType::class, $monClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // dd($form->getData());
            //dd($form['societe']->getData());
            #on met a jour
            if (
                !empty($form['societe']->getData()) &&
                !empty($form['ville']->getData()) &&
                !empty($form['pays']->getData()) &&
                !empty($form['nom']->getData()) &&
                !empty($form['prenom']->getData()) &&
                !empty($form['phone']->getData()) &&
                !empty($form['titre']->getData()) &&
                !empty($form['email']->getData()) &&
                !empty($form['adresse']->getData())
            ) {
                $clientRDV->getPersonneGestion()->setNom($form['nom']->getData())
                    ->setPrenom($form['prenom']->getData())
                    ->setPhone($form['phone']->getData())
                    ->setTitre($form['titre']->getData())
                    ->setEmail($form['email']->getData())
                    ->setAdresse($form['adresse']->getData());
                $clientRDV->setSociete($form['societe']->getData())
                    ->setVille($form['ville']->getData())
                    ->setPays($form['pays']->getData());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($clientRDV);

                #on valide la modification
                $entityManager->flush();

                $this->addFlash(
                   'success',
                   'Informations du client modifiées avec succès'
                );

                return $this->redirectToRoute('gestion_rendez_vous_client_show', ['id' => $clientRDV->getId()], Response::HTTP_SEE_OTHER);

            }

        }

        return $this->renderForm('admin/gestion_rendez_vous/client_rdv/edit.html.twig', [
            'client' => $clientRDV,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="gestion_rendez_vous_client_delete", methods={"POST"})
     */
    public function delete(Request $request, ClientRDV $clientRDV): Response
    {
        if (
            $request->request->get('suppr_client') &&
            $request->request->get('suppr_client') == 'zimbissa_yawou' &&
            $request->request->get('id_supr') &&
            !empty($request->request->get('id_supr')) &&
            $request->request->get('id_supr') == $clientRDV->getId()
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($clientRDV);
            #je valide
            $entityManager->flush();

            $response = 'success';
        } else {
            $response = 'failed';
        }
        return new JsonResponse($response);

        //return $this->redirectToRoute('admin_gestion_rendez_vous_client_r_d_v_index', [], Response::HTTP_SEE_OTHER);
    }
}
