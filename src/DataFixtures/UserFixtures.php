<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const PASSWORD = 'azerty';

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = (new User())
            ->setEmail('enzo@dev.lan')
            ->setRoles(['ROLE_SUPER_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, self::PASSWORD);
        $user->setPassword($hashedPassword);
        
        $manager->persist($user);

        for ($i = 0; $i < 50; $i++) {
            $user = (new User())
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, self::PASSWORD);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
