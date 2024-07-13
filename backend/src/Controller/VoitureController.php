<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Caracteristique;
use App\Entity\Equipement;
use App\Entity\VoitureImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VoitureController extends AbstractController
{
    #[Route('/api/voitures', name: 'create_voiture', methods: ['POST'])]
    public function createVoiture(
        Request $request, 
        EntityManagerInterface $em, 
        ValidatorInterface $validator, 
        SerializerInterface $serializer
    ): Response {
        $data = json_decode($request->getContent(), true);

        $voiture = new Voiture();
        $voiture->setPrix($data['prix']);
        $voiture->setKilometrage($data['kilometrage']);
        $voiture->setAnneeCirculation($data['anneeCirculation']);
        $voiture->setModele($data['modele']);
        $voiture->setNom($data['nom']);
        $voiture->setPrenom($data['prenom']);
        $voiture->setNumero($data['numero']);

        foreach ($data['caracteristiques'] as $caracteristiqueName) {
            $caracteristique = new Caracteristique();
            $caracteristique->setCaracteristique($caracteristiqueName);
            $voiture->addCaracteristique($caracteristique);
        }

        foreach ($data['equipements'] as $equipementName) {
            $equipement = new Equipement();
            $equipement->setEquipement($equipementName);
            $voiture->addEquipement($equipement);
        }

        foreach ($data['images'] as $imageName) {
            $voitureImage = new VoitureImage();
            $voitureImage->setImage($imageName);
            $voiture->addImage($voitureImage);
        }

        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return new Response($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }

        $em->persist($voiture);
        $em->flush();

        return new Response('Voiture créée avec succès', Response::HTTP_CREATED);
    }

    #[Route('/api/voitures/{id}', name: 'get_voiture', methods: ['GET'])]
    public function getVoiture(int $id, EntityManagerInterface $em): Response
    {
        $voiture = $em->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            return new Response('Voiture non trouvée', Response::HTTP_NOT_FOUND);
        }

        return $this->json($voiture, Response::HTTP_OK, [], [
            'groups' => ['voiture:read']
        ]);
    }
}
