<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="cours")
     */
    public function index(): Response
    {
        return $this->render('main/cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
}
