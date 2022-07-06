<?php

namespace App\Manager;

use App\Entity\Necklace;
use App\Entity\Pet;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PetManager
{
    public function __construct
    (
        private Security $security,
        protected EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    )
    {
    }

    public function createPet(Pet $pet)
    {
        $user = $this->userRepository->findOneBy(['id' => $this->security->getUser()]);
        $pet->setUser($user);
        $pet->setCreatedAt(new \DateTimeImmutable());
        $pet->setNecklace(new Necklace());
        $this->entityManager->persist($pet);
        $this->entityManager->flush();
    }
}
