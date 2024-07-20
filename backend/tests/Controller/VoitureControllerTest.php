<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JwtHandler;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;

class VoitureControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $jwtHandler;
    private $logger;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = $this->client->getContainer();
        $this->entityManager = $container->get('doctrine')->getManager();

        $params = $container->get(ParameterBagInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->jwtHandler = new JwtHandler($params, $this->logger);

        $this->createTestVoiture();
    }

    private function createTestVoiture(): void
    {
        $voiture = new Voiture();
        $voiture->setPrix(30000);
        $voiture->setKilometrage(10000);
        $voiture->setAnneeCirculation(2020);
        $voiture->setModele('Model S');
        $voiture->setNom('Doe');
        $voiture->setPrenom('Jane');
        $voiture->setNumero('0987654321');

        $this->entityManager->persist($voiture);
        $this->entityManager->flush();
    }

    private function createVoiturePayload(): array
    {
        return [
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
        ];
    }

    public function testCreateVoiture(): void
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
            json_encode($this->createVoiturePayload())
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertStringContainsString('Voiture created with success', $response->getContent());
    }

    public function testCreateVoitureWithoutToken(): void
    {
        $this->client->request(
            'POST',
            '/api/voitures',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($this->createVoiturePayload())
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertStringContainsString('Missing or invalid JWT token', $response->getContent());
    }

    public function testCreateVoitureWithInvalidRole(): void
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
            json_encode($this->createVoiturePayload())
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertStringContainsString('You do not have the necessary role.', $response->getContent());
    }

    public function testGetVoiture(): void
    {
        $voiture = $this->entityManager->getRepository(Voiture::class)->findOneBy([]);
        $this->assertNotNull($voiture, 'No Voiture found in the database.');
    
        $this->client->request(
            'GET',
            '/api/voitures/' . $voiture->getId(),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );
    
        $response = $this->client->getResponse();
    
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertStringContainsString($voiture->getModele(), $response->getContent());
    }
}
