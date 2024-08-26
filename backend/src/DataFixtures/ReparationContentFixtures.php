<?php

namespace App\DataFixtures;

use App\Entity\ReparationContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReparationContentFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $reparations = [
            [
                'title' => 'Reparation',
                'intro' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                'description' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                'image' => 'toolbox.jpg'
            ]
        ];
        foreach ($reparations as $reparation) {
            $reparationContent = new ReparationContent();
            $reparationContent->setTitle($reparation['title']);
            $reparationContent->setIntro($reparation['intro']);
            $reparationContent->setDescription($reparation['description']);
            $reparationContent->setImagePath($reparation['image']);
            $manager->persist($reparationContent);
        }
        $manager->flush();
    }
}