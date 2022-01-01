<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    /**
     * @Route("/cv/{slug}/", name="cv_show")
     */
    public function index(string $slug): Response
    {
        switch ($slug) {
            case 'malick-tounkara':
                # malick tounkara
                $cv = [
                    'nom'=>'Tounkara',
                    'prenom'=>'Malick',
                    'photo'=>'malick-tounkara.jpg',
                    'poste'=>'Dévéloppeur Web',
                    'description'=>'Je suis un informaticien avec une connaissance holistique du développement et de la conception de logiciels.'
                ];
                break;
            case 'pepin':
                # pepin ngoulou
                break;
            case 'mamadou-dieme':
                # mamadou
                break;
            
            default:
                    return  $this->redirectToRoute('home');
                break;
        }
        return $this->render('main/cv/cv.html.twig', [
            'cv'=>$cv
        ]);
    }
}
