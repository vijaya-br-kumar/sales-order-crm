<?php

namespace App\Entity;

use App\Repository\SalesOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=SalesOrderRepository::class)
 */
class SalesOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $salesOrderNo;

    /**
     * @ORM\Column(type="float")
     */
    private $totalValue;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="salesOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="salesOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity=SalesOrderMapping::class, mappedBy="salesOrder", orphanRemoval=true)
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

    public function getSalesOrderNo(): ?string
    {
        return $this->salesOrderNo;
    }

    public function setSalesOrderNo(string $salesOrderNo): self
    {
        $this->salesOrderNo = $salesOrderNo;

        return $this;
    }

    public function getTotalValue(): ?float
    {
        return $this->totalValue;
    }

    public function setTotalValue(float $totalValue): self
    {
        $this->totalValue = $totalValue;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    /**
     * @ORM\PostPersist()
     */
    public function postPersist()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

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
            $salesOrderMapping->setSalesOrder($this);
        }

        return $this;
    }

    public function removeSalesOrderMapping(SalesOrderMapping $salesOrderMapping): self
    {
        if ($this->salesOrderMappings->contains($salesOrderMapping)) {
            $this->salesOrderMappings->removeElement($salesOrderMapping);
            // set the owning side to null (unless already changed)
            if ($salesOrderMapping->getSalesOrder() === $this) {
                $salesOrderMapping->setSalesOrder(null);
            }
        }

        return $this;
    }
}
