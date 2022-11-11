<?php

namespace App\Repository;

use App\Entity\ContractantInvestissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractantInvestissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractantInvestissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractantInvestissement[]    findAll()
 * @method ContractantInvestissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractantInvestissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractantInvestissement::class);
    }

    // /**
    //  * @return ContractantInvestissement[] Returns an array of ContractantInvestissement objects
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
    public function findOneBySomeField($value): ?ContractantInvestissement
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
