<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use App\Controller\User\RegisterController;
use App\Controller\User\UpdateProfileController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: [
        'register' => [
            'normalizationContext' => ['groups' => 'write:user'],
            'method' => 'post',
            'path' => '/register',
            'controller' => RegisterController::class,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'required' => ['email', 'password', 'firstname', 'lastname'],
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                    'email' => [
                                        'type' => 'string'
                                    ],
                                    'password' => [
                                        'type' => 'string'
                                    ],
                                    'firstname' => [
                                        'type' => 'string'
                                    ],
                                    'lastname' => [
                                        'type' => 'string'
                                    ],
                                    'address' => [
                                        'type' => 'string'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'login' => [
            'path' => '/login',
            'normalization_context' => ['groups' => 'login:user'],
            'method' => 'POST',
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'required' => ['email', 'password'],
                                'type' => 'object',
                                'properties' => [
                                    'username' => [
                                        'type' => 'string'
                                    ],
                                    'password' => [
                                        'type' => 'string'
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    itemOperations: [
        'profile' => [
            'pagination_enabled' => false,
            'path' => '/users/{id}',
            'method' => 'get',
            'normalization_context' => ['groups' => 'read:user'],
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ]
        ],
        'editProfile' => [
            'Renormalization_context' => ['groups' => 'write:user'],
            'controller' => UpdateProfileController::class,
            'path' => '/users/{id}/edit',
            'method' => 'Put',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
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
                                    'firstname' => [
                                        'type' => 'string'
                                    ],
                                    'lastname' => [
                                        'type' => 'string'
                                    ],
                                    'email' => [
                                        'type' => 'string'
                                    ],
                                    'password' => [
                                        'type' => 'string'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'deleteAccount' => [
            'path' => 'users/{id}/delete',
            'method' => 'Delete',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
            ]
        ]
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:user', 'read:pet'])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['read:user', 'write:user', 'login:user'])]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['write:user', 'login:user'])]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:user', 'write:user'])]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:user', 'write:user'])]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:user', 'write:user'])]
    private $address;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Pet::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['read:user'])]
    private $pets;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Toy::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['read:user'])]
    private $toys;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ['persist', 'remove'])]
    private $media;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
        $this->toys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets[] = $pet;
            $pet->setUser($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getUser() === $this) {
                $pet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Toy>
     */
    public function getToys(): Collection
    {
        return $this->toys;
    }

    public function addToy(Toy $toy): self
    {
        if (!$this->toys->contains($toy)) {
            $this->toys[] = $toy;
            $toy->setUser($this);
        }

        return $this;
    }

    public function removeToy(Toy $toy): self
    {
        if ($this->toys->removeElement($toy)) {
            // set the owning side to null (unless already changed)
            if ($toy->getUser() === $this) {
                $toy->setUser(null);
            }
        }

        return $this;
    }

    public static function createFromPayload($id, array $payload): User|JWTUserInterface
    {
        return (new User())->setId($id);
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
}
