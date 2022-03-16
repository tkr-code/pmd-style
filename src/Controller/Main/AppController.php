<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="main_app")
     */
    public function index(): Response
    {
        return $this->render('main/app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}
