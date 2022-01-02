<?php

namespace App\Controller\Main;

use App\Entity\Cv;
use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    /**
     * @Route("/cv/{slug}", name="cv_show")
     */
    public function index(string $slug, CvRepository $cvRepository): Response
    {
       $cv = $cvRepository->findOneBy([
            'slug'=>$slug
        ]);
        if(!$cv){
           return $this->createNotFoundException();
        }
        return $this->render('main/cv/cv.html.twig', [
            'cv'=>$cv
        ]);
    }
}
