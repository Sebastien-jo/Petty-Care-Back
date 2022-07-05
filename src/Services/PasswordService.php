<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordService
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function hash(User $user, string $password): string
    {
        return $this->userPasswordHasher->hashPassword($user, $password);
    }

    public function formatRequirement(string $password): int
    {
        return preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $password);
    }

    public function isValid(User $user, string $password): bool
    {
        return $this->userPasswordHasher->isPasswordValid($user, $password);
    }
}
