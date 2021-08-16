<?php

namespace App\DataFixtures;

use App\Entity\Athlete;
use App\Entity\Nation;
use App\DataFixtures\NationFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AthleteFixtures extends Fixture  implements DependentFixtureInterface
{
    protected $entityManager;
    protected $faker;


    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 100; $i++) {
            $athlete = new Athlete();
            $athlete->setFirstName($this->faker->firstName());
            $athlete->setLastName($this->faker->lastName());
            $nation = null;
            while ($nation === null) {
                $countryCode = $this->faker->countryCode();
                $nation = $this->entityManager
                    ->getRepository(Nation::class)
                    ->findOneBy(['iso_code' => $countryCode]);
            }
            $athlete->setNation($nation);
            $manager->persist($athlete);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            NationFixtures::class,
        ];
    }
}
