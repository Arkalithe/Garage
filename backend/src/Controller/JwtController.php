<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\JwtHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class JwtController extends AbstractController
{
    private JwtHandler $jwtHandler;

    public function __construct(JwtHandler $jwtHandler)
    {
        $this->jwtHandler = $jwtHandler;
    }

    #[Route('/api/checkLoggedInStatus', name: 'app_check_login', methods: ['GET'])]
    public function checkLoggedInStatus(Request $request): Response
    {
        $response = ['isLoggedIn' => false, 'message' => "L'utilisateur n'est pas connecté"];

        try {
            $token = $request->cookies->get('jwt');

            if (!$token) {

                return $this->json($response);
            }

            $decodedToken = $this->jwtHandler->jwtDecodeData($token);

            if (isset($decodedToken['message'])) {
                $response['message'] = $decodedToken['message'];
                return $this->json($response);
            }

            if ($this->isTokenValid($decodedToken, $request->getHost())) {
                return $this->json([
                    'isLoggedIn' => true,
                    'accessToken' => $token,
                    'role' => $decodedToken['role'],
                    'message' => "L'utilisateur est connecté"
                ]);
            } else {
                $response['message'] = 'token Invalid';
            }
        } catch (\Exception $e) {
            $response['message'] = 'Une erreur est survenue';
        }

        return $this->json($response);
    }

    private function isTokenValid(array $decodedToken, string $host): bool
    {
        if ($decodedToken['aud'] === $host) {
            return true;
        }

        return false;
    }
}
