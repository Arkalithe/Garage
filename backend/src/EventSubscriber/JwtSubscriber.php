<?php

namespace App\EventSubscriber;

use App\Service\JwtHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'kernel.request', method: 'onKernelRequest')]
class JwtSubscriber
{
    private JwtHandler $jwtHandler;

    private const PUBLIC_ROUTES = [
        '/login' => [],
        '/register' => [],
        '/create-admin' => [],
        '/api/voitures' => ['GET'],
        '/api/voitures/{id}' => ['GET'],
        '/api/aviss' => ['GET'],
        '/api/voiture_contents' => ["GET"],
        '/api/reparation_contents' => ['GET'],
        '/api/depannage_contents' => ['GET'],
        '/api' => [],
        '/_profiler' => []
    ];

    public function __construct(JwtHandler $jwtHandler)
    {
        $this->jwtHandler = $jwtHandler;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        $method = $request->getMethod();

        error_log('Path: ' . $path);
        error_log('Method: ' . $method);

        foreach (self::PUBLIC_ROUTES as $route => $methods) {
            if (preg_match("#^" . preg_quote($route, '#') . "(?:/\d+)?(/|$)#", $path) && (empty($methods) || in_array($method, $methods))) {
                return;
            }
        }

        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new AccessDeniedHttpException('Missing or invalid JWT token');
        }

        $decodedToken = $this->jwtHandler->jwtDecodeData($matches[1]);
        if (isset($decodedToken['message'])) {
            throw new AccessDeniedHttpException($decodedToken['message']);
        }

        $userRole = $decodedToken['role'];
        $request->attributes->set('jwt_data', $decodedToken['data']);
        $request->attributes->set('jwt_role', $userRole);
    }

    public function denyAccessUnlessRole(string $requiredRole, Request $request): void
    {
        $role = $request->attributes->get('jwt_role');
        if ($role !== $requiredRole) {
            throw new AccessDeniedHttpException('You do not have the necessary role.');
        }
    }
}
