<?php

namespace App\DataFixtures;

use App\Entity\DepannageContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepannageContentFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $depanage = [
            [
                'title' => 'Depannage',
                'intro' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                'description' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                'image' => 'guy.jpg'
            ]
        ];
        foreach ($depanage as $item) {
            $depanageContent = new DepannageContent();
            $depanageContent->setTitle($item['title']);
            $depanageContent->setIntro($item['intro']);
            $depanageContent->setDescription($item['description']);
            $depanageContent->setImagePath($item['image']);
            $manager->persist($depanageContent);
        }
        $manager->flush();
    }
}