<?php

namespace App\Repository;

use App\Entity\SalesOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @method SalesOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOrder[]    findAll()
 * @method SalesOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOrderRepository extends ServiceEntityRepository
{
    private $tokenStorage;
    public function __construct(ManagerRegistry $registry, TokenStorageInterface $tokenStorage)
    {
        parent::__construct($registry, SalesOrder::class);
        $this->tokenStorage = $tokenStorage;
    }

    public function getCurrentYearSales($year = null)
    {
        $salesData = ['months' => [], 'sales' => array_fill(1, 12, "0")];
        try
        {
            $year = ($year ?? date_format(new \DateTime(), 'Y'));
            $salesData['year'] = $year;
            $qb = $this->createQueryBuilder('so');
            $data = $qb->select('count(so.id) as salesCount, MONTHNAME(so.createdAt) as monthName, MONTH(so.createdAt) as monthInt')
                ->where('YEAR(so.createdAt) = :year')
                ->andWhere('so.admin = :admin')
                ->groupBy('monthInt')
                ->setParameter('year', $year)
                ->setParameter('admin', ($this->tokenStorage->getToken()->getUser() ?? ""))
                ->getQuery()->execute();
            if(count($data) > 0)
            {
                $salesData['months'] = array_column($data, 'monthName');
                foreach ($data as $value)
                {
                    $salesData['sales'][$value['monthInt']] = $value['salesCount'];
                }
            }
            $salesData['sales'] = array_values($salesData['sales']);
        }
        catch (\Exception $exception)
        {
        }
        return $salesData;
    }

    public function getYearlySales()
    {
        $salesData = ['sales' => array_fill(2015, 10, "0")];
        try
        {
            $qb = $this->createQueryBuilder('so');
            $data = $qb->select('count(so.id) as salesCount, YEAR(so.createdAt) as yearInt')
                ->where('so.admin = :admin')
                ->groupBy('yearInt')
                ->setParameter('admin', ($this->tokenStorage->getToken()->getUser() ?? ""))
                ->getQuery()->execute();
            if(count($data) > 0)
            {
                foreach ($data as $value)
                {
                    $salesData['sales'][$value['yearInt']] = $value['salesCount'];
                }
            }
        }
        catch (\Exception $exception)
        {
        }
        return $salesData;
    }

    // /**
    //  * @return SalesOrder[] Returns an array of SalesOrder objects
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
    public function findOneBySomeField($value): ?SalesOrder
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
