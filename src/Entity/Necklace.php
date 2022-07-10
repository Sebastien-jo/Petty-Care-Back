<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NecklaceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NecklaceRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => 'read:necklace'],
            'method' => 'get',
            'path' => '/necklaces/{id}',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'description' => 'get the necklace of your pet'
            ]
        ]
    ]
)]
class Necklace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:necklace'])]
    private $id;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['read:necklace'])]
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
