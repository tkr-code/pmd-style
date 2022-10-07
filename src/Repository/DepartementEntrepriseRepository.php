<?php

namespace App\Repository;

use App\Entity\DepartementEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepartementEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartementEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartementEntreprise[]    findAll()
 * @method DepartementEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartementEntreprise::class);
    }

    // /**
    //  * @return DepartementEntreprise[] Returns an array of DepartementEntreprise objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepartementEntreprise
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
