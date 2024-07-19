<?php

namespace App\DataFixtures;

use App\Entity\Candy;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        for ($i = 0; $i < 100; $i++) {
            $candy = new Candy();
            $candy->setName($faker->vehicleBrand);
            $candy->setDescription($faker->sentence(5,false));
            $candy->setCreateAt(new DateTimeImmutable());

            $slug = $this->slugger->slug($candy->getName())->lower();
            $candy->setSlug($slug);

            $manager->persist($candy);
        }
        $manager->flush();
    }
}
