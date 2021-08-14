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
        dd(getenv('DATABASE_URL'));
        $kernel = self::bootKernel();

        DatabasePrimer::prime(self::$kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreate()
    {
        $athlete = new Athlete();
        $athlete->setFirstName('Claudio');
        $athlete->setLastName('Cenghialta');
        $this->entityManager->persist($athlete);
        $this->entityManager->flush();
        $search =  $this->entityManager
            ->getRepository(Athlete::class)
            ->findOneBy(['first_name' => 'Claudio']);
        var_dump($search);
        $this->assertSame('Cenghialta', $athlete->getLastName());
    }

    public function testSearchByName()
    {
        $athlete = $this->entityManager
            ->getRepository(Athlete::class)
            ->findOneBy(['first_name' => 'test_first_name'])
        ;

        $this->assertSame('test_last_name', $athlete->getLastName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
