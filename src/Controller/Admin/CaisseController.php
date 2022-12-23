<?php

namespace App\Controller\Admin;

use App\Entity\Caisse;
use App\Form\CaisseType;
use App\Repository\CaisseRepository;
use App\Service\CaisseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my-account/caisse")
 */
class CaisseController extends AbstractController
{
    /**
     * @Route("/", name="admin_caisse_index", methods={"GET"})
     */
    public function index(CaisseRepository $caisseRepository, CaisseService $caisseService): Response
    {

        $pmd = $moh = $tkr= $lkp =0;
        foreach ($caisseRepository->findAll() as $key => $value) {
            if($value->getCode() == 'PMD'){
                $pmd += $value->getMontant();
            }elseif ($value->getCode() == 'TKR') {
                $tkr += $value->getMontant();
            }elseif ($value->getCode() == 'MOH') {
                $moh += $value->getMontant();
                
            }elseif ($value->getCode() == 'LKP') {
                $lkp += $value->getMontant();
            }
        }
        $caisses= [
            [
                'code'=>'pmd',
                'montant'=>$pmd
            ],
            [
                'code'=>'lkp',
                'montant'=>$lkp
            ],
            [
                'code'=>'moh',
                'montant'=>$moh
            ],
            [
                'code'=>'tkr',
                'montant'=>$tkr
            ],
            ];        
        return $this->render('admin/caisse/index.html.twig', [
            'caisses' => $caisses,
            'montantTotal'=>$caisseService->total()
        ]);
    }

    /**
     * @Route("/new", name="admin_caisse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $caisse = new Caisse();
        $form = $this->createForm(CaisseType::class, $caisse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $caisse->setMontant($caisse->getValeur());
            $entityManager->persist($caisse);
            $entityManager->flush();
            $this->addFlash('success',"L'enregistrement a été éffectué avec succès.");
            return $this->redirectToRoute('admin_caisse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/caisse/new.html.twig', [
            'caisse' => $caisse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{code}", name="admin_caisse_show", methods={"GET"})
     */
    public function show(CaisseRepository $caisseRepository, string $code): Response
    {
        $caisses = $caisseRepository->findBy([
            'code'=>$code
        ]);
        $montantTotal = 0;
        
        foreach ($caisses as $key => $value) {
            $montantTotal += $value->getValeur(); 
        }
        return $this->render('admin/caisse/show.html.twig', [
            'caisses' => $caisses,
            'montantTotal'=>$montantTotal
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_caisse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caisse $caisse): Response
    {
        $form = $this->createForm(CaisseType::class, $caisse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $caisse->setMontant($caisse->getValeur());
            $this->getDoctrine()->getManager()->flush($caisse);
            $this->addFlash('success','Modification réussie.');
            return $this->redirectToRoute('admin_caisse_show', ['code'=> strtolower($caisse->getCode())], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/caisse/edit.html.twig', [
            'caisse' => $caisse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_caisse_delete", methods={"POST"})
     */
    public function delete(Request $request, Caisse $caisse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caisse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caisse);
            $entityManager->flush();
            $this->addFlash('success',"L'enregistrement a été supprimé avec succès.");
        }
        return $this->redirectToRoute('admin_caisse_show', ['code'=>strtolower($caisse->getCode())], Response::HTTP_SEE_OTHER);
    }
}
