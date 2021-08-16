<?php

namespace App\DataFixtures;

use App\Entity\SportCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SportCategoryFixtures extends Fixture
{
    protected $categories = array(
        "Athletics",
        "Swimming",
        "Boxing",
        "Fencing",
        "Judo"
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $key => $value) {
            $sportcategory = new SportCategory();
            $sportcategory->setName($value);
            $manager->persist($sportcategory);
        }

        $manager->flush();
    }
}
