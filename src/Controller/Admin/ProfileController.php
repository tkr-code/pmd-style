<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\ProfileType;
use App\Entity\Phone;
use App\Form\PhoneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\ChangePasswordFormType;
use App\Repository\PhoneRepository;
use App\Service\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

/**
 * @Route("my-account/profile")
 */
class ProfileController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    /**
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $user =  $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        return $this->renderForm('admin/profile/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new", name="profile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
        /**
     * @Route("/phone", name="profile_phone_index", methods={"GET"})
     */
    public function phoneIndex(PhoneRepository $phoneRepository): Response
    {        
        return $this->render('admin/profile/phone/index.html.twig', [
            'phones' =>$phoneRepository->findBy([
                        'user'=>$this->getUser()->getId(),
                    ])
        ]);
    }
       /**
     * @Route("/phone/new", name="profile_phone_new", methods={"GET","POST"})
     */
    public function phoneNew(Request $request): Response
    {
        $phone = new Phone();
        $phone->setUser($this->getUser());
        $form = $this->createForm(PhoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($phone);
            $entityManager->flush();
            $this->addFlash('success','Success');
            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profile/phone/new.html.twig', [
            'phone' => $phone,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="profile_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    
    /**
     * @Route("-edit-api-key", name="profile_edit_api_key", methods={"POST"})
     */
    public function editApiKey(Request $request, EntityManagerInterface $entityManager, Service $service): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('edit_api' . $user->getId(), $request->request->get('_token'))) {
            $newApiKey = $service->aleatoire(101);
            $user->setApiKey($newApiKey);
            $entityManager->flush();
            return new JsonResponse([
                'response'=>true,
                'content'=>$newApiKey
            ]);
        }

        return new JsonResponse(false);
    }
    /**
     * @Route("-edit-password", name="profile_edit_password", methods={"GET","POST"})
     */
    public function editPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $user->getPersonne();
            $user->setPersonne($personne);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Mot de passe modifié');
            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profile/edit-email.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {        
        $form = $this->createForm(ProfileType::class, $user,[]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('avatar')->getData();
            $personne = $user->getPersonne();
            if ($image) {
                # code...
                $fichier = md5(uniqid()). '.'.$image->guessExtension();
                $image->move(
                $this->getParameter('user_images_directory'),
                $fichier
                );
                $personne->setAvatar($fichier);
            }
            $user->setPersonne($personne);
            $this->getDoctrine()->getManager()->flush();
            $message  = $this->translator->trans('profil modify');
            $this->addFlash('success',$message);
            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profile/index.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="profile_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
    }
}