<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use App\DataFixtures\SportCategoryFixtures;
use App\Entity\SportCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class SportFixtures extends Fixture implements DependentFixtureInterface
{
    protected $entityManager;

    protected $sports = array(
        "Athletics"=> [
            "Women's 100m",
            "Men's High Jump",
            "Men's 100m",
            "Women's 800m",
            "Men's Discus Throw"
        ],
        "Swimming"=> [
            "Women's 100m Butterfly",
            "Men's 400m Freestyle"
        ],
        "Boxing"=> [
            "Women's Feather (54-57kg)",
            "Men's Welter (63-69kg)"
        ],
        "Fencing"=> [
            "Men's Sabre Individual",
            "Women's Épée Individual"
        ],
        "Judo"=> [
            "Women -48 kg",
            "Men -60 kg"
        ]
    );

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->sports as $sportCategory => $sportsValues) {
            foreach ($sportsValues as $value) {
                $sport = new Sport();
                $sport->setName($value);
                $category = $this->entityManager
                    ->getRepository(SportCategory::class)
                    ->findOneBy(['name' => $sportCategory]);
                $sport->setCategory($category);
                $manager->persist($sport);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SportCategoryFixtures::class,
        ];
    }
}
