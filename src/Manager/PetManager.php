<?php

namespace App\Manager;

use App\Entity\Media;
use App\Entity\Necklace;
use App\Entity\Pet;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class PetManager
{
    public function __construct
    (
        private Security $security,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    )
    {
    }

    public function createPet(Pet $pet, Request $request)
    {
        $file = $request->files->get('file');
        $user = $this->userRepository->findOneBy(['id' => $this->security->getUser()]);

        if($file) {
            $media = new Media();
            $media->setFile($file);
            $pet->setMedia($media);
        }

        $pet->setUser($user);
        $pet->setCreatedAt(new \DateTimeImmutable());
        $pet->setNecklace(new Necklace());

        $this->entityManager->persist($pet);
        $this->entityManager->flush();
    }

    public function onUpdate(Pet $pet, Request $request)
    {
        $file = $request->files->get('file');

        if($file !== null) {
            $media = new Media();
            $media->setFile($file);
            $pet->setMedia($media);
        }

        $pet->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($pet);
        $this->entityManager->flush();
    }
}
