<?php

namespace App\Controller\Admin;

use App\Repository\CahierChargeRepository;
use App\Service\CaisseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translatorInterface)
    {
        $this->translator = $translatorInterface;
    }
    /**
     * @Route("/admin/", name="admin")
     */
    public function index(CahierChargeRepository $cahierChargeRepository, CaisseService $caisseService): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $cahierCharges = $cahierChargeRepository->findBy(
            [],['id'=>'DESC'],10
        );
        return $this->render('admin/index.html.twig',[
            'parent_page'=>$this->translator->trans('Dashboard'),
            'cahierCharges'=>$cahierCharges,
            'totalCaisse'=>$caisseService->total()
        ]);
    }
    /**
     * @Route("/admin/blank", name="admin_blank_index")
     */
    public function blank(): Response
    {
        return $this->render('admin/blank.html.twig',[
            'parent_page'=>$this->translator->trans('Dashboard')
        ]);
    }
}
