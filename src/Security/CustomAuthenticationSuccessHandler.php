<?php 
// src/Security/CustomAuthenticationSuccessHandler.php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class CustomAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $jwtEncoder;

    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Construction de la réponse JSON réussie personnalisée
        $data = [
            'success' => true,
            'message' => 'Authentification réussie'
        ];// Générer le token JWT
        $user = $token->getUser();
        $token = $this->jwtEncoder->encode(['username' => $user->getUsername()]);

        // Construction de la réponse JSON réussie personnalisée avec le token
        $data = [
            'success' => true,
            'token' => $token,
            'message' => 'Authentification réussie'
        ];

        return new JsonResponse($data);
    }
}
