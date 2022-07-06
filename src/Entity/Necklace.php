<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NecklaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NecklaceRepository::class)]
#[ApiResource]
class Necklace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $date_of_purchase;

    #[ORM\OneToOne(inversedBy: 'necklace', targetEntity: Pet::class, cascade: ['persist', 'remove'])]
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

    public function setPet(?Pet $pet): self
    {
        $this->pet = $pet;

        return $this;
    }
}
