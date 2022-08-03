<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        assert($faker instanceof Generator);

        for ($i = 0; $i < 20; $i++) {

            $fakeTitle = $faker->words(2, true);
            assert(is_string($fakeTitle));

            $fakeShortdescription = $faker->words(10, true);
            assert(is_string($fakeShortdescription));

            $fakeDescription = $faker->paragraph(30);
            assert(is_string($fakeDescription));

            $date = new \DateTime('now');

            $userIdRand = rand(0, 49);
            $user = $this->getReference("user_$userIdRand");

            $article = (new Article())
                ->setTitle($fakeTitle)
                ->setShortdescription($fakeShortdescription)
                ->setDescription($fakeDescription)
                ->setCategory(Article::CATGORIES[array_rand(Article::CATEGORIES)])
                ->setPublicationDate($date)
                ->setUser($user)
            ;

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return [
            UserFixtures::class,
        ];
    }
}
