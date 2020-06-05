<?php

namespace App\DataFixtures;

use App\Entity\SalesOrderItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<20; $i++)
        {
            $item = new SalesOrderItem();
            $item->setItemCode(sprintf("Item-%s", $i+1));
            $item->setItemDescription(sprintf("Item-Desc-%s", $i+1));
            $item->setPrice(mt_rand(10, 1000));
            $manager->persist($item);
        }
        $manager->flush();
    }
}
