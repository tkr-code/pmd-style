<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\ContactType;
use App\Service\Email\EmailService;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(ContactRepository $contactRepository, MailerInterface $mailerInterface, Request $request, EmailService $emailService): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class,$contact);
        $contact = $form->handleRequest($request);
        $reCAPTCHA_secret_key="6LfDomMhAAAAAHVQGcmpEZUbJ-5XsGPq63w_7vw9";
        $g_recaptcha_response="";
        $ip = $_SERVER['REMOTE_ADDR'];
        $globaals = $this->get('twig')->getGlobals();

      if($form->isSubmitted() && $form->isValid()){
        $g_recaptcha_response = $request->request->get('g-recaptcha-response');
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
        . urlencode($reCAPTCHA_secret_key) . '&response=' 
        . urlencode($g_recaptcha_response) . '&remoteip=' 
        . urlencode($ip);
        $response = file_get_contents($url);
        $responeKey = json_decode($response,true);
        if($responeKey['success']){
          $email = (new TemplatedEmail())
          ->from($contact->get('email')->getData())
          ->to($globaals['site']['email'])
          ->subject('Contact depuis le site pmd developper')
          ->htmlTemplate('email/contact.html.twig')
          ->context([
            'theme'=>$emailService->theme(6),
            'name'=>$contact->get('name')->getData(),
            'mail'=>$contact->get('email')->getData(),
            'phone'=>$contact->get('phone_number')->getData(),
            'message'=>$contact->get('message')->getData(),
          ]);
          $mailerInterface->send($email);
          $contactRepository->add($contact);
          
          $this->addFlash('success','Email envoyé');
          return $this->redirectToRoute('contact', []);
        }elseif($responeKey['error-codes']){
          $this->addFlash('errors','Captcha invalide');
        }else{
          $this->addFlash('errors','Une erreur est survenu');
        }
      }
      return $this->renderForm('main/contact/contact.html.twig', [
        'form'=>$form
      ]);
    }
}