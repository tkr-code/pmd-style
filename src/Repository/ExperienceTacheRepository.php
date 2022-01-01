<?php

namespace App\Repository;

use App\Entity\ExperienceTache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExperienceTache|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExperienceTache|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExperienceTache[]    findAll()
 * @method ExperienceTache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperienceTacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperienceTache::class);
    }

    // /**
    //  * @return ExperienceTache[] Returns an array of ExperienceTache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExperienceTache
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
