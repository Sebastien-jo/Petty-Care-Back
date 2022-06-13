<?php

namespace App\Entity;

use App\Repository\ToyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToyRepository::class)]
class Toy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'toy', targetEntity: Pet::class)]
    private $pet;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'toys')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function __construct()
    {
        $this->pet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPet(): Collection
    {
        return $this->pet;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pet->contains($pet)) {
            $this->pet[] = $pet;
            $pet->setToy($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pet->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getToy() === $this) {
                $pet->setToy(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
