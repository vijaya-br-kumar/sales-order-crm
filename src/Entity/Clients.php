<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity=SalesOrder::class, mappedBy="client", orphanRemoval=true)
     */
    private $salesOrders;

    public function __construct()
    {
        $this->salesOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|SalesOrder[]
     */
    public function getSalesOrders(): Collection
    {
        return $this->salesOrders;
    }

    public function addSalesOrder(SalesOrder $salesOrder): self
    {
        if (!$this->salesOrders->contains($salesOrder)) {
            $this->salesOrders[] = $salesOrder;
            $salesOrder->setClient($this);
        }

        return $this;
    }

    public function removeSalesOrder(SalesOrder $salesOrder): self
    {
        if ($this->salesOrders->contains($salesOrder)) {
            $this->salesOrders->removeElement($salesOrder);
            // set the owning side to null (unless already changed)
            if ($salesOrder->getClient() === $this) {
                $salesOrder->setClient(null);
            }
        }

        return $this;
    }
}
