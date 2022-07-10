<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Pet\CreatePetController;
use App\Controller\Pet\UpdatePetController;
use App\Repository\PetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[ApiResource(
    collectionOperations: [
        'pets' => [
            'normalization_context' => ['groups' => 'read:pets'],
            'method' => 'Get',
            'path' => '/pets',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'description' => 'retrieve all your pets'
            ]
        ],
        'createPet' => [
            'Renormalization_context' => ['groups' => 'write:pet'],
            'controller' => CreatePetController::class,
            'method' => 'Post',
            'path' => '/pets/create',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'description' => 'add a new pet',
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                            'required' => ['name'],
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                    'name' => [
                                        'type' => 'string'
                                    ],
                                    'age' => [
                                        'type' => 'Datetime',
                                        'nullable' => true
                                    ],
                                    'weight' => [
                                        'type' => 'float'
                                    ],
                                    'weight_goal' => [
                                        'type' => 'float'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    itemOperations: [
        'patch' => [
            'method' => 'patch',
            'controller' => UpdatePetController::class,
            'Renormalization_context' => ['groups' => 'write:pet'],
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'description' => 'edit info for a pet',
                'requestBody' => [
                    'content' => [
                        'application/x-www-form-urlencoded' => [
                            'schema' => [
                                'required' => ['name'],
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                    'name' => [
                                        'type' => 'string'
                                    ],
                                    'age' => [
                                        'type' => 'string',
                                        'nullable' => true
                                    ],
                                    'weight' => [
                                        'type' => 'float'
                                    ],
                                    'weight_goal' => [
                                        'type' => 'float'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'pet' => [
            'schema' => [
                'normalization_context' => ['groups' => 'read:pets'],
            ],
            'method' => 'Get',
            'path'=> '/pets/{id}',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'description' => 'information of one pet',
                'responses' => [
                    '200' => [
                        'description' => 'your pet',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Pet',
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'deletePet' => [
            'method' => 'Delete',
            'path' => 'pets/{id}/delete',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'description' => 'delete a pet'
            ]
        ],
    ]
)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:pets'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:pets', 'write:pet'])]
    private $name;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:pets', 'write:pet'])]
    private $weight;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['write:pet', 'read:pets'])]
    private $age;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:pets'])]
    private $steps;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:pets'])]
    private $activity_time;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:pets'])]
    private $user;

    #[ORM\OneToOne(mappedBy: 'pet', targetEntity: Necklace::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'cascade')]
    #[Groups(['read:pets'])]
    private $necklace;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:pets', 'write:Pet'])]
    private $weightGoal;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:pets'])]
    private $status;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ['persist', 'remove'])]
    private $media;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAge(): ?\DateTimeImmutable
    {
        return $this->age;
    }

    public function setAge(?\DateTimeImmutable $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSteps(): ?int
    {
        return $this->steps;
    }

    public function setSteps(?int $steps): self
    {
        $this->steps = $steps;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getActivityTime(): ?int
    {
        return $this->activity_time;
    }

    public function setActivityTime(?int $activity_time): self
    {
        $this->activity_time = $activity_time;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNecklace(): ?Necklace
    {
        return $this->necklace;
    }

    public function setNecklace(?Necklace $necklace): self
    {
        // unset the owning side of the relation if necessary
        if ($necklace === null && $this->necklace !== null) {
            $this->necklace->setPet(null);
        }

        // set the owning side of the relation if necessary
        if ($necklace !== null && $necklace->getPet() !== $this) {
            $necklace->setPet($this);
        }

        $this->necklace = $necklace;

        return $this;
    }

    public function getWeightGoal(): ?float
    {
        return $this->weightGoal;
    }

    public function setWeightGoal(?float $weightGoal): self
    {
        $this->weightGoal = $weightGoal;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
