<?php

namespace App\Controller\Main;

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
    /**
     * @Route("/cours/initiation_a_l_algorithmique", name="cour_initiation_a_l_algorithmique")
     */
    public function show(): Response
    {
        return $this->render('main/cours/initiation_a_l_algorithmique.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
}
