<?php

namespace App\Manager;

use App\Entity\Media;
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
        private PasswordService $passwordService,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    )
    {
    }

    private function findEmail(string $email)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if($user){
            return $user;
        }
        return null;
    }

    public function register(User $user, Request $request)
    {
        $email = $this->findEmail($user->getUserIdentifier());
        $file = $request->files->get('file');

        if($email){
            throw new BadRequestHttpException("email already used");
        }

        if($file) {
            $media = new Media();
            $media->setFile($request->files->get('file'));
            $user->setMedia($media);
        }

        $plainTextPassword = $this->passwordService->hash($user, $user->getPassword());
        $user->setPassword($plainTextPassword);
        $user->setAddress($user->getAddress());
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function onUpdate(User $user, Request $request)
    {
        $password = $request->get('password');
        $file = $request->files->get('file');

        if($password !== null) {
            $plainTextPassword = $this->passwordService->hash($user, $user->getPassword());
            $user->setPassword($plainTextPassword);
        }

        if($file !== null) {
            $media = new Media();
            $media->setFile($file);
            $user->setMedia($media);
        }

        $user->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
