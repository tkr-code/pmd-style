<?php

namespace App\Repository;

use App\Entity\AvancePaiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvancePaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvancePaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvancePaiement[]    findAll()
 * @method AvancePaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvancePaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvancePaiement::class);
    }

    // /**
    //  * @return AvancePaiement[] Returns an array of AvancePaiement objects
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
    public function findOneBySomeField($value): ?AvancePaiement
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
