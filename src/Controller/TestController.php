<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test_index')]
    public function index(): Response
    {
        $expiration = new \DateTime();
        $expiration->modify('+1 year');

        $cookie = Cookie::create('test','Malick',$expiration);

        $response = new Response();
        $response->headers->setCookie($cookie);
        $response->send();
        // $options['edit']=true;
        $optionEdit = empty($options['edit']) ? false:true;
        $required = $optionEdit == true ? true:false;
        dd($required);
        $pages = [
            [
                'path' => 'test_application',
                'name' => 'Application Mobile'
            ],
            [
                'path' => 'test_search',
                'name' => 'Page de recherche'
            ]
        ];
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'pages' => $pages
        ]);
    }

    #[Route('/test/applications', name: 'test_application')]
    public function applications(): Response
    {
        return $this->render('test/applications.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/test/search', name: 'test_search')]
    public function search(): Response
    {
        return $this->render('test/search.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
