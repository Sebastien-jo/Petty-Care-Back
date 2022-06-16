<?php

namespace App\Entity;

use App\Repository\NecklaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NecklaceRepository::class)]
class Necklace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $date_of_purchase;

    #[ORM\OneToOne(inversedBy: 'necklace', targetEntity: Pet::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $pet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfPurchase(): ?\DateTimeInterface
    {
        return $this->date_of_purchase;
    }

    public function setDateOfPurchase(?\DateTimeInterface $date_of_purchase): self
    {
        $this->date_of_purchase = $date_of_purchase;

        return $this;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(Pet $pet): self
    {
        $this->pet = $pet;

        return $this;
    }
}
