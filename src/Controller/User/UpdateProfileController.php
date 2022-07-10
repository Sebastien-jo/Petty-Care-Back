<?php

namespace App\Controller\User;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateProfileController extends AbstractController
{
    public function __construct(protected UserManager $userManager)
    {
    }

    public function __invoke($data, Request $request): JsonResponse
    {
        $this->userManager->onUpdate($data, $request);

        return $this->json($data, 200, ['message' => 'User updated']);
    }
}
