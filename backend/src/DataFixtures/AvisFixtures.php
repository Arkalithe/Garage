<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AvisFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $avis = [
            ['name' => 'John Marchand', 'message' => 'Content du service', 'note' => '4', 'moderate' => '1'],
            ['name' => 'Doe Inconnu', 'message' => 'Prix abordable et personelle agrable', 'note' => '5', 'moderate' => '1'],
            ['name' => 'Angry User', 'message' => 'Ils ont prit leurs temps alors que j"etais pressé', 'note' => '2', 'moderate' => '0']
        ];

        foreach ($avis as $avis) {
            $avisEntity = new Avis();
            $avisEntity->setName($avis['name']);
            $avisEntity->setMessage($avis['message']);
            $avisEntity->setNote($avis['note']);
            $avisEntity->setModerate($avis['moderate']);
            $manager->persist($avisEntity);
        }
        $manager->flush();
    }
}