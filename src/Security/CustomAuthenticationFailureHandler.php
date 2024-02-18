<?php
// src/Security/CustomAuthenticationFailureHandler.php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class CustomAuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // Construction de la réponse JSON d'échec personnalisée
        $data = [
            'success' => false,
            'message' => 'Erreur d\'authentification: ' . $exception->getMessage()
        ];

        return new JsonResponse($data);
    }
}
