<?php

namespace App\Repository;

use App\Entity\CahierCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CahierCharge|null find($id, $lockMode = null, $lockVersion = null)
 * @method CahierCharge|null findOneBy(array $criteria, array $orderBy = null)
 * @method CahierCharge[]    findAll()
 * @method CahierCharge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CahierChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CahierCharge::class);
    }
    public function findQuery()
    {
        return $this->createQueryBuilder('o');
    }
    public function findLast()
    {
       return $this->findQuery()
        ->orderBy('o.id','desc')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult()
        ;   
    }

    // /**
    //  * @return CahierCharge[] Returns an array of CahierCharge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CahierCharge
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
