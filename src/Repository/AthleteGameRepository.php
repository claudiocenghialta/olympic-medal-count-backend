<?php

namespace App\Repository;

use App\Entity\AthleteGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AthleteGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method AthleteGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method AthleteGame[]    findAll()
 * @method AthleteGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AthleteGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AthleteGame::class);
    }

    // /**
    //  * @return AthleteGame[] Returns an array of AthleteGame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AthleteGame
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
