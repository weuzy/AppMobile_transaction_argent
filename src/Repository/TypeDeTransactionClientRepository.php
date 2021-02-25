<?php

namespace App\Repository;

use App\Entity\TypeDeTransactionClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDeTransactionClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDeTransactionClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDeTransactionClient[]    findAll()
 * @method TypeDeTransactionClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDeTransactionClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDeTransactionClient::class);
    }

    // /**
    //  * @return TypeDeTransactionClient[] Returns an array of TypeDeTransactionClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDeTransactionClient
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
