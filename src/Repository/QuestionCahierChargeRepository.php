<?php

namespace App\Repository;

use App\Entity\QuestionCahierCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionCahierCharge|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionCahierCharge|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionCahierCharge[]    findAll()
 * @method QuestionCahierCharge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionCahierChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionCahierCharge::class);
    }

    // /**
    //  * @return QuestionCahierCharge[] Returns an array of QuestionCahierCharge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionCahierCharge
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
