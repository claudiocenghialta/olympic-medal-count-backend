<?php

namespace App\Tests;

use App\Tests\DatabasePrimer;

use App\Entity\Athlete;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AthleteTest extends KernelTestCase
{
    protected $entityManager;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        DatabasePrimer::prime(self::$kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreate()
    {
        $athlete = new Athlete();
        $athlete->setFirstName('Claudio_test');
        $athlete->setLastName('Cenghialta');
        $this->entityManager->persist($athlete);
        $this->entityManager->flush();
        $search =  $this->entityManager
            ->getRepository(Athlete::class)
            ->findOneBy(['first_name' => 'Claudio_test']);
        $this->assertSame('Cenghialta', $search->getLastName());
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
