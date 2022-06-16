<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;
//
//    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Pet::class, orphanRemoval: true)]
//    private $pets;
//
//    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Toy::class, orphanRemoval: true)]
//    private $toys;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
        $this->toys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
//
//    /**
//     * @return Collection<int, Pet>
//     */
//    public function getPets(): Collection
//    {
//        return $this->pets;
//    }
//
//    public function addPet(Pet $pet): self
//    {
//        if (!$this->pets->contains($pet)) {
//            $this->pets[] = $pet;
//            $pet->setUserId($this);
//        }
//
//        return $this;
//    }
//
//    public function removePet(Pet $pet): self
//    {
//        if ($this->pets->removeElement($pet)) {
//            // set the owning side to null (unless already changed)
//            if ($pet->getUserId() === $this) {
//                $pet->setUserId(null);
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, Toy>
//     */
//    public function getToys(): Collection
//    {
//        return $this->toys;
//    }
//
//    public function addToy(Toy $toy): self
//    {
//        if (!$this->toys->contains($toy)) {
//            $this->toys[] = $toy;
//            $toy->setUser($this);
//        }
//
//        return $this;
//    }
//
//    public function removeToy(Toy $toy): self
//    {
//        if ($this->toys->removeElement($toy)) {
//            // set the owning side to null (unless already changed)
//            if ($toy->getUser() === $this) {
//                $toy->setUser(null);
//            }
//        }
//
//        return $this;
//    }
}
