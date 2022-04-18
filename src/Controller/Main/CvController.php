<?php

namespace App\Controller\Main;

use App\Entity\Cv;
use App\Form\ContactType;
use App\Repository\CvRepository;
use App\Service\Email\EmailService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    /**
     * @Route("/cv/{slug}", name="cv_show")
     */
    public function index(EmailService $emailService, Request $request,MailerInterface $mailerInterface, string $slug, CvRepository $cvRepository): Response
    {
        $cv = $cvRepository->findOneBy([
             'slug'=>$slug
         ]);
         if(!$cv){
            return $this->createNotFoundException();
         }
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email  = (new TemplatedEmail())
            ->from($contact->get('email')->getData())
            ->to($cv->getUser()->getEmail())
        ->subject('Contact depuis le site pmd developper')
        ->htmlTemplate('email/contact.html.twig')
        ->context([
          'theme'=>$emailService->theme(6),
          'name'=>$contact->get('name')->getData(),
          'mail'=>$contact->get('email')->getData(),
          'phone'=>$contact->get('phone_number')->getData(),
          'message'=>$contact->get('message')->getData(),
        ])
        ;
            $mailerInterface->send($email);
            $this->addFlash('success','Votre message a été  envoyé.');
            return $this->redirectToRoute('cv_show',['slug'=>$slug]);
        }

        return $this->renderForm('main/cv/cv.html.twig', [
            'cv'=>$cv,
            'form'=>$form
        ]);
    }
}
