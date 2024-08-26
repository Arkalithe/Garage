<?php

namespace App\DataFixtures;

use App\Entity\VoitureContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VoitureContentFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $occasions = [
            [
                'title' => 'Occasion',
                'intro' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                'image' => 'Voiture.png'
            ]
        ];
        foreach ($occasions as $occasion) {
            $voitureContent = new VoitureContent();
            $voitureContent->setTitle($occasion['title']);
            $voitureContent->setIntro($occasion['intro']);
            $voitureContent->setImagePath($occasion['image']);
            $manager->persist($voitureContent);
        }
        $manager->flush();
    }
}