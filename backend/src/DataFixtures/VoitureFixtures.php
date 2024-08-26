<?php

namespace App\DataFixtures;

use App\Entity\Caracteristique;
use App\Entity\CVVoiture;
use App\Entity\Equipement;
use App\Entity\EVVoiture;
use App\Entity\Image;
use App\Entity\Voiture;
use App\Entity\VoitureImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VoitureFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $voituresData = [
            [15000, 50000, 2019, 'Model X', 'John', 'Doe', '1234567890'],
            [12000, 40000, 2018, 'Model Y', 'Jane', 'Smith', '9876543210'],
            [18000, 60000, 2020, 'Model Z', 'Robert', 'Johnson', '4567890123'],
            [20000, 55000, 2017, 'Model A', 'Michael', 'Brown', '7890123456'],
            [14000, 45000, 2019, 'Model B', 'Emily', 'Davis', '5678901234'],
            [16000, 55000, 2018, 'Model C', 'David', 'Miller', '8901234567'],
            [13000, 50000, 2019, 'Model D', 'Emma', 'Wilson', '3456789012'],
            [17000, 45000, 2017, 'Model E', 'Andrew', 'Taylor', '6789012345'],
            [19000, 60000, 2020, 'Model F', 'Olivia', 'Anderson', '0123456789'],
            [11000, 40000, 2018, 'Model G', 'Daniel', 'Thomas', '9012345678']
        ];

        foreach ($voituresData as $voiture) {
            $voitureEntity = new Voiture();
            $voitureEntity->setPrix($voiture[0]);
            $voitureEntity->setKilometrage($voiture[1]);
            $voitureEntity->setAnneeCirculation($voiture[2]);
            $voitureEntity->setModele($voiture[3]);
            $voitureEntity->setPrenom($voiture[4]);
            $voitureEntity->setNom($voiture[5]);
            $voitureEntity->setNumero($voiture[6]);
            $manager->persist($voitureEntity);
            $voitures[] = $voitureEntity;
        }
        $caracteristiqueData = [
            ['Caracterisique 1'],
            ['Caracterisique 2'],
            ['Caracterisique 3'],
            ['Caracterisique 4'],
            ['Caracterisique 5'],
            ['Caracterisique 6'],
            ['Caracterisique 7'],
            ['Caracterisique 8'],
            ['Caracterisique 9'],
            ['Caracterisique 10']
        ];

        foreach ($caracteristiqueData as $caracteristique) {
            $caracteristiqueEntity = new Caracteristique();
            $caracteristiqueEntity->setCaracteristique($caracteristique[0]);
            $manager->persist($caracteristiqueEntity);
            $caracteristiques[] = $caracteristiqueEntity;
        }

        $equipementData = [
            ['Equipment 1'],
            ['option 2'],
            ['Equipment 3'],
            ['option 4'],
            ['Equipment 5'],
            ['option 6'],
            ['Equipment 7'],
            ['option 8'],
            ['Equipment 9'],
            ['option 10']
        ];
        foreach ($equipementData as $equipement) {
            $equipementEntity = new Equipement();
            $equipementEntity->setEquipement($equipement[0]);
            $manager->persist($equipementEntity);
            $equipements[] = $equipementEntity;
        }

        $cvvoitureData = [
            [1, 1],
            [1, 2],
            [2, 3],
            [3, 4],
            [4, 5],
            [4, 6],
            [5, 7],
            [6, 8],
            [7, 9],
            [8, 0],
            [8, 2]
        ];
        foreach ($cvvoitureData as $cvvoiture) {
            $cvvoitureEntity = new CVVoiture();
            $cvvoitureEntity->setVoiture($voitures[$cvvoiture[0]]);
            $cvvoitureEntity->setCaracteristique($caracteristiques[$cvvoiture[1]]);
            $manager->persist($cvvoitureEntity);
        }

        $evvoitureData = [
            [1, 1],
            [2, 2],
            [2, 3],
            [3, 4],
            [4, 5],
            [5, 6],
            [6, 7],
            [7, 8],
            [7, 9],
            [8, 0],
            [8, 1]
        ];
        $manager->flush();
        foreach ($evvoitureData as $evvoiture) {
            $evvoitureEntity = new EVVoiture();
            $evvoitureEntity->setVoiture($voitures[$evvoiture[0]]);
            $evvoitureEntity->setEquipement($equipements[$evvoiture[1]]);
            $manager->persist($evvoitureEntity);
        }
        $imagesData = [
            [1, 'Voiture.png'],
            [2, 'Voiture5.png'],
            [3, 'Voiture1.png'],
            [4, 'Voiture2.png'],
        ];
        foreach ($imagesData as $image) {
            $imageEntity = new Image();
            $imageEntity->setImagePath($image[1]);
            $manager->persist($imageEntity);
            $images[] = $imageEntity;
        }
        $manager->flush();
        $voitureImagesData = [
            [1, 1],
            [1, 2],
            [2, 3],
            [3, 0],
            [4, 1],
            [5, 2],
            [6, 3],
            [7, 0],
            [8, 1],
            [9, 2],
            [0, 3],
        ];
        foreach ($voitureImagesData as $voitureImage) {
            $voitureImageEntity = new VoitureImage();
            $voitureImageEntity->setVoiture($voitures[$voitureImage[0]]);
            $voitureImageEntity->setImage($images[$voitureImage[1]]);
            $manager->persist($voitureImageEntity);
        }
        $manager->flush();
    }
}