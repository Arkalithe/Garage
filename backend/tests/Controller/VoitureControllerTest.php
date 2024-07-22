<?php

namespace App\Tests\Controller;

use App\Entity\Caracteristique;
use App\Entity\CVVoiture;
use App\Entity\Equipement;
use App\Entity\EVVoiture;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JwtHandler;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use App\Entity\Voiture;
use App\Entity\VoitureImage;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;

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

        $this->resetSchema();
        $this->loadFixtures();
    }

    private function createJwtToken(string $username, string $role): string
    {
        return $this->jwtHandler->jwtEncodeData('issuer', ['username' => $username], $role);
    }

    private function resetSchema(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
    }

    private function loadFixtures(): void
    {
        $this->loadVoitureFixtures();
    }

    private function loadVoitureFixtures(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $voiture = new Voiture();
            $voiture->setPrix($faker->numberBetween(15000, 50000));
            $voiture->setKilometrage($faker->numberBetween(0, 200000));
            $voiture->setAnneeCirculation($faker->numberBetween(2000, 2023));
            $voiture->setModele($faker->randomElement(['Model S', 'Model X',]));
            $voiture->setNom($faker->lastName());
            $voiture->setPrenom($faker->firstName());
            $voiture->setNumero($faker->phoneNumber());

            $caracteristique = new Caracteristique();
            $caracteristique->setCaracteristique('Air Conditioning');
            $this->entityManager->persist($caracteristique);

            $cvVoiture = new CVVoiture();
            $cvVoiture->setVoiture($voiture);
            $cvVoiture->setCaracteristique($caracteristique);
            $voiture->addCaracteristique($cvVoiture);

            $equipement = new Equipement();
            $equipement->setEquipement('GPS');
            $this->entityManager->persist($equipement);

            $evVoiture = new EVVoiture();
            $evVoiture->setVoiture($voiture);
            $evVoiture->setEquipement($equipement);
            $voiture->addEquipement($evVoiture);

            $image = new Image();
            $image->setImagePath('/images/car1.jpg');
            $this->entityManager->persist($image);
            $voitureImage = new VoitureImage();
            $voitureImage->setVoiture($voiture);
            $voitureImage->setImage($image);
            $voiture->addImage($voitureImage);

            $this->entityManager->persist($voiture);

        }

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
            'caracteristique' => ['Air Conditioning', 'Leather Seats'],
            'equipement' => ['GPS', 'Bluetooth'],
            'images' => ['/images/car1.jpg', '/images/car2.jpg']
        ];
    }

    public function testCreateVoiture(): void
    {
        $jwtToken = $this->createJwtToken('admin', 'admin');

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

        $createdVoiture = $this->entityManager->getRepository(Voiture::class)->findOneBy(['nom' => 'Doe']);
        $this->assertNotNull($createdVoiture);
        $this->assertEquals(25000, $createdVoiture->getPrix());

        $this->assertCount(2, $createdVoiture->getCaracteristique());
        $this->assertCount(2, $createdVoiture->getEquipements());
        $this->assertCount(2, $createdVoiture->getImage());
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
        $jwtToken = $this->createJwtToken('user', 'user');

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

    public function testListVoitures(): void
    {
        $this->client->request(
            'GET',
            '/api/voitures',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertStringContainsString('Model S', $response->getContent());
        $this->assertStringContainsString('Model X', $response->getContent());
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
    
        $content = $response->getContent();    
        $data = json_decode($content, true);
        
        $this->assertEquals($voiture->getModele(), $data['modele']);
        $this->assertEquals('Air Conditioning', $data['caracteristique'][0]['caracteristique']['caracteristique']);
        $this->assertEquals('GPS', $data['equipements'][0]['equipement']['equipement']);
        $this->assertEquals('/images/car1.jpg', $data['image'][0]['image']['ImagePath']);
    }

    public function testUpdateVoiture(): void
    {
        $voiture = $this->entityManager->getRepository(Voiture::class)->findOneBy([]);
        $this->assertNotNull($voiture, 'No Voiture found in the database.');

        $jwtToken = $this->createJwtToken('admin', 'admin');

        $payload = $this->createVoiturePayload();
        $payload['prix'] = 35000;

        $this->client->request(
            'PUT',
            '/api/voitures/' . $voiture->getId(),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => sprintf('Bearer %s', $jwtToken),
            ],
            json_encode($payload)
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertStringContainsString('Voiture updated with success', $response->getContent());

        $updatedVoiture = $this->entityManager->getRepository(Voiture::class)->find($voiture->getId());
        $this->assertEquals(35000, $updatedVoiture->getPrix());
    }

    public function testDeleteVoiture(): void
    {
        $voiture = $this->entityManager->getRepository(Voiture::class)->findOneBy([]);
        $this->assertNotNull($voiture, 'No Voiture found in the database.');

        $jwtToken = $this->createJwtToken('admin', 'admin');

        $this->client->request(
            'DELETE',
            '/api/voitures/' . $voiture->getId(),
            [],
            [],
            [
                'HTTP_Authorization' => sprintf('Bearer %s', $jwtToken),
            ]
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
