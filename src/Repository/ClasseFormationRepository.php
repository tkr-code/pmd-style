<?php

namespace App\Repository;

use App\Entity\ClasseFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClasseFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClasseFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClasseFormation[]    findAll()
 * @method ClasseFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClasseFormation::class);
    }

    // /**
    //  * @return ClasseFormation[] Returns an array of ClasseFormation objects
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
    public function findOneBySomeField($value): ?ClasseFormation
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
