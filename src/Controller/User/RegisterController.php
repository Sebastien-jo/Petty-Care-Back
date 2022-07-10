<?php

namespace App\Controller\User;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController
{
    public function __construct(protected UserManager $userManager)
    {
    }

    public function __invoke($data, Request $request): JsonResponse
    {
        $this->userManager->register($data, $request);

        return $this->json($data, 201, ['message' => 'User created']);
    }
}
