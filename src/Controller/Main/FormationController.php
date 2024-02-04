<?php

namespace App\Controller\Main;

use App\Entity\Formations;
use App\Repository\FormationsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    #[Route('/formations', name: 'formations')]
    public function index(Request $request, PaginatorInterface $paginator, FormationsRepository $formationsRepository): Response
    {
        $pagination = $paginator->paginate(
            $formationsRepository->all(),
            $request->query->getInt('page',1),
            12
        );
        return $this->render('main/formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'formations' => $pagination,
        ]);
    }

    #[Route('/formations/{slug}/{id}', name: 'formations_show')]
    public function show(Formations $formation): Response
    {
        return $this->render('main/formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }
}
