<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
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
//        dd($user);
//        $user->setEmail($user->getEmail());
        $plainTextPassword = $this->passwordService->hash($user, $user->getPassword());
        $user->setPassword($plainTextPassword);
//        $user->setFirstname($user->getFirstname());
        $user->setAddress($user->getAddress());
//        $user->setLastname($user->getLastname());
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            "message" => "User created",
            "user" => $user
        ];
    }
}
