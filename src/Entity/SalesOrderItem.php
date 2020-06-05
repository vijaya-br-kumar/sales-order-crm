<?php

namespace App\Entity;

use App\Repository\SalesOrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalesOrderItemRepository::class)
 */
class SalesOrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemCode;

    /**
     * @ORM\Column(type="text")
     */
    private $itemDescription;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=SalesOrderMapping::class, mappedBy="salesOrderItem", orphanRemoval=true)
     */
    private $salesOrderMappings;

    public function __construct()
    {
        $this->salesOrderMappings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemCode(): ?string
    {
        return $this->itemCode;
    }

    public function setItemCode(string $itemCode): self
    {
        $this->itemCode = $itemCode;

        return $this;
    }

    public function getItemDescription(): ?string
    {
        return $this->itemDescription;
    }

    public function setItemDescription(string $itemDescription): self
    {
        $this->itemDescription = $itemDescription;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|SalesOrderMapping[]
     */
    public function getSalesOrderMappings(): Collection
    {
        return $this->salesOrderMappings;
    }

    public function addSalesOrderMapping(SalesOrderMapping $salesOrderMapping): self
    {
        if (!$this->salesOrderMappings->contains($salesOrderMapping)) {
            $this->salesOrderMappings[] = $salesOrderMapping;
            $salesOrderMapping->setSalesOrderItem($this);
        }

        return $this;
    }

    public function removeSalesOrderMapping(SalesOrderMapping $salesOrderMapping): self
    {
        if ($this->salesOrderMappings->contains($salesOrderMapping)) {
            $this->salesOrderMappings->removeElement($salesOrderMapping);
            // set the owning side to null (unless already changed)
            if ($salesOrderMapping->getSalesOrderItem() === $this) {
                $salesOrderMapping->setSalesOrderItem(null);
            }
        }

        return $this;
    }
}
