<?php

namespace App\Repository;

use App\Entity\PersonneGestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonneGestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonneGestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonneGestion[]    findAll()
 * @method PersonneGestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneGestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonneGestion::class);
    }

    // /**
    //  * @return PersonneGestion[] Returns an array of PersonneGestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonneGestion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
