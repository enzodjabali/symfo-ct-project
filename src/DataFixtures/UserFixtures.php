<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;
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
        assert($faker instanceof Generator);

        $user = (new User())
            ->setEmail('admin@dev.lan')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setVerified(true);

        $hashedPassword = $this->passwordHasher->hashPassword($user, UserFixtures::PASSWORD);
        $user->setPassword($hashedPassword);
        
        $manager->persist($user);

        for ($i = 0; $i < 50; $i++) {

            $fakeEmail = $faker->email();
            assert(is_string($fakeEmail));

            $user = (new User())
                ->setEmail($fakeEmail)
                ->setRoles(['ROLE_USER']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, UserFixtures::PASSWORD);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
