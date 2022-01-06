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

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(MailerInterface $mailerInterface, Request $request, EmailService $emailService): Response
    {
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        $email = (new TemplatedEmail())
        ->from($contact->get('email')->getData())
        ->to('malick.tounkara.1@gmail.com')
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
        $this->addFlash('success','Email envoyé');
        return $this->redirectToRoute('contact', []);
      }
      return $this->renderForm('main/contact/contact.html.twig', [
        'form'=>$form
      ]);
    }
}