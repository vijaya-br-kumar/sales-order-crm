<?php

namespace App\Repository;

use App\Entity\SalesOrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalesOrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOrderItem[]    findAll()
 * @method SalesOrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesOrderItem::class);
    }

    // /**
    //  * @return SalesOrderItem[] Returns an array of SalesOrderItem objects
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
    public function findOneBySomeField($value): ?SalesOrderItem
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return array
     */
    public function getSalesOrderItems()
    {
        $items = [];
        try
        {
            $itemData = $this->findAll();
            foreach ($itemData as $item)
            {
                $items[] = ['id' => $item->getId(), 'itemCode'=> $item->getItemCode(), 'price' => $item->getPrice()];
            }
        }
        catch (\Exception $exception)
        {

        }
        return $items;
    }
}
