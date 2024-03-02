<?php

namespace App\Controller;

use App\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // /**
    //  * @Route("/api/login", name="api_login" , methods={"POST"})
    //  */
    // public function apiLogin(Request $request)
    // {
    //     // dd($request->request);
    //     $user = $this->getUser();
    //     if ($user) {
    //         return   $this->json(
    //             [
    //                 'username' => $user->getUsername(),
    //                 'roles' => $user->getRoles()
    //             ]
    //         );
    //     } else {
    //         return  $this->json([
    //             'error' => 'Donnees inavlide',
    //         ]);
    //     }
    // }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        // dump($_POST);
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
