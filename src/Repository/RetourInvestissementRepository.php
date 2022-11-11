<?php

namespace App\Repository;

use App\Entity\RetourInvestissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RetourInvestissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetourInvestissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetourInvestissement[]    findAll()
 * @method RetourInvestissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetourInvestissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetourInvestissement::class);
    }

    // /**
    //  * @return RetourInvestissement[] Returns an array of RetourInvestissement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RetourInvestissement
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
