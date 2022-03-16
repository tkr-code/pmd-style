<?php

namespace App\Repository;

use App\Entity\ReponseCahierCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReponseCahierCharge|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseCahierCharge|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseCahierCharge[]    findAll()
 * @method ReponseCahierCharge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseCahierChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseCahierCharge::class);
    }

    // /**
    //  * @return ReponseCahierCharge[] Returns an array of ReponseCahierCharge objects
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
    public function findOneBySomeField($value): ?ReponseCahierCharge
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
