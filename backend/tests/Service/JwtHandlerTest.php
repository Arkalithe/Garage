<?php

namespace App\Tests\Service;

use App\Service\JwtHandler;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandlerTest extends TestCase
{
    private JwtHandler $jwtHandler;

    protected function setUp(): void
    {
        $params = $this->createMock(ParameterBagInterface::class);
        $params->method('get')->willReturn('secret_key');
        
        $logger = $this->createMock(LoggerInterface::class);

        $this->jwtHandler = new JwtHandler($params, $logger);
    }

    public function testJwtEncodeData(): void
    {
        $token = $this->jwtHandler->jwtEncodeData('issuer', ['id' => 1, 'email' => 'test@example.com'], 'ROLE_USER');
        $this->assertIsString($token);
    }

    public function testJwtDecodeData(): void
    {
        $token = $this->jwtHandler->jwtEncodeData('issuer', ['id' => 1, 'email' => 'test@example.com'], 'ROLE_USER');
        $decodedData = $this->jwtHandler->jwtDecodeData($token);
        
        $this->assertIsArray($decodedData);
        $this->assertArrayHasKey('data', $decodedData);
        $this->assertArrayHasKey('role', $decodedData);
        $this->assertEquals('ROLE_USER', $decodedData['role']);
    }

    public function testJwtDecodeExpiredToken(): void
    {
        $expiredToken = JWT::encode([
            'iss' => 'issuer',
            'aud' => 'issuer',
            'iat' => time() - 3600,
            'exp' => time() - 1800, 
            'data' => ['id' => 1, 'email' => 'test@example.com'],
            'role' => 'ROLE_USER'
        ], 'secret_key', 'HS256');

        $decodedData = $this->jwtHandler->jwtDecodeData($expiredToken);
        
        $this->assertArrayHasKey('message', $decodedData);
        $this->assertEquals('Token has expired', $decodedData['message']);
    }

    public function testJwtDecodeInvalidToken(): void
    {
        $invalidToken = 'invalid.token.here';
        
        $decodedData = $this->jwtHandler->jwtDecodeData($invalidToken);
        
        $this->assertArrayHasKey('message', $decodedData);
        $this->assertEquals('Invalid token', $decodedData['message']);
    }
}
