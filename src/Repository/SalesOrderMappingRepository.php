<?php

namespace App\Repository;

use App\Entity\SalesOrderMapping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalesOrderMapping|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOrderMapping|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOrderMapping[]    findAll()
 * @method SalesOrderMapping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOrderMappingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesOrderMapping::class);
    }

    // /**
    //  * @return SalesOrderMapping[] Returns an array of SalesOrderMapping objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalesOrderMapping
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
