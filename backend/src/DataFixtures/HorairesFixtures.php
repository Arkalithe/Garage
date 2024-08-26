<?php

namespace App\DataFixtures;

use App\Entity\Horaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HorairesFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $horaires = [
            ['day_id' => 1, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
            ['day_id' => 2, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
            ['day_id' => 3, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
            ['day_id' => 4, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
            ['day_id' => 5, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
            ['day_id' => 6, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => false],
            ['day_id' => 7, 'heure_start' => '08:00:00', 'heure_fin' => '12:00:00', 'time_period' => 'Morning', 'is_fermed' => true],

            ['day_id' => 2, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
            ['day_id' => 3, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
            ['day_id' => 4, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
            ['day_id' => 1, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
            ['day_id' => 5, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
            ['day_id' => 6, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => false],
            ['day_id' => 7, 'heure_start' => '13:00:00', 'heure_fin' => '17:00:00', 'time_period' => 'Afternoon', 'is_fermed' => true],
        ];

        foreach ($horaires as $horaire) {
            $horairesEntity = new Horaire();
            $horairesEntity->setDayId($horaire['day_id']);
            $heureStart = \DateTime::createFromFormat('H:i:s', $horaire['heure_start']);
            $horairesEntity->setHeureStart($heureStart);
            $heureFin = \DateTime::createFromFormat('H:i:s', $horaire['heure_fin']);
            $horairesEntity->setHeureFin($heureFin);
            $horairesEntity->setTimePeriode($horaire['time_period']);
            $horairesEntity->setIsFermed($horaire['is_fermed']);
            $manager->persist($horairesEntity);
        }
        $manager->flush();
    }
}