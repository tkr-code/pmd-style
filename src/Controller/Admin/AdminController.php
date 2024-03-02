<?php

namespace App\Controller\Admin;

use App\Repository\CahierChargeRepository;
use App\Repository\FormationsRepository;
use App\Service\CaisseService;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/my-account")
 */
class AdminController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translatorInterface)
    {
        $this->translator = $translatorInterface;
    }
    /**
     * @Route("/", name="admin")
     */
    public function index(FormationsRepository $formationsRepository, CahierChargeRepository $cahierChargeRepository, CaisseService $caisseService): Response
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
            'totalCaisse'=>$caisseService->total(),
            'formations'=>$formationsRepository->findAll()
        ]);
    }
    /**
     * @Route("/analytics", name="admin_analytics")
     */
    public function analytics(): Response
    {
        $KEY_FILE_LOCATION = $this->getParameter('key_file_location');

        // $client = new Goo
        // $googleClient = new Google/Client();
        // dd($googleClient);
        // $googleClient->setApplicationName('Hello analitycs reports');
        // $googleClient->setDeveloperKey($KEY_FILE_LOCATION);
        return $this->render('admin/google/analytics.html.twig',[
        ]);
    }
        /**
     * @Route("/api", name="admin_api_index")
     */
    public function api(): Response
    {
        return $this->render('admin/api/index.html.twig',[
            'parent_page'=>"API"
        ]);
    }
    /**
     * @Route("/blank", name="admin_blank_index")
     */
    public function blank(): Response
    {
        return $this->render('admin/blank.html.twig',[
            'parent_page'=>$this->translator->trans('Dashboard')
        ]);
    }
}
