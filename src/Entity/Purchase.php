<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\ManyToOne(inversedBy: 'y')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'purchase')]
    private Collection $y;

    public function __construct()
    {
        $this->y = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getY(): Collection
    {
        return $this->y;
    }

    public function addY(Product $y): static
    {
        if (!$this->y->contains($y)) {
            $this->y->add($y);
            $y->addPurchase($this);
        }

        return $this;
    }

    public function removeY(Product $y): static
    {
        if ($this->y->removeElement($y)) {
            $y->removePurchase($this);
        }

        return $this;
    }
   
}
