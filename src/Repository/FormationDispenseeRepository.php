<?php

namespace App\Repository;

use App\Entity\FormationDispensee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationDispensee|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationDispensee|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationDispensee[]    findAll()
 * @method FormationDispensee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationDispenseeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationDispensee::class);
    }

    // /**
    //  * @return FormationDispensee[] Returns an array of FormationDispensee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormationDispensee
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
