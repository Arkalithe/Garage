<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Caracteristique;
use App\Entity\Equipement;
use App\Entity\VoitureImage;
use App\Entity\Image;
use App\Entity\CVVoiture;
use App\Entity\EVVoiture;
use App\EventSubscriber\JwtSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VoitureController extends AbstractController
{
    private JwtSubscriber $jwtSubscriber;

    public function __construct(JwtSubscriber $jwtSubscriber)
    {
        $this->jwtSubscriber = $jwtSubscriber;
    }

    #[Route('/api/voitures', name: 'create_voiture', methods: ['POST'])]
    public function createVoiture(
        Request $request, 
        EntityManagerInterface $em, 
        ValidatorInterface $validator, 
        SerializerInterface $serializer
    ): Response {
        $this->jwtSubscriber->denyAccessUnlessRole('admin', $request);

        $data = json_decode($request->getContent(), true);

        $voiture = new Voiture();
        $this->populateVoiture($voiture, $data, $em);

        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return new Response($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }

        $em->persist($voiture);
        $em->flush();

        return new Response('Voiture created with success', Response::HTTP_CREATED);
    }

    #[Route('/api/voitures/{id}', name: 'get_voiture', methods: ['GET'])]
    public function getVoiture(int $id, EntityManagerInterface $em): Response
    {
        $voiture = $em->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            return new Response('Voiture not found', Response::HTTP_NOT_FOUND);
        }

        return $this->json($voiture, Response::HTTP_OK, [], [
            'groups' => ['voiture:read']
        ]);
    }

    #[Route('/api/voitures', name: 'list_voitures', methods: ['GET'])]
    public function listVoitures(EntityManagerInterface $em): Response
    {
        $voitures = $em->getRepository(Voiture::class)->findAll();

        return $this->json($voitures, Response::HTTP_OK, [], [
            'groups' => ['voiture:read']
        ]);
    }

    #[Route('/api/voitures/{id}', name: 'update_voiture', methods: ['PUT'])]
    public function updateVoiture(
        int $id, 
        Request $request, 
        EntityManagerInterface $em, 
        ValidatorInterface $validator, 
        SerializerInterface $serializer
    ): Response {
        $this->jwtSubscriber->denyAccessUnlessRole('admin', $request);

        $voiture = $em->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            return new Response('Voiture not found', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $this->populateVoiture($voiture, $data, $em);

        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return new Response($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }

        $em->flush();

        return new Response('Voiture updated with success', Response::HTTP_OK);
    }

    #[Route('/api/voitures/{id}', name: 'delete_voiture', methods: ['DELETE'])]
    public function deleteVoiture(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $this->jwtSubscriber->denyAccessUnlessRole('admin', $request);

        $voiture = $em->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            return new Response('Voiture not found', Response::HTTP_NOT_FOUND);
        }

        $em->remove($voiture);
        $em->flush();

        return new Response('Voiture deleted with success', Response::HTTP_NO_CONTENT);
    }

    private function populateVoiture(Voiture $voiture, array $data, EntityManagerInterface $em): void
    {
        $voiture->setPrix($data['prix']);
        $voiture->setKilometrage($data['kilometrage']);
        $voiture->setAnneeCirculation($data['anneeCirculation']);
        $voiture->setModele($data['modele']);
        $voiture->setNom($data['nom']);
        $voiture->setPrenom($data['prenom']);
        $voiture->setNumero($data['numero']);

        $this->handleCaracteristiques($voiture, $data['caracteristiques'], $em);
        $this->handleEquipements($voiture, $data['equipements'], $em);
        $this->handleImages($voiture, $data['images'], $em);
    }

    private function handleCaracteristiques(Voiture $voiture, array $caracteristiques, EntityManagerInterface $em): void
    {
        foreach ($voiture->getCaracteristique() as $cvVoiture) {
            $em->remove($cvVoiture);
        }
        $voiture->getCaracteristique()->clear();

        foreach ($caracteristiques as $caracteristiqueName) {
            $caracteristique = $em->getRepository(Caracteristique::class)->findOneBy(['caracteristique' => $caracteristiqueName]) 
                ?? new Caracteristique();
            $caracteristique->setCaracteristique($caracteristiqueName);
            $em->persist($caracteristique);

            $cvVoiture = new CVVoiture();
            $cvVoiture->setVoiture($voiture);
            $cvVoiture->setCaracteristique($caracteristique);
            $voiture->addCaracteristique($cvVoiture);
            $em->persist($cvVoiture);
        }
    }

    private function handleEquipements(Voiture $voiture, array $equipements, EntityManagerInterface $em): void
    {
        foreach ($voiture->getEquipements() as $evVoiture) {
            $em->remove($evVoiture);
        }
        $voiture->getEquipements()->clear();

        foreach ($equipements as $equipementName) {
            $equipement = $em->getRepository(Equipement::class)->findOneBy(['equipement' => $equipementName]) 
                ?? new Equipement();
            $equipement->setEquipement($equipementName);
            $em->persist($equipement);

            $evVoiture = new EVVoiture();
            $evVoiture->setVoiture($voiture);
            $evVoiture->setEquipement($equipement);
            $voiture->addEquipement($evVoiture);
            $em->persist($evVoiture);
        }
    }

    private function handleImages(Voiture $voiture, array $images, EntityManagerInterface $em): void
    {
        foreach ($voiture->getImage() as $voitureImage) {
            $em->remove($voitureImage);
        }
        $voiture->getImage()->clear();

        foreach ($images as $imagePath) {
            $image = $em->getRepository(Image::class)->findOneBy(['ImagePath' => $imagePath]) 
                ?? new Image();
            $image->setImagePath($imagePath);
            $em->persist($image);

            $voitureImage = new VoitureImage();
            $voitureImage->setVoiture($voiture);
            $voitureImage->setImage($image);
            $voiture->addImage($voitureImage);
            $em->persist($voitureImage);
        }
    }
}
