<?php

namespace App\Repository;

use App\Entity\AvancePaiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvancePaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvancePaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvancePaiement[]    findAll()
 * @method AvancePaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvancePaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvancePaiement::class);
    }

    // /**
    //  * @return AvancePaiement[] Returns an array of AvancePaiement objects
    //  */

    public function allAvanceForPaiement(int $id_projet)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.paiement = :val')
            ->setParameter('val', $id_projet)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?AvancePaiement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    #elle renvoie la derniere avance inserer en base de donnée
    #Avec le SQL brut comme dans l'ancien temps
    public function lastAvanceInsertedForPaiment(int $id_projet): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM avance_paiement A
            WHERE A.paiement_id = :idProjet AND A.id = (SELECT MAX(id) FROM avance_paiement)
            
            ';
        #deuxieme façon d'ecrire la requete
        $sql2 = '
            SELECT * FROM avance_paiement A
            ORDER BY A.id DESC LIMIT 1
            ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['idProjet' => $id_projet]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
