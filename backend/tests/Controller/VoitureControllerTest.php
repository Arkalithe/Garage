<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JwtHandler;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VoitureControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $jwtHandler;
    private $logger;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $params = $this->client->getContainer()->get(ParameterBagInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->jwtHandler = new JwtHandler($params, $this->logger);
    }

    public function testCreateVoiture()
    {
        $jwtToken = $this->jwtHandler->jwtEncodeData('issuer', ['username' => 'admin'], 'admin');

        $this->client->request(
            'POST',
            '/api/voitures',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => sprintf('Bearer %s', $jwtToken),
            ],
            json_encode([
                'prix' => 25000,
                'kilometrage' => 50000,
                'anneeCirculation' => 2015,
                'modele' => 'Model X',
                'nom' => 'Doe',
                'prenom' => 'John',
                'numero' => '1234567890',
                'caracteristiques' => ['Air Conditioning', 'Leather Seats'],
                'equipements' => ['GPS', 'Bluetooth'],
                'images' => ['/images/car1.jpg', '/images/car2.jpg']
            ])
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertStringContainsString('Voiture created with success', $response->getContent());
    }

    public function testCreateVoitureWithoutToken()
    {
        $this->expectException(AccessDeniedHttpException::class);
        $this->expectExceptionMessage('Missing or invalid JWT token');

        $this->client->request(
            'POST',
            '/api/voitures',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'prix' => 25000,
                'kilometrage' => 50000,
                'anneeCirculation' => 2015,
                'modele' => 'Model X',
                'nom' => 'Doe',
                'prenom' => 'John',
                'numero' => '1234567890',
                'caracteristiques' => ['Air Conditioning', 'Leather Seats'],
                'equipements' => ['GPS', 'Bluetooth'],
                'images' => ['/images/car1.jpg', '/images/car2.jpg']
            ])
        );
    }

    public function testCreateVoitureWithInvalidRole()
    {

        $jwtToken = $this->jwtHandler->jwtEncodeData('issuer', ['username' => 'user'], 'user');

        $this->client->request(
            'POST',
            '/api/voitures',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => sprintf('Bearer %s', $jwtToken),
            ],
            json_encode([
                'prix' => 25000,
                'kilometrage' => 50000,
                'anneeCirculation' => 2015,
                'modele' => 'Model X',
                'nom' => 'Doe',
                'prenom' => 'John',
                'numero' => '1234567890',
                'caracteristiques' => ['Air Conditioning', 'Leather Seats'],
                'equipements' => ['GPS', 'Bluetooth'],
                'images' => ['/images/car1.jpg', '/images/car2.jpg']
            ])
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertStringContainsString('You do not have the necessary role.', $response->getContent());
    }

    
}
