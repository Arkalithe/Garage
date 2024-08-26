<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtHandler
{
    private string $jwtSecret;
    private int $issuedAt;
    private int $expire;
    private LoggerInterface $logger;

    public function __construct(ParameterBagInterface $params, LoggerInterface $logger)
    {
        $this->issuedAt = time();
        $this->expire = $this->issuedAt + 3600;
        $this->jwtSecret = $params->get('app.jwt_secret');
        $this->logger = $logger;
    }

    public function jwtEncodeData(string $iss, array $data, string $role): string
    {
        $token = [
            "iss" => $iss,
            "aud" => $iss,
            "iat" => $this->issuedAt,
            "exp" => $this->expire,
            "data" => $data,
            "role" => $role
        ];

        return JWT::encode($token, $this->jwtSecret, 'HS256');
    }

    public function jwtDecodeData(string $jwtToken): array
    {
        try {
            $decoded = JWT::decode($jwtToken, new Key($this->jwtSecret, 'HS256'));

            if (time() > $decoded->exp) {
                throw new ExpiredException('Le token a expiré');
            }

            return [
                "data" => (array)$decoded->data,
                "role" => $decoded->role
            ];
        } catch (ExpiredException $e) {
            $this->logger->error('JWT expire: ' . $e->getMessage());
            return ["message" => 'Le token a expiré'];
        } catch (\Exception $e) {
            $this->logger->error('JWT decode erreur: ' . $e->getMessage());
            return ["message" => 'Le token est invalide'];
        }
    }
}