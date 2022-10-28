<?php

namespace App\Repository;

use App\Entity\ClientRDV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientRDV|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientRDV|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientRDV[]    findAll()
 * @method ClientRDV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRDVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientRDV::class);
    }

    // /**
    //  * @return ClientRDV[] Returns an array of ClientRDV objects
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
    public function findOneBySomeField($value): ?ClientRDV
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    #on affiche les clients du rendez d'un utilisateur bien speficique
    public function allRendezVousClientParUserConnected(int $id_user): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                personne_gestion_id as personneGestion,
                societe,ville,pays 
            FROM client_rdv C 
            JOIN rendez_vous R 
            ON C.id = R.client_rdv_id
            WHERE R.user_id = :id_user
            
            ';
        

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id_user' => $id_user]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
