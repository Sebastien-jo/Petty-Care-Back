<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserManager
{
    public function __construct
    (
        protected PasswordService $passwordService,
        protected EntityManagerInterface $entityManager,
        protected UserRepository $userRepository
    )
    {
    }

    public function findEmail(string $email)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if($user){
            return $user;
        }
        return null;
    }

    public function register(User $user)
    {
        $email = $this->findEmail($user->getUserIdentifier());

        if($email){
            throw new BadRequestHttpException("email déjà existant");
        }
        $plainTextPassword = $this->passwordService->hash($user, $user->getPassword());
        $user->setPassword($plainTextPassword);
        $user->setAddress($user->getAddress());
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            "message" => "User created",
            "user" => $user
        ];
    }

    public function onUpdate(User $user)
    {
        $plainTextPassword = $this->passwordService->hash($user, $user->getPassword());
        $user->setPassword($plainTextPassword);
        $user->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            "message" => "User updated",
            "user" => $user
        ];
    }

    public function logout()
    {
    }
}
