<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {
        $users = [
            ['email' => 'employee@example.com', 'password' => 'Empl123*', 'role' => 'employee'],
            ['email' => 'test@example.com', 'password' => 'EmpltTest0*', 'role' => 'employee'],
            ['email' => 'mdp@example.com', 'password' => 'tmpMdp0*', 'role' => 'employee'],
        ];
        foreach ($users as $user) {
            $entity = new User();
            $entity->setEmail($user['email']);
            $hashedPassword = $this->passwordHasher->hashPassword($entity, $user['password']);
            $entity->setPassword($hashedPassword);
            $entity->setRole($user['role']);
            $manager->persist($entity);
        }
        $manager->flush();
    }
}