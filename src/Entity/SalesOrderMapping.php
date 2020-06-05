<?php

namespace App\Entity;

use App\Repository\SalesOrderMappingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalesOrderMappingRepository::class)
 */
class SalesOrderMapping
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SalesOrder::class, inversedBy="salesOrderMappings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $salesOrder;

    /**
     * @ORM\ManyToOne(targetEntity=SalesOrderItem::class, inversedBy="salesOrderMappings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $salesOrderItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalesOrder(): ?SalesOrder
    {
        return $this->salesOrder;
    }

    public function setSalesOrder(?SalesOrder $salesOrder): self
    {
        $this->salesOrder = $salesOrder;

        return $this;
    }

    public function getSalesOrderItem(): ?SalesOrderItem
    {
        return $this->salesOrderItem;
    }

    public function setSalesOrderItem(?SalesOrderItem $salesOrderItem): self
    {
        $this->salesOrderItem = $salesOrderItem;

        return $this;
    }
}
