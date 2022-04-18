<?php

namespace App\Controller\Main;

use App\Entity\CahierCharge;
use App\Entity\ReponseCahierCharge;
use App\Repository\QuestionCahierChargeRepository;
use App\Repository\ReponseCahierChargeRepository;
use App\Service\CahierChargeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CahierChargeController extends AbstractController
{
    /**
     * @Route("/cahier-de-charge", name="cahier_charge_index")
     */
    public function index(QuestionCahierChargeRepository $questionCahierChargeRepository): Response
    {
        return $this->render('main/cahier_charge/index.html.twig', [
            'questions'=>$questionCahierChargeRepository->findAll()
        ]);
    }
    /**
     * @Route("/cahier-de-charge/success", name="cahier_charge_success")
     */
    public function success(QuestionCahierChargeRepository $questionCahierChargeRepository): Response
    {
        return $this->render('main/cahier_charge/success.html.twig', []);
    }
    /**
     * @Route("cahier-de-charge/new", name="cahier_charge_new")
     */
    public function new(Request $request,CahierChargeService $cahierChargeService, QuestionCahierChargeRepository $questionCahierChargeRepository):Response
    {
        if(!empty($request->request)){
            $cahierCharge = new CahierCharge();
            $cahierCharge->setFullName($request->request->get('fullName'));
            $cahierCharge->setEmail($request->request->get('email'));
            $cahierCharge->setTel($request->request->get('tel'));
            $cahierCharge->setStatus('En attente');
            $cahierCharge->setNumber($cahierChargeService->nextNumber());
            //QUESTION  1 START
            $reponse1 = new ReponseCahierCharge();
            $r1 = '';
            $reponse1->setQuestion($questionCahierChargeRepository->findOneBy([
                'number'=>1
            ]));
            if(!empty($request->request->get('mobile'))){
                $r1 .= 'Application mobile : '. $request->request->get('mobile'). ', '; 
            }
            if(!empty($request->request->get('web-app'))){
                $r1 .='Application web : '. $request->request->get('web-app'). ', '; 
            }
            if(!empty($request->request->get('bureau-app'))){
                $r1 .='Application de bureau : '. $request->request->get('bureau-app'). ', '; 
            }
            if(!empty($request->request->get('app-web-autre-text'))){
                $r1 .='Autre application  web : '. $request->request->get('app-web-autre-text'); 
            }
            if(!empty($request->request->get('bureau-autre-text'))){
                $r1 .='Autre Application : '. $request->request->get('bureau-autre-text'); 
            }
            if(!empty($request->request->get('erp'))){
                $r1 .="ERP : ERP ( application d’entreprise)"; 
            }
            if(!empty($request->request->get('autre-question-1-text'))){
                $r1 .= 'Autre '. $request->request->get('autre-question-1-text');
            }
            $reponse1->setReponse($r1);
            $cahierCharge->addReponse($reponse1);
            //  QUESTION 1 END
            //  QUESTION 2 START
            if(!empty($request->request->get('q2'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>2
                ]));
                $reponse->setReponse($request->request->get('q2'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 2 END
            //  QUESTION 3 START
            if(!empty($request->request->get('q3'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>3
                ]));
                $reponse->setReponse($request->request->get('q3'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 3 END
            //  QUESTION 4 START
            if(!empty($request->request->get('q4'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>4
                ]));
                $reponse->setReponse($request->request->get('q4'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 4 END
            //  QUESTION 5 START
            if(!empty($request->request->get('q5'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>5
                ]));
                $reponse->setReponse($request->request->get('q5'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 5 END
            //  QUESTION 6 START
            $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>6
                ]));
            $r1 ='';
            if(!empty($request->request->get('q6-0') )){
                $r1 .= $request->request->get('q6-0').', '; 
            }
            if(!empty($request->request->get('q6-1') )){
                $r1 .= $request->request->get('q6-1').', '; 
            }
            if(!empty($request->request->get('q6-2') )){
                $r1 .= $request->request->get('q6-2').', '; 
            }
            if(!empty($request->request->get('q6-3') )){
                $r1 .= $request->request->get('q6-3').', '; 
            }
            if(!empty($request->request->get('q6-4') )){
                $r1 .= $request->request->get('q6-4').', '; 
            }
            if(!empty($request->request->get('q6-5') )){
                $r1 .= $request->request->get('q6-5').', '; 
            }
            if(!empty($request->request->get('q6-6') )){
                $r1 .= $request->request->get('q6-6').', '; 
            }
            if(!empty($request->request->get('q6-7') )){
                $r1 .= $request->request->get('q6-7').', '; 
            }
            if(!empty($request->request->get('q6-8') )){
                $r1 .= $request->request->get('q6-8').', '; 
            }
            if(!empty($request->request->get('q6-9') )){
                $r1 .= $request->request->get('q6-9').', '; 
            }
            if(!empty($request->request->get('q6-10') )){
                $r1 .= $request->request->get('q6-10').''; 
            }
            $reponse->setReponse($r1);
            $cahierCharge->addReponse($reponse);
            //  QUESTION 6 END
            //  QUESTION 7 START
            if(!empty($request->request->get('q7'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>7
                ]));
                $reponse->setReponse($request->request->get('q7'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 7 END              
            //  QUESTION 8 START
            if(!empty($request->request->get('q8'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>8
                ]));
                $reponse->setReponse($request->request->get('q8'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 8 END              
            //  QUESTION 9 START
            if(!empty($request->request->get('q9'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>9
                ]));
                $reponse->setReponse($request->request->get('q9'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 9 END              
            //  QUESTION 10 START
            if(!empty($request->request->get('q10'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>10
                ]));
                $reponse->setReponse($request->request->get('q10'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 10 END              
            //  QUESTION 11 START
            if(!empty($request->request->get('q11'))){
                $reponse = new ReponseCahierCharge();
                $reponse->setQuestion($questionCahierChargeRepository->findOneBy([
                    'number'=>11
                ]));
                $reponse->setReponse($request->request->get('q11'));
                $cahierCharge->addReponse($reponse);            
            }
            //  QUESTION 11 END 
            
            //  INSERTION DU CAHIER DE CAHRGE EN BD
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cahierCharge);
            $entityManager->flush();
            return new JsonResponse('success');
        }
        return new JsonResponse('error');
    }
}
