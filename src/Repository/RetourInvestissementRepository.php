<?php

namespace App\Repository;

use App\Entity\RetourInvestissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RetourInvestissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetourInvestissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetourInvestissement[]    findAll()
 * @method RetourInvestissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetourInvestissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetourInvestissement::class);
    }

    // /**
    //  * @return RetourInvestissement[] Returns an array of RetourInvestissement objects
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
    public function findOneBySomeField($value): ?RetourInvestissement
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function sommmeRetourInvestissement(int $id_invest): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT SUM(montant_recu) AS total_retour
            FROM retour_investissement AS R
            JOIN investissement I
            ON I.id = R.investissement_id
            WHERE R.investissement_id = :val
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['val' => $id_invest]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
