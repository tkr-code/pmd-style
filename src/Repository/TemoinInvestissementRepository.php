<?php

namespace App\Repository;

use App\Entity\TemoinInvestissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TemoinInvestissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemoinInvestissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemoinInvestissement[]    findAll()
 * @method TemoinInvestissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemoinInvestissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemoinInvestissement::class);
    }

    // /**
    //  * @return TemoinInvestissement[] Returns an array of TemoinInvestissement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TemoinInvestissement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
