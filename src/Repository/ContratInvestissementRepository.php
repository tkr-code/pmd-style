<?php

namespace App\Repository;

use App\Entity\ContratInvestissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContratInvestissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratInvestissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratInvestissement[]    findAll()
 * @method ContratInvestissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratInvestissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratInvestissement::class);
    }

    // /**
    //  * @return ContratInvestissement[] Returns an array of ContratInvestissement objects
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
    public function findOneBySomeField($value): ?ContratInvestissement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function lastInsertedIdDb(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT MAX(id) AS id
            FROM contrat_investissement 
            
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
